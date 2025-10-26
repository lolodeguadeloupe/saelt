<?php

namespace App\Http\Controllers\Front;

use App\Exports\AlmaModele;
use App\Exports\PayementAlma;
use App\Http\Controllers\Controller;
use App\Http\Requests\PutFacturationCommande;
use App\Mail\Payement\ErrorMailPaiement;
use App\Models\ChambreEnCommande;
use App\Models\Commande;
use App\Models\Excursion\Excursion;
use App\Models\FacturationCommande;
use App\Models\FraisDossier;
use App\Models\GestionRequestUtilisateur;
use App\Models\Hebergement\Tarif;
use App\Models\Hebergement\TypeChambre;
use Illuminate\Http\Request;
use App\Models\Ile;
use App\Models\LigneCommandeBilletCompagnie;
use App\Models\LigneCommandeBilletterie;
use App\Models\LigneCommandeChambre;
use App\Models\LigneCommandeExcursion;
use App\Models\LigneCommandeLocation;
use App\Models\LigneCommandeLunchPrestataire;
use App\Models\LigneCommandeSupplement;
use App\Models\LigneCommandeTransfert;
use App\Models\LigneCommandeTypePersonne;
use App\Models\LigneVolHebergement;
use App\Models\ModePayement;
use App\Models\Taxe;
use App\Models\TypePersonne;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class FacturationController extends Controller
{

    public function index(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyIdentifiant($request, false);
        /* */
        $commande = [];
        /* */
        if ($my_request != null) {
            $request_session = GestionRequestUtilisateur::where(['identifiant_session' => $my_request['key_']])->first();
            if ($request_session != null) {
                $request_session = $request_session->getData();
                /** */
                GestionRequestUtilisateurController::updateSessionId($request, $request_session->session_id);
                /** */
                $commande = collect($request_session->data);
            }
        } else {
            $commande = GestionCommandeUtilisateurController::all($request);
        }
        //
        foreach ($commande as $key => $value) {
            $commande[$key] = collect($commande[$key])->map(function ($data) {
                $data->data = json_decode($data->data);
                $data->computed = json_decode($data->computed);
                return $data;
            })->toArray();
        }
        $commande = collect($commande)->filter(function ($data) {
            return count($data) > 0;
        });
        if (count($commande) > 1 || isset($commande['hebergement'])) {
            $taxe_heb = Taxe::where(['sigle' => 'tva_hebergement_pack'])->first();
            foreach ($commande as $key => $value) {
                $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe_heb) {
                    if ($taxe_heb != null && (($taxe_heb->taxe_appliquer == 0 && $taxe_heb->valeur_pourcent != null && doubleval($taxe_heb->valeur_pourcent) > 0)
                        || ($taxe_heb->taxe_appliquer == 1 && $taxe_heb->valeur_devises != null && doubleval($taxe_heb->valeur_devises) > 0))) {
                        $data->taxe_calculer = $taxe_heb->taxe_appliquer == 1 ? doubleval($taxe_heb->valeur_devises) : $data->data->marge_calculer * doubleval($taxe_heb->valeur_pourcent) / 100;
                    } else {
                        $data->taxe_calculer = 0;
                    }
                    return $data;
                })->toArray();
            }
        } else {
            if (isset($commande['excursion'])) {
                $has_other_produit = false;
                collect($commande['excursion'])->map(function ($_exc) use (&$has_other_produit) {
                    foreach ($_exc->data->supplementCkecked as $key => $value) {
                        if (count($value)) {
                            $has_other_produit = true;
                        }
                    }
                    if ($_exc->data->item->lunch == 1 || $_exc->data->item->ticket) {
                        $has_other_produit = true;
                    }
                });
                if ($has_other_produit) {
                    $taxe = Taxe::where(['sigle' => 'tva_hebergement_pack'])->first();
                    foreach ($commande as $key => $value) {
                        $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                            if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                                || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                                $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                            } else {
                                $data->taxe_calculer = 0;
                            }
                            return $data;
                        })->toArray();
                    }
                } else {
                    $taxe = Taxe::where(['sigle' => 'tva_excursion'])->first();
                    foreach ($commande as $key => $value) {
                        $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                            if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                                || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                                $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                            } else {
                                $data->taxe_calculer = 0;
                            }
                            return $data;
                        })->toArray();
                    }
                }
            } else if (isset($commande['transfert'])) {
                $taxe = Taxe::where(['sigle' => 'tva_transfert'])->first();
                foreach ($commande as $key => $value) {
                    $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                        if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                            || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                            $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                        } else {
                            $data->taxe_calculer = 0;
                        }
                        return $data;
                    })->toArray();
                }
            } else if (isset($commande['billeterie'])) {
                $taxe = Taxe::where(['sigle' => 'tva_billetterie'])->first();
                foreach ($commande as $key => $value) {
                    $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                        if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                            || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                            $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                        } else {
                            $data->taxe_calculer = 0;
                        }
                        return $data;
                    })->toArray();
                }
            } else if (isset($commande['location'])) {
                $taxe = Taxe::where(['sigle' => 'tva_location'])->first();
                foreach ($commande as $key => $value) {
                    $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                        if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                            || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                            $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                        } else {
                            $data->taxe_calculer = 0;
                        }
                        return $data;
                    })->toArray();
                }
            }
        }
        /*$type_commande = collect($commande)->keys()->toArray();
        if (array_search('hebergement', $type_commande) !== false) {
            $taxe_heb = Taxe::where(['sigle' => 'tva_hebergement_pack'])->first();
            foreach ($commande as $key => $value) {
                $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe_heb) {
                    if ($taxe_heb != null && (($taxe_heb->taxe_appliquer == 0 && $taxe_heb->valeur_pourcent != null && doubleval($taxe_heb->valeur_pourcent) > 0)
                        || ($taxe_heb->taxe_appliquer == 1 && $taxe_heb->valeur_devises != null && doubleval($taxe_heb->valeur_devises) > 0))) {
                        $data->taxe_calculer = $taxe_heb->taxe_appliquer == 1 ? doubleval($taxe_heb->valeur_devises) : $data->data->marge_calculer * doubleval($taxe_heb->valeur_pourcent) / 100;
                    } else {
                        $data->taxe_calculer = 0;
                    }
                    return $data;
                })->toArray();
            }
        } else {
            foreach ($commande as $key => $value) {
                $taxe  = null;
                switch ($key) {
                    case 'transfert':
                        $taxe = Taxe::where(['sigle' => 'tva_transfert'])->first();
                        break;
                    case 'billeterie':
                        $taxe = Taxe::where(['sigle' => 'tva_billetterie'])->first();
                        break;
                    case 'location':
                        $taxe = Taxe::where(['sigle' => 'tva_location'])->first();
                        break;
                    case 'excursion':
                        $taxe = Taxe::where(['sigle' => 'tva_excursion'])->first();
                        break;
                }
                $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                    if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                        || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                        $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                    } else {
                        $data->taxe_calculer = 0;
                    }
                    return $data;
                })->toArray();
            }
        }*/
        //
        $frais_dossier = FraisDossier::where(['sigle' => 'frais_internet'])->first();
        //
        $tva = Taxe::all();
        //dd($commande); 
        return $this->viewCustom('front.facturation', [
            'data' => $commande,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'TVA' => $tva,
            'fraisdossier' => $frais_dossier,
            'modePayement' => ModePayement::all()
        ]);
    }

    public function check(Request $request)
    {
        if (!$request->has('pid'))
            abort(404);
        /** */
        $paiement = new AlmaModele();
        $payement_gateway = new PayementAlma($request, $paiement);
        $status_paiement = $payement_gateway->checkStatus($request->pid);
        if ($status_paiement['satus_code'] != 200) {
            abort(404);
        }
        $request_commande = $status_paiement['data']['orders'];
        $custom_data = json_decode($status_paiement['data']['custom_data']);
        /** */
        if (count($request_commande) == 0 && count($custom_data) == 0)
            abort(404);
        /** */

        $request_commande = $request_commande[0]->data;
        /** */
        $date = $custom_data->date;

        /** */
        if ($status_paiement['data']['state'] == "not_started" || $status_paiement['data']['state'] == "scored_no") {

            Mail::to($request_commande->client_info->email)->send(new ErrorMailPaiement([
                'url_commande' => base_url('/facturation?key_=' . $request->key_),
                'lien_titre' => "lien de commande"
            ]));

            return redirect("/facturation?key_=" . $status_paiement['data']['customer_cancel_url']);
        }
        /** */
        $commande = [
            'date' => $date,
            'status' => 1, /* 0->non_payer, 1->payer, 2->annuler */
            'status_payement' => ($status_paiement['data']['state'] == "not_started" || $status_paiement['data']['state'] == "scored_no") ? 0 : 1, /* 0->non_payer, 1->payer, 2->annuler */
            'prix' => $custom_data->prix,
            'tva' => $custom_data->tva,
            'frais_dossier' => $custom_data->frais_dossier,
            'prix_total' => $custom_data->prix_total,
            'paiement_id' => $status_paiement['data']['id'],
            'mode_payement_id' => $custom_data->mode_payement_id
        ];
        $commande = Commande::create($commande);
        /** */
        $info_client = (array) $request_commande->client_info;
        $info_client['date'] = $date;
        $info_client['commande_id'] = $commande->id;
        /** */
        $facture = FacturationCommande::create($info_client);
        /** */
        $hebergement = $request_commande->hebergement;
        foreach ($hebergement as $key => $value) {

            $_item = [
                'hebergement_id' => $value->data->item->hebergement->id,
                'hebergement_name' => $value->data->item->hebergement->name,
                'hebergement_type' => $value->data->item->hebergement->type->name,
                'hebergement_duration_min' => $value->data->item->hebergement->duration_min,
                'hebergement_caution' => $value->data->item->hebergement->caution,
                'hebergement_etoil' => $value->data->item->hebergement->etoil,
                /* */
                'chambre_id' => $value->data->item->type_chambre->id,
                'chambre_name' => $value->data->item->type_chambre->name,
                'chambre_image' => $value->image,
                'chambre_capacite' => $value->data->item->type_chambre->capacite,
                /* */
                'chambre_base_type_titre' => $value->data->item->base_type->titre,
                'chambre_base_type_nombre' => $value->data->item->base_type->nombre,
                /* */
                'quantite_chambre' => $value->data->chambreChecked,
                'date_debut' => parse_date(Carbon::createFromFormat('d/m/Y', $value->computed->dateDebutCalendar)),
                'date_fin' => parse_date(Carbon::createFromFormat('d/m/Y', $value->computed->dateEndCalendar)),
                /* */
                'prix_unitaire' => $value->prix,
                'prix_total' => $value->computed->prixTotal,
                'commande_id' => $commande->id,
                /* */
                'ville_id' => $value->data->item->hebergement->ville_id,
                'ile_id' => $value->data->item->hebergement->ile_id,
                'prestataire_id' => $value->data->item->hebergement->prestataire_id,
            ];
            $_item_heb = LigneCommandeChambre::create($_item);
            $chambre = TypeChambre::find($value->data->item->type_chambre->id);
            ChambreEnCommande::where([
                'chambre_id' => $value->data->item->type_chambre->id,
                'session_id' => $request->session()->getId(),
            ])->delete();

            if ($value->data->item->vol) {
                $vol_heb = new LigneVolHebergement;
                $vol_heb->depart = $value->data->item->vol->depart;
                $vol_heb->arrive = $value->data->item->vol->arrive;
                $vol_heb->nombre_jour = $value->data->item->vol->nombre_jour;
                $vol_heb->nombre_nuit = $value->data->item->vol->nombre_nuit;
                $vol_heb->heure_depart = $value->data->item->vol->heure_depart;
                $vol_heb->heure_arrive = $value->data->item->vol->heure_arrive;
                /* */
                $vol_heb->allotement_id =  $value->data->item->vol->allotement_id;
                $vol_heb->titre = $value->data->item->vol->allotement->titre;
                $vol_heb->compagnie_transport_id =  $value->data->item->vol->allotement->compagnie_transport_id;
                $vol_heb->lieu_depart_id =  $value->data->item->vol->allotement->lieu_depart_id;
                $vol_heb->lieu_depart =  $value->data->item->vol->allotement->depart->name;
                $vol_heb->lieu_arrive_id =  $value->data->item->vol->allotement->lieu_arrive_id;
                $vol_heb->lieu_arrive =  $value->data->item->vol->allotement->arrive->name;
                //
                $vol_heb->compagnie_nom = $value->data->item->vol->allotement->compagnie->nom;
                $vol_heb->compagnie_email = $value->data->item->vol->allotement->compagnie->email;
                $vol_heb->compagnie_phone = $value->data->item->vol->allotement->compagnie->phone;
                $vol_heb->compagnie_adresse = $value->data->item->vol->allotement->compagnie->adresse;
                $vol_heb->compagnie_logo =  $value->data->item->vol->allotement->compagnie->logo;
                $vol_heb->type_transport =  $value->data->item->vol->allotement->compagnie->type_transport;
                $vol_heb->compagnie_heure_ouverture =  $value->data->item->vol->allotement->compagnie->heure_ouverture;
                $vol_heb->compagnie_heure_fermeture =  $value->data->item->vol->allotement->compagnie->heure_fermeture;
                $vol_heb->compagnie_ville_id =  $value->data->item->vol->allotement->compagnie->ville->id;
                $vol_heb->compagnie_ville_name =  $value->data->item->vol->allotement->compagnie->ville->name;
                $vol_heb->compagnie_ville_code_postal =  $value->data->item->vol->allotement->compagnie->ville->code_postal;
                $_item_heb->vol()->save($vol_heb);
            }

            /* type personne tarif */
            foreach ($value->data->item->tarif as $_personne_tarif) {
                $new_tarif_personne = new LigneCommandeTypePersonne;
                $new_tarif_personne->type = $_personne_tarif->personne->type;
                $new_tarif_personne->age = $_personne_tarif->personne->age;
                $new_tarif_personne->nb = intval($value->form->{'personne_' . $_personne_tarif->personne->id});
                $new_tarif_personne->prix_unitaire = $_personne_tarif->prix_vente;
                $new_tarif_personne->prix_total = 0;
                $_item_heb->personne()->save($new_tarif_personne);
            }

            /** supplement */
            foreach ($value->data->supplementCkecked as $key_supp => $value_supp) {

                for ($i = 0; $i < count($value_supp); $i++) {
                    if ($value_supp[$i]->regle_tarif == 1) {
                        $new_supp = new LigneCommandeSupplement;
                        $new_supp->titre = $value_supp[$i]->titre;
                        $new_supp->icon = $value_supp[$i]->icon;
                        $new_supp->regle_tarif = isset($value_supp[$i]->regle_tarif) ? $value_supp[$i]->regle_tarif : 1;
                        $new_supp->prix = collect($value_supp[$i]->tarif)->map(function ($data) use ($value) {
                            $personne = TypePersonne::find($data->type_personne_id);
                            return intval($value->form->{'personne_' . $personne->id}) * $data->prix_vente;
                        })->sum();
                        /** */
                        if (isset($value_supp[$i]->prestataire)) {
                            $new_supp->prestataire_id = $value_supp[$i]->prestataire->id;
                            $new_supp->prestataire_name = $value_supp[$i]->prestataire->name;
                            $new_supp->prestataire_adresse = $value_supp[$i]->prestataire->adresse;
                            $new_supp->prestataire_ville = $value_supp[$i]->prestataire->ville->name;
                            $new_supp->prestataire_code_postal = $value_supp[$i]->prestataire->ville->code_postal;
                            $new_supp->prestataire_phone = $value_supp[$i]->prestataire->phone;
                            $new_supp->prestataire_email = $value_supp[$i]->prestataire->email;
                            $new_supp->prestataire_second_email = $value_supp[$i]->prestataire->second_email;
                        }
                        $_item_heb->supplement()->save($new_supp);

                        foreach ($value_supp[$i]->tarif as $value_supp_tarif) {
                            $personne = TypePersonne::find($value_supp_tarif->type_personne_id);
                            $new_supp_personne = new LigneCommandeTypePersonne;
                            $new_supp_personne->type = $personne['type'];
                            $new_supp_personne->age = $personne['age'];
                            $new_supp_personne->nb = intval($value->form->{'personne_' . $personne->id});
                            $new_supp_personne->prix_unitaire = $value_supp_tarif->prix_vente;
                            $new_supp_personne->prix_total = doubleval($value_supp_tarif->prix_vente) * intval($value->form->{'personne_' . $personne->id});
                            $new_supp->personne()->save($new_supp_personne);
                        }
                    } else {
                        $new_supp = new LigneCommandeSupplement;
                        $new_supp->titre = $value_supp[$i]->titre;
                        $new_supp->icon = $value_supp[$i]->icon;
                        $new_supp->regle_tarif = isset($value_supp[$i]->regle_tarif) ? $value_supp[$i]->regle_tarif : 1;
                        $new_supp->prix = collect($value_supp[$i]->tarif)->map(function ($data) use ($value) {
                            return  $data->prix_vente;
                        })->sum();
                        $_item_heb->supplement()->save($new_supp);
                    }
                }
            }
        }
        /** */
        $excursion = $request_commande->excursion;
        foreach ($excursion as $key => $value) {

            $_item = [
                'excursion_id' => $value->data->item->id,
                'title' => $value->data->item->title,
                'participant_min' => $value->data->item->participant_min,
                'duration' => $value->data->item->duration,
                'fond_image' => $value->image,
                'card' => $value->data->item->card,
                'lunch' => $value->data->item->lunch,
                'ticket' => $value->data->item->ticket,
                'adresse_arrive' => $value->data->item->adresse_arrive,
                'adresse_depart' => $value->data->item->adresse_depart,
                'ville_id' => $value->data->item->ville_id,
                'ile_id' => $value->data->item->ile_id,
                'prestataire_id' => $value->data->item->prestataire_id,
                'lieu_depart_id' => $value->data->item->lieu_depart_id,
                'lieu_arrive_id' => $value->data->item->lieu_arrive_id,
                /* */
                'date_excursion' => parse_date($value->data->selectCalendarDate[0]),
                'heure_depart' => $value->data->item->heure_depart,
                'heure_arrive' => $value->data->item->heure_arrive,
                /* */
                'prix_unitaire' => $value->prix,
                'prix_total' => $value->computed->prixTotal,
                'commande_id' => $commande->id,
                'lunch_prestataire_id' => $value->data->item->lunch_prestataire_id,
                'ticket_compagnie_id' => $value->data->item->ticket_billeterie_id,
                /* */
            ];
            $_item_exc = LigneCommandeExcursion::create($_item);

            /* type personne tarif */
            foreach ($value->data->personneChecked as $_personne_tarif) {
                $new_tarif_personne = new LigneCommandeTypePersonne;
                $new_tarif_personne->type = $_personne_tarif->type->type;
                $new_tarif_personne->age = $_personne_tarif->type->age;
                $new_tarif_personne->nb = intval($_personne_tarif->nb);
                $new_tarif_personne->prix_unitaire = $_personne_tarif->unitaire;
                $new_tarif_personne->prix_total = doubleval($_personne_tarif->prix);
                $_item_exc->personne()->save($new_tarif_personne);
            }

            /** supplement */
            foreach ($value->data->supplementCkecked as $key_supp => $value_supp) {
                for ($i = 0; $i < count($value_supp); $i++) {
                    $new_supp = new LigneCommandeSupplement;
                    $new_supp->titre = $value_supp[$i]->titre;
                    $new_supp->icon = $value_supp[$i]->icon;
                    $new_supp->regle_tarif = isset($value_supp[$i]->regle_tarif) ? $value_supp[$i]->regle_tarif : 1;
                    $new_supp->prix = collect($value_supp[$i]->tarif)->map(function ($data) use ($value) {
                        $personne = TypePersonne::find($data->type_personne_id);
                        return intval($value->form->{'personne_' . $personne->id}) * $data->prix_vente;
                    })->sum();
                    /** */
                    if (isset($value_supp[$i]->prestataire)) {
                        $new_supp->prestataire_id = $value_supp[$i]->prestataire->id;
                        $new_supp->prestataire_name = $value_supp[$i]->prestataire->name;
                        $new_supp->prestataire_adresse = $value_supp[$i]->prestataire->adresse;
                        $new_supp->prestataire_ville = $value_supp[$i]->prestataire->ville->name;
                        $new_supp->prestataire_code_postal = $value_supp[$i]->prestataire->ville->code_postal;
                        $new_supp->prestataire_phone = $value_supp[$i]->prestataire->phone;
                        $new_supp->prestataire_email = $value_supp[$i]->prestataire->email;
                        $new_supp->prestataire_second_email = $value_supp[$i]->prestataire->second_email;
                    }
                    $_item_exc->supplement()->save($new_supp);

                    foreach ($value_supp[$i]->tarif as $value_supp_tarif) {
                        $personne = TypePersonne::find($value_supp_tarif->type_personne_id);
                        $new_supp_personne = new LigneCommandeTypePersonne;
                        $new_supp_personne->type = $personne['type'];
                        $new_supp_personne->age = $personne['age'];
                        $new_supp_personne->nb = intval($value->form->{'personne_' . $personne->id});
                        $new_supp_personne->prix_unitaire = $value_supp_tarif->prix_vente;
                        $new_supp_personne->prix_total = doubleval($value_supp_tarif->prix_vente) * intval($value->form->{'personne_' . $personne->id});
                        $new_supp->personne()->save($new_supp_personne);
                    }
                }
            }

            foreach ($value->data->item->lunch_prestataire as $value_lunch_prestataire) {
                $_lunch_prestataire = new LigneCommandeLunchPrestataire;
                $_lunch_prestataire->prestataire_id = $value_lunch_prestataire->id;
                $_lunch_prestataire->prestataire_name = $value_lunch_prestataire->name;
                $_lunch_prestataire->prestataire_adresse = $value_lunch_prestataire->adresse;
                $_lunch_prestataire->prestataire_ville = $value_lunch_prestataire->ville->name;
                $_lunch_prestataire->prestataire_code_postal = $value_lunch_prestataire->ville->code_postal;
                $_lunch_prestataire->prestataire_phone = $value_lunch_prestataire->phone;
                $_lunch_prestataire->prestataire_email = $value_lunch_prestataire->email;
                $_lunch_prestataire->prestataire_second_email = $value_lunch_prestataire->second_email;
                $_item_exc->lunch_prestataire()->save($_lunch_prestataire);
            }

            foreach ($value->data->item->ticket_billeterie as $value_ticket_billeterie) {
                $_ticket_billeterie = new LigneCommandeBilletCompagnie;
                $_ticket_billeterie->compagnie_id = $value_ticket_billeterie->compagnie->id;
                $_ticket_billeterie->compagnie_nom = $value_ticket_billeterie->compagnie->nom;
                $_ticket_billeterie->compagnie_email = $value_ticket_billeterie->compagnie->email;
                $_ticket_billeterie->compagnie_phone = $value_ticket_billeterie->compagnie->phone;
                $_ticket_billeterie->compagnie_adresse = $value_ticket_billeterie->compagnie->adresse;
                $_ticket_billeterie->compagnie_ville = $value_ticket_billeterie->compagnie->ville->name;
                $_ticket_billeterie->compagnie_code_postal = $value_ticket_billeterie->compagnie->ville->code_postal;
                $_ticket_billeterie->billet_id = $value_ticket_billeterie->id;
                $_ticket_billeterie->billet_titre = $value_ticket_billeterie->titre;
                $_ticket_billeterie->billet_date_depart = $value->data->selectCalendarDate[0];
                $_ticket_billeterie->billet_date_arrive = $value->data->selectCalendarDate[0];
                $_ticket_billeterie->billet_lieu_depart_id = $value_ticket_billeterie->depart->id;
                $_ticket_billeterie->billet_lieu_arrive_id = $value_ticket_billeterie->arrive->id;
                $_ticket_billeterie->billet_lieu_depart_name = $value_ticket_billeterie->depart->name;
                $_ticket_billeterie->billet_lieu_arrive_name = $value_ticket_billeterie->arrive->name;
                $_ticket_billeterie->billet_lieu_depart_ville = $value_ticket_billeterie->depart->ville->name;
                $_ticket_billeterie->billet_lieu_arrive_ville = $value_ticket_billeterie->arrive->ville->name;
                $_ticket_billeterie->billet_lieu_depart_code_postal = $value_ticket_billeterie->depart->ville->code_postal;
                $_ticket_billeterie->billet_lieu_arrive_code_postal = $value_ticket_billeterie->arrive->ville->code_postal;
                $_item_exc->billet_compagnie()->save($_ticket_billeterie);
            }
        }
        /** */
        $location = $request_commande->location;
        foreach ($location as $key => $value) {

            $_item = [
                'location_id' => $value->data->item->id,
                'titre' => $value->data->item->titre,
                'immatriculation' => $value->data->item->immatriculation,
                'duration_min' => $value->data->item->duration_min,
                'image' => $value->image,
                'marque_vehicule_id' => $value->data->item->marque->id,
                'marque_vehicule_titre' => $value->data->item->marque->titre,
                'modele_vehicule_id' => $value->data->item->modele->id,
                'modele_vehicule_titre' => $value->data->item->modele->titre,
                'categorie_vehicule_id' => $value->data->item->categorie->id,
                'categorie_vehicule_titre' => $value->data->item->categorie->titre,
                'famille_vehicule_id' => $value->data->item->categorie->famille->id,
                'famille_vehicule_titre' => $value->data->item->categorie->famille->titre,
                'prestataire_id' => $value->data->item->prestataire_id,
                'agence_recuperation_name' => $value->data->item->agence_recuperation->name,
                'agence_recuperation_id' => $value->data->item->agence_recuperation->id,
                'agence_restriction_name' => $value->data->item->agence_restriction->name,
                'agence_restriction_id' => $value->data->item->agence_restriction->id,
                'date_recuperation' => parse_date(Carbon::createFromFormat('Y-m-d', $value->form->date_recuperation)),
                'date_restriction' => parse_date(Carbon::createFromFormat('Y-m-d', $value->form->date_restriction)),
                'heure_recuperation' => $value->form->heure_recuperation,
                'heure_restriction' => $value->form->heure_restriction,
                'nom_conducteur' => $value->form->nom,
                'prenom_conducteur' => $value->form->prenom,
                'adresse_conducteur' => $value->form->adresse,
                'ville_conducteur' => $value->form->ville,
                'code_postal_conducteur' => $value->form->{'code-postal'},
                'telephone_conducteur' => $value->form->telephone,
                'email_conducteur' => $value->form->email,
                'date_naissance_conducteur' => $value->form->{'date-naissance'},
                'lieu_naissance_conducteur' => $value->form->{'lieu-naissance'},
                'num_permis_conducteur' => $value->form->{'num-permis'},
                'date_permis_conducteur' => $value->form->{'date-permis'},
                'lieu_deliv_permis_conducteur' => $value->form->{'lieu-deliv-permis'},
                'num_identite_conducteur' => $value->form->{'num-identite'},
                'date_emis_identite_conducteur' => $value->form->{'date-emis-identite'},
                'lieu_deliv_identite_conducteur' => $value->form->{'lieu-deliv-identite'},
                'order_comments' => $value->form->order_comments,
                /* */
                'prix_unitaire' => $value->prix,
                'prix_total' => $value->computed->prixTotal,
                'commande_id' => $commande->id,
                /* */
                'caution' => $value->data->item->caution,
                'deplacement_lieu_tarif' => $value->data->item->categorie->supplement ? $value->data->item->categorie->supplement->tarif : 0,
            ];

            foreach ($value->data->assurance as $val) {
                $_item[$val->assurance] = $val->value;
            }

            $_item_location = LigneCommandeLocation::create($_item);
        }
        /** */
        $billeterie = $request_commande->billeterie;

        foreach ($billeterie as $key => $value) {

            $_item = [
                'billeterie_id' => $value->data->item->id,
                'titre' => $value->data->item->titre,
                'date_depart' => parse_date(Carbon::createFromFormat('Y-m-d', $value->data->item->date_depart)),
                'image' => $value->image,
                'quantite' => collect($value->data->item->personne)->map(function ($data) {
                    return $data->nb;
                })->sum(),
                'compagnie_transport_id' => $value->data->item->compagnie->id,
                'compagnie_transport_name' => $value->data->item->compagnie->nom,
                'lieu_depart_id' => $value->data->item->depart->id,
                'lieu_depart_name' => $value->data->item->depart->name,
                'lieu_arrive_id' => $value->data->item->arrive->id,
                'lieu_arrive_name' => $value->data->item->arrive->name,
                /* */
                'parcours' => $value->data->item->parcours,
                'heure_aller' => $value->form->heure_aller,
                /* */
                'prix_unitaire' => $value->prix,
                'prix_total' => $value->computed->prixTotal,
                'commande_id' => $commande->id,
            ];
            if ($value->data->item->parcours == 2) {
                $_item['date_retour'] = parse_date(Carbon::createFromFormat('Y-m-d', $value->data->item->date_retour));
                $_item['heure_retour'] = $value->form->heure_retour;
            }
            $_item_billet = LigneCommandeBilletterie::create($_item);

            /* type personne tarif */
            foreach ($value->data->item->tarif as $_personne_tarif) {
                $new_tarif_personne = new LigneCommandeTypePersonne;
                $new_tarif_personne->type = $_personne_tarif->personne->type;
                $new_tarif_personne->age = $_personne_tarif->personne->age;
                $new_tarif_personne->nb = $_personne_tarif->nb;
                $new_tarif_personne->prix_unitaire = $value->data->item->parcours == 1 ? $_personne_tarif->prix_vente_aller : $_personne_tarif->prix_vente_aller_retour;
                $new_tarif_personne->prix_total = $value->data->item->parcours == 1 ? doubleval($_personne_tarif->prix_vente_aller) * intval($_personne_tarif->nb) : doubleval($_personne_tarif->prix_vente_aller_retour) * intval($_personne_tarif->nb);
                $_item_billet->personne()->save($new_tarif_personne);
            }
        }
        /** */
        $transfert = $request_commande->transfert;
        foreach ($transfert as $key => $value) {

            $_item = [
                'transfert_id' => $value->data->item->id,
                'titre' => $value->data->item->titre,
                'date_depart' => parse_date(Carbon::createFromFormat('Y-m-d', $value->data->item->date_depart)),
                'image' => $value->image,
                'quantite' => collect($value->data->item->personne)->map(function ($data) {
                    return $data->nb;
                })->sum(),
                'lieu_depart_id' => $value->data->item->lieu_depart->id,
                'lieu_depart_name' => $value->data->item->lieu_depart->titre,
                'lieu_arrive_id' => $value->data->item->lieu_retour->id,
                'lieu_arrive_name' => $value->data->item->lieu_retour->titre,
                /* */
                'parcours' => $value->data->item->parcours,
                'heure_depart' => $value->data->item->heure_depart,
                'prime_depart' => $value->data->item->prime_depart,
                'prime_retour' => $value->data->item->prime_retour,
                /* */
                'prix_unitaire' => $value->prix,
                'prix_total' => $value->computed->prixTotal,
                'commande_id' => $commande->id,
                'prestataire_id' => $value->data->item->tranche->type->prestataire->id,
            ];
            if ($value->data->item->parcours == 2) {
                $_item['date_retour'] = parse_date(Carbon::createFromFormat('Y-m-d', $value->data->item->date_retour));
                $_item['heure_retour'] = $value->data->item->heure_retour;
            }
            $_item_trans = LigneCommandeTransfert::create($_item);

            /* type personne tarif */
            foreach ($value->data->item->tranche->tarif as $_personne_tarif) {
                $new_tarif_personne = new LigneCommandeTypePersonne;
                $new_tarif_personne->type = $_personne_tarif->personne->type;
                $new_tarif_personne->age = $_personne_tarif->personne->age;
                $new_tarif_personne->nb = $_personne_tarif->nb_personne;
                $new_tarif_personne->prix_unitaire = $value->data->item->parcours == 1 ? $_personne_tarif->prix_vente_aller : $_personne_tarif->prix_vente_aller_retour;
                $new_tarif_personne->prix_total = $value->data->item->parcours == 1 ? doubleval($_personne_tarif->prix_vente_aller) * intval($_personne_tarif->nb_personne) : doubleval($_personne_tarif->prix_vente_aller_retour) * intval($_personne_tarif->nb_personne);
                $_item_trans->personne()->save($new_tarif_personne);
            }
        }

        /** delete commande */
        GestionCommandeUtilisateurController::delete_all($request);
        /** delete commande */
        $key_session =  GestionRequestUtilisateurController::putIdentifiantKey([
            'paiement_id' => $status_paiement['data']['id']
        ]);
        return  redirect('remerciement?key_=' . $key_session['key']);
    }

    public function paiement(PutFacturationCommande $request)
    {
        /* */
        $key_session =  GestionRequestUtilisateurController::putIdentifiantKey([
            'key_' => GestionCommandeUtilisateurController::identifiantSession($request)
        ]);
        /* */
        $date = parse_date(now());
        $commande = [
            'date' => $date,
            'status' => 0, /* 0->non_payer, 1->payer, 2->annuler */
            'prix' => doubleval($request->tarifTotal),
            'tva' => doubleval($request->taxe_tva),
            'frais_dossier' => doubleval($request->frais_dossier),
            'prix_total' => doubleval($request->tarifTotalTaxe),
            'mode_payement_id' => $request->mode_payement,
            'identifiant_session' => $key_session['key']
        ];
        $info_client = $request->client_info;

        /** */
        $paiement = new AlmaModele();
        $paiement->payment_purchase_amount = doubleval($commande['prix_total']) * 100;
        $paiement->payment_installments_count = 1;
        $paiement->payment_return_url = base_url('/check-facturation?key_=' . $commande['identifiant_session']);
        $paiement->payment_shipping_address_first_name = $info_client['nom'];
        $paiement->payment_shipping_address_last_name = $info_client['prenom'];
        $paiement->payment_shipping_address_line1 = $info_client['adresse'];
        $paiement->payment_shipping_address_postal_code = $info_client['code_postal'];
        $paiement->payment_shipping_address_city = $info_client['ville'];
        $paiement->payment_locale = 'fr';
        $paiement->payment_origin = 'online';
        /** */
        $paiement->customer_first_name = $info_client['nom'];
        $paiement->customer_last_name = $info_client['prenom'];
        $paiement->customer_email = $info_client['email'];
        $paiement->customer_phone = $info_client['telephone'];
        /** */
        $paiement->customer_fee = 0; // frais payé par le client appart montant
        $paiement->customer_interest = 0; // intéret payé par le client appart montant
        $paiement->payment_ipn_callback_url = base_url('/check-payement'); // url de sécoure
        $paiement->payment_merchant_name = 'Sael voyages'; // nom de marchand ayant créé le paiement,
        $paiement->payment_custom_data = collect($commande)->toJson(); //Objet JSON de format libre qui vous permet d'associer au paiement Alma des données provenant de votre base de données.
        /** */
        $paiement->orders_merchant_reference = '' . $commande['identifiant_session'] . '';
        $paiement->orders_merchant_url = base_url('/panier?key_=' . $commande['identifiant_session']);
        $paiement->orders_data =   $request->all();
        /** */
        $paiement->customer_cancel_url = base_url('/facturation?key_=' . $commande['identifiant_session']);

        /** */
        $payement_gateway = new PayementAlma($request, $paiement);
        $payement_info = $payement_gateway->payer();

        if ($payement_info['satus_code'] == 200) {
            return response($payement_info['data']['url'], $payement_info['satus_code'])
                ->header('Content-Type', 'text/json');
        } else {
            return response($payement_info['data'], $payement_info['satus_code'])
                ->header('Content-Type', 'text/json');
        }
    }
}
