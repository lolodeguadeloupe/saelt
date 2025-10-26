<?php

namespace App\Http\Controllers\Front;

use App\Exports\AttemptTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use Brackets\AdminListing\Facades\AdminListing;
use App\Models\TransfertVoyage\LieuTransfert;
use App\Models\TypePersonne;
use App\Models\Ile;
use App\Models\TransfertVoyage\TarifTransfertVoyage;
use App\Models\TransfertVoyage\TrajetTransfertVoyage;
use App\Models\TransfertVoyage\TranchePersonneTransfertVoyage;
use App\Models\TransfertVoyage\TransfertVoyagePrimeNuit;

class TransfertController extends Controller
{

    public function index(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);
        //
        /* filtre tranche personne*/
        $customer_search = null;
        if ($request->has('customer_search') && $request->ajax() || $my_request != null) {
            $customer_search = $request->has('customer_search') ? json_decode($request->customer_search) : (object)$my_request['customer_search'];
        }
        /* */
        // dd($type_transfert_id != null);
        $data = AdminListing::create(TypeTransfertVoyage::class)
            ->modifyQuery(function ($query) use ($request, $customer_search) {
                if (isset($customer_search)) {
                    $query->with(['tranche' => function ($query) use ($customer_search) {
                        $query->with(['type' => function ($query) {
                            $query->with(['prestataire']);
                        }, 'tarif' => function ($query) use ($customer_search) {
                            $query->select('tarif_transfert_voyage.*')
                                ->with(['trajet', 'personne'])
                                ->join('trajet_transfert_voyage as trajet', 'trajet.id', 'tarif_transfert_voyage.trajet_transfert_voyage_id')
                                ->where([
                                    'trajet.point_depart' => $customer_search->depart,
                                    'trajet.point_arrive' => $customer_search->retour,
                                ]);
                        }]);
                    }]);
                } else {
                    $query->where(['id' => 0]);
                }
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'nombre_min', 'nombre_max'],
                // set columns to searchIn
                ['id', 'titre', 'description']
            );

        $collection = $data->getCollection();
        //dd($collection->toArray());

        $personne = [];
        $nb_personne = 0;

        if (isset($customer_search)) {
            foreach ($customer_search as $key => $value) {
                if (explode('_', $key)[0] == 'personne') {
                    $nb_personne = $nb_personne + intval($value);
                    $_personne = TypePersonne::find(explode('_', $key)[1]);
                    $_personne->nb = intval($value);
                    $personne[] = (object)collect($_personne)->toArray();
                }
            }
        }
        $collection = json_decode(json_encode($collection));
        $collection = collect($collection)->map(function ($data) use ($personne) {
            $personne_exist = json_decode(json_encode(TypePersonne::where(['model' => TypeTransfertVoyage::class, 'model_id' => $data->id])->get()));
            $personne_exist = collect($personne_exist)->filter(function ($pers) use ($personne) {
                $trouver = false;
                collect($personne)->map(function ($test_pers) use (&$trouver, $pers) {
                    if ($test_pers->id == $pers->original_id) {
                        $pers->nb = $test_pers->nb;
                        $trouver = true;
                    }
                });
                return $trouver;
            })->values();
            $data->personne = $personne_exist;
            $nb_personne = 0;
            foreach ($personne_exist as $key => $value) {
                $nb_personne = $nb_personne + intval($value->nb);
            }
            $data->nb_personne = $nb_personne;
            $data->tranche = collect($data->tranche)->filter(function ($data_tranche) use ($nb_personne) {
                /*if ($data_tranche->type->titre == 'Autocar')
                    dd( $nb_personne);*/
                return count($data_tranche->tarif) > 0 && intval($data_tranche->nombre_min)  <= intval($nb_personne) && intval($data_tranche->nombre_max)  >= intval($nb_personne);
            })->values();
            $data->prime_depart = 0;
            $data->prime_retour = 0;
            return $data;
        });

        //dd(json_decode(json_encode($collection)));
        $collection = collect($collection)->map(function ($data) use ($customer_search) {
            $id_array_pers = collect($data->personne)->map(function ($pers) {
                return $pers->id;
            })->toArray();
            $data->tranche = collect($data->tranche)->map(function ($data_tranche) use ($id_array_pers, $data, $customer_search) {
                $data_tranche->{'tarif_calculer'} = (object)[
                    'marge' => 0,
                    'aller' => 0,
                    'aller_retour' => 0,
                ];
                /** modification */
                $prix_base_adulte = collect($data_tranche->tarif)->filter(function ($data_tranche_tarif) {
                    return $data_tranche_tarif->personne->reference_prix = 1;
                })->first();
                $data_tranche->tarif_calculer->marge = intval($prix_base_adulte->marge_aller) + ($customer_search->parcours == 2 ? (intval($prix_base_adulte->marge_aller_retour)) : 0);
                $data_tranche->tarif_calculer->aller = intval($prix_base_adulte->prix_vente_aller);
                $data_tranche->tarif_calculer->aller_retour = intval($prix_base_adulte->prix_vente_aller_retour);
                /* modification */

                collect($data_tranche->tarif)->map(function ($data_tranche_tarif) use ($id_array_pers, $data_tranche, $data) {
                    if (($key = array_search($data_tranche_tarif->type_personne_id, $id_array_pers)) !== false) {
                        /*
                        $data_tranche->tarif_calculer->aller = $data_tranche->tarif_calculer->aller + (intval($data_tranche_tarif->prix_vente_aller) * intval($data->personne[$key]->nb));
                        $data_tranche->tarif_calculer->aller_retour = $data_tranche->tarif_calculer->aller_retour + (intval($data_tranche_tarif->prix_vente_aller_retour) * intval($data->personne[$key]->nb));
                        */
                        $data_tranche_tarif->nb_personne = intval($data->personne[$key]->nb);
                    }
                });
                $data_tranche->reference_prix = collect($data_tranche->tarif)->min($customer_search->parcours == 2 ? 'prix_vente_aller_retour' : 'prix_vente_aller');

                return $data_tranche;
            });

            /** */
            if (isset($customer_search)) {
                $data->date_depart = $customer_search->date_depart;
                $data->date_retour = isset($customer_search->date_retour) ? $customer_search->date_retour : null;
                $data->heure_depart = $customer_search->heure_depart;
                $data->heure_retour = isset($customer_search->heure_retour) ? $customer_search->heure_retour : null;
                $data->parcours = $customer_search->parcours;
                $data->lieu_depart = LieuTransfert::find($customer_search->depart);
                $data->lieu_retour = LieuTransfert::find($customer_search->retour);
            }
            return $data;
        });

        $collection = collect($collection)->filter(function ($data) {
            return count($data->tranche) > 0;
        })->values();

        $collection = collect($collection)->map(function ($data) use ($customer_search) {
            $data->tranche = collect($data->tranche)->filter(function ($data_tranche) use ($data) {
                return $data_tranche->reference_prix == collect($data->tranche)->max('reference_prix');
            })->values();
            $data->tranche = collect($data->tranche)->first();
            /** calcule prime */
            $prime = TransfertVoyagePrimeNuit::where(['trajet_id' => $data->tranche->tarif[0]->trajet->id, 'type_transfert_id' => $data->id])->first();
            $heure_aller = explode(':', strval($customer_search->heure_depart))[0];
            if (intval($heure_aller) >= 20 || intval($heure_aller) <= 6) {
                $data->prime_depart = isset($prime) ? doubleval($prime->prime_nuit) : 0;
            }
            if (isset($customer_search->heure_retour)) {
                $heure_aller_retour = explode(':', strval($customer_search->heure_retour))[0];
                if (intval($heure_aller_retour) >= 20 || intval($heure_aller_retour) <= 6) {
                    $data->prime_retour = isset($prime) ? doubleval($prime->prime_nuit) : 0;
                }
            }
            $data->prime_depart = ($data->tranche->tarif_calculer->aller * $data->prime_depart / 100);
            $data->prime_retour = ($data->tranche->tarif_calculer->aller_retour * ($data->prime_retour) / 100);
            $data->tranche->tarif_calculer->aller =  $data->tranche->tarif_calculer->aller + ($data->tranche->tarif_calculer->aller * $data->prime_depart / 100);
            $data->tranche->tarif_calculer->aller_retour =  $data->tranche->tarif_calculer->aller_retour + ($data->tranche->tarif_calculer->aller_retour * ($data->prime_retour + $data->prime_depart) / 100);
            
            /** */
            return $data;
        })->values();

        $data->setCollection(collect($collection));

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return [
                'data' => $data
            ];
        }

        /* lieu */
        $lieu_grouped = [];
        $trie = [];
        $lieu = LieuTransfert::with(['ville'])->get();
        $lieu = collect($lieu)->map(function ($_lieu) {
            $_lieu->related_id = collect(TrajetTransfertVoyage::join('tarif_transfert_voyage', 'tarif_transfert_voyage.trajet_transfert_voyage_id', 'trajet_transfert_voyage.id')->select('trajet_transfert_voyage.point_arrive')->where(['trajet_transfert_voyage.point_depart' => $_lieu->id])->get())->map(function ($data) {
                return $data->point_arrive;
            })->values();
            return $_lieu;
        });
        $lieu = $lieu->map(function ($data) use (&$lieu_grouped, $trie) {

            if (($key = array_search($data->ville_id, $trie)) !== false) {
                $lieu_grouped[$key][] = $data;
            } else {
                $lieu_grouped[count($trie)][] = $data;
                $trie[] = $data->ville_id;
            }
            return $data;
        });
        //dd($data->toArray());
        return $this->viewCustom('front.transfert.transferts', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'aside' => [
                'lieu' => $lieu_grouped,
                'personne' => TypePersonne::whereNull('model')->whereNull('model_id')->get()
            ]
        ]);
    }
}
