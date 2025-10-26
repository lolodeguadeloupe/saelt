<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excursion\TarifSupplementExcursion\BulkDestroyTarifSupplementExcursion;
use App\Http\Requests\Admin\Excursion\TarifSupplementExcursion\DestroyTarifSupplementExcursion;
use App\Http\Requests\Admin\Excursion\TarifSupplementExcursion\IndexTarifSupplementExcursion;
use App\Http\Requests\Admin\Excursion\TarifSupplementExcursion\StoreTarifSupplementExcursion;
use App\Http\Requests\Admin\Excursion\TarifSupplementExcursion\UpdateTarifSupplementExcursion;
use App\Models\Excursion\TarifSupplementExcursion;
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

class TarifSupplementExcursionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifSupplementExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexTarifSupplementExcursion $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TarifSupplementExcursion::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->with(['supplement', 'personne']);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'supplement_excursion_id', 'type_personne_id', 'prix_achat', 'marge', 'prix_vente'],
                // set columns to searchIn
                ['id', 'prix_achat', 'marge', 'prix_vente']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.tarif-supplement-excursion.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.tarif-supplement-excursion.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifSupplementExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifSupplementExcursion $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TarifSupplementExcursion
        $tarifSupplementExcursion = TarifSupplementExcursion::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-supplement-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-supplement-excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifSupplementExcursion $tarifSupplementExcursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(TarifSupplementExcursion $tarifSupplementExcursion) {
        $this->authorize('admin.tarif-supplement-excursion.show', $tarifSupplementExcursion);

        if (!$this->request->ajax()) {
            abort(404);
        }

        // TODO your code goes here

        return ['tariifSupplementExcursion' => $tarifSupplementExcursion];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifSupplementExcursion $tarifSupplementExcursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TarifSupplementExcursion $tarifSupplementExcursion) {
        $this->authorize('admin.tarif-supplement-excursion.edit', $tarifSupplementExcursion);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'tarifSupplementExcursion' => TarifSupplementExcursion::with(['personne', 'supplement'])->find($tarifSupplementExcursion->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifSupplementExcursion $request
     * @param TarifSupplementExcursion $tarifSupplementExcursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifSupplementExcursion $request, TarifSupplementExcursion $tarifSupplementExcursion) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifSupplementExcursion
        $tarifSupplementExcursion->update($sanitized);
        

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-supplement-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-supplement-excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifSupplementExcursion $request
     * @param TarifSupplementExcursion $tarifSupplementExcursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifSupplementExcursion $request, TarifSupplementExcursion $tarifSupplementExcursion) {
        $tarifSupplementExcursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifSupplementExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifSupplementExcursion $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        TarifSupplementExcursion::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
