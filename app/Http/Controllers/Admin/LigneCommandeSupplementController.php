<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommandeSupplement\BulkDestroyLigneCommandeSupplement;
use App\Http\Requests\Admin\LigneCommandeSupplement\DestroyLigneCommandeSupplement;
use App\Http\Requests\Admin\LigneCommandeSupplement\IndexLigneCommandeSupplement;
use App\Http\Requests\Admin\LigneCommandeSupplement\StoreLigneCommandeSupplement;
use App\Http\Requests\Admin\LigneCommandeSupplement\UpdateLigneCommandeSupplement;
use App\Models\LigneCommandeSupplement;
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

class LigneCommandeSupplementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommandeSupplement $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommandeSupplement $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommandeSupplement::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'titre', 'regle_tarif', 'prix', 'commande_id', 'ligne_commande_model', 'ligne_commande_id'],

            // set columns to searchIn
            ['id', 'titre', 'icon', 'regle_tarif', 'ligne_commande_model']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande-supplement.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande-supplement.create');

        return view('admin.ligne-commande-supplement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommandeSupplement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommandeSupplement $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommandeSupplement
        $ligneCommandeSupplement = LigneCommandeSupplement::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commande-supplements'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commande-supplements');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommandeSupplement $ligneCommandeSupplement
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommandeSupplement $ligneCommandeSupplement)
    {
        $this->authorize('admin.ligne-commande-supplement.show', $ligneCommandeSupplement);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommandeSupplement $ligneCommandeSupplement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommandeSupplement $ligneCommandeSupplement)
    {
        $this->authorize('admin.ligne-commande-supplement.edit', $ligneCommandeSupplement);


        return view('admin.ligne-commande-supplement.edit', [
            'ligneCommandeSupplement' => $ligneCommandeSupplement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommandeSupplement $request
     * @param LigneCommandeSupplement $ligneCommandeSupplement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommandeSupplement $request, LigneCommandeSupplement $ligneCommandeSupplement)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommandeSupplement
        $ligneCommandeSupplement->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commande-supplements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commande-supplements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommandeSupplement $request
     * @param LigneCommandeSupplement $ligneCommandeSupplement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommandeSupplement $request, LigneCommandeSupplement $ligneCommandeSupplement)
    {
        $ligneCommandeSupplement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommandeSupplement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommandeSupplement $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommandeSupplement::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
