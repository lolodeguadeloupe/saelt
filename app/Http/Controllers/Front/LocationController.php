<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LocationVehicule\VehiculeLocation;
use Brackets\AdminListing\Facades\AdminListing;
use App\Models\LocationVehicule\MarqueVehicule;
use App\Models\LocationVehicule\FamilleVehicule;
use App\Models\LocationVehicule\CategorieVehicule;
use App\Models\LocationVehicule\ModeleVehicule;
use App\Models\LocationVehicule\AgenceLocation;
use App\Models\Ile;
use App\Models\Saison;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{

    public function index(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);
        /* search */
        $vehicule_filter_id = null;
        $search_condition = [
            'lieu_recuperation' => '',
            'date_recuperation' => '',
            'heure_recuperation' => '',
            'lieu_restriction' => '',
            'date_restriction' => '',
            'heure_restriction' => '',
        ];
        $categorie = [];
        $marque =  [];
        $modele = [];
        $famille =  [];
        $customer_search = null;

        if ($request->has('customer_search') || $my_request) {
            $customer_search = $request->has('customer_search') ? json_decode($request->customer_search) : (object)((object) $my_request)->customer_search;
            /* affectation valeur filter */
            $categorie = isset($customer_search->categorie) ? explode(',', $customer_search->categorie) : [];
            $marque = isset($customer_search->marque) ? explode(',', $customer_search->marque) : [];
            $modele = isset($customer_search->modele) ? explode(',', $customer_search->modele) : [];
            $famille = isset($customer_search->famille) ? explode(',', $customer_search->famille) : [];
            $search_condition['lieu_recuperation'] = isset($customer_search->lieu_recuperation) ? $customer_search->lieu_recuperation : '';
            $search_condition['date_recuperation'] = isset($customer_search->date_recuperation) ? $customer_search->date_recuperation : '';
            $search_condition['heure_recuperation'] = isset($customer_search->heure_recuperation) ? $customer_search->heure_recuperation : '';
            $search_condition['lieu_restriction'] = isset($customer_search->lieu_restriction) ? $customer_search->lieu_restriction : '';
            $search_condition['date_restriction'] = isset($customer_search->date_restriction) ? $customer_search->date_restriction : '';
            $search_condition['heure_restriction'] = isset($customer_search->heure_restriction) ? $customer_search->heure_restriction : '';
        }

        $data = AdminListing::create(VehiculeLocation::class)
            ->modifyQuery(function ($query) use ($request, $categorie, $marque, $modele, $famille, $customer_search) {
                $query->join('marque_vehicule', 'marque_vehicule.id', 'vehicule_location.marque_vehicule_id');
                $query->join('modele_vehicule', 'modele_vehicule.id', 'vehicule_location.modele_vehicule_id');
                $query->join('categorie_vehicule', 'categorie_vehicule.id', 'vehicule_location.categorie_vehicule_id');
                $query->join('famille_vehicule', 'famille_vehicule.id', 'categorie_vehicule.famille_vehicule_id');
                $query->with(['prestataire', 'marque', 'modele', 'info_tech', 'categorie' => function ($query) {
                    $query->with(['famille']);
                }, 'tarif_location' => function ($query) {
                    $query->with(['saison', 'trancheSaison']);
                }]);
                $query->where(['entite_modele' => 'location_vehicule']);
                if (count($categorie) > 0) {
                    $query->whereIn('categorie_vehicule.id', $categorie);
                }
                if (count($famille) > 0) {
                    $query->whereIn('famille_vehicule.id', $famille);
                }
                if (count($marque) > 0) {
                    $query->whereIn('marque_vehicule.id', $marque);
                }
                if (count($modele) > 0) {
                    $query->whereIn('modele_vehicule.id', $modele);
                }
                if ($customer_search == null) {
                    //$query->where('vehicule_location.id', 0);
                }
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'status', 'duration_min', 'prestataire_id', 'categorie_vehicule_id', 'franchise', 'franchise_non_rachatable', 'caution'],
                // set columns to searchIn
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'franchise', 'franchise_non_rachatable', 'caution', 'description', 'prestataire.name', 'categorie.titre', 'categorie_vehicule.titre', 'famille_vehicule.titre']
            );

        $collection = $data->getCollection();

        $collection = $collection->map(function ($data) use ($search_condition) {
            $data = collect($data);
            $data->put('search_condition', collect($search_condition));
            $data['tarif_location'] = collect($data['tarif_location'])->map(function ($data_tarif) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $data_tarif['saison']['debut'],
                    'fin' => $data_tarif['saison']['fin']
                ]);
                $data_tarif['saison']['debut'] = $saion_ranger['debut'];
                $data_tarif['saison']['fin'] = $saion_ranger['fin'];
                return $data_tarif;
            });
            /*
            $data->put('tarif_location', collect($data['tarif_location'])->filter(function ($tarif) use ($data) {
                $date = new Carbon($data['search_condition']['date_restriction']);
                return ($date->isAfter($tarif['saison']['debut']) && $date->isBefore($tarif['saison']['fin']) && $tarif['tranche_saison']['nombre_min'] <= $date->diffInDays($data['search_condition']['date_recuperation']) && $date->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max'])
                    ||
                    ($date->equalTo($tarif['saison']['debut']) && $date->isBefore($tarif['saison']['fin']) && $tarif['tranche_saison']['nombre_min'] <= $date->diffInDays($data['search_condition']['date_recuperation']) && $date->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max']);
            })->values()->first());
            */
            $data->put('tarif_location', collect($data['tarif_location'])->filter(function ($tarif) use ($data) {
                $date_fin = new Carbon($data['search_condition']['date_restriction']);
                $date_debut = new Carbon($data['search_condition']['date_recuperation']);
                return ($date_debut->isAfter($tarif['saison']['debut']) && $date_fin->isBefore($tarif['saison']['fin']) && $date_fin->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max'])
                    ||
                    ($date_debut->equalTo($tarif['saison']['debut']) && $date_fin->isBefore($tarif['saison']['fin']) && $date_fin->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max']);
            })->values()->first());
            return $data;
        });
        $collection = $collection->filter(function ($data) {
            return $data['tarif_location'] != null;
        })->values();
        $data->setCollection($customer_search != null ? $collection : collect([]));

        if ($request->ajax()) {

            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        //dd($data->toArray());
        return $this->viewCustom('front.location.locations', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'aside' => [
                'marque' => MarqueVehicule::all(),
                'modele' => ModeleVehicule::all(),
                'famille' => FamilleVehicule::with(['categorie'])->get(),
                'agence_location' => AgenceLocation::all()
            ]
        ]);
    }

    public function product(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request);
        // 
        $data = AdminListing::create(VehiculeLocation::class)
            ->modifyQuery(function ($query) use ($request, $my_request) {
                $query->join('marque_vehicule', 'marque_vehicule.id', 'vehicule_location.marque_vehicule_id');
                $query->join('modele_vehicule', 'modele_vehicule.id', 'vehicule_location.modele_vehicule_id');
                $query->join('categorie_vehicule', 'categorie_vehicule.id', 'vehicule_location.categorie_vehicule_id');
                $query->join('famille_vehicule', 'famille_vehicule.id', 'categorie_vehicule.famille_vehicule_id');
                $query->with(['prestataire', 'marque', 'modele', 'info_tech', 'categorie' => function ($query) {
                    $query->with(['famille', 'supplement' => function ($query) {
                        $query->with(['trajet']);
                    }]);
                }, 'tarif_location' => function ($query) {
                    $query->with(['saison', 'trancheSaison']);
                }]);
                $query->where(['entite_modele' => 'location_vehicule', 'vehicule_location.id' => $my_request['id']]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'status', 'duration_min', 'prestataire_id', 'categorie_vehicule_id', 'franchise', 'franchise_non_rachatable', 'caution'],
                // set columns to searchIn
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'franchise', 'franchise_non_rachatable', 'caution', 'description', 'prestataire.name', 'categorie.titre', 'categorie_vehicule.titre', 'famille_vehicule.titre']
            );

        $collection = $data->getCollection();

        $collection = $collection->map(function ($data) use ($my_request) {
            $data = collect($data);
            $data->put('search_condition', collect($my_request['search_condition']));
            $date_fin = new Carbon($data['search_condition']['date_restriction']);
            //
            $date_debut = new Carbon($data['search_condition']['date_recuperation']);
            $data['tarif_location'] = collect($data['tarif_location'])->map(function ($data_tarif) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $data_tarif['saison']['debut'],
                    'fin' => $data_tarif['saison']['fin']
                ]);
                $data_tarif['saison']['debut'] = $saion_ranger['debut'];
                $data_tarif['saison']['fin'] = $saion_ranger['fin'];
                return $data_tarif;
            });
            /*
            $data->put('tarif_location', collect($data['tarif_location'])->filter(function ($tarif) use ($data, $date) {
                return ($date->isAfter($tarif['saison']['debut']) && $date->isBefore($tarif['saison']['fin']) && $tarif['tranche_saison']['nombre_min'] <= $date->diffInDays($data['search_condition']['date_recuperation']) && $date->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max'])
                    ||
                    ($date->equalTo($tarif['saison']['debut']) && $date->isBefore($tarif['saison']['fin']) && $tarif['tranche_saison']['nombre_min'] <= $date->diffInDays($data['search_condition']['date_recuperation']) && $date->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max']);
            })->values());
            */
            $data->put('tarif_location', collect($data['tarif_location'])->filter(function ($tarif) use ($data, $date_debut, $date_fin) {
                return ($date_debut->isAfter($tarif['saison']['debut']) && $date_fin->isBefore($tarif['saison']['fin']) && $date_fin->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max'])
                    ||
                    ($date_debut->equalTo($tarif['saison']['debut']) && $date_fin->isBefore($tarif['saison']['fin']) && $date_fin->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max']);
            })->values());
            $categorie = $data['categorie'];
            $categorie['supplement'] = collect($data['categorie']['supplement'])->filter(function ($supp) use ($data) {
                return $supp['trajet']['agence_location_depart'] == $data['search_condition']['lieu_recuperation'] && $supp['trajet']['agence_location_arrive'] == $data['search_condition']['lieu_restriction'];
            });
            $categorie['supplement'] = collect($categorie['supplement'])->first();
            $data->put('categorie', $categorie);
            $data->put('tarif_location', collect($data['tarif_location'])->first());
            $data->put('agence_recuperation', AgenceLocation::find($data['search_condition']['lieu_recuperation'])->toArray());
            $data->put('agence_restriction', AgenceLocation::find($data['search_condition']['lieu_restriction'])->toArray());
            return $data;
        });
        /** */
        $collection = $collection->filter(function ($data) use ($my_request) {
            $data = collect($data);
            return $data['tarif_location'] != null;
        });

        $collection = $collection->map(function ($data) use ($my_request) {
            $data = collect($data);
            $data->put('search_condition', collect($my_request['search_condition']));
            //
            $date_fin = new Carbon($data['search_condition']['date_restriction']);
            //
            $times_fin = preg_split('/\:/', $data['search_condition']['heure_restriction'], -1, PREG_SPLIT_NO_EMPTY);
            $date_time_fin = new Carbon($date_fin);
            if (count($times_fin) > 1) {
                $date_time_fin->setHour(intval($times_fin[0]));
                $date_time_fin->setMinute(intval($times_fin[1]));
            }
            //
            $date_debut = new Carbon($data['search_condition']['date_recuperation']);
            $times_debut = preg_split('/\:/', $data['search_condition']['heure_recuperation'], -1, PREG_SPLIT_NO_EMPTY);
            $date_time_debut = new Carbon($date_debut);
            if (count($times_debut) > 1) {
                $date_time_debut->setHour(intval($times_debut[0]));
                $date_time_debut->setMinute(intval($times_debut[1]));
            }
            $nb_jours = $date_time_fin->diffInDays($date_time_debut);
            $nb_jours = $nb_jours == 0 ? ($date_time_fin->diffInMinutes($date_time_debut) > 0 ? 1 : 0) : $nb_jours;
            //
            $data->put('jours', $nb_jours);
            $data->put('prixTotal', ($data['tarif_location']['prix_vente'] * $nb_jours) + ($data['categorie']['supplement'] != null && $data['categorie']['supplement']['tarif'] != null ? $data['categorie']['supplement']['tarif'] : 0));
            return $data;
        });
        /** */
        $data->setCollection($collection->filter(function ($data) {
            return $data['prixTotal'] > 0;
        }));
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        $_all_saison = VehiculeLocation::find($my_request['id'])->saison()->get();

        $_all_saison = collect($_all_saison)->map(function ($_saison) {
            $saion_ranger = self::rangerSaison([
                'debut' => $_saison->debut,
                'fin' =>  $_saison->fin
            ]);
            $_saison->debut = $saion_ranger['debut'];
            $_saison->fin = $saion_ranger['fin'];
            return $_saison;
        });

        return $this->viewCustom('front.location.location-product', [
            'data' => $data,
            'saisons' => $_all_saison,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'aside' => [
                'marque' => MarqueVehicule::all(),
                'modele' => ModeleVehicule::all(),
                'categorie' => CategorieVehicule::with(['famille'])->get(),
                'agence_location' => AgenceLocation::all()
            ],
            'commande_saved' => GestionCommandeUtilisateurController::modifier($request, 'location', $my_request['id'], collect($my_request)->get('date_commande')),
            'edit_pannier' => isset($my_request['panier']) && $my_request['panier'] == true,
        ]);
    }


    public function productPrice(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $data = VehiculeLocation::select('vehicule_location.*')
            ->join('marque_vehicule', 'marque_vehicule.id', 'vehicule_location.marque_vehicule_id')
            ->join('modele_vehicule', 'modele_vehicule.id', 'vehicule_location.modele_vehicule_id')
            ->join('categorie_vehicule', 'categorie_vehicule.id', 'vehicule_location.categorie_vehicule_id')
            ->join('famille_vehicule', 'famille_vehicule.id', 'categorie_vehicule.famille_vehicule_id')
            ->with(['prestataire', 'marque', 'modele', 'info_tech', 'categorie' => function ($query) {
                $query->with(['famille', 'supplement' => function ($query) {
                    $query->with(['trajet']);
                }]);
            }, 'tarif_location' => function ($query) {
                $query->with(['saison', 'trancheSaison']);
            }])
            ->where(['entite_modele' => 'location_vehicule', 'vehicule_location.id' => $request->location_id])
            ->get();
        /*dd(json_decode(json_encode(VehiculeLocation::with(['tarif_location' => function ($query) {
            $query->with(['saison', 'trancheSaison']);
        }])->find($request->location_id))));*/
        /*dd(json_decode(json_encode($data)));*/
        /** */
        $data = collect($data)->map(function ($data) use ($request) {
            $data = collect($data);
            $data->put('search_condition', collect($request->all()));
            $date_fin = new Carbon($request->date_restriction);
            $date_debut = new Carbon($request->date_recuperation);
            $data['tarif_location'] = collect($data['tarif_location'])->map(function ($data_tarif) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $data_tarif['saison']['debut'],
                    'fin' => $data_tarif['saison']['fin']
                ]);
                $data_tarif['saison']['debut'] = $saion_ranger['debut'];
                $data_tarif['saison']['fin'] = $saion_ranger['fin'];
                return $data_tarif;
            });
            $data->put('tarif_location', collect($data['tarif_location'])->filter(function ($tarif) use ($data, $date_debut, $date_fin) {
                return ($date_debut->isAfter($tarif['saison']['debut']) && $date_fin->isBefore($tarif['saison']['fin']) && $date_fin->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max'])
                    ||
                    ($date_debut->equalTo($tarif['saison']['debut']) && $date_fin->isBefore($tarif['saison']['fin']) && $date_fin->diffInDays($data['search_condition']['date_recuperation']) <= $tarif['tranche_saison']['nombre_max']);
            })->values());
            $categorie = $data['categorie'];
            $categorie['supplement'] = collect($data['categorie']['supplement'])->filter(function ($supp) use ($data) {
                return $supp['trajet']['agence_location_depart'] == $data['search_condition']['lieu_recuperation'] && $supp['trajet']['agence_location_arrive'] == $data['search_condition']['lieu_restriction'];
            });
            $categorie['supplement'] = collect($categorie['supplement'])->first();
            $data->put('categorie', $categorie);
            $data->put('tarif_location', collect($data['tarif_location'])->first());
            $data->put('agence_recuperation', AgenceLocation::find($data['search_condition']['lieu_recuperation'])->toArray());
            $data->put('agence_restriction', AgenceLocation::find($data['search_condition']['lieu_restriction'])->toArray());
            return $data;
        });
        /** */
        $data = collect($data)->filter(function ($data) {
            return $data['tarif_location'] == !null;
        });
        $data = collect($data)->map(function ($data) use ($request) {
            $data = collect($data);
            $date = new Carbon($request->date_restriction);
            //
            $date_fin = new Carbon($data['search_condition']['date_restriction']);
            //
            $times_fin = preg_split('/\:/', $data['search_condition']['heure_restriction'], -1, PREG_SPLIT_NO_EMPTY);
            $date_time_fin = new Carbon($date_fin);
            if (count($times_fin) > 1) {
                $date_time_fin->setHour(intval($times_fin[0]));
                $date_time_fin->setMinute(intval($times_fin[1]));
            }
            //
            $date_debut = new Carbon($data['search_condition']['date_recuperation']);
            $times_debut = preg_split('/\:/', $data['search_condition']['heure_recuperation'], -1, PREG_SPLIT_NO_EMPTY);
            $date_time_debut = new Carbon($date_debut);
            if (count($times_debut) > 1) {
                $date_time_debut->setHour(intval($times_debut[0]));
                $date_time_debut->setMinute(intval($times_debut[1]));
            }
            $nb_jours = $date_time_fin->diffInDays($date_time_debut);
            $nb_jours = $nb_jours == 0 ? ($date_time_fin->diffInMinutes($date_time_debut) > 0 ? 1 : 0) : 0;
            //
            $data->put('jours', $nb_jours);
            $data->put('prixTotal', ($data['tarif_location']['prix_vente'] * $nb_jours) + ($data['categorie']['supplement'] != null && $data['categorie']['supplement']['tarif'] != null ? $data['categorie']['supplement']['tarif'] : 0));
            return $data;
        });
        $data = collect($data)->filter(function ($data_filter) use ($data) {
            return $data_filter['prixTotal'] > 0 && collect($data)->max('prixTotal');
        })->values();

        return [
            'data' => $data
        ];
    }
}
