<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommandeTypePersonne\BulkDestroyLigneCommandeTypePersonne;
use App\Http\Requests\Admin\LigneCommandeTypePersonne\DestroyLigneCommandeTypePersonne;
use App\Http\Requests\Admin\LigneCommandeTypePersonne\IndexLigneCommandeTypePersonne;
use App\Http\Requests\Admin\LigneCommandeTypePersonne\StoreLigneCommandeTypePersonne;
use App\Http\Requests\Admin\LigneCommandeTypePersonne\UpdateLigneCommandeTypePersonne;
use App\Models\LigneCommandeTypePersonne;
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

class LigneCommandeTypePersonneController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommandeTypePersonne $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommandeTypePersonne $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommandeTypePersonne::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'type', 'age', 'prix'],

            // set columns to searchIn
            ['id', 'type', 'age']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande-type-personne.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande-type-personne.create');

        return view('admin.ligne-commande-type-personne.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommandeTypePersonne $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommandeTypePersonne $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommandeTypePersonne
        $ligneCommandeTypePersonne = LigneCommandeTypePersonne::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commande-type-personnes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commande-type-personnes');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommandeTypePersonne $ligneCommandeTypePersonne
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommandeTypePersonne $ligneCommandeTypePersonne)
    {
        $this->authorize('admin.ligne-commande-type-personne.show', $ligneCommandeTypePersonne);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommandeTypePersonne $ligneCommandeTypePersonne
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommandeTypePersonne $ligneCommandeTypePersonne)
    {
        $this->authorize('admin.ligne-commande-type-personne.edit', $ligneCommandeTypePersonne);


        return view('admin.ligne-commande-type-personne.edit', [
            'ligneCommandeTypePersonne' => $ligneCommandeTypePersonne,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommandeTypePersonne $request
     * @param LigneCommandeTypePersonne $ligneCommandeTypePersonne
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommandeTypePersonne $request, LigneCommandeTypePersonne $ligneCommandeTypePersonne)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommandeTypePersonne
        $ligneCommandeTypePersonne->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commande-type-personnes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commande-type-personnes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommandeTypePersonne $request
     * @param LigneCommandeTypePersonne $ligneCommandeTypePersonne
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommandeTypePersonne $request, LigneCommandeTypePersonne $ligneCommandeTypePersonne)
    {
        $ligneCommandeTypePersonne->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommandeTypePersonne $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommandeTypePersonne $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommandeTypePersonne::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
