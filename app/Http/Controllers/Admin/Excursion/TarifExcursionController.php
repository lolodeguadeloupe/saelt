<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excursion\TarifExcursion\BulkDestroyTarifExcursion;
use App\Http\Requests\Admin\Excursion\TarifExcursion\DestroyTarifExcursion;
use App\Http\Requests\Admin\Excursion\TarifExcursion\IndexTarifExcursion;
use App\Http\Requests\Admin\Excursion\TarifExcursion\StoreTarifExcursion;
use App\Http\Requests\Admin\Excursion\TarifExcursion\UpdateTarifExcursion;
use App\Http\Requests\Admin\Excursion\TarifExcursion\UpdateAllTarifExcursion;
use App\Models\Excursion\Excursion;
use App\Models\Excursion\TarifExcursion;
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

class TarifExcursionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexTarifExcursion $request)
    {
        $excursion = Excursion::find($request->excursion);
        if ($excursion == null) {
            abort(404);
        }

        $saison  = $excursion->saison()->get();
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Saison::class)
            ->modifyQuery(function ($query) use ($request, $saison) {
                $query->whereIn('id', collect($saison)->map(function ($saison) {
                    return collect($saison)->only(['id'])->all();
                }));
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'debut', 'fin', 'titre','debut_format','fin_format'],
                // set columns to searchIn
                ['id', 'debut', 'fin', 'titre']
            );

        $collection = $data->getCollection();
        $collection = json_decode(json_encode($collection));

        $collection = collect($collection)->map(function($data){
            $data->tarif = TarifExcursion::with(['personne','excursion','saison'])->where(['saison_id'=>$data->id])->get();
            return $data;
        });

        $data->setCollection(collect($collection));

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }


        if (!(isset($request->excursion) && \App\Models\Excursion\Excursion::find($request->excursion))) {
            return redirect('admin/excursions');
        }

        return view('admin.excursion.tarif-excursion.index', [
            'data' => $data,
            'excursion' => \App\Models\Excursion\Excursion::find($request->excursion)
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
        $this->authorize('admin.tarif-excursion.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        $exc = Excursion::find($this->request->excursion);
        if ($exc == null) {
            abort(404);
        }

        return [
            'typePersonne' => $exc->personne()->get(),
            'saison' => $exc->saison()->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifExcursion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TarifExcursion
        $tarifExcursion = null;

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            $tarifExcursion = TarifExcursion::create([
                'marge' => $sanitized['marge'][$i],
                'prix_achat' => $sanitized['prix_achat'][$i],
                'prix_vente' => $sanitized['prix_vente'][$i],
                'excursion_id' => $sanitized['excursion_id'],
                'saison_id' => $sanitized['saison_id'],
                'type_personne_id' => $sanitized['type_personne_id'][$i],
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tarifExcursion' => $tarifExcursion,
            ];
        }

        return redirect('admin/tarif-excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifExcursion $tarifExcursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(\App\Models\Excursion\Excursion $excursion)
    {
        $this->authorize('admin.tarif-excursion.show', $excursion);

        $saison = $excursion->saison()->first();
        if ($saison == null) {
            return [];
        }
        return [
            'tarifExcursion' => TarifExcursion::with(['saison', 'personne'])
                ->where(['saison_id' => $saison->id, 'excursion_id' => $excursion->id])->get(),
            'typePersonne' => $excursion->personne()->get(),
            'saison' => $excursion->saison()->get(),
        ];
    }

    public function showTarifSaison(\App\Models\Excursion\Excursion $excursion, Saison $saison)
    {
        $this->authorize('admin.tarif-excursion.show-tarif-saison', $excursion);

        return [
            'tarifExcursion' => TarifExcursion::with(['saison', 'personne'])
                ->where(['saison_id' => $saison->id, 'excursion_id' => $excursion->id])->get(),
            'typePersonne' => $excursion->personne()->get(),
            'saison' => $excursion->saison()->get(),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifExcursion $tarifExcursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TarifExcursion $tarifExcursion)
    {
        $this->authorize('admin.tarif-excursion.edit', $tarifExcursion);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'tarifExcursion' => TarifExcursion::with(['personne'])->find($tarifExcursion->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifExcursion $request
     * @param TarifExcursion $tarifExcursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifExcursion $request, TarifExcursion $tarifExcursion)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifExcursion

        $tarifExcursion->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tarifExcursion' => $tarifExcursion,
            ];
        }

        return redirect('admin/tarif-excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifExcursion $request
     * @param TarifExcursion $tarifExcursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifExcursion $request, TarifExcursion $tarifExcursion)
    {
        $tarifExcursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifExcursion $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TarifExcursion::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function updateAll(UpdateAllTarifExcursion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifExcursion
        $tarifExcursion = null;

        DB::transaction(function () use ($sanitized, &$tarifExcursion) {
            // Store the ArticlesWithRelationship

            for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
                $tarifExcursion = TarifExcursion::where([
                    'excursion_id' => $sanitized['excursion_id'],
                    'saison_id' => $sanitized['saison_id'],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                ])->first();
                if ($tarifExcursion != null) {
                    $tarifExcursion->update([
                        'marge' => $sanitized['marge'][$i],
                        'prix_achat' => $sanitized['prix_achat'][$i],
                        'prix_vente' => $sanitized['prix_vente'][$i]
                    ]);
                } else {
                    TarifExcursion::create([
                        'marge' => $sanitized['marge'][$i],
                        'prix_achat' => $sanitized['prix_achat'][$i],
                        'prix_vente' => $sanitized['prix_vente'][$i],
                        'excursion_id' => $sanitized['excursion_id'],
                        'saison_id' => $sanitized['saison_id'],
                        'type_personne_id' => $sanitized['type_personne_id'][$i],
                    ]);
                }
            }
        });


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-excursions');
    }
}
