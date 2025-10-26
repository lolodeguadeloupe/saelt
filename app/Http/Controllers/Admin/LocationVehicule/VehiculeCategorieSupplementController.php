<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement\BulkDestroyVehiculeCategorieSupplement;
use App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement\DestroyVehiculeCategorieSupplement;
use App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement\IndexVehiculeCategorieSupplement;
use App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement\StoreAllVehiculeCategorieSupplement;
use App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement\StoreVehiculeCategorieSupplement;
use App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement\UpdateVehiculeCategorieSupplement;
use App\Models\LocationVehicule\VehiculeCategorieSupplement;
use App\Models\LocationVehicule\CategorieVehicule;
use App\Models\LocationVehicule\AgenceLocation;
use App\Models\LocationVehicule\RestrictionTrajetVehicule;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VehiculeCategorieSupplementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVehiculeCategorieSupplement $request
     * @return array|Factory|View
     */
    public function index(IndexVehiculeCategorieSupplement $request, CategorieVehicule $categorie)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VehiculeCategorieSupplement::class)
            ->modifyQuery(function ($query) use ($request, $categorie) {
                $query->join('restriction_trajet_vehicule as trajet', 'trajet.id', 'vehicule_categorie_supplement.restriction_trajet_id');
                $query->join('categorie_vehicule as categorie', 'categorie.id', 'vehicule_categorie_supplement.categorie_vehicule_id');
                $query->with(['categorie', 'trajet' => function ($query) {
                    $query->with(['point_depart', 'point_arrive']);
                }]);
                $query->where(['vehicule_categorie_supplement.categorie_vehicule_id' => $categorie->id]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'tarif', 'restriction_trajet_id', 'categorie_vehicule_id'],
                // set columns to searchIn
                ['id', 'tarif', 'trajet.titre']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.location-vehicule.vehicule-categorie-supplement.index', [
            'data' => $data,
            'categorie' => $categorie
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create(CategorieVehicule $categorie)
    {
        $this->authorize('admin.vehicule-categorie-supplement.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVehiculeCategorieSupplement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVehiculeCategorieSupplement $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the VehiculeCategorieSupplement
        $vehiculeCategorieSupplement = VehiculeCategorieSupplement::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-categorie-supplements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeCategorieSupplement' => $vehiculeCategorieSupplement,
            ];
        }

        return redirect('admin/vehicule-categorie-supplements');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAllVehiculeCategorieSupplement $request
     * @return array|RedirectResponse|Redirector
     */
    public function storeAll(StoreAllVehiculeCategorieSupplement $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        foreach ($sanitized['tarif'] as $key => $value) {
            $vehiculeCategorieSupplement = VehiculeCategorieSupplement::where([
                'restriction_trajet_id' =>  $sanitized['restriction_trajet_id'][$key],
                'categorie_vehicule_id' =>  $sanitized['categorie_vehicule_id'][$key],
            ])->first();
            if ($vehiculeCategorieSupplement) {
                $vehiculeCategorieSupplement->update([
                    'tarif' =>  $value,
                ]);
            } else {
                VehiculeCategorieSupplement::create([
                    'tarif' =>  $value,
                    'restriction_trajet_id' =>  $sanitized['restriction_trajet_id'][$key],
                    'categorie_vehicule_id' =>  $sanitized['categorie_vehicule_id'][$key],
                ]);
            }
        }
        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-categorie-supplements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')
            ];
        }

        return redirect('admin/vehicule-categorie-supplements');
    }

    /**
     * Display the specified resource.
     *
     * @param VehiculeCategorieSupplement $vehiculeCategorieSupplement
     * @throws AuthorizationException
     * @return void
     */
    public function show(VehiculeCategorieSupplement $vehiculeCategorieSupplement)
    {
        $this->authorize('admin.vehicule-categorie-supplement.show', $vehiculeCategorieSupplement);

        // TODO your code goes here

        if (!$this->request->ajax()) {
            abort(404);
        }

        $vehiculeCategorieSupplement = VehiculeCategorieSupplement::with(['categorie', 'trajet' => function ($query) {
            $query->with(['point_depart', 'point_arrive']);
        }])->find($vehiculeCategorieSupplement->id);

        return ['vehiculeCategorieSupplement' => $vehiculeCategorieSupplement];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VehiculeCategorieSupplement $vehiculeCategorieSupplement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VehiculeCategorieSupplement $vehiculeCategorieSupplement, CategorieVehicule $categorie)
    {
        $this->authorize('admin.vehicule-categorie-supplement.edit', $vehiculeCategorieSupplement);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $vehiculeCategorieSupplement = VehiculeCategorieSupplement::with(['categorie', 'trajet' => function ($query) {
            $query->with(['point_depart', 'point_arrive']);
        }])->find($vehiculeCategorieSupplement->id);

        return [
            'vehiculeCategorieSupplement' => $vehiculeCategorieSupplement,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVehiculeCategorieSupplement $request
     * @param VehiculeCategorieSupplement $vehiculeCategorieSupplement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVehiculeCategorieSupplement $request, VehiculeCategorieSupplement $vehiculeCategorieSupplement)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values VehiculeCategorieSupplement
        $vehiculeCategorieSupplement->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-categorie-supplements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeCategorieSupplement' => $vehiculeCategorieSupplement,
            ];
        }

        return redirect('admin/vehicule-categorie-supplements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVehiculeCategorieSupplement $request
     * @param VehiculeCategorieSupplement $vehiculeCategorieSupplement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVehiculeCategorieSupplement $request, VehiculeCategorieSupplement $vehiculeCategorieSupplement)
    {
        $vehiculeCategorieSupplement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVehiculeCategorieSupplement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVehiculeCategorieSupplement $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VehiculeCategorieSupplement::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
