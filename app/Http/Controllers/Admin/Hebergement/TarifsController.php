<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\Tarif\BulkDestroyTarif;
use App\Http\Requests\Admin\Hebergement\Tarif\DestroyTarif;
use App\Http\Requests\Admin\Hebergement\Tarif\IndexTarif;
use App\Http\Requests\Admin\Hebergement\Tarif\StoreTarif;
use App\Http\Requests\Admin\Hebergement\Tarif\RequestTarifWithVol;
use App\Http\Requests\Admin\Hebergement\Tarif\RequestUpdateWithVol;
use App\Http\Requests\Admin\Hebergement\Tarif\UpdateTarif;
use App\Models\Hebergement\Allotement;
use App\Models\Hebergement\BaseType;
use App\Models\Hebergement\Hebergement;
use App\Models\Hebergement\Tarif;
use App\Models\Hebergement\TypeChambre;
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

class TarifsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarif $request
     * @return array|Factory|View
     */
    public function index(IndexTarif $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Tarif::class)
            ->modifyQuery(
                function ($query) use ($request) {
                    $query->join('saisons', 'saisons.id', 'tarifs.saison_id');
                    $query->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id');
                    $query->leftjoin('base_type', 'base_type.id', 'tarifs.base_type_id');
                    $query->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id');
                    $query->leftjoin('allotements', 'allotements.id', 'hebergement_vol.allotement_id');
                    $query->leftjoin('compagnie_transport', 'compagnie_transport.id', 'allotements.compagnie_transport_id')->limit(1);
                    $query->with([
                        'type_chambre',
                        'saison',
                        'vol' => function ($query) {
                            $query->with(['allotement' => function ($query) {
                                $query->with(['compagnie', 'depart', 'arrive']);
                            }]);
                        },
                        'hebergement',
                        'tarif' => function ($query) {
                            $query->with(['personne']);
                        },
                        'base_type'
                    ])->where(['tarifs.hebergement_id' => $request->heb]);
                    if (isset($request->type_chambre_id)) {
                        $query->whereIn(
                            'tarifs.type_chambre_id',
                            explode(',', $request->type_chambre_id)
                        );
                    }
                }
            )
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                [
                    'id',
                    'titre',
                    'type_chambre_id',
                    'base_type_id',
                    'saison_id',
                    'description',
                    'taxe_active',
                    'taxe',
                    'jour_min',
                    'jour_max',
                    'nuit_min',
                    'nuit_max'
                ],
                // set columns to searchIn
                [
                    'id',
                    'saisons.titre',
                    'allotements.titre',
                    'compagnie_transport.nom',
                    'hebergement_vol.lien_depart',
                    'hebergement_vol.lien_arrive',
                    'hebergement_vol.depart',
                    'hebergement_vol.arrive',
                    'type_chambre.name',
                    'base_type.titre',
                    'jour_min',
                    'jour_max',
                    'nuit_min',
                    'nuit_max'
                ]
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        if (!(isset($request->heb) && Hebergement::find($request->heb))) {
            return redirect('admin/hebergements');
        }

        return view('admin.hebergement.tarif.index', [
            'data' => $data,
            'chambres' => collect(Hebergement::find($request->heb)->chambre()->get())->map(function ($data) {
                $data->base_type = BaseType::where('nombre', '<=', $data->capacite)->get();
                return $data;
            }),
            'hebergement' => Hebergement::find($request->heb),
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

        $this->authorize('admin.tarif.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        $heb = Hebergement::find($this->request->heb);
        if ($heb == null) {
            abort(404);
        }

        return [
            'personnes' => $heb->personne()->get(),
            'typeChambre' => collect(Hebergement::find($this->request->heb)->chambre()->get())->map(function ($data) {
                $data->base_type = BaseType::where('nombre', '<=', $data->capacite)->get();
                return $data;
            }),
            'saisons' => $heb->saison()->get(),
            'allotement' => Allotement::with(['depart', 'arrive'])->where('date_depart', '>=', date('Y-m-d'))->get(),
        ];
    }

    public function storeWithVol(RequestTarifWithVol $request)
    {

        //$book->authors()->syncWithoutDetaching([1, 2, 3]);
        //$book->authors()->sync([5, 2, 10]);
        // Sanitize input
        $tarifSanitize = $request->getSanitizedTarif();

        $volSanitize = $request->getSanitizedVol();

        // Store the Tarif
        $tarif = null;
        DB::transaction(function () use ($tarifSanitize, &$tarif) {
            // Store the ArticlesWithRelationship
            $tarif = Tarif::create($tarifSanitize);
            for ($i = 0; $i < count($tarifSanitize['type_personne_id']); $i++) {
                $_tarif = [
                    'marge' => $tarifSanitize['marge'][$i],
                    'prix_achat' => $tarifSanitize['prix_achat'][$i],
                    'prix_vente' => $tarifSanitize['prix_vente'][$i],
                    'type_personne_id' => $tarifSanitize['type_personne_id'][$i],
                    'tarif_id' => $tarif->id,
                ];
                if (isset($tarifSanitize['prix_vente_supp'][$i])) {
                    $_tarif['marge_supp'] = $tarifSanitize['marge_supp'][$i];
                    $_tarif['prix_achat_supp'] = $tarifSanitize['prix_achat_supp'][$i];
                    $_tarif['prix_vente_supp'] = $tarifSanitize['prix_vente_supp'][$i];
                }
                \App\Models\Hebergement\TarifTypePersonneHebergement::create($_tarif);
            }
        });
        //store the vol
        $volSanitize['tarif_id'] = $tarif->id;
        $vol = \App\Models\Hebergement\HebergementVol::create($volSanitize);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarifs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tarif' => $tarif,
                'vol' => Tarif::with(['vol'])->find($tarif->id)->vol
            ];
        }

        return redirect('admin/tarifs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarif $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarif $request)
    {

        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Tarif      
        $tarif = null;
        DB::transaction(function () use ($sanitized, &$tarif) {
            // Store the ArticlesWithRelationship
            $tarif = Tarif::create($sanitized);
            for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
                $_tarif = [
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'tarif_id' => $tarif->id,
                ];
                if (isset($sanitized['prix_vente_supp'][$i])) {
                    $_tarif['marge_supp'] = $sanitized['marge_supp'][$i];
                    $_tarif['prix_achat_supp'] = $sanitized['prix_achat_supp'][$i];
                    $_tarif['prix_vente_supp'] = $sanitized['prix_vente_supp'][$i];
                }
                \App\Models\Hebergement\TarifTypePersonneHebergement::create($_tarif);
            }
        });


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarifs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tarif' => $tarif,
                'vol' => $tarif ? Tarif::with(['vol'])->find($tarif->id)->vol : []
            ];
        }

        return redirect('admin/tarifs');
    }

    /**
     * Display the specified resource.
     *
     * @param Tarif $tarif
     * @throws AuthorizationException
     * @return void
     */
    public function show(Tarif $tarif)
    {

        $this->authorize('admin.tarif.show', $tarif);

        $tarif = Tarif::with([
            'vol' => function ($query) {
                $query->with(['allotement' => function ($query) {
                    $query->with(['compagnie', 'depart', 'arrive']);
                }]);
            },
            'hebergement',
            'saison',
            'type_chambre', 'tarif' => function ($query) {
                $query->with(['personne']);
            },
            'base_type'
        ])->find($tarif->id);

        if ($this->request->ajax()) {
            return ['data' => $tarif,];
        }

        return view('admin.hebergement.tarif.detail', [
            'data' => $tarif,
            'hebergement' => \App\Models\Hebergement\Hebergement::find($this->request->heb),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tarif $tarif
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Tarif $tarif)
    {

        $this->authorize('admin.tarif.edit', $tarif);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $tarif = Tarif::with(['vol' => function ($query) {
            $query->with(['allotement' => function ($query) {
                $query->with(['compagnie', 'depart', 'arrive']);
            }]);
        }, 'hebergement', 'saison', 'tarif', 'type_chambre'])->find($tarif->id);
        $heb = Hebergement::find($tarif->hebergement->id);
        if ($heb == null) {
            abort(404);
        }
        return [
            'tarif' => $tarif,
            'personnes' => $heb->personne()->get(),
            'typeChambre' => collect(Hebergement::find($heb->id)->chambre()->get())->map(function ($data) {
                $data->base_type = BaseType::where('nombre', '<=', $data->capacite)->get();
                return $data;
            }),
            'saisons' => $heb->saison()->get(),
            'allotement' => Allotement::with(['depart', 'arrive'])
                ->where(function ($query) use ($tarif) {
                    $query->where('date_depart', '>=', date('Y-m-d'));
                    if ($tarif->vol) {
                        $query->orWhere(['id' => $tarif->vol->allotement->id]);
                    }
                })
                ->get(),
        ];
    }

    public function updateWithVol(RequestUpdateWithVol $request, Tarif $tarif)
    {
        // Sanitize input
        $sanitized = $request->getSanitizedTarif();

        $requestVol = $request->getSanitizedVol();

        // Update changed values Tarif
        DB::transaction(function () use ($sanitized, &$tarif) {
            // Store the ArticlesWithRelationship
            $tarif->update($sanitized);
            for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
                $tarif_heb = \App\Models\Hebergement\TarifTypePersonneHebergement::where([
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'tarif_id' => $tarif->id,
                ])->get()
                    ->first();
                if ($tarif_heb) {
                    $_tarif = [
                        'marge' => $sanitized['marge'][$i],
                        'prix_achat' => $sanitized['prix_achat'][$i],
                        'prix_vente' => $sanitized['prix_vente'][$i],
                        'type_personne_id' => $sanitized['type_personne_id'][$i],
                        'tarif_id' => $tarif->id,
                    ];
                    if (isset($sanitized['prix_vente_supp'][$i])) {
                        $_tarif['marge_supp'] = $sanitized['marge_supp'][$i];
                        $_tarif['prix_achat_supp'] = $sanitized['prix_achat_supp'][$i];
                        $_tarif['prix_vente_supp'] = $sanitized['prix_vente_supp'][$i];
                    } else {
                        $_tarif['marge_supp'] = null;
                        $_tarif['prix_achat_supp'] = null;
                        $_tarif['prix_vente_supp'] = null;
                    }
                    $tarif_heb->update($_tarif);
                } else {
                    $_tarif = [
                        'marge' => $sanitized['marge'][$i],
                        'prix_achat' => $sanitized['prix_achat'][$i],
                        'prix_vente' => $sanitized['prix_vente'][$i],
                        'type_personne_id' => $sanitized['type_personne_id'][$i],
                        'tarif_id' => $tarif->id,
                    ];
                    if (isset($sanitized['prix_vente_supp'][$i])) {
                        $_tarif['marge_supp'] = $sanitized['marge_supp'][$i];
                        $_tarif['prix_achat_supp'] = $sanitized['prix_achat_supp'][$i];
                        $_tarif['prix_vente_supp'] = $sanitized['prix_vente_supp'][$i];
                    }
                    \App\Models\Hebergement\TarifTypePersonneHebergement::create($_tarif);
                }
            }
        });

        $vol = \App\Models\Hebergement\HebergementVol::where(['tarif_id' => $tarif->id])->get()->first();
        if ($vol) {
            $vol->update($requestVol);
        } else {
            $requestVol['tarif_id'] = $tarif->id;
            $vol = \App\Models\Hebergement\HebergementVol::create($requestVol);
        }


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarifs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarifs');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarif $request
     * @param Tarif $tarif
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarif $request, Tarif $tarif)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Tarif
        DB::transaction(function () use ($sanitized, &$tarif) {
            // Store the ArticlesWithRelationship
            $tarif->update($sanitized);
            for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
                $tarif_heb = \App\Models\Hebergement\TarifTypePersonneHebergement::where([
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'tarif_id' => $tarif->id,
                ])->get()
                    ->first();
                if ($tarif_heb) {
                    $_tarif = [
                        'marge' => $sanitized['marge'][$i],
                        'prix_achat' => $sanitized['prix_achat'][$i],
                        'prix_vente' => $sanitized['prix_vente'][$i],
                        'type_personne_id' => $sanitized['type_personne_id'][$i],
                        'tarif_id' => $tarif->id,
                    ];
                    if (isset($sanitized['prix_vente_supp'][$i])) {
                        $_tarif['marge_supp'] = $sanitized['marge_supp'][$i];
                        $_tarif['prix_achat_supp'] = $sanitized['prix_achat_supp'][$i];
                        $_tarif['prix_vente_supp'] = $sanitized['prix_vente_supp'][$i];
                    } else {
                        $_tarif['marge_supp'] = null;
                        $_tarif['prix_achat_supp'] = null;
                        $_tarif['prix_vente_supp'] = null;
                    }
                    $tarif_heb->update($_tarif);
                } else {
                    $_tarif = [
                        'marge' => $sanitized['marge'][$i],
                        'prix_achat' => $sanitized['prix_achat'][$i],
                        'prix_vente' => $sanitized['prix_vente'][$i],
                        'type_personne_id' => $sanitized['type_personne_id'][$i],
                        'tarif_id' => $tarif->id,
                    ];
                    if (isset($sanitized['prix_vente_supp'][$i])) {
                        $_tarif['marge_supp'] = $sanitized['marge_supp'][$i];
                        $_tarif['prix_achat_supp'] = $sanitized['prix_achat_supp'][$i];
                        $_tarif['prix_vente_supp'] = $sanitized['prix_vente_supp'][$i];
                    }
                    \App\Models\Hebergement\TarifTypePersonneHebergement::create($_tarif);
                }
            }
        });

        //delete vol
        $vol = \App\Models\Hebergement\HebergementVol::where(['tarif_id' => $tarif->id])->get()->first();
        if ($vol) {
            $vol->delete();
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarifs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarifs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarif $request
     * @param Tarif $tarif
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarif $request, Tarif $tarif)
    {
        $tarif->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarif $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarif $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Tarif::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
