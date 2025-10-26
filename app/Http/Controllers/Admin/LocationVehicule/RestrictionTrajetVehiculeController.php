<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\RestrictionTrajetVehicule\BulkDestroyRestrictionTrajetVehicule;
use App\Http\Requests\Admin\LocationVehicule\RestrictionTrajetVehicule\DestroyRestrictionTrajetVehicule;
use App\Http\Requests\Admin\LocationVehicule\RestrictionTrajetVehicule\IndexRestrictionTrajetVehicule;
use App\Http\Requests\Admin\LocationVehicule\RestrictionTrajetVehicule\StoreRestrictionTrajetVehicule;
use App\Http\Requests\Admin\LocationVehicule\RestrictionTrajetVehicule\UpdateRestrictionTrajetVehicule;
use App\Http\Requests\Admin\LocationVehicule\RestrictionTrajetVehicule\AutocompletionRestrictionTrajetVehicule;
use App\Models\LocationVehicule\CategorieVehicule;
use App\Models\LocationVehicule\RestrictionTrajetVehicule;
use App\Models\LocationVehicule\VehiculeCategorieSupplement;
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

class RestrictionTrajetVehiculeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRestrictionTrajetVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexRestrictionTrajetVehicule $request)
    {
        collect(CategorieVehicule::all())->map(function ($categorie) {
            collect(RestrictionTrajetVehicule::all())->map(function ($trajet) use ($categorie) {
                if (VehiculeCategorieSupplement::where([
                    'restriction_trajet_id' =>  $trajet->id,
                    'categorie_vehicule_id' =>  $categorie->id,
                ])->count() == 0) {
                    VehiculeCategorieSupplement::create([
                        'tarif' => 0,
                        'restriction_trajet_id' =>  $trajet->id,
                        'categorie_vehicule_id' =>  $categorie->id,
                    ]);
                };
            });
        });
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(RestrictionTrajetVehicule::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('agence_location as depart', 'depart.id', 'restriction_trajet_vehicule.agence_location_depart');
                $query->join('agence_location as arrive', 'arrive.id', 'restriction_trajet_vehicule.agence_location_arrive');
                $query->with(['point_depart', 'point_arrive']);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'agence_location_depart', 'agence_location_arrive'],
                // set columns to searchIn
                ['id', 'titre', 'depart.name', 'arrive.name']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.location-vehicule.restriction-trajet-vehicule.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.restriction-trajet-vehicule.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRestrictionTrajetVehicule $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRestrictionTrajetVehicule $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the RestrictionTrajetVehicule
        $restrictionTrajetVehicule = RestrictionTrajetVehicule::create($sanitized);

        collect(CategorieVehicule::all())->map(function ($categorie) use($restrictionTrajetVehicule) {
                if (VehiculeCategorieSupplement::where([
                    'restriction_trajet_id' =>  $restrictionTrajetVehicule->id,
                    'categorie_vehicule_id' =>  $categorie->id,
                ])->count() == 0) {
                    VehiculeCategorieSupplement::create([
                        'tarif' => 0,
                        'restriction_trajet_id' =>  $restrictionTrajetVehicule->id,
                        'categorie_vehicule_id' =>  $categorie->id,
                    ]);
                };
        });

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/restriction-trajet-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'restrictionTrajetVehicule' =>  $restrictionTrajetVehicule
            ];
        }

        return redirect('admin/restriction-trajet-vehicules');
    }

    /**
     * Display the specified resource.
     *
     * @param RestrictionTrajetVehicule $restrictionTrajetVehicule
     * @throws AuthorizationException
     * @return void
     */
    public function show(RestrictionTrajetVehicule $restrictionTrajetVehicule)
    {
        $this->authorize('admin.restriction-trajet-vehicule.show', $restrictionTrajetVehicule);

        // TODO your code goes here

        if (!$this->request->ajax()) {
            abort(404);
        }

        $restrictionTrajetVehicule = RestrictionTrajetVehicule::with(['point_depart', 'point_arrive'])->find($restrictionTrajetVehicule->id);

        return ['restrictionTrajetVehicule' => $restrictionTrajetVehicule,];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RestrictionTrajetVehicule $restrictionTrajetVehicule
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(RestrictionTrajetVehicule $restrictionTrajetVehicule)
    {
        $this->authorize('admin.restriction-trajet-vehicule.edit', $restrictionTrajetVehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $restrictionTrajetVehicule = RestrictionTrajetVehicule::with(['point_depart', 'point_arrive'])->find($restrictionTrajetVehicule->id);

        return [
            'restrictionTrajetVehicule' => $restrictionTrajetVehicule,
            'categories' => collect(CategorieVehicule::all())->map(function ($cat) use ($restrictionTrajetVehicule) {
                $cat->tarif = VehiculeCategorieSupplement::where([
                    'restriction_trajet_id' =>  $restrictionTrajetVehicule->id,
                    'categorie_vehicule_id' =>  $cat->id,
                ])->first();
                return $cat;
            }),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRestrictionTrajetVehicule $request
     * @param RestrictionTrajetVehicule $restrictionTrajetVehicule
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRestrictionTrajetVehicule $request, RestrictionTrajetVehicule $restrictionTrajetVehicule)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values RestrictionTrajetVehicule
        $restrictionTrajetVehicule->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/restriction-trajet-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'restrictionTrajetVehicule' => $restrictionTrajetVehicule,
            ];
        }

        return redirect('admin/restriction-trajet-vehicules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRestrictionTrajetVehicule $request
     * @param RestrictionTrajetVehicule $restrictionTrajetVehicule
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyRestrictionTrajetVehicule $request, RestrictionTrajetVehicule $restrictionTrajetVehicule)
    {
        VehiculeCategorieSupplement::where(['restriction_trajet_id' => $restrictionTrajetVehicule->id])->delete();
        $restrictionTrajetVehicule->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRestrictionTrajetVehicule $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyRestrictionTrajetVehicule $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {

                    VehiculeCategorieSupplement::whereIn('restriction_trajet_id', $bulkChunk)->delete();
                    RestrictionTrajetVehicule::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionRestrictionTrajetVehicule $resquest)
    {
        $sanitized = $resquest->getSanitized();

        $search = RestrictionTrajetVehicule::select('restriction_trajet_vehicule.*')->with(['point_depart', 'point_arrive'])
            ->join('agence_location as depart', 'depart.id', 'restriction_trajet_vehicule.agence_location_depart')
            ->where(function ($query) use ($sanitized) {
                $query->where('titre', 'like', '%' . $sanitized['search'] . '%')
                    ->orWhere('depart.name', 'like', '%' . $sanitized['search'] . '%');
            })
            ->limit(20)
            ->get();

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'search' => $search,
        ];
    }
}
