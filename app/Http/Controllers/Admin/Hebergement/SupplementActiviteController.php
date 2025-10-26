<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\SupplementActivite\BulkDestroySupplementActivite;
use App\Http\Requests\Admin\Hebergement\SupplementActivite\DestroySupplementActivite;
use App\Http\Requests\Admin\Hebergement\SupplementActivite\IndexSupplementActivite;
use App\Http\Requests\Admin\Hebergement\SupplementActivite\StoreSupplementActivite;
use App\Http\Requests\Admin\Hebergement\SupplementActivite\UpdateSupplementActivite;
use App\Models\Hebergement\Hebergement;
use App\Models\Hebergement\SupplementActivite;
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

class SupplementActiviteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSupplementActivite $request
     * @return array|Factory|View
     */
    public function index(IndexSupplementActivite $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SupplementActivite::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['tarif' => function ($query) {
                    $query->with(['personne']);
                },'prestataire']);
                if (isset($request->heb)) {
                    $query->where(['hebergement_id' => $request->heb]);
                }
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'regle_tarif', 'hebergement_id', 'prestataire_id'],
                // set columns to searchIn
                ['id', 'titre', 'description', 'regle_tarif', 'prestataire_id']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        if (!(isset($request->heb) && \App\Models\Hebergement\Hebergement::find($request->heb))) {
            return redirect('admin/hebergements');
        }

        return view('admin.hebergement.supplement-activite.index', [
            'data' => $data,
            'hebergement' => \App\Models\Hebergement\Hebergement::find($request->heb),
            'supp_appliquer' => json_encode(config('supp-appliquer'))
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
        $this->authorize('admin.supplement-activite.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        $heb = Hebergement::find($this->request->heb);

        if ($heb == null) {
            abort(404);
        }

        return [
            'typePersonne' => $heb->personne()->get()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupplementActivite $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSupplementActivite $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the SupplementActivite
        $supplementActivite = SupplementActivite::create($sanitized);

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            \App\Models\Hebergement\TarifSupplementActivite::create([
                'marge' => $sanitized['marge'][$i],
                'prix_achat' => $sanitized['prix_achat'][$i],
                'prix_vente' => $sanitized['prix_vente'][$i],
                'type_personne_id' => $sanitized['type_personne_id'][$i],
                'supplement_id' => $supplementActivite->id,
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-activites'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementActivite' => $supplementActivite
            ];
        }

        return redirect('admin/supplement-activites');
    }

    /**
     * Display the specified resource.
     *
     * @param SupplementActivite $supplementActivite
     * @throws AuthorizationException
     * @return void
     */
    public function show(SupplementActivite $supplementActivite)
    {
        $this->authorize('admin.supplement-activite.show', $supplementActivite);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        $supplementActivite = SupplementActivite::with(['tarif' => function ($query) {
            $query->with(['personne']);
        },'prestataire'])->find($supplementActivite->id);

        $heb = Hebergement::find($supplementActivite->hebergement_id);

        return [
            'supplementActivite' => $supplementActivite,
            'typePersonne' => $heb->personne()->get()
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SupplementActivite $supplementActivite
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SupplementActivite $supplementActivite)
    {
        $this->authorize('admin.supplement-activite.edit', $supplementActivite);

        if (!$this->request->ajax()) {
            abort(404);
        }
        $supplementActivite = SupplementActivite::with(['tarif' => function ($query) {
            $query->with(['personne']);
        },'prestataire'])->find($supplementActivite->id);

        $heb = Hebergement::find($supplementActivite->hebergement_id);
        return [
            'supplementActivite' => $supplementActivite,
            'typePersonne' => $heb->personne()->get()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplementActivite $request
     * @param SupplementActivite $supplementActivite
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSupplementActivite $request, SupplementActivite $supplementActivite)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SupplementActivite
        $supplementActivite->update($sanitized);

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            $tarif = \App\Models\Hebergement\TarifSupplementActivite::where([
                'type_personne_id' => $sanitized['type_personne_id'][$i],
                'supplement_id' => $supplementActivite->id,
            ])->get()
                ->first();
            if ($tarif) {
                $tarif->update([
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'supplement_id' => $supplementActivite->id,
                ]);
            } else {
                \App\Models\Hebergement\TarifSupplementActivite::create([
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'supplement_id' => $supplementActivite->id,
                ]);
            }
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-activites'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementActivite' => $supplementActivite
            ];
        }

        return redirect('admin/supplement-activites');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySupplementActivite $request
     * @param SupplementActivite $supplementActivite
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySupplementActivite $request, SupplementActivite $supplementActivite)
    {
        $supplementActivite->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySupplementActivite $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySupplementActivite $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SupplementActivite::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
