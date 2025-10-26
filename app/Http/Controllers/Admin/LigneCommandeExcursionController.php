<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommandeExcursion\BulkDestroyLigneCommandeExcursion;
use App\Http\Requests\Admin\LigneCommandeExcursion\DestroyLigneCommandeExcursion;
use App\Http\Requests\Admin\LigneCommandeExcursion\IndexLigneCommandeExcursion;
use App\Http\Requests\Admin\LigneCommandeExcursion\StoreLigneCommandeExcursion;
use App\Http\Requests\Admin\LigneCommandeExcursion\UpdateLigneCommandeExcursion;
use App\Models\LigneCommandeExcursion;
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

class LigneCommandeExcursionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommandeExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommandeExcursion $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommandeExcursion::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'excursion_id', 'title', 'participant_min', 'duration', 'lunch', 'ticket', 'adresse_arrive', 'adresse_depart', 'ville_id', 'ile_id', 'prestataire_id', 'lieu_depart_id', 'lieu_arrive_id', 'quantite_chambre', 'date_debut', 'date_fin', 'prix_unitaire', 'prix_total', 'commande_id'],

            // set columns to searchIn
            ['id', 'excursion_id', 'title', 'fond_image', 'card', 'adresse_arrive', 'adresse_depart', 'prestataire_id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande-excursion.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande-excursion.create');

        return view('admin.ligne-commande-excursion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommandeExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommandeExcursion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommandeExcursion
        $ligneCommandeExcursion = LigneCommandeExcursion::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commande-excursions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commande-excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommandeExcursion $ligneCommandeExcursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommandeExcursion $ligneCommandeExcursion)
    {
        $this->authorize('admin.ligne-commande-excursion.show', $ligneCommandeExcursion);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommandeExcursion $ligneCommandeExcursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommandeExcursion $ligneCommandeExcursion)
    {
        $this->authorize('admin.ligne-commande-excursion.edit', $ligneCommandeExcursion);


        return view('admin.ligne-commande-excursion.edit', [
            'ligneCommandeExcursion' => $ligneCommandeExcursion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommandeExcursion $request
     * @param LigneCommandeExcursion $ligneCommandeExcursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommandeExcursion $request, LigneCommandeExcursion $ligneCommandeExcursion)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommandeExcursion
        $ligneCommandeExcursion->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commande-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commande-excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommandeExcursion $request
     * @param LigneCommandeExcursion $ligneCommandeExcursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommandeExcursion $request, LigneCommandeExcursion $ligneCommandeExcursion)
    {
        $ligneCommandeExcursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommandeExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommandeExcursion $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommandeExcursion::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
