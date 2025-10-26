<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommande\BulkDestroyLigneCommande;
use App\Http\Requests\Admin\LigneCommande\DestroyLigneCommande;
use App\Http\Requests\Admin\LigneCommande\IndexLigneCommande;
use App\Http\Requests\Admin\LigneCommande\StoreLigneCommande;
use App\Http\Requests\Admin\LigneCommande\UpdateLigneCommande;
use App\Models\LigneCommande;
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

class LigneCommandeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommande $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommande $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommande::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'quantite', 'prix_unitaire', 'prix_total'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande.create');

        return view('admin.ligne-commande.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommande $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommande $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommande
        $ligneCommande = LigneCommande::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commandes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commandes');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommande $ligneCommande
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommande $ligneCommande)
    {
        $this->authorize('admin.ligne-commande.show', $ligneCommande);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommande $ligneCommande
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommande $ligneCommande)
    {
        $this->authorize('admin.ligne-commande.edit', $ligneCommande);


        return view('admin.ligne-commande.edit', [
            'ligneCommande' => $ligneCommande,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommande $request
     * @param LigneCommande $ligneCommande
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommande $request, LigneCommande $ligneCommande)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommande
        $ligneCommande->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commandes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commandes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommande $request
     * @param LigneCommande $ligneCommande
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommande $request, LigneCommande $ligneCommande)
    {
        $ligneCommande->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommande $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommande $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommande::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
