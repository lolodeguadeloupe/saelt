<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\LocationVehiculeSaison\BulkDestroyLocationVehiculeSaison;
use App\Http\Requests\Admin\LocationVehicule\LocationVehiculeSaison\DestroyLocationVehiculeSaison;
use App\Http\Requests\Admin\LocationVehicule\LocationVehiculeSaison\IndexLocationVehiculeSaison;
use App\Http\Requests\Admin\LocationVehicule\LocationVehiculeSaison\StoreLocationVehiculeSaison;
use App\Http\Requests\Admin\LocationVehicule\LocationVehiculeSaison\UpdateLocationVehiculeSaison;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\Saison;
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

class LocationVehiculeSaisonsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSaison $request
     * @return array|Factory|View
     */
    public function index(IndexLocationVehiculeSaison $request, VehiculeLocation $locationVehicule)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Saison::class)
            ->modifyQuery(function ($query) use ($request, $locationVehicule) {
                $query->where(['model' => VehiculeLocation::class, 'model_id' => $locationVehicule->id]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'debut', 'fin', 'titre'],
                // set columns to searchIn
                ['id', 'debut', 'fin', 'titre']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.location-vehicule.saison.index', [
            'data' => $data,
            'vehiculeLocation' => $locationVehicule
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create(VehiculeLocation $locationVehicule)
    {
        $this->authorize('admin.location-vehicule-saison.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSaison $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLocationVehiculeSaison $request, VehiculeLocation $locationVehicule)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $saison = $locationVehicule->saison()->create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/location-vehicule-saisons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'saison' => $saison,
            ];
        }

        return redirect('admin/location-vehicule-saisons');
    }

    /**
     * Display the specified resource.
     *
     * @param Saison $saison
     * @throws AuthorizationException
     * @return void
     */
    public function show(Saison $saison)
    {
        $this->authorize('admin.location-vehicule-saison.show', $saison);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }
        return ['saison' => $saison];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Saison $saison
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Saison $saison)
    {
        $this->authorize('admin.location-vehicule-saison.edit', $saison);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'saison' => $saison
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSaison $request
     * @param Saison $saison
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLocationVehiculeSaison $request, Saison $saison)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Saison
        $saison->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/location-vehicule-saisons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'saison' => $saison,
            ];
        }

        return redirect('admin/location-vehicule-saisons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySaison $request
     * @param Saison $saison
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLocationVehiculeSaison $request, Saison $saison)
    {
        $saison->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySaison $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLocationVehiculeSaison $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Saison::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
