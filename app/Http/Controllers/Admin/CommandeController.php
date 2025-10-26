<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Commande\BulkDestroyCommande;
use App\Http\Requests\Admin\Commande\DestroyCommande;
use App\Http\Requests\Admin\Commande\IndexCommande;
use App\Http\Requests\Admin\Commande\StoreCommande;
use App\Http\Requests\Admin\Commande\UpdateCommande;
use App\Models\Commande;
use App\Models\LocationVehicule\VehiculeInfoTech;
use App\Models\ModePayement;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommandeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCommande $request
     * @return array|Factory|View
     */
    public function index(IndexCommande $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Commande::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('facturation_commande', 'facturation_commande.commande_id', 'commande.id');
                $query->join('mode_payement', 'mode_payement.id', 'commande.mode_payement_id');
                $query->with(['mode_payement', 'facture']);
                if(!isset($request->orderBy)){
                    $query->orderBy('id','desc');
                }
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,

                // set columns to query
                ['commande.id', 'commande.date', 'commande.status','commande.status_payement', 'commande.prix', 'commande.tva', 'commande.frais_dossier', 'commande.prix_total', 'commande.mode_payement_id', 'commande.paiement_id', 'facturation_commande.nom', 'facturation_commande.prenom', 'facturation_commande.adresse', 'facturation_commande.ville', 'facturation_commande.code_postal'],

                // set columns to searchIn
                ['commande.id', 'commande.date', 'commande.status', 'commande.prix', 'commande.tva', 'commande.prix_total', 'mode_payement.titre', 'facturation_commande.nom', 'facturation_commande.prenom', 'facturation_commande.adresse', 'facturation_commande.ville', 'facturation_commande.code_postal']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        return view('admin.commande.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.commande.create');

        return view('admin.commande.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommande $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCommande $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Commande
        $commande = Commande::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/commandes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/commandes');
    }

    /**
     * Display the specified resource.
     *
     * @param Commande $commande
     * @throws AuthorizationException
     * @return void
     */
    public function show(Request $request, Commande $commande)
    {
        $this->authorize('admin.commande.show', $commande);

        // TODO your code goes here

        $data = AdminListing::create(Commande::class)
            ->modifyQuery(function ($query) use ($request, $commande) {
                $query->join('facturation_commande', 'facturation_commande.commande_id', 'commande.id');
                $query->join('mode_payement', 'mode_payement.id', 'commande.mode_payement_id');
                $query->with([
                    'hebergement' => function ($query) {
                        $query->with(['personne', 'supplement']);
                    },
                    'excursion' => function ($query) {
                        $query->with([
                            'personne',
                            'supplement' => function ($query) {
                                $query->with(['personne']);
                            },
                            'ile'
                        ]);
                    },
                    'location' => function ($query) {
                        $query->with(['personne', 'supplement']);
                    },
                    'billeterie' => function ($query) {
                        $query->with(['personne', 'supplement']);
                    },
                    'transfert' => function ($query) {
                        $query->with(['personne', 'supplement']);
                    },
                    'facture'
                ]);
                $query->where(['commande.id' => $commande->id]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['commande.id','commande.paiement_id', 'commande.mode_payement_id', 'commande.date', 'commande.status','commande.status_payement',  'commande.prix', 'commande.tva', 'commande.frais_dossier', 'commande.prix_total', 'facturation_commande.nom', 'facturation_commande.prenom', 'facturation_commande.adresse', 'facturation_commande.ville', 'facturation_commande.code_postal', 'facturation_commande.telephone', 'facturation_commande.email'],

                // set columns to searchIn
                ['commande.id',  'mode_payement.titre', 'commande.date', 'commande.status', 'commande.prix', 'commande.tva', 'commande.prix_total', 'facturation_commande.nom', 'facturation_commande.prenom', 'facturation_commande.adresse', 'facturation_commande.ville', 'facturation_commande.code_postal']
            );

        $collection = $data->getCollection();
        $collection = json_decode(json_encode($collection));
        $collection = collect($collection)->map(function ($data) {
            $data->location = collect($data->location)->map(function ($data_location) {
                $data_location->info_tech = VehiculeInfoTech::where(['vehicule_id' => $data_location->location_id])->first();
                return $data_location;
            });
            return $data;
        });

        $data->setCollection($collection);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        //dd($data->toArray());
        return $this->viewCustom('admin.commande.detail', [
            'data' => $data,
            'modePayement' => ModePayement::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Commande $commande
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Commande $commande)
    {
        $this->authorize('admin.commande.edit', $commande);


        return view('admin.commande.edit', [
            'commande' => $commande,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommande $request
     * @param Commande $commande
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCommande $request, Commande $commande)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Commande
        $commande->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/commandes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/commandes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCommande $request
     * @param Commande $commande
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCommande $request, Commande $commande)
    {
        $commande->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCommande $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCommande $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Commande::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
