<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommandeTransfert\BulkDestroyLigneCommandeTransfert;
use App\Http\Requests\Admin\LigneCommandeTransfert\DestroyLigneCommandeTransfert;
use App\Http\Requests\Admin\LigneCommandeTransfert\IndexLigneCommandeTransfert;
use App\Http\Requests\Admin\LigneCommandeTransfert\StoreLigneCommandeTransfert;
use App\Http\Requests\Admin\LigneCommandeTransfert\UpdateLigneCommandeTransfert;
use App\Models\LigneCommandeTransfert;
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

class LigneCommandeTransfertController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommandeTransfert $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommandeTransfert $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommandeTransfert::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'titre', 'date_depart', 'date_retour', 'quantite', 'lieu_depart_id', 'lieu_depart_name', 'lieu_arrive_id', 'lieu_arrive_name', 'parcours', 'heure_depart', 'heure_retour', 'prix_unitaire', 'prix_total', 'commande_id'],

            // set columns to searchIn
            ['id', 'titre', 'image', 'lieu_depart_id', 'lieu_depart_name', 'lieu_arrive_id', 'lieu_arrive_name', 'heure_depart', 'heure_retour']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande-transfert.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande-transfert.create');

        return view('admin.ligne-commande-transfert.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommandeTransfert $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommandeTransfert $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommandeTransfert
        $ligneCommandeTransfert = LigneCommandeTransfert::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commande-transferts'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commande-transferts');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommandeTransfert $ligneCommandeTransfert
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommandeTransfert $ligneCommandeTransfert)
    {
        $this->authorize('admin.ligne-commande-transfert.show', $ligneCommandeTransfert);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommandeTransfert $ligneCommandeTransfert
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommandeTransfert $ligneCommandeTransfert)
    {
        $this->authorize('admin.ligne-commande-transfert.edit', $ligneCommandeTransfert);


        return view('admin.ligne-commande-transfert.edit', [
            'ligneCommandeTransfert' => $ligneCommandeTransfert,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommandeTransfert $request
     * @param LigneCommandeTransfert $ligneCommandeTransfert
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommandeTransfert $request, LigneCommandeTransfert $ligneCommandeTransfert)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommandeTransfert
        $ligneCommandeTransfert->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commande-transferts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commande-transferts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommandeTransfert $request
     * @param LigneCommandeTransfert $ligneCommandeTransfert
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommandeTransfert $request, LigneCommandeTransfert $ligneCommandeTransfert)
    {
        $ligneCommandeTransfert->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommandeTransfert $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommandeTransfert $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommandeTransfert::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
