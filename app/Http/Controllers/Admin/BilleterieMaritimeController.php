<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BilleterieMaritime\AutocompletionBilleterie;
use App\Http\Requests\Admin\BilleterieMaritime\BulkDestroyBilleterieMaritime;
use App\Http\Requests\Admin\BilleterieMaritime\DestroyBilleterieMaritime;
use App\Http\Requests\Admin\BilleterieMaritime\IndexBilleterieMaritime;
use App\Http\Requests\Admin\BilleterieMaritime\StoreBilleterieMaritime;
use App\Http\Requests\Admin\BilleterieMaritime\UpdateBilleterieMaritime;
use App\Models\BilleterieMaritime;
use App\Models\CompagnieTransport;
use App\Models\PlaningTime;
use App\Models\TypePersonne;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BilleterieMaritimeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBilleterieMaritime $request
     * @return array|Factory|View
     */
    public function index(IndexBilleterieMaritime $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(BilleterieMaritime::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('compagnie_transport', 'compagnie_transport.id', 'billeterie_maritime.compagnie_transport_id');
                $query->join('service_port', 'service_port.id', 'billeterie_maritime.lieu_depart_id');
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'availability', 'titre', 'lieu_depart_id', 'lieu_arrive_id', 'date_depart', 'date_arrive', 'date_acquisition', 'date_limite', 'image', 'quantite', 'compagnie_transport_id', 'parcours'],
                // set columns to searchIn
                ['id', 'titre', 'lieu_depart', 'lieu_arrive', 'date_depart', 'date_arrive', 'date_acquisition', 'date_limite', 'quantite', 'compagnie_transport.nom', 'service_port.name', 'service_port.code_service', 'parcours'],
                function ($query) use ($request) {

                    $query->with(['compagnie', 'tarif' => function ($query) use ($request) {
                        $query->with(['personne']);
                    }, 'depart' => function ($query) {
                        $query->with(['ville' => function ($query) {
                            $query->with(['pays']);
                        }]);
                    }, 'arrive' => function ($query) {
                        $query->with(['ville' => function ($query) {
                            $query->with(['pays']);
                        }]);
                    }]);
                }
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.billeterie-maritime.index', [
            'data' => $data,
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
        $this->authorize('admin.billeterie-maritime.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'typePersonne' => TypePersonne::whereNull('model')->whereNull('model_id')->get(),
            'compagnieTransport' => CompagnieTransport::where(['type_transport' => 'Maritime'])->get()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBilleterieMaritime $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBilleterieMaritime $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the BilleterieMaritime
        $billeterieMaritime = BilleterieMaritime::create($sanitized);

        //store heure billeterie
        if (isset($sanitized['debut']) && isset($sanitized['fin'])) {
            PlaningTime::create([
                'id_model' => 'billeterie_maritime_' . $billeterieMaritime->id,
                'debut' => $sanitized['debut'],
                'fin' => $sanitized['fin'],
            ]);
        }

        for ($i = 0; $i < count($sanitized['type_personne_type']); $i++) {
            $personne = DB::table('type_personne')->insertGetId([
                'type' => $sanitized['type_personne_type'][$i],
                'age' => $sanitized['type_personne_age'][$i],
                'description' => $sanitized['type_personne_description'][$i],
                'reference_prix' => $sanitized['type_personne_reference_prix'][$i],
                'model' => get_class($billeterieMaritime),
                'model_id' => $billeterieMaritime->id,
                'original_id' => $sanitized['type_personne_original_id'][$i]
            ]);
            $item_billet = [
                'marge_aller' => $sanitized['marge_aller'][$i],
                'prix_achat_aller' => $sanitized['prix_achat_aller'][$i],
                'prix_vente_aller' => $sanitized['prix_vente_aller'][$i],
                'type_personne_id' => $personne,
                'billeterie_maritime_id' => $billeterieMaritime->id,
            ];
            if (isset($sanitized['prix_vente_aller_retour'][$i])) {
                $item_billet['prix_achat_aller_retour'] = $sanitized['prix_achat_aller_retour'][$i];
                $item_billet['prix_vente_aller_retour'] = $sanitized['prix_vente_aller_retour'][$i];
                $item_billet['marge_aller_retour'] = $sanitized['marge_aller_retour'][$i];
            }
            \App\Models\TarifBilleterieMaritime::create($item_billet);
        }

        $billeterieMaritime = BilleterieMaritime::with(['compagnie', 'tarif' => function ($query) {
            $query->with(['personne']);
        }])->find($billeterieMaritime->id);
        $billeterieMaritime['planingTime'] = \App\Models\PlaningTime::where(['id_model' => 'billeterie_maritime_' . $billeterieMaritime->id])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/billeterie-maritimes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'billeterieMaritime' => $billeterieMaritime,
            ];
        }

        return redirect('admin/billeterie-maritimes');
    }

    /**
     * Display the specified resource.
     *
     * @param BilleterieMaritime $billeterieMaritime
     * @throws AuthorizationException
     * @return void
     */
    public function show(\Illuminate\Http\Request $request, BilleterieMaritime $billeterieMaritime)
    {
        $this->authorize('admin.billeterie-maritime.show', $billeterieMaritime);
        $data = BilleterieMaritime::with([
            'compagnie', 'tarif' => function ($query) {
                $query->with(['personne']);
            },
            'depart' => function ($query) {
                $query->with(['ville' => function ($query) {
                    $query->with(['pays']);
                }]);
            }, 'arrive' => function ($query) {
                $query->with(['ville' => function ($query) {
                    $query->with(['pays']);
                }]);
            }
        ])->find($billeterieMaritime->id);
        $data['planingTime'] = \App\Models\PlaningTime::where(['id_model' => 'billeterie_maritime_' . $billeterieMaritime->id])->get();

        if ($request->ajax()) {
            return [
                'data' => $data,
            ];
        }
        return view('admin.billeterie-maritime.detail', [
            'data' => json_encode($data),
            'billeterieMaritime' => $billeterieMaritime,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BilleterieMaritime $billeterieMaritime
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(BilleterieMaritime $billeterieMaritime)
    {
        $this->authorize('admin.billeterie-maritime.edit', $billeterieMaritime);

        if (!$this->request->ajax()) {
            abort(404);
        }
        $billeterieMaritime = BilleterieMaritime::with(['compagnie', 'depart' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'arrive' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }])->find($billeterieMaritime->id);
        return [
            'billeterieMaritime' => $billeterieMaritime,
            'typePersonne' => $billeterieMaritime->personne()->get(),
            'tarif' => BilleterieMaritime::with(['compagnie', 'tarif' => function ($query) {
                $query->with(['personne']);
            }])->find($billeterieMaritime->id),
            'compagnieTransport' => \App\Models\CompagnieTransport::where(['type_transport' => 'Maritime'])->get()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBilleterieMaritime $request
     * @param BilleterieMaritime $billeterieMaritime
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBilleterieMaritime $request, BilleterieMaritime $billeterieMaritime)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values BilleterieMaritime
        $billeterieMaritime->update($sanitized);
        $personne_id = [];
        for ($i = 0; $i < count($sanitized['type_personne_type']); $i++) {
            $personne = null;
            if ($sanitized['type_personne_id'][$i] == 0) {
                $personne = DB::table('type_personne')->insertGetId([
                    'type' => $sanitized['type_personne_type'][$i],
                    'age' => $sanitized['type_personne_age'][$i],
                    'description' => $sanitized['type_personne_description'][$i],
                    'reference_prix' => $sanitized['type_personne_reference_prix'][$i],
                    'model' => get_class($billeterieMaritime),
                    'model_id' => $billeterieMaritime->id,
                    'original_id' => $sanitized['type_personne_original_id'][$i]
                ]);
                $personne_id[] = $personne;
            } else {
                $personne = $sanitized['type_personne_id'][$i];
                $personne_id[] = $personne;
                TypePersonne::find($personne)->update([
                    'type' => $sanitized['type_personne_type'][$i],
                    'age' => $sanitized['type_personne_age'][$i],
                    'description' => $sanitized['type_personne_description'][$i],
                    'original_id' => $sanitized['type_personne_original_id'][$i]
                ]);
            }
            /** */
            $tarif = \App\Models\TarifBilleterieMaritime::where([
                'type_personne_id' => $personne,
                'billeterie_maritime_id' => $billeterieMaritime->id,
            ])->get()
                ->first();
            $item_billet = [
                'marge_aller' => $sanitized['marge_aller'][$i],
                'prix_achat_aller' => $sanitized['prix_achat_aller'][$i],
                'prix_vente_aller' => $sanitized['prix_vente_aller'][$i],
                'type_personne_id' => $personne,
                'billeterie_maritime_id' => $billeterieMaritime->id,
            ];
            if (isset($sanitized['prix_vente_aller_retour'][$i])) {
                $item_billet['prix_achat_aller_retour'] = $sanitized['prix_achat_aller_retour'][$i];
                $item_billet['prix_vente_aller_retour'] = $sanitized['prix_vente_aller_retour'][$i];
                $item_billet['marge_aller_retour'] = $sanitized['marge_aller_retour'][$i];
            }
            if ($tarif != null) {
                $tarif->update($item_billet);
            } else {
                \App\Models\TarifBilleterieMaritime::create($item_billet);
            }
        }
        /* destruct personne */
        $billeterieMaritime->personne()->whereNotIn('id', $personne_id)->delete();

        $billeterieMaritime = BilleterieMaritime::with(['compagnie', 'tarif' => function ($query) {
            $query->with(['personne']);
        }])->find($billeterieMaritime->id);
        $billeterieMaritime['planingTime'] = \App\Models\PlaningTime::where(['id_model' => 'billeterie_maritime_' . $billeterieMaritime->id])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/billeterie-maritimes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'billeterieMaritime' => $billeterieMaritime,
            ];
        }

        return redirect('admin/billeterie-maritimes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBilleterieMaritime $request
     * @param BilleterieMaritime $billeterieMaritime
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBilleterieMaritime $request, BilleterieMaritime $billeterieMaritime)
    {
        $billeterieMaritime->personne()->delete();
        $billeterieMaritime->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBilleterieMaritime $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBilleterieMaritime $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    collect(BilleterieMaritime::whereIn('id', $bulkChunk)->get())->map(function ($billeterieMaritime) {
                        $billeterieMaritime->personne()->delete();
                        $billeterieMaritime->delete();
                    });
                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionBilleterie $resquest)
    {
        $sanitized = $resquest->getSanitized();

        $billeterie = BilleterieMaritime::with(['compagnie' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'depart' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'arrive' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }])->where('titre', 'like', '%' . $sanitized['search'] . '%')
            ->limit(20)
            ->get();

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'search' => $billeterie,
        ];
    }
}
