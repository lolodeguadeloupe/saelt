<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\TrancheSaison\BulkDestroyTrancheSaison;
use App\Http\Requests\Admin\LocationVehicule\TrancheSaison\DestroyTrancheSaison;
use App\Http\Requests\Admin\LocationVehicule\TrancheSaison\IndexTrancheSaison;
use App\Http\Requests\Admin\LocationVehicule\TrancheSaison\StoreTrancheSaison;
use App\Http\Requests\Admin\LocationVehicule\TrancheSaison\UpdateTrancheSaison;
use App\Models\LocationVehicule\TrancheSaison;
use App\Models\LocationVehicule\VehiculeLocation;
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

class LocationVehiculeTrancheSaisonController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTrancheSaison $request
     * @return array|Factory|View
     */
    public function index(IndexTrancheSaison $request)
    {
        // create and AdminListing instance for a specific model and
        $locationVehicule = VehiculeLocation::find($request->location);
        if($locationVehicule == null){
            abort(404);
        }
        $data = AdminListing::create(TrancheSaison::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->where(['model' => VehiculeLocation::class,'model_id'=>$request->location ]);
            })

            ->processRequestAndGet(
                // pass the request with params
                $request,

                // set columns to query
                ['id', 'titre', 'nombre_min', 'nombre_max'],

                // set columns to searchIn
                ['id', 'titre', 'nombre_min', 'nombre_max']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.location-vehicule.tranche-saison.index', [
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
    public function create()
    {
        $this->authorize('admin.tranche-saison.create');

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTrancheSaison $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTrancheSaison $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $locationVehicule = VehiculeLocation::find($request->location);
        if($locationVehicule == null){
            abort(404);
        }

        $trancheSaison = $locationVehicule->tranche_saison()->create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tranche-saisons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'trancheSaison' => $trancheSaison
            ];
        }

        return redirect('admin/tranche-saisons');
    }

    /**
     * Display the specified resource.
     *
     * @param TrancheSaison $trancheSaison
     * @throws AuthorizationException
     * @return void
     */
    public function show(TrancheSaison $trancheSaison)
    {
        $this->authorize('admin.tranche-saison.show', $trancheSaison);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TrancheSaison $trancheSaison
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TrancheSaison $trancheSaison)
    {
        $this->authorize('admin.tranche-saison.edit', $trancheSaison);


        return [
            'trancheSaison' => $trancheSaison,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTrancheSaison $request
     * @param TrancheSaison $trancheSaison
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTrancheSaison $request, TrancheSaison $trancheSaison)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TrancheSaison
        $trancheSaison->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tranche-saisons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'trancheSaison' => $trancheSaison,
            ];
        }

        return redirect('admin/tranche-saisons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTrancheSaison $request
     * @param TrancheSaison $trancheSaison
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTrancheSaison $request, TrancheSaison $trancheSaison)
    {
        $trancheSaison->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTrancheSaison $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTrancheSaison $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TrancheSaison::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
