<?php

namespace App\Http\Controllers\Front;

use App\Exports\AttemptTask;
use App\Http\Controllers\Controller;
use App\Models\AppConfig;
use App\Models\Commande;
use App\Models\LocationVehicule\VehiculeInfoTech;
use Illuminate\Http\Request;

class RemerciementController extends Controller
{
    public function index(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyIdentifiant($request);
        /** */

        $commande = Commande::select(
            'commande.id',
            'commande.mode_payement_id',
            'commande.paiement_id',
            'commande.prix',
            'commande.tva',
            'commande.frais_dossier',
            'commande.date',
            'commande.status',
            'commande.prix_total',
            'facturation_commande.nom',
            'facturation_commande.prenom',
            'facturation_commande.adresse',
            'facturation_commande.ville',
            'facturation_commande.code_postal',
            'facturation_commande.telephone',
            'facturation_commande.email'
        )
            ->join('facturation_commande', 'facturation_commande.commande_id', 'commande.id')
            ->with([
                'facture',
                'mode_payement',
                'hebergement' => function ($query) {
                    $query->with(['personne', 'supplement', 'vol', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }]);
                },
                'excursion' => function ($query) {
                    $query->with([
                        'personne',
                        'supplement' => function ($query) {
                            $query->with(['personne']);
                        },
                        'ile',
                        'prestataire' => function ($query) {
                            $query->with(['ville']);
                        },
                        'billet_compagnie',
                        'lunch_prestataire'
                    ]);
                },
                'location' => function ($query) {
                    $query->with(['personne', 'supplement', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }]);
                },
                'billeterie' => function ($query) {
                    $query->with(['personne', 'supplement', 'compagnie' => function ($query) {
                        $query->with(['ville']);
                    }]);
                },
                'transfert' => function ($query) {
                    $query->with(['personne', 'supplement', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }]);
                }
            ])
            ->where(['commande.paiement_id' => $my_request['paiement_id']])
            ->get();
        /** */

        if (count($commande) == 0) {
            abort(404);
        }

        $commande = json_decode(json_encode($commande));
        $commande = collect($commande)->map(function ($data) {
            $data->location = collect($data->location)->map(function ($data_location) {
                $data_location->info_tech = VehiculeInfoTech::where(['vehicule_id' => $data_location->location_id])->first();
                return $data_location;
            });
            return $data;
        });

        //
        $collect_first_commande = collect(json_decode(json_encode($commande), true))->first();
        $collect_first_commande = collect($collect_first_commande)->put('app', AppConfig::with(['ville'])->get()->first()->toArray());

        AttemptTask::post(url("notification-client-commande"), [
            'id' => $collect_first_commande['id']
        ], 'test_test', $request);
        //notification-test-post

        /** */

        return $this->viewCustom('front.remerciement', [
            'data' => $commande,
            'session_request' => json_encode(isset($my_request) ? $my_request : null)
        ]);
    }
}

/**
 * 
        $footer = $canvas->open_object();
        anvas->close_object();
        $canvas->add_object($footer, "all");
 */
