<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommandeChambre\BulkDestroyLigneCommandeChambre;
use App\Http\Requests\Admin\LigneCommandeChambre\DestroyLigneCommandeChambre;
use App\Http\Requests\Admin\LigneCommandeChambre\IndexLigneCommandeChambre;
use App\Http\Requests\Admin\LigneCommandeChambre\StoreLigneCommandeChambre;
use App\Http\Requests\Admin\LigneCommandeChambre\UpdateLigneCommandeChambre;
use App\Models\LigneCommandeChambre;
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

class LigneCommandeChambreController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommandeChambre $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommandeChambre $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommandeChambre::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'hebergement_id', 'hebergement_name', 'hebergement_type', 'hebergement_duration_min', 'hebergement_caution', 'hebergement_etoil', 'chambre_id', 'chambre_name', 'chambre_capacite', 'chambre_base_type_titre', 'chambre_base_type_nombre', 'quantite_chambre', 'date_debut', 'date_fin', 'prix_unitaire', 'prix_total', 'commande_id', 'ville_id', 'ile_id', 'prestataire_id'],

            // set columns to searchIn
            ['id', 'hebergement_id', 'hebergement_name', 'hebergement_type', 'chambre_id', 'chambre_name', 'chambre_image', 'chambre_base_type_titre', 'chambre_base_type_nombre', 'prestataire_id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande-chambre.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande-chambre.create');

        return view('admin.ligne-commande-chambre.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommandeChambre $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommandeChambre $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommandeChambre
        $ligneCommandeChambre = LigneCommandeChambre::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commande-chambres'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commande-chambres');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommandeChambre $ligneCommandeChambre
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommandeChambre $ligneCommandeChambre)
    {
        $this->authorize('admin.ligne-commande-chambre.show', $ligneCommandeChambre);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommandeChambre $ligneCommandeChambre
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommandeChambre $ligneCommandeChambre)
    {
        $this->authorize('admin.ligne-commande-chambre.edit', $ligneCommandeChambre);


        return view('admin.ligne-commande-chambre.edit', [
            'ligneCommandeChambre' => $ligneCommandeChambre,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommandeChambre $request
     * @param LigneCommandeChambre $ligneCommandeChambre
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommandeChambre $request, LigneCommandeChambre $ligneCommandeChambre)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommandeChambre
        $ligneCommandeChambre->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commande-chambres'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commande-chambres');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommandeChambre $request
     * @param LigneCommandeChambre $ligneCommandeChambre
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommandeChambre $request, LigneCommandeChambre $ligneCommandeChambre)
    {
        $ligneCommandeChambre->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommandeChambre $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommandeChambre $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommandeChambre::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
