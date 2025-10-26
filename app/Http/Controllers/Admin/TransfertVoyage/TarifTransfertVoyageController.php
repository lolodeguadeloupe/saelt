<?php

namespace App\Http\Controllers\Admin\TransfertVoyage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransfertVoyage\TarifTransfertVoyage\BulkDestroyTarifTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TarifTransfertVoyage\DestroyTarifTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TarifTransfertVoyage\IndexTarifTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TarifTransfertVoyage\StoreTarifTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TarifTransfertVoyage\UpdateTarifTransfertVoyage;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\TransfertVoyage\TarifTransfertVoyage;
use App\Models\TransfertVoyage\TranchePersonneTransfertVoyage;
use App\Models\TransfertVoyage\TrajetTransfertVoyage;
use App\Models\TransfertVoyage\TransfertVoyagePrimeNuit;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use App\Models\TypePersonne;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TarifTransfertVoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifTransfertVoyage $request
     * @return array|Factory|View
     */
    public function index(IndexTarifTransfertVoyage $request)
    {
        if (!isset($request->transfert)) {
            abort(404);
        }
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TarifTransfertVoyage::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('tranche_personne_transfert_voyage', 'tranche_personne_transfert_voyage.id', 'tarif_transfert_voyage.tranche_transfert_voyage_id');
                $query->join('type_transfert_voyage', 'type_transfert_voyage.id', 'tranche_personne_transfert_voyage.type_transfert_id');
                $query->join('type_personne', 'type_personne.id', 'tarif_transfert_voyage.type_personne_id');
                $query->join('trajet_transfert_voyage', 'trajet_transfert_voyage.id', 'tarif_transfert_voyage.trajet_transfert_voyage_id');
                $query->with([
                    'personne', 'trajet' => function ($query) {
                        $query->with(['point_depart', 'point_arrive']);
                    },
                    'tranche' => function ($query) {
                        $query->with([
                            'type' => function ($query) {
                                $query->select('type_transfert_voyage.*');
                                $query->join('tranche_personne_transfert_voyage', 'tranche_personne_transfert_voyage.type_transfert_id', 'type_transfert_voyage.id');
                                $query->join('tarif_transfert_voyage', 'tarif_transfert_voyage.tranche_transfert_voyage_id', 'tranche_personne_transfert_voyage.id');
                                $query->join('trajet_transfert_voyage', 'trajet_transfert_voyage.id', 'tarif_transfert_voyage.trajet_transfert_voyage_id');
                            }
                        ]);
                    }
                ]);
                $query->where([
                    'type_transfert_voyage.id' => $request->transfert
                ]);
                if (isset($request->trajet_transfert_voyage_id)) {
                    $query->where([
                        'trajet_transfert_voyage_id' => $request->trajet_transfert_voyage_id
                    ]);
                }
                if (isset($request->tranche_transfert_voyage_id)) {
                    $query->where([
                        'tranche_transfert_voyage_id' => $request->tranche_transfert_voyage_id
                    ]);
                }
                $query->orderBy('tarif_transfert_voyage.type_personne_id', 'asc');
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'trajet_transfert_voyage_id', 'tranche_transfert_voyage_id', 'type_personne_id', 'prix_achat_aller', 'prix_achat_aller_retour', 'marge_aller', 'marge_aller_retour', 'prix_vente_aller', 'prix_vente_aller_retour', 'prime_nuit'],
                // set columns to searchIn
                ['id', 'prix_achat_aller', 'prix_achat_aller_retour', 'marge_aller', 'marge_aller_retour', 'prix_vente_aller', 'prix_vente_aller_retour', 'prime_nuit']
            );

        $typeTransfertVoyage = TypeTransfertVoyage::find($request->transfert);
        if ($typeTransfertVoyage == null) {
            abort(404);
        }

        $collection = $data->getCollection();

        $collection = collect($collection)->groupBy(['trajet_transfert_voyage_id', 'tranche_transfert_voyage_id'])->values();

        $new_collection = collect([]);

        collect($collection)->map(function ($data_1) use (&$new_collection) {
            collect($data_1)->map(function ($data_2) use (&$new_collection) {
                if (isset($data_2[0])) {
                    $new_collection->push([
                        'resource_url' => url('admin/tarif-transfert-voyages/' . $data_2[0]->trajet->id . '_' . $data_2[0]->tranche->id),
                        'id' => collect($data_2)->pluck('id')->join('_'),
                        'trajet' => $data_2[0]->trajet,
                        'tranche' => $data_2[0]->tranche,
                        'tarif' => collect($data_2)->values()->toArray(),
                        'prime_nuit' => TransfertVoyagePrimeNuit::where([
                            'trajet_id' => $data_2[0]->trajet->id,
                            'type_transfert_id' =>  $data_2[0]->tranche->type->id
                        ])->first()
                    ]);
                }
            });
        });

        $data->setCollection($new_collection);

        //dd($data->toArray());

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return [
                'data' => $data,
                'tranchetransfertvoyage' => TranchePersonneTransfertVoyage::where(['type_transfert_id' => $typeTransfertVoyage->id])->get(),
                'trajettransfertvoyage' => TrajetTransfertVoyage::all(),
                'typetransfertVoyage' => $typeTransfertVoyage
            ];
        }

        return view('admin.transfert-voyage.tarif-transfert-voyage.index', [
            'data' => $data,
            'tranchetransfertvoyage' => TranchePersonneTransfertVoyage::where(['type_transfert_id' => $typeTransfertVoyage->id])->get(),
            'trajettransfertvoyage' => TrajetTransfertVoyage::all(),
            'typeTransfertVoyage' => $typeTransfertVoyage
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
        $this->authorize('admin.tarif-transfert-voyage.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        if (!isset($this->request->transfert)) {
            abort(404);
        }
        $typeTransfertVoyage = TypeTransfertVoyage::find($this->request->transfert);
        if ($typeTransfertVoyage == null) {
            abort(404);
        }

        return [
            'typePersonne' => $typeTransfertVoyage->personne()->get(),
            'trajetTransfertVoyage' => TrajetTransfertVoyage::all(),
            'tranchetransfertvoyage' => TranchePersonneTransfertVoyage::where(['type_transfert_id' => $typeTransfertVoyage->id])->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifTransfertVoyage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifTransfertVoyage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        if (!isset($request->transfert)) {
            abort(404);
        }

        $typeTransfertVoyage = TypeTransfertVoyage::find($request->transfert);

        if ($typeTransfertVoyage == null) {
            abort(404);
        }

        $tarifTransfertVoyage = TarifTransfertVoyage::where([
            'trajet_transfert_voyage_id' => $sanitized['trajet_transfert_voyage_id'],
            'tranche_transfert_voyage_id' => $sanitized['tranche_transfert_voyage_id']
        ])->get();

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            $tarifTransfertVoyage = TarifTransfertVoyage::where([
                'trajet_transfert_voyage_id' => $sanitized['trajet_transfert_voyage_id'],
                'tranche_transfert_voyage_id' => $sanitized['tranche_transfert_voyage_id'],
                'type_personne_id' => $sanitized['type_personne_id'][$i],
            ])->first();

            if ($tarifTransfertVoyage == null) {
                $tarifTransfertVoyage = TarifTransfertVoyage::create([
                    'trajet_transfert_voyage_id' => $sanitized['trajet_transfert_voyage_id'],
                    'tranche_transfert_voyage_id' => $sanitized['tranche_transfert_voyage_id'],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    //
                    'marge_aller' => $sanitized['marge_aller'][$i],
                    'prix_achat_aller' => $sanitized['prix_achat_aller'][$i],
                    'prix_vente_aller' => $sanitized['prix_vente_aller'][$i],
                    //
                    'marge_aller_retour' => $sanitized['marge_aller_retour'][$i],
                    'prix_achat_aller_retour' => $sanitized['prix_achat_aller_retour'][$i],
                    'prix_vente_aller_retour' => $sanitized['prix_vente_aller_retour'][$i],
                ]);
            } else {
                $tarifTransfertVoyage->update([
                    'marge_aller' => $sanitized['marge_aller'][$i],
                    'prix_achat_aller' => $sanitized['prix_achat_aller'][$i],
                    'prix_vente_aller' => $sanitized['prix_vente_aller'][$i],
                    //
                    'marge_aller_retour' => $sanitized['marge_aller_retour'][$i],
                    'prix_achat_aller_retour' => $sanitized['prix_achat_aller_retour'][$i],
                    'prix_vente_aller_retour' => $sanitized['prix_vente_aller_retour'][$i],
                ]);
            }
        }
        $typeTransfertVoyage->prime_nuit_trajet()->sync([$sanitized['trajet_transfert_voyage_id'] => ['prime_nuit' => $sanitized['prime_nuit']]]);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tarifTransfertVoyage' => $tarifTransfertVoyage,
            ];
        }

        return redirect('admin/tarif-transfert-voyages');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifTransfertVoyage $tarifTransfertVoyage
     * @throws AuthorizationException
     * @return void
     */
    public function show(TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage, TrajetTransfertVoyage $trajetTransfertVoyage)
    {
        $this->authorize('admin.tarif-transfert-voyage.show', $tranchePersonneTransfertVoyage);

        if (!$this->request->ajax()) {
            abort(404);
        }

        if (!isset($this->request->transfert)) {
            abort(404);
        }

        $typeTransfertVoyage = TypeTransfertVoyage::find($this->request->transfert);

        if ($typeTransfertVoyage == null) {
            abort(404);
        }

        $trajetTransfertVoyage = TrajetTransfertVoyage::with(['point_depart', 'point_arrive'])->find($trajetTransfertVoyage->id);

        $tarifTransfertVoyage = TarifTransfertVoyage::with([
            'personne', 'trajet' => function ($query) {
                $query->with(['point_depart', 'point_arrive']);
            },
            'tranche' => function ($query) use ($trajetTransfertVoyage) {
                $query->with([
                    'type' => function ($query) use ($trajetTransfertVoyage) {
                        $query->with([
                            'prime_nuit_trajet' => function ($query) use ($trajetTransfertVoyage) {
                                $query->where(['trajet_id' => $trajetTransfertVoyage->id]);
                            }
                        ]);
                    }
                ]);
            }
        ])
            ->where([
                'trajet_transfert_voyage_id' => $trajetTransfertVoyage->id,
                'tranche_transfert_voyage_id' => $tranchePersonneTransfertVoyage->id
            ])->get();
        // TODO your code goes here
        return [
            'tarifTransfertVoyage' => $tarifTransfertVoyage,
            'typePersonne' => $typeTransfertVoyage->personne()->get(),
            'trajetTransfertVoyage' => TrajetTransfertVoyage::all(),
            'tranchetransfertvoyage' => TranchePersonneTransfertVoyage::where(['type_transfert_id' => $typeTransfertVoyage->id])->get(),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifTransfertVoyage $tarifTransfertVoyage
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit($trajetTranche)
    {
        $this->authorize('admin.tarif-transfert-voyage.edit', $trajetTranche);

        if (!$this->request->ajax()) {
            abort(404);
        }

        if (!isset($this->request->transfert)) {
            abort(404);
        }

        $typeTransfertVoyage = TypeTransfertVoyage::find($this->request->transfert);

        if ($typeTransfertVoyage == null) {
            abort(404);
        }

        $tarifTransfertVoyage = TarifTransfertVoyage::with(['personne', 'trajet', 'tranche' => function ($query) {
            $query->with(['type']);
        }])->where([
            'trajet_transfert_voyage_id' => explode('_', $trajetTranche)[0],
            'tranche_transfert_voyage_id' => explode('_', $trajetTranche)[1]
        ])->get();

        return [
            'resource_url' => url('admin/tarif-transfert-voyages/' . $trajetTranche),
            'tarifTransfertVoyage' => $tarifTransfertVoyage,
            'prime_nuit' => TransfertVoyagePrimeNuit::where([
                'trajet_id' => explode('_', $trajetTranche)[0],
                'type_transfert_id' => $this->request->transfert,
            ])->first(),
            'tranchetransfertvoyage' => TranchePersonneTransfertVoyage::where(['type_transfert_id' => $typeTransfertVoyage->id])->get(),
            'typePersonne' => $typeTransfertVoyage->personne()->get(),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifTransfertVoyage $request
     * @param TarifTransfertVoyage $tarifTransfertVoyage
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifTransfertVoyage $request, $trajetTranche)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        for ($index = 0; $index < count($sanitized['type_personne_id']); $index++) {
            $tarifTransfertVoyage = TarifTransfertVoyage::where([
                'trajet_transfert_voyage_id' => explode('_', $trajetTranche)[0],
                'type_personne_id' => $sanitized['type_personne_id'][$index],
                'tranche_transfert_voyage_id' => explode('_', $trajetTranche)[1],
            ])->first();
            if ($tarifTransfertVoyage) {
                $tarifTransfertVoyage->update([
                    'prix_achat_aller' => $sanitized['prix_achat_aller'][$index],
                    'prix_achat_aller_retour' => $sanitized['prix_achat_aller_retour'][$index],
                    'marge_aller' => $sanitized['marge_aller'][$index],
                    'marge_aller_retour' => $sanitized['marge_aller_retour'][$index],
                    'prix_vente_aller' => $sanitized['prix_vente_aller'][$index],
                    'prix_vente_aller_retour' => $sanitized['prix_vente_aller_retour'][$index],
                ]);
            }
        }

        /*TranchePersonneTransfertVoyage::find($sanitized['tranche_transfert_voyage_id'])
            ->type()
            ->first()
            ->prime_nuit_trajet()
            ->sync([$sanitized['trajet_transfert_voyage_id'] => ['prime_nuit' => $sanitized['prime_nuit']]]);*/
        $type_transfert = TranchePersonneTransfertVoyage::find(explode('_', $trajetTranche)[1])->type()->first();
        $prime_nuit = TransfertVoyagePrimeNuit::where([
            'trajet_id' => explode('_', $trajetTranche)[0],
            'type_transfert_id' => $type_transfert->id
        ])->first();

        if ($prime_nuit == null) {
            $prime_nuit = TransfertVoyagePrimeNuit::create([
                'trajet_id' => explode('_', $trajetTranche)[0],
                'type_transfert_id' => $type_transfert->id,
                'prime_nuit' => $sanitized['prime_nuit']
            ]);
        } else {
            $prime_nuit->update(['prime_nuit' => $sanitized['prime_nuit']]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-transfert-voyages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifTransfertVoyage $request
     * @param TarifTransfertVoyage $tarifTransfertVoyage
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifTransfertVoyage $request, $trajetTranche)
    {
        TarifTransfertVoyage::where([
            'trajet_transfert_voyage_id' => explode('_', $trajetTranche)[0],
            'tranche_transfert_voyage_id' => explode('_', $trajetTranche)[1]
        ])->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifTransfertVoyage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifTransfertVoyage $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TarifTransfertVoyage::where([
                        'trajet_transfert_voyage_id' => explode('_', $bulkChunk)[0],
                        'tranche_transfert_voyage_id' => explode('_', $bulkChunk)[1]
                    ])->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
