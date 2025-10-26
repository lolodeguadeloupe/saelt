<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\TarifTypePersonneHebergement\BulkDestroyTarifTypePersonneHebergement;
use App\Http\Requests\Admin\Hebergement\TarifTypePersonneHebergement\DestroyTarifTypePersonneHebergement;
use App\Http\Requests\Admin\Hebergement\TarifTypePersonneHebergement\IndexTarifTypePersonneHebergement;
use App\Http\Requests\Admin\Hebergement\TarifTypePersonneHebergement\StoreTarifTypePersonneHebergement;
use App\Http\Requests\Admin\Hebergement\TarifTypePersonneHebergement\UpdateTarifTypePersonneHebergement;
use App\Models\Hebergement\TarifTypePersonneHebergement;
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

class TarifTypePersonneHebergementController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifTypePersonneHebergement $request
     * @return array|Factory|View
     */
    public function index(IndexTarifTypePersonneHebergement $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TarifTypePersonneHebergement::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'prix_achat', 'marge', 'prix_vente', 'type_personne_id', 'tarif_id'],
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

        return view('admin.tarif-type-personne-hebergement.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.tarif-type-personne-hebergement.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifTypePersonneHebergement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifTypePersonneHebergement $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TarifTypePersonneHebergement
        $tarifTypePersonneHebergement = TarifTypePersonneHebergement::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/tarif-type-personne-hebergements'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/tarif-type-personne-hebergements');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifTypePersonneHebergement $tarifTypePersonneHebergement
     * @throws AuthorizationException
     * @return void
     */
    public function show(TarifTypePersonneHebergement $tarifTypePersonneHebergement) {
        $this->authorize('admin.tarif-type-personne-hebergement.show', $tarifTypePersonneHebergement);

        if (!$this->request->ajax()) {
            abort(404);
        }

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifTypePersonneHebergement $tarifTypePersonneHebergement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TarifTypePersonneHebergement $tarifTypePersonneHebergement) {
        $this->authorize('admin.tarif-type-personne-hebergement.edit', $tarifTypePersonneHebergement);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'tarifTypePersonneHebergement' => TarifTypePersonneHebergement::with(['personne'])->find($tarifTypePersonneHebergement->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifTypePersonneHebergement $request
     * @param TarifTypePersonneHebergement $tarifTypePersonneHebergement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifTypePersonneHebergement $request, TarifTypePersonneHebergement $tarifTypePersonneHebergement) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifTypePersonneHebergement
        $tarifTypePersonneHebergement->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-type-personne-hebergements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-type-personne-hebergements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifTypePersonneHebergement $request
     * @param TarifTypePersonneHebergement $tarifTypePersonneHebergement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifTypePersonneHebergement $request, TarifTypePersonneHebergement $tarifTypePersonneHebergement) {
        $tarifTypePersonneHebergement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifTypePersonneHebergement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifTypePersonneHebergement $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        TarifTypePersonneHebergement::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
