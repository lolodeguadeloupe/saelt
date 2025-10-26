<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\VehiculeInfoTech\BulkDestroyVehiculeInfoTech;
use App\Http\Requests\Admin\LocationVehicule\VehiculeInfoTech\DestroyVehiculeInfoTech;
use App\Http\Requests\Admin\LocationVehicule\VehiculeInfoTech\IndexVehiculeInfoTech;
use App\Http\Requests\Admin\LocationVehicule\VehiculeInfoTech\StoreVehiculeInfoTech;
use App\Http\Requests\Admin\LocationVehicule\VehiculeInfoTech\UpdateVehiculeInfoTech;
use App\Models\LocationVehicule\VehiculeInfoTech;
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

class VehiculeInfoTechController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexVehiculeInfoTech $request
     * @return array|Factory|View
     */
    public function index(IndexVehiculeInfoTech $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VehiculeInfoTech::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'nombre_place', 'nombre_porte', 'vitesse_maxi', 'nombre_vitesse', 'boite_vitesse', 'type_carburant', 'vehicule_id','kilometrage'],
                // set columns to searchIn
                ['id', 'vitesse_maxi', 'nombre_vitesse', 'boite_vitesse', 'type_carburant', 'fiche_technique','kilometrage']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.vehicule-info-tech.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.vehicule-info-tech.create');

        if (!$this->request->ajax()) {
            abort(404);
        }
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVehiculeInfoTech $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVehiculeInfoTech $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the VehiculeInfoTech
        $vehiculeInfoTech = VehiculeInfoTech::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-info-teches'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeInfoTech' => $vehiculeInfoTech
            ];
        }

        return redirect('admin/vehicule-info-teches');
    }

    /**
     * Display the specified resource.
     *
     * @param VehiculeInfoTech $vehiculeInfoTech
     * @throws AuthorizationException
     * @return void
     */
    public function show(VehiculeInfoTech $vehiculeInfoTech) {
        $this->authorize('admin.vehicule-info-tech.show', $vehiculeInfoTech);

        // TODO your code goes here

        if (!$this->request->ajax()) {
            abort(404);
        }
        return ['vehiculeInfoTech' => $vehiculeInfoTech];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VehiculeInfoTech $vehiculeInfoTech
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VehiculeInfoTech $vehiculeInfoTech) {
        $this->authorize('admin.vehicule-info-tech.edit', $vehiculeInfoTech);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'vehiculeInfoTech' => $vehiculeInfoTech,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVehiculeInfoTech $request
     * @param VehiculeInfoTech $vehiculeInfoTech
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVehiculeInfoTech $request, VehiculeInfoTech $vehiculeInfoTech) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values VehiculeInfoTech
        $vehiculeInfoTech->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-info-teches'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeInfoTech' => $vehiculeInfoTech
            ];
        }

        return redirect('admin/vehicule-info-teches');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVehiculeInfoTech $request
     * @param VehiculeInfoTech $vehiculeInfoTech
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVehiculeInfoTech $request, VehiculeInfoTech $vehiculeInfoTech) {
        $vehiculeInfoTech->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVehiculeInfoTech $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVehiculeInfoTech $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        VehiculeInfoTech::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
