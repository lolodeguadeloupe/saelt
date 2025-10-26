<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\TarifSupplementPension\BulkDestroyTarifSupplementPension;
use App\Http\Requests\Admin\Hebergement\TarifSupplementPension\DestroyTarifSupplementPension;
use App\Http\Requests\Admin\Hebergement\TarifSupplementPension\IndexTarifSupplementPension;
use App\Http\Requests\Admin\Hebergement\TarifSupplementPension\StoreTarifSupplementPension;
use App\Http\Requests\Admin\Hebergement\TarifSupplementPension\UpdateTarifSupplementPension;
use App\Models\Hebergement\TarifSupplementPension;
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

class TarifSupplementPensionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifSupplementPension $request
     * @return array|Factory|View
     */
    public function index(IndexTarifSupplementPension $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TarifSupplementPension::class)->processRequestAndGet(
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

        return view('admin.tarif-supplement-pension.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.tarif-supplement-pension.create');
        if (!$this->request->ajax()) {
            abort(404);
        }
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifSupplementPension $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifSupplementPension $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TarifSupplementPension
        $tarifSupplementPension = TarifSupplementPension::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/tarif-supplement-pensions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/tarif-supplement-pensions');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifSupplementPension $tarifSupplementPension
     * @throws AuthorizationException
     * @return void
     */
    public function show(TarifSupplementPension $tarifSupplementPension) {
        $this->authorize('admin.tarif-supplement-pension.show', $tarifSupplementPension);

        if (!$this->request->ajax()) {
            abort(404);
        }
        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifSupplementPension $tarifSupplementPension
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TarifSupplementPension $tarifSupplementPension) {
        $this->authorize('admin.tarif-supplement-pension.edit', $tarifSupplementPension);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'tarifSupplementPension' => TarifSupplementPension::with(['personne'])->find($tarifSupplementPension->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifSupplementPension $request
     * @param TarifSupplementPension $tarifSupplementPension
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifSupplementPension $request, TarifSupplementPension $tarifSupplementPension) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifSupplementPension
        $tarifSupplementPension->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-supplement-pensions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-supplement-pensions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifSupplementPension $request
     * @param TarifSupplementPension $tarifSupplementPension
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifSupplementPension $request, TarifSupplementPension $tarifSupplementPension) {
        $tarifSupplementPension->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifSupplementPension $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifSupplementPension $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        TarifSupplementPension::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
