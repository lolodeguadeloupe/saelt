<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommandeLocation\BulkDestroyLigneCommandeLocation;
use App\Http\Requests\Admin\LigneCommandeLocation\DestroyLigneCommandeLocation;
use App\Http\Requests\Admin\LigneCommandeLocation\IndexLigneCommandeLocation;
use App\Http\Requests\Admin\LigneCommandeLocation\StoreLigneCommandeLocation;
use App\Http\Requests\Admin\LigneCommandeLocation\UpdateLigneCommandeLocation;
use App\Models\LigneCommandeLocation;
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

class LigneCommandeLocationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommandeLocation $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommandeLocation $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommandeLocation::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'location_id', 'titre', 'immatriculation', 'duration_min', 'franchise', 'franchise_non_rachatable', 'caution', 'image', 'marque_vehicule_id', 'marque_vehicule_titre', 'modele_vehicule_id', 'modele_vehicule_titre', 'categorie_vehicule_id', 'categorie_vehicule_titre', 'famille_vehicule_id', 'famille_vehicule_titre', 'prestataire_id', 'agence_recuperation_name', 'agence_recuperation_id', 'agence_restriction_name', 'agence_restriction_id', 'date_recuperation', 'date_restriction', 'heure_recuperation', 'heure_restriction', 'nom_conducteur', 'prenom_conducteur', 'adresse_conducteur', 'ville_conducteur', 'code_postal_conducteur', 'telephone_conducteur', 'email_conducteur', 'date_naissance_conducteur', 'lieu_naissance_conducteur', 'num_permis_conducteur', 'date_permis_conducteur', 'lieu_deliv_permis_conducteur', 'num_identite_conducteur', 'date_emis_identite_conducteur', 'lieu_deliv_identite_conducteur', 'order_comments', 'prix_unitaire', 'prix_total', 'commande_id'],

            // set columns to searchIn
            ['id', 'location_id', 'titre', 'immatriculation', 'marque_vehicule_id', 'marque_vehicule_titre', 'modele_vehicule_id', 'modele_vehicule_titre', 'categorie_vehicule_id', 'categorie_vehicule_titre', 'famille_vehicule_id', 'famille_vehicule_titre', 'prestataire_id', 'agence_recuperation_name', 'agence_recuperation_id', 'agence_restriction_name', 'agence_restriction_id', 'heure_recuperation', 'heure_restriction', 'nom_conducteur', 'prenom_conducteur', 'adresse_conducteur', 'ville_conducteur', 'code_postal_conducteur', 'telephone_conducteur', 'email_conducteur', 'date_naissance_conducteur', 'lieu_naissance_conducteur', 'num_permis_conducteur', 'date_permis_conducteur', 'lieu_deliv_permis_conducteur', 'num_identite_conducteur', 'date_emis_identite_conducteur', 'lieu_deliv_identite_conducteur', 'order_comments']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande-location.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande-location.create');

        return view('admin.ligne-commande-location.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommandeLocation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommandeLocation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommandeLocation
        $ligneCommandeLocation = LigneCommandeLocation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commande-locations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commande-locations');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommandeLocation $ligneCommandeLocation
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommandeLocation $ligneCommandeLocation)
    {
        $this->authorize('admin.ligne-commande-location.show', $ligneCommandeLocation);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommandeLocation $ligneCommandeLocation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommandeLocation $ligneCommandeLocation)
    {
        $this->authorize('admin.ligne-commande-location.edit', $ligneCommandeLocation);


        return [
            'ligneCommandeLocation' => LigneCommandeLocation::with(['commande' => function ($query) {
                $query->with(['mode_payement', 'facture']);
            }])->find($ligneCommandeLocation->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommandeLocation $request
     * @param LigneCommandeLocation $ligneCommandeLocation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommandeLocation $request, LigneCommandeLocation $ligneCommandeLocation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommandeLocation
        $ligneCommandeLocation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commande-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commande-locations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommandeLocation $request
     * @param LigneCommandeLocation $ligneCommandeLocation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommandeLocation $request, LigneCommandeLocation $ligneCommandeLocation)
    {
        $ligneCommandeLocation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommandeLocation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommandeLocation $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommandeLocation::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
