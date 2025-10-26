<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Excursion\Excursion;
use App\Models\Excursion\TarifExcursion;
use Brackets\AdminListing\Facades\AdminListing;
use App\Models\Ville;
use App\Models\Ile;
use App\Models\LocationVehicule\AgenceLocation;
use App\Models\TypePersonne;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExcursionController extends Controller
{

    public function index(Request $request)
    {

        $data = AdminListing::create(Ile::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['excursion']);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name', 'card', 'pays_id', 'background_image'],
                // set columns to searchIn
                ['id', 'name', 'card', 'pays_id', 'background_image']
            );

        $collection = $data->getCollection();
        $collection = $data->filter(function ($data) {
            return count($data->excursion);
        })->values();
        $data->setCollection($collection);

        return $this->viewCustom('front.excursion.excursions', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
        ]);
    }

    public function allproducts(Request $request)
    {

        /* search */
        $excursion_filter_id = null;
        $filter_ile = null;

        /* search ajax */
        if ($request->has('customer_search') && $request->ajax()) {
            $customer_search = json_decode($request->customer_search);
            $ile_id = explode(',', $customer_search->ile);
            $columns_search = [
                'iles.name',
                'villes.name',
                'lieu_depart.name',
                'lieu_arrive.name',
                'excursions.title',
                'excursions.heure_depart',
                'excursions.description',
                'excursions.adresse_depart',
                'excursions.adresse_arrive',
            ];

            /* affectation valeur filter */
            $mot_cle = isset($customer_search->mot_cle) ? $customer_search->mot_cle : '';
            $price = explode(',', $customer_search->price);

            /* indication ile filter */
            if (count($ile_id) > 1) {
                $filter_ile = trans('admin-base.filter.all_ile');
            } else {
                $filter_ile = Ile::find($ile_id[0])->name;
            }

            /* globale filter dans la base de données */
            $excursion_filter = Excursion::select('excursions.id')
                ->join('iles', 'iles.id', 'excursions.ile_id')
                ->leftjoin('villes', 'villes.id', 'excursions.ville_id')
                ->leftJoin('service_port as lieu_depart', 'lieu_depart.id', 'excursions.lieu_depart_id')
                ->leftJoin('service_port as lieu_arrive', 'lieu_arrive.id', 'excursions.lieu_arrive_id')
                ->join('tarif_excursion', 'tarif_excursion.excursion_id', 'excursions.id')
                ->join('saisons', 'saisons.id', 'tarif_excursion.saison_id')
                ->whereIn('iles.id', $ile_id)
                ->where(function ($query) use ($columns_search, $mot_cle) {
                    array_map(function ($array) use (&$query, $mot_cle) {
                        $query = $query->orWhere(DB::raw('lower(' . $array . ')'), 'like', '%' . strtolower($mot_cle) . '%');
                    }, $columns_search);
                })
                /** moteur sur le fitre saison code marche mais commenté */
                /*->where(function ($query) {
                    $query->whereColumn(DB::raw('month(saisons.debut)'), '<', DB::raw('month(saisons.fin)'))
                        ->where(function ($query) {
                            $query->whereMonth('saisons.fin', '>', now()->month)
                                ->orWhere(function ($query) {
                                    $query->whereMonth('saisons.debut', '=', now()->month)
                                        ->whereDay('saisons.fin', '>=', now()->day);
                                });
                        })
                        ->orWhere(function ($query) {
                            $query->whereColumn(DB::raw('month(saisons.debut)'), '>', DB::raw('month(saisons.fin)'))
                                ->where(function ($query) {
                                    $query->whereMonth('saisons.fin', '>', now()->month)
                                        ->orWhere(function ($query) {
                                            $query->whereMonth('saisons.fin', '=', now()->month)
                                                ->whereDay('saisons.fin', '>=', now()->day);
                                        })
                                        ->orWhere(function ($query) {
                                            $query->whereMonth('saisons.debut', '<', now()->month)
                                                ->orWhere(function ($query) {
                                                    $query->whereMonth('saisons.debut', '=', now()->month)
                                                        ->whereDay('saisons.debut', '<=', now()->day);
                                                });
                                        });
                                });
                        })
                        ->orWhere(function ($query) {
                            $query->whereColumn(DB::raw('month(saisons.debut)'), '=', DB::raw('month(saisons.fin)'))
                                ->whereDay('saisons.debut', '<=', now()->day)
                                ->whereDay('saisons.fin', '>=', now()->day);
                        });
                })*/
                ->whereBetween('tarif_excursion.prix_vente', $price);

            if ($customer_search->duration != '*') {
                $excursion_filter = $excursion_filter->where(['excursions.duration' => $customer_search->duration]);
            }

            $excursion_filter = $excursion_filter->get();

            /* liste hebergement_id trouvée par la filtre */
            $excursion_filter_id = $excursion_filter->map(function ($data_collection) {
                return $data_collection->id;
            })->values();

            /* search interactif get */
        } else {
            /* filter ile seulement si le customer_filter no definie */
            $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);

            if ($my_request != null) {
                $iles_id = explode(',', $my_request['ile']);
                $filter_ile = count($iles_id) == 1 ? Ile::find($iles_id[0])->name : 'Tout';

                $excursion_filter = Excursion::select('excursions.*')
                    ->join('tarif_excursion', 'tarif_excursion.excursion_id', 'excursions.id')
                    ->join('saisons', 'saisons.id', 'tarif_excursion.saison_id')
                    /** moteur sur le fitre saison code marche mais commenté */
                    /* ->where(function ($query) {
                        $query->whereColumn(DB::raw('month(saisons.debut)'), '<', DB::raw('month(saisons.fin)'))
                            ->where(function ($query) {
                                $query->whereMonth('saisons.fin', '>', now()->month)
                                    ->orWhere(function ($query) {
                                        $query->whereMonth('saisons.debut', '=', now()->month)
                                            ->whereDay('saisons.fin', '>=', now()->day);
                                    });
                            })
                            ->orWhere(function ($query) {
                                $query->whereColumn(DB::raw('month(saisons.debut)'), '>', DB::raw('month(saisons.fin)'))
                                    ->where(function ($query) {
                                        $query->whereMonth('saisons.fin', '>', now()->month)
                                            ->orWhere(function ($query) {
                                                $query->whereMonth('saisons.fin', '=', now()->month)
                                                    ->whereDay('saisons.fin', '>=', now()->day);
                                            })
                                            ->orWhere(function ($query) {
                                                $query->whereMonth('saisons.debut', '<', now()->month)
                                                    ->orWhere(function ($query) {
                                                        $query->whereMonth('saisons.debut', '=', now()->month)
                                                            ->whereDay('saisons.debut', '<=', now()->day);
                                                    });
                                            });
                                    });
                            })
                            ->orWhere(function ($query) {
                                $query->whereColumn(DB::raw('month(saisons.debut)'), '=', DB::raw('month(saisons.fin)'))
                                    ->whereDay('saisons.debut', '<=', now()->day)
                                    ->whereDay('saisons.fin', '>=', now()->day);
                            });
                    })*/
                    ->whereIn('ile_id', $iles_id);

                /* villes */
                if (isset($my_request['ville'])) {
                    $excursion_filter = $excursion_filter->whereIn('ville_id', explode(',', $my_request['ville']));
                }

                /* saison debut */
                if (isset($my_request['date_debut'])) {
                    $date = Carbon::createFromFormat('Y-m-d', $my_request['date_debut']);
                    $excursion_filter = $excursion_filter->where(function ($query) use ($date) {
                        $query->where(function ($query) use ($date) {
                            $query->whereColumn(DB::raw('month(saisons.debut)'), '<', DB::raw('month(saisons.fin)'))
                                ->where(function ($query) use ($date) {
                                    $query->whereMonth('saisons.debut', '<', $date->month)
                                        ->orWhere(function ($query) use ($date) {
                                            $query->whereMonth('saisons.debut', '=', $date->month)
                                                ->whereDay('saisons.debut', '<=', $date->day);
                                        });
                                });
                        })
                            ->orWhere(function ($query) use ($date) {
                                $query->whereColumn(DB::raw('month(saisons.debut)'), '>', DB::raw('month(saisons.fin)'))
                                    ->where(function ($query) use ($date) {
                                        $query->whereMonth('saisons.debut', '<', $date->month)
                                            ->orWhere(function ($query) use ($date) {
                                                $query->whereMonth('saisons.debut', '=', $date->month)
                                                    ->whereDay('saisons.debut', '<=', $date->day);
                                            })
                                            ->orWhere(function ($query) use ($date) {
                                                $query->whereMonth('saisons.fin', '>', $date->month)
                                                    ->orWhere(function ($query) use ($date) {
                                                        $query->whereMonth('saisons.fin', '=', $date->month)
                                                            ->whereDay('saisons.fin', '>=', $date->day);
                                                    });
                                            });
                                    });
                            })
                            ->orWhere(function ($query) use ($date) {
                                $query->whereColumn(DB::raw('month(saisons.debut)'), '=', DB::raw('month(saisons.fin)'))
                                    ->whereDay('saisons.debut', '<=', $date->day)
                                    ->whereDay('saisons.fin', '>=', $date->day);
                            });
                    });
                }

                /* saison fin */
                if (isset($my_request['date_fin'])) {
                    $date = Carbon::createFromFormat('Y-m-d', $my_request['date_fin']);
                    $excursion_filter = $excursion_filter->where(function ($query) use ($date) {
                        $query->where(function ($query) use ($date) {
                            $query->whereColumn(DB::raw('month(saisons.debut)'), '<', DB::raw('month(saisons.fin)'))
                                ->where(function ($query) use ($date) {
                                    $query->whereMonth('saisons.fin', '>', $date->month)
                                        ->orWhere(function ($query) use ($date) {
                                            $query->whereMonth('saisons.debut', '=', $date->month)
                                                ->whereDay('saisons.fin', '>=', $date->day);
                                        });
                                })
                                ->orWhere(function ($query) use ($date) {
                                    $query->whereColumn(DB::raw('month(saisons.debut)'), '>', DB::raw('month(saisons.fin)'))
                                        ->where(function ($query) use ($date) {
                                            $query->whereMonth('saisons.fin', '>', $date->month)
                                                ->orWhere(function ($query) use ($date) {
                                                    $query->whereMonth('saisons.fin', '=', $date->month)
                                                        ->whereDay('saisons.fin', '>=', $date->day);
                                                })
                                                ->orWhere(function ($query) use ($date) {
                                                    $query->whereMonth('saisons.debut', '<', $date->month)
                                                        ->orWhere(function ($query) use ($date) {
                                                            $query->whereMonth('saisons.debut', '=', $date->month)
                                                                ->whereDay('saisons.debut', '<=', $date->day);
                                                        });
                                                });
                                        });
                                })
                                ->orWhere(function ($query) use ($date) {
                                    $query->whereColumn(DB::raw('month(saisons.debut)'), '=', DB::raw('month(saisons.fin)'))
                                        ->whereDay('saisons.debut', '<=', $date->day)
                                        ->whereDay('saisons.fin', '>=', $date->day);
                                });
                        });
                    });
                }

                $excursion_filter = $excursion_filter->get();

                $excursion_filter_id = $excursion_filter->map(function ($data_collection) {
                    return $data_collection->id;
                })->values();
            } else {
                $excursion_filter = Excursion::first();
                if ($excursion_filter) {
                    $excursion_filter_id = [$excursion_filter->id];
                }
                $filter_ile = Ile::find($excursion_filter->ile_id)->name;
            }
        }
        
        if (count($excursion_filter_id) == 0) {
            $excursion_filter_id = [0];
        }
        /* search */
        $data = AdminListing::create(Excursion::class)
            ->modifyQuery(function ($query) use ($request, $excursion_filter_id) {
                $query->join('iles', 'iles.id', 'excursions.ile_id');
                $query->leftjoin('villes', 'villes.id', 'excursions.ville_id');
                $query->leftJoin('service_port as lieu_depart', 'lieu_depart.id', 'excursions.lieu_depart_id');
                $query->leftJoin('service_port as lieu_arrive', 'lieu_arrive.id', 'excursions.lieu_arrive_id');
                $query->with(['ville', 'taxe', 'depart', 'arrive', 'ile', 'compagnie_liaison', 'tarif' => function ($query) {
                    $query->with(['personne', 'saison']);
                }, 'supplement' => function ($query) {
                    $query->with(['tarif']);
                }, 'compagnie' => function ($query) {
                    $query->with(['ville', 'billeterie']);
                }]);
                $query->whereIn('excursions.id', $excursion_filter_id);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'title', 'lunch', 'ticket', 'availability', 'participant_min', 'card', 'heure_depart', 'description', 'ville_id', 'prestataire_id', 'status', 'duration', 'lieu_depart_id', 'lieu_arrive_id', 'ile_id', 'adresse_depart', 'adresse_arrive'],
                // set columns to searchIn
                ['id', 'title', 'lunch', 'ticket', 'availability', 'participant_min', 'card', 'heure_depart', 'prestataire.name', 'lieu_depart.name', 'lieu_arrive.name', 'iles.name', 'adresse_depart', 'adresse_arrive']
            );
        $collection = $data->getCollection();

        $collection = $collection->map(function ($data) {
            $data = collect($data);
            $data->put('supplement', collect($data['supplement'])->groupBy('type_label.value'));
            $data->put('tarif', collect($data['tarif'])->filter(function ($tarif) use ($data) {
                $has_adulte = collect($data['tarif'])->filter(function ($personne) {
                    return strtolower($personne['personne']['reference_prix']) == "1";
                })->values();
                if (count($has_adulte)) {
                    return $tarif['type_personne_id'] == $has_adulte[0]['type_personne_id']; // check personne adulte
                } else {
                    return $tarif['prix_vente'] == collect($data['tarif'])->min('prix_vente'); //reference prix
                }
            })->values());

            $data['tarif'] = collect($data['tarif'])->map(function ($data) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $data['saison']['debut'],
                    'fin' => $data['saison']['fin']
                ]);
                $data['saison']['debut'] = $saion_ranger['debut'];
                $data['saison']['fin'] = $saion_ranger['fin'];
                return $data;
            });
            /** moteur sur le fitre saison code marche mais commenté */
            /* $tarif_sans_vol_min_1 = collect($data['tarif'])->filter(function ($data) {
                return now()->greaterThanOrEqualTo($data['saison']['debut']) && now()->lessThanOrEqualTo($data['saison']['fin']);
            })->values();
            //filtre saison 2
            if (count($tarif_sans_vol_min_1) == 0) {
                $tarif_sans_vol_min_2 = collect($data['tarif'])->filter(function ($data) {
                    return now()->greaterThanOrEqualTo($data['saison']['debut']);
                })->values();
                //finalisation filtre saison
                $data['tarif'] = collect($tarif_sans_vol_min_2)->filter(function ($data) use ($tarif_sans_vol_min_2) {
                    return $data['saison']['debut']->getTimestamp() == collect($tarif_sans_vol_min_2)->map(function ($convert_time) {
                        return $convert_time['saison']['debut']->getTimestamp();
                    })->min();
                })->first();
            } else {
                // finalisation filtre saison
                $data['tarif'] = collect($tarif_sans_vol_min_1)->filter(function ($data) use ($tarif_sans_vol_min_1) {
                    return $data['saison']['fin']->getTimestamp() == collect($tarif_sans_vol_min_1)->map(function ($convert_time) {
                        return $convert_time['saison']['fin']->getTimestamp();
                    })->max();
                })->first();
            }
            */

            /* code temporaire pour le filtrage prix min */
            $data['tarif'] = collect($data['tarif'])->filter(function ($_data) use ($data) {
                return $_data['prix_vente'] == collect($data['tarif'])->min('prix_vente');
            })->first();
            /* code temporaire pour le filtrage prix min */

            return $data;
        })->values();

        $collection = $collection->filter(function ($data) {
            return $data['tarif'] != null;
        })->values();

        $data->setCollection($collection);

        //dd($data->toArray());
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        return $this->viewCustom('front.excursion.excursion-all-products', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'filter_ile' => $filter_ile
        ]);
    }

    public function product(Request $request)
    {

        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request);
        //
        $data = AdminListing::create(Excursion::class)
            ->modifyQuery(function ($query) use ($request, $my_request) {
                $query->join('iles', 'iles.id', 'excursions.ile_id');
                $query->leftjoin('villes', 'villes.id', 'excursions.ville_id');
                $query->leftJoin('service_port as lieu_depart', 'lieu_depart.id', 'excursions.lieu_depart_id');
                $query->leftJoin('service_port as lieu_arrive', 'lieu_arrive.id', 'excursions.lieu_arrive_id');
                $query->with(['ville', 'taxe', 'depart', 'arrive', 'ile', 'compagnie_liaison', 'tarif' => function ($query) {
                    $query->with(['personne', 'saison']);
                }, 'supplement' => function ($query) {
                    $query->with(['tarif', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }]);
                }, 'compagnie' => function ($query) {
                    $query->with(['ville', 'billeterie']);
                }, 'itineraire', 'depart', 'arrive']);
                $query->where(['excursions.id' => $my_request['id']]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'title', 'lunch', 'ticket', 'availability', 'participant_min', 'card', 'heure_depart', 'heure_arrive', 'description', 'ville_id', 'prestataire_id', 'status', 'duration', 'lieu_depart_id', 'lieu_arrive_id', 'ile_id', 'adresse_depart', 'adresse_arrive', 'fond_image', 'lunch_prestataire_id', 'ticket_billeterie_id'],
                // set columns to searchIn
                ['id', 'title', 'lunch', 'ticket', 'availability', 'participant_min', 'card', 'heure_depart', 'heure_arrive', 'prestataire.name', 'lieu_depart.name', 'lieu_arrive.name', 'iles.name', 'adresse_depart', 'adresse_arrive']
            );
        $collection = $data->getCollection();
        $collection = $collection->map(function ($data) {
            $data = collect($data);
            $saison = [];
            $data->put('supplement', collect($data['supplement'])->groupBy('type_label.value'));
            $data->put('reference_tarif', collect($data['tarif'])->filter(function ($tarif) use ($data, &$saison) {
                $saison[] = collect($tarif)->get('saison');
                $has_adulte = collect($data['tarif'])->filter(function ($personne) {
                    return strtolower($personne['personne']['reference_prix']) == "1";
                })->values();
                if (count($has_adulte)) {
                    return $tarif['type_personne_id'] == $has_adulte[0]['type_personne_id']; // check personne adulte
                } else {
                    return $tarif['prix_vente'] == collect($data['tarif'])->min('prix_vente'); //reference prix
                }
            })->values());
            $data['reference_tarif'] = collect($data['reference_tarif'])->map(function ($data) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $data['saison']['debut'],
                    'fin' => $data['saison']['fin']
                ]);
                $data['saison']['debut'] = $saion_ranger['debut'];
                $data['saison']['fin'] = $saion_ranger['fin'];
                return $data;
            });
            /** moteur sur le fitre saison code marche mais commenté */
            /*$tarif_sans_vol_min_1 = collect($data['reference_tarif'])->filter(function ($data) {
                return now()->greaterThanOrEqualTo($data['saison']['debut']) && now()->lessThanOrEqualTo($data['saison']['fin']);
            })->values();
            // filtre saison 2
            if (count($tarif_sans_vol_min_1) == 0) {
                $tarif_sans_vol_min_2 = collect($data['reference_tarif'])->filter(function ($data) {
                    return now()->greaterThanOrEqualTo($data['saison']['debut']);
                })->values();
                // finalisation filtre saison
                $data['reference_tarif'] = collect($tarif_sans_vol_min_2)->filter(function ($data) use ($tarif_sans_vol_min_2) {
                    return $data['saison']['debut']->getTimestamp() == collect($tarif_sans_vol_min_2)->map(function ($convert_time) {
                        return $convert_time['saison']['debut']->getTimestamp();
                    })->min();
                })->first();
            } else {
                // finalisation filtre saison
                $data['reference_tarif'] = collect($tarif_sans_vol_min_1)->filter(function ($data) use ($tarif_sans_vol_min_1) {
                    return $data['saison']['fin']->getTimestamp() == collect($tarif_sans_vol_min_1)->map(function ($convert_time) {
                        return $convert_time['saison']['fin']->getTimestamp();
                    })->max();
                })->first();
            }*/

            /* code temporaire pour le filtrage prix min */
            $data['reference_tarif'] = collect($data['reference_tarif'])->filter(function ($_data) use ($data) {
                return $_data['prix_vente'] == collect($data['reference_tarif'])->min('prix_vente');
            })->first();
            /* code temporaire pour le filtrage prix min */


            $saison = collect($saison)->map(function ($_saison) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $_saison['debut'],
                    'fin' => $_saison['fin']
                ]);
                $_saison['debut'] = $saion_ranger['debut'];
                $_saison['fin'] = $saion_ranger['fin'];
                return $_saison;
            });
            $data->put('saison', $saison);
            /* has location */
            $data->put('agence_location', AgenceLocation::where(['ville_id' => $data->get('ville_id')])->get());

            /**  */
            $tarif = collect($data['tarif'])->groupBy('saison.id', false);
            $data->put('tarif', collect($tarif)->first());
            return $data;
        })->values();

        $data->setCollection($collection);
        //dd($data->toArray());
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        //dd($data->toArray());
        return $this->viewCustom('front.excursion.excursion-product', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'personne' => Excursion::find($my_request['id'])->personne()->get(),
            'commande_saved' => GestionCommandeUtilisateurController::modifier($request, 'excursion', $my_request['id'], collect($my_request)->get('date_commande')),
            'edit_pannier' => isset($my_request['panier']) && $my_request['panier'] == true,
            'produit_associer' => collect($this->produit_associer([], $my_request['id']))
        ]);
    }

    public function productPrice(Request $request)
    {
        $saison = $request->saison;
        $tarif_saison = collect($saison)->map(function ($data) use ($request) {
            $tarifs = TarifExcursion::select('tarif_excursion.*')
                ->with(['saison'])
                ->join('saisons', 'saisons.id', 'tarif_excursion.saison_id')
                ->where(['excursion_id' => $request->excursion_id])
                ->where(function ($query) use ($request, $data) {
                    $query->where(function ($query)  use ($request, $data) {
                        $query->whereMonth('saisons.debut', '<', parse_date($data)->month)
                            ->orWhere(function ($query) use ($request, $data) {
                                $query->whereMonth('saisons.debut', '=', parse_date($data)->month)
                                    ->whereDay('saisons.debut', '<=', parse_date($data)->day);
                            });
                    })
                        ->orWhere(function ($query) use ($request, $data) {
                            $query->where(function ($query) use ($request, $data) {
                                $query->whereColumn(DB::raw('month(saisons.fin)'), '<', DB::raw('month(saisons.debut)'))
                                    ->whereMonth('saisons.debut', '>', parse_date($data)->month)
                                    ->where(function ($query) use ($request, $data) {
                                        $query->whereMonth('saisons.fin', '>', parse_date($data)->month)
                                            ->orWhere(function ($query) use ($request, $data) {
                                                $query->whereMonth('saisons.fin', '=', parse_date($data)->month)
                                                    ->whereDay('saisons.fin', '>=', parse_date($data)->day);
                                            });
                                    });
                            })
                                ->orWhere(function ($query) use ($request, $data) {
                                    $query->whereColumn(DB::raw('month(saisons.fin)'), '=', DB::raw('month(saisons.debut)'))
                                        ->whereColumn(DB::raw('day(saisons.fin)'), '<', DB::raw('day(saisons.debut)'))
                                        ->whereDay('saisons.debut', '>', parse_date($data)->day)
                                        ->whereDay('saisons.fin', '>', parse_date($data)->day);
                                });
                        });
                })
                ->get();
            /** */
            $tarifs = collect($tarifs)->groupBy('saison.id')->values();
            $tarifs = collect($tarifs)->map(function ($data) {
                $data = collect($data)->map(function ($saison) {
                    $saion_ranger = self::rangerSaison([
                        'debut' => $saison->debut,
                        'fin' => $saison->fin
                    ]);
                    $saison->debut = $saion_ranger['debut'];
                    $saison->fin = $saion_ranger['fin'];
                    return $saison;
                });
                return $data;
            });
            $tarifs = collect($tarifs)->filter(function ($data) use ($tarifs) {
                return parse_date(collect($data)->first()->saison->fin)->getTimestamp() == collect($tarifs)->map(function ($data) {
                    return parse_date(collect($data)->first()->saison->fin)->getTimestamp();
                })->max();
            });
            /** */
            return collect($tarifs)->first();
        });
        /** */
        return [
            'tarif' => $tarif_saison
        ];
    }

    private function produit_associer($my_request = [], $exculde_id = 0)
    {
        $excursion_filter_id = [];
        if (isset($my_request['customer_search'])) {

            $customer_search = json_decode($my_request['customer_search']);
            $ile_id = explode(',', $customer_search->ile);
            $columns_search = [
                'iles.name',
                'villes.name',
                'lieu_depart.name',
                'lieu_arrive.name',
                'excursions.title',
                'excursions.heure_depart',
                'excursions.description',
                'excursions.adresse_depart',
                'excursions.adresse_arrive',
            ];

            /* affectation valeur filter */
            $mot_cle = isset($customer_search->mot_cle) ? $customer_search->mot_cle : '';
            $price = explode(',', $customer_search->price);

            /* indication ile filter */
            if (count($ile_id) > 1) {
                $filter_ile = trans('admin-base.filter.all_ile');
            } else {
                $filter_ile = Ile::find($ile_id[0])->name;
            }

            /* globale filter dans la base de données */
            $excursion_filter = Excursion::select('excursions.id')
                ->join('iles', 'iles.id', 'excursions.ile_id')
                ->leftjoin('villes', 'villes.id', 'excursions.ville_id')
                ->leftJoin('service_port as lieu_depart', 'lieu_depart.id', 'excursions.lieu_depart_id')
                ->leftJoin('service_port as lieu_arrive', 'lieu_arrive.id', 'excursions.lieu_arrive_id')
                ->join('tarif_excursion', 'tarif_excursion.excursion_id', 'excursions.id')
                ->join('saisons', 'saisons.id', 'tarif_excursion.saison_id')
                ->whereIn('iles.id', $ile_id)
                ->where(function ($query) use ($columns_search, $mot_cle) {
                    array_map(function ($array) use (&$query, $mot_cle) {
                        $query = $query->orWhere(DB::raw('lower(' . $array . ')'), 'like', '%' . strtolower($mot_cle) . '%');
                    }, $columns_search);
                })
                ->whereBetween('tarif_excursion.prix_vente', $price);

            if ($customer_search->duration != '*') {
                $excursion_filter = $excursion_filter->where(['excursions.duration' => $customer_search->duration]);
            }

            $excursion_filter = $excursion_filter->get();

            /* liste hebergement_id trouvée par la filtre */
            $excursion_filter_id = $excursion_filter->map(function ($data_collection) {
                return $data_collection->id;
            })->values();

            /* search interactif get */
        }

        $all_excursion = Excursion::select('excursions.*')
            ->join('iles', 'iles.id', 'excursions.ile_id')
            ->leftjoin('villes', 'villes.id', 'excursions.ville_id')
            ->leftJoin('service_port as lieu_depart', 'lieu_depart.id', 'excursions.lieu_depart_id')
            ->leftJoin('service_port as lieu_arrive', 'lieu_arrive.id', 'excursions.lieu_arrive_id')
            ->with(['ville', 'taxe', 'depart', 'arrive', 'ile', 'compagnie_liaison', 'tarif' => function ($query) {
                $query->with(['personne', 'saison']);
            }, 'supplement' => function ($query) {
                $query->with(['tarif']);
            }, 'compagnie' => function ($query) {
                $query->with(['ville', 'billeterie']);
            }])
            ->where(function ($query) use ($excursion_filter_id, $exculde_id) {
                if (count($excursion_filter_id) > 0) {
                    $query->whereIn('excursions.id', $excursion_filter_id);
                }
                $query->whereNotIn('excursions.id', [$exculde_id]);
            })
            ->limit(10, 'desc')
            ->get();

        $all_excursion = json_decode(json_encode($all_excursion));
        $all_excursion = collect($all_excursion)->map(function ($data) {
            $data->supplement = collect($data->supplement)->groupBy('type_label.value');
            $data->tarif = collect($data->tarif)->filter(function ($tarif) use ($data) {
                $has_adulte = collect($data->tarif)->filter(function ($personne) {
                    return strtolower($personne->personne->reference_prix) == "1";
                })->values();
                if (count($has_adulte)) {
                    return $tarif->type_personne_id == $has_adulte[0]->type_personne_id; // check personne adulte
                } else {
                    return $tarif->prix_vente == collect($data->tarif)->min('prix_vente'); //reference prix
                }
            })->values();

            $data->tarif = collect($data->tarif)->map(function ($data) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $data->saison->debut,
                    'fin' => $data->saison->fin
                ]);
                $data->saison->debut = $saion_ranger['debut'];
                $data->saison->fin = $saion_ranger['fin'];
                return $data;
            });

            /* code temporaire pour le filtrage prix min */
            $data->tarif = collect($data->tarif)->filter(function ($_data) use ($data) {
                return $_data->prix_vente == collect($data->tarif)->min('prix_vente');
            })->first();
            /* code temporaire pour le filtrage prix min */
            return $data;
        })->values();

        $all_excursion = collect($all_excursion)->filter(function ($data) {
            return $data->tarif != null;
        })->values();
        //dd($all_excursion);
        return ['data' => $all_excursion];
    }
}
