<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation\BulkDestroyTarifTrancheSaisonLocation;
use App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation\DestroyTarifTrancheSaisonLocation;
use App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation\IndexTarifTrancheSaisonLocation;
use App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation\StoreTarifTrancheSaisonLocation;
use App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation\UpdateTarifTrancheSaisonLocation;
use App\Models\LocationVehicule\TarifTrancheSaisonLocation;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\LocationVehicule\CategorieVehicule;
use App\Models\LocationVehicule\TrancheSaison;
use App\Models\Saison;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TarifTrancheSaisonLocationController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifTrancheSaisonLocation $request
     * @return array|Factory|View
     */
    public function index(IndexTarifTrancheSaisonLocation $request, VehiculeLocation $vehicule) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TarifTrancheSaisonLocation::class)
                ->modifyQuery(function($query) use ($request, $vehicule) {
                    $query->join('saisons','saisons.id','tarif_tranche_saison_location.saisons_id');
                    $query->join('tranche_saison','tranche_saison.id','tarif_tranche_saison_location.tranche_saison_id');
                    $query->with(['trancheSaison', 'vehicule', 'saison']);
                    $query->where(['vehicule_location_id' => $vehicule->id]);
                    if (isset($request->saisons_id)) {
                        $query->where(['saisons_id' => $request->saisons_id]);
                    }
                    if (isset($request->tranche_saison_id)) {
                        $query->where(['tranche_saison_id' => $request->tranche_saison_id]);
                    }
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['tarif_tranche_saison_location.id', 'tarif_tranche_saison_location.marge', 'tarif_tranche_saison_location.prix_achat', 'tarif_tranche_saison_location.prix_vente', 'tarif_tranche_saison_location.tranche_saison_id', 'tarif_tranche_saison_location.vehicule_location_id', 'tarif_tranche_saison_location.saisons_id'],
                // set columns to searchIn
                ['tarif_tranche_saison_location.id', 'tarif_tranche_saison_location.marge', 'tarif_tranche_saison_location.prix_achat', 'tarif_tranche_saison_location.prix_vente', 'tranche_saison.titre', 'vehicule_location.titre', 'saisons.titre']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        
        return view('admin.location-vehicule.tarif-tranche-saison-location.index', [
            'data' => $data,
            'saison' => $vehicule->saison()->get(),
            'tranche_saison' => $vehicule->tranche_saison()->get(),
            'vehicule' => $vehicule,
            'vehiculeLocation' => $vehicule
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create(VehiculeLocation $vehicule) {
        $this->authorize('admin.tarif-tranche-saison-location.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'saison' => $vehicule->saison()->get(),
            'tranche_saison' => $vehicule->tranche_saison()->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifTrancheSaisonLocation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifTrancheSaisonLocation $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        for ($i = 0; $i < count($sanitized['tranche_saison_id']); $i++) {

            $tarifTrancheSaisonLocation = TarifTrancheSaisonLocation::where([
                        'saisons_id' => $sanitized['saisons_id'],
                        'tranche_saison_id' => $sanitized['tranche_saison_id'][$i],
                        'vehicule_location_id' => $sanitized['vehicule_location_id']
                    ])->get()->first();

            if ($tarifTrancheSaisonLocation) {
                $tarifTrancheSaisonLocation->update([
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'saisons_id' => $sanitized['saisons_id'],
                    'vehicule_location_id' => $sanitized['vehicule_location_id'],
                    'tranche_saison_id' => $sanitized['tranche_saison_id'][$i],
                ]);
            } else {
                $tarifTrancheSaisonLocation = TarifTrancheSaisonLocation::create([
                            'marge' => $sanitized['marge'][$i],
                            'prix_achat' => $sanitized['prix_achat'][$i],
                            'prix_vente' => $sanitized['prix_vente'][$i],
                            'saisons_id' => $sanitized['saisons_id'],
                            'vehicule_location_id' => $sanitized['vehicule_location_id'],
                            'tranche_saison_id' => $sanitized['tranche_saison_id'][$i],
                ]);
            }
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-tranche-saison-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tarifTrancheSaisonLocation' => $tarifTrancheSaisonLocation
            ];
        }

        return redirect('admin/tarif-tranche-saison-locations');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifTrancheSaisonLocation $tarifTrancheSaisonLocation
     * @throws AuthorizationException
     * @return void
     */
    public function show(VehiculeLocation $vehicule, Saison $saison) {
        $this->authorize('admin.tarif-tranche-saison-location.show', $vehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }
        // TODO your code goes here
        $tarif = TarifTrancheSaisonLocation::with(['trancheSaison', 'vehicule', 'saison'])
                        ->where([
                            'vehicule_location_id' => $vehicule->id,
                            'saisons_id' => $saison->id
                        ])->get();
        return [
            'tarif' => $tarif,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifTrancheSaisonLocation $tarifTrancheSaisonLocation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TarifTrancheSaisonLocation $tarifTrancheSaisonLocation) {
        $this->authorize('admin.tarif-tranche-saison-location.edit', $tarifTrancheSaisonLocation);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $tarifTrancheSaisonLocation = TarifTrancheSaisonLocation::with(['trancheSaison', 'vehicule', 'saison'])
                ->find($tarifTrancheSaisonLocation->id);
        return [
            'tarifTrancheSaisonLocation' => $tarifTrancheSaisonLocation,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifTrancheSaisonLocation $request
     * @param TarifTrancheSaisonLocation $tarifTrancheSaisonLocation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifTrancheSaisonLocation $request, TarifTrancheSaisonLocation $tarifTrancheSaisonLocation) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifTrancheSaisonLocation
        $tarifTrancheSaisonLocation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-tranche-saison-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-tranche-saison-locations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifTrancheSaisonLocation $request
     * @param TarifTrancheSaisonLocation $tarifTrancheSaisonLocation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifTrancheSaisonLocation $request, TarifTrancheSaisonLocation $tarifTrancheSaisonLocation) {
        $tarifTrancheSaisonLocation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifTrancheSaisonLocation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifTrancheSaisonLocation $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        TarifTrancheSaisonLocation::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
