<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\TarifSupplementActivite\BulkDestroyTarifSupplementActivite;
use App\Http\Requests\Admin\Hebergement\TarifSupplementActivite\DestroyTarifSupplementActivite;
use App\Http\Requests\Admin\Hebergement\TarifSupplementActivite\IndexTarifSupplementActivite;
use App\Http\Requests\Admin\Hebergement\TarifSupplementActivite\StoreTarifSupplementActivite;
use App\Http\Requests\Admin\Hebergement\TarifSupplementActivite\UpdateTarifSupplementActivite;
use App\Models\Hebergement\TarifSupplementActivite;
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

class TarifSupplementActiviteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifSupplementActivite $request
     * @return array|Factory|View
     */
    public function index(IndexTarifSupplementActivite $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TarifSupplementActivite::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'prix_achat', 'marge', 'prix_vente', 'type_personne_id', 'supplement_id'],
                // set columns to searchIn
                ['id', 'prix_achat', 'prix_vente']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.tarif-supplement-activite.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.tarif-supplement-activite.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifSupplementActivite $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifSupplementActivite $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TarifSupplementActivite
        $tarifSupplementActivite = TarifSupplementActivite::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/tarif-supplement-activites'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/tarif-supplement-activites');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifSupplementActivite $tarifSupplementActivite
     * @throws AuthorizationException
     * @return void
     */
    public function show(TarifSupplementActivite $tarifSupplementActivite) {
        $this->authorize('admin.tarif-supplement-activite.show', $tarifSupplementActivite);

        if (!$this->request->ajax()) {
            abort(404);
        }
        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifSupplementActivite $tarifSupplementActivite
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TarifSupplementActivite $tarifSupplementActivite) {
        $this->authorize('admin.tarif-supplement-activite.edit', $tarifSupplementActivite);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'tarifSupplementActivite' => TarifSupplementActivite::with(['personne'])->find($tarifSupplementActivite->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifSupplementActivite $request
     * @param TarifSupplementActivite $tarifSupplementActivite
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifSupplementActivite $request, TarifSupplementActivite $tarifSupplementActivite) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifSupplementActivite
        $tarifSupplementActivite->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-supplement-activites'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-supplement-activites');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifSupplementActivite $request
     * @param TarifSupplementActivite $tarifSupplementActivite
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifSupplementActivite $request, TarifSupplementActivite $tarifSupplementActivite) {
        $tarifSupplementActivite->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifSupplementActivite $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifSupplementActivite $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        TarifSupplementActivite::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
