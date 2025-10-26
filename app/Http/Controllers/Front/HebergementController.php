<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ChambreEnCommande;
use Illuminate\Http\Request;
use App\Models\Hebergement\Hebergement;
use App\Models\Hebergement\SupplementVue;
use App\Models\Hebergement\Tarif;
use App\Models\Prestataire;
use App\Models\Ville;
use App\Models\Ile;
use App\Models\Hebergement\TypeChambre;
use App\Models\LigneCommandeChambre;
use App\Models\Saison;
use App\Models\TypePersonne;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HebergementController extends Controller
{

    public function index(Request $request)
    {


        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);
        //
        $data = AdminListing::create(Ile::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['hebergement' => function ($query) {
                    $query->with(['tarif' => function ($query) {
                        $query->with(['saison']);
                    }]);
                }]);
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
            if (count(collect($data->hebergement)->toArray()) > 0) {
                $is_saison = false;
                collect($data->hebergement)->map(function ($data) {
                    collect($data->tarif)->map(function ($data) {
                        $d = new Carbon($data->saison->fin);
                        $d->year(now()->format('Y'));
                        if ($d->isAfter(Carbon::today())) {
                            $is_saison = true;
                        }
                    });
                });
                return true;
            }
            return false;
        })->values();
        $data->setCollection($collection);
        return $this->viewCustom('front.hebergement.hebergements', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null)
        ]);
    }

    public function allhosts(Request $request)
    {
        /* données filtre afficher au front */
        $hebergement_filter_id = null;
        $filter_ile = null;

        /* requet ajax specifier filtre avec mot-clé */
        if ($request->has('customer_search') && $request->ajax()) {
            $customer_search = json_decode($request->customer_search);
            $ile_id = explode(',', $customer_search->ile);
            $columns_search = [
                'iles.name',
                'villes.name',
                'type_chambre.name',
                'hebergements.name',
                'type_hebergement.name',
                'tarifs.titre'
            ];

            /* affectation valeur filter */
            $mot_cle = isset($customer_search->mot_cle) ? $customer_search->mot_cle : '';
            $price = explode(',', $customer_search->price);
            $search_vol = isset($customer_search->transport) ? $customer_search->transport : '2';

            /* indication ile filter */
            if (count($ile_id) > 1) {
                $filter_ile = trans('admin-base.filter.all_ile');
            } else {
                $filter_ile = Ile::find($ile_id[0])->name;
            }

            /* globale filter dans la base de données */
            $hebergement_filter = Hebergement::select('hebergements.*')
                ->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id')
                ->join('iles', 'iles.id', 'hebergements.ile_id')
                ->join('villes', 'villes.id', 'hebergements.ville_id')
                ->join('tarifs', 'tarifs.hebergement_id', 'hebergements.id')
                ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                ->leftJoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                ->join('tarif_type_personne_hebergement', 'tarif_type_personne_hebergement.tarif_id', 'tarifs.id')
                ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                ->whereIn('iles.id', $ile_id)
                ->where(function ($query) use ($columns_search, $mot_cle) {
                    array_map(function ($array) use (&$query, $mot_cle) {
                        $query = $query->orWhere(DB::raw('lower(' . $array . ')'), 'like', '%' . strtolower($mot_cle) . '%');
                    }, $columns_search);
                })
                ->whereBetween('tarif_type_personne_hebergement.prix_vente', $price);
            switch ($search_vol) {
                case '0':
                    $hebergement_filter = $hebergement_filter->where(function ($query) {
                        $query->where(function ($query) {
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
                        });
                    });
                    $hebergement_filter = $hebergement_filter->whereNull('hebergement_vol.tarif_id');
                    break;
                case '1':
                    $hebergement_filter = $hebergement_filter->whereNotNull('hebergement_vol.tarif_id');
                    $hebergement_filter = $hebergement_filter->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                    break;
                default:
                    $hebergement_filter = $hebergement_filter->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where(function ($query) {
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
                            })
                                ->whereNull('hebergement_vol.tarif_id');
                        })
                            ->orWhere(function ($query) {
                                $query->whereNotNull('hebergement_vol.tarif_id')
                                    ->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                            });
                    });
                    break;
            }

            $hebergement_filter = $hebergement_filter->get();

            /* liste hebergement_id trouvée par la filtre */
            $hebergement_filter_id = $hebergement_filter->map(function ($data_collection) {
                return $data_collection->id;
            })->values();


            /* recherche direct par la méthode get http */
        } else {

            /* implementation de filtre dans le requet my_request */
            $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);

            if ($my_request != null) {
                /* iles */
                $iles_id = explode(',', $my_request['ile']);
                $filter_ile = count($iles_id) == 1 ? Ile::find($iles_id[0])->name : 'Tout';
                $hebergement_filter = Hebergement::select('hebergements.*')
                    ->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id')
                    ->join('iles', 'iles.id', 'hebergements.ile_id')
                    ->join('villes', 'villes.id', 'hebergements.ville_id')
                    ->join('tarifs', 'tarifs.hebergement_id', 'hebergements.id')
                    ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                    ->leftJoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                    ->join('tarif_type_personne_hebergement', 'tarif_type_personne_hebergement.tarif_id', 'tarifs.id')
                    ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                    ->whereIn('ile_id', $iles_id)
                    ->where(function ($query) use ($my_request) {
                        $query->where(function ($query) use ($my_request) {
                            $query->where(function ($query) use ($my_request) {
                                /* saison debut */
                                if (isset($my_request['date_debut'])) {
                                    $date = Carbon::createFromFormat('Y-m-d', $my_request['date_debut']);
                                    $query->where(function ($query) use ($date) {
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
                                    $query->where(function ($query) use ($date) {
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
                            })
                                ->whereNull('hebergement_vol.tarif_id');
                        })
                            ->orWhere(function ($query) {
                                $query->whereNotNull('hebergement_vol.tarif_id')
                                    ->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                            });
                    });


                /* villes */
                if (isset($my_request['ville'])) {
                    $hebergement_filter = $hebergement_filter->whereIn('ville_id', explode(',', $my_request['ville']));
                }



                $hebergement_filter = $hebergement_filter->get();
                $hebergement_filter_id = $hebergement_filter->map(function ($data_collection) {
                    return $data_collection->id;
                })->values();
            } else {
                $hebergement_filter = Hebergement::first();
                if ($hebergement_filter) {
                    $hebergement_filter_id = [$hebergement_filter->id];
                }
                $filter_ile = Ile::find($hebergement_filter->ile_id)->name;
            }
        }

        if (count($hebergement_filter_id) == 0) {
            $hebergement_filter_id = [0];
        }
        /* search */
        $data = AdminListing::create(Hebergement::class)
            ->modifyQuery(function ($query) use ($request, $hebergement_filter_id) {
                $query->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id');
                $query->join('prestataire', 'prestataire.id', 'hebergements.prestataire_id');
                $query->join('iles', 'iles.id', 'hebergements.ile_id');
                $query->with(['type', 'ville', 'ile', 'tarif' => function ($query) {
                    $query->with(['tarif' => function ($query) {
                        //$query->orderBy('prix_vente', 'desc');
                        $query->with(['personne']);
                    }, 'type_chambre', 'base_type']);
                }, 'supplement_activite', 'supplement_vue', 'supplement_pension']);

                $query->whereIn('hebergements.id', $hebergement_filter_id);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name', 'duration_min', 'status', 'image', 'heure_ouverture', 'heure_fermeture', 'adresse', 'description', 'type_hebergement_id', 'ville_id', 'prestataire_id', 'caution', 'ile_id', 'fond_image', 'etoil'],
                // set columns to searchIn
                []
            );

        //dd($data->toArray());
        $collection = $data->getCollection();
        $collection = json_decode(json_encode($collection));

        $collection = collect($collection)->map(function ($data) { //filtrage si chambre / filtrage tarif min 

            $data->tarif = collect($data->tarif)->filter(function ($tarif) use ($data) { //filtrage si chambre

                $tarif->tarif = collect($tarif->tarif)->filter(function ($all_tarif) use ($tarif) { //tarif de type personne
                    $has_adulte = collect($tarif->tarif)->filter(function ($personne) {
                        return $personne->personne->reference_prix == "1";
                    })->values();
                    if (count($has_adulte)) {
                        return $all_tarif->type_personne_id == $has_adulte[0]->type_personne_id; // check personne adulte
                    } else {
                        return $all_tarif->prix_vente == collect($tarif->tarif)->min('prix_vente'); //reference prix
                    }
                })->values();

                if (count($tarif->tarif)) {
                    $reference_tarif = collect($tarif->tarif)->filter(function ($data) use ($tarif) {
                        return $data->prix_vente == collect($tarif->tarif)->min('prix_vente');
                    });
                    $tarif->tarif = collect($reference_tarif)->first();
                    return true;
                }
                return false;
            })->values();

            $data->tarif = collect($data->tarif)->filter(function ($tarif) use ($data) { // filtrage tarif min
                return $tarif->tarif->prix_vente == collect($data->tarif)->map(function ($tarif_map) {
                    return $tarif_map->tarif->prix_vente;
                })->min();
            })->values();


            if (count($data->tarif) > 1) {
                $data->tarif = $data->tarif->take(1);
            }

            if (count($data->tarif)) {
                $data->tarif = $data->tarif->first(); //convertir tarif en objet
            } else {
                $data->tarif = null; //convertir tarif en objet
            }
            return $data;
        })->values();

        $collection = collect($collection)->filter(function ($data) {  // filtrage si tarif

            $data->tarif->type_chambre->formule = collect(config('formule-heb'))->filter(function ($formule) use ($data) {
                return $data->tarif->type_chambre->formule == $formule['id'];
            })->first();

            if ($data->tarif != null) {
                return true;
            } else {
                return false;
            }
        })->values();

        $data->setCollection(collect($collection));

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        //dd($data->toArray());
        return $this->viewCustom('front.hebergement.hebergement-all-hosts', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'filter_ile' => $filter_ile
        ]);
    }

    public function host(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request);

        /* search */
        $hebergement_filter_id = null;

        if ($request->has('customer_search') || isset($my_request['customer_search'])) {

            $customer_search = $request->has('customer_search') ? json_decode($request->customer_search) : (object) $my_request['customer_search'];
            $ile_id = explode(',', $customer_search->ile);
            $columns_search = [
                'iles.name',
                'villes.name',
                'type_chambre.name',
                'hebergements.name',
                'type_hebergement.name',
                'tarifs.titre'
            ];
            $mot_cle = isset($customer_search->mot_cle) ? $customer_search->mot_cle : '';
            $price = explode(',', $customer_search->price);
            $search_vol = isset($customer_search->transport) ? $customer_search->transport : '2';
            $tarif_filter = Hebergement::select('tarifs.id')
                ->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id')
                ->join('iles', 'iles.id', 'hebergements.ile_id')
                ->join('villes', 'villes.id', 'hebergements.ville_id')
                ->join('tarifs', 'tarifs.hebergement_id', 'hebergements.id')
                ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                ->join('tarif_type_personne_hebergement', 'tarif_type_personne_hebergement.tarif_id', 'tarifs.id')
                ->leftJoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                ->where(['hebergements.id' => $my_request['id']])
                ->whereIn('iles.id', $ile_id)
                ->where(function ($query) use ($columns_search, $mot_cle) {
                    array_map(function ($array) use (&$query, $mot_cle) {
                        $query = $query->orWhere(DB::raw('lower(' . $array . ')'), 'like', '%' . strtolower($mot_cle) . '%');
                    }, $columns_search);
                })
                ->whereBetween('tarif_type_personne_hebergement.prix_vente', $price);
            switch ($search_vol) {
                case '0':
                    $tarif_filter =  $tarif_filter->whereNull('hebergement_vol.tarif_id');
                    $tarif_filter = $tarif_filter->where(function ($query) {
                        $query->whereMonth('saisons.fin', '>', Carbon::today()->month())
                            ->orWhere(function ($query) {
                                $query->whereMonth('saisons.fin', '=', Carbon::today()->month)
                                    ->whereDay('saisons.fin', '>', Carbon::today()->format('d'));
                            });
                    });
                    break;

                case '1':
                    $tarif_filter =  $tarif_filter->whereNotNull('hebergement_vol.tarif_id');
                    $tarif_filter = $tarif_filter->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                    break;
                default:
                    $tarif_filter =  $tarif_filter->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where(function ($query) {
                                $query->whereMonth('saisons.fin', '>', Carbon::today()->month)
                                    ->orWhere(function ($query) {
                                        $query->whereMonth('saisons.fin', '=', Carbon::today()->month)
                                            ->whereDay('saisons.fin', '>', Carbon::today()->format('d'));
                                    });
                            })
                                ->whereNull('hebergement_vol.tarif_id');
                        })
                            ->orWhere(function ($query) {
                                $query->whereNotNull('hebergement_vol.tarif_id')
                                    ->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                            });
                    });
                    break;
            }
            $tarif_filter =  $tarif_filter->get();
            $tarif_filter_id = $tarif_filter->map(function ($data_collection) {
                return $data_collection->id;
            })->values();
        } else {
            $tarif_filter = Tarif::select('tarifs.*')
                ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                ->leftJoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                ->where(['tarifs.hebergement_id' => $my_request['id']])
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereMonth('saisons.fin', '>', Carbon::today()->month)
                                ->orWhere(function ($query) {
                                    $query->whereMonth('saisons.fin', '=', Carbon::today()->month)
                                        ->whereDay('saisons.fin', '>', Carbon::today()->format('d'));
                                });
                        })
                            ->whereNull('hebergement_vol.tarif_id');
                    })
                        ->orWhere(function ($query) {
                            $query->whereNotNull('hebergement_vol.tarif_id')
                                ->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                        });
                })
                ->get();

            $tarif_filter_id = $tarif_filter->map(function ($data_collection) {
                return $data_collection->id;
            })->values();
        }

        if (count($tarif_filter_id) == 0) {
            $tarif_filter_id = [0];
        }
        /* search */
        $data = AdminListing::create(Hebergement::class)
            ->modifyQuery(function ($query) use ($request, $my_request, $tarif_filter_id) {
                $query->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id');
                $query->join('prestataire', 'prestataire.id', 'hebergements.prestataire_id');
                $query->with(['type', 'ville', 'ile', 'chambre' => function ($query) use ($tarif_filter_id) {
                    $query->with([
                        'tarif' => function ($query) use ($tarif_filter_id) {
                            $query->whereIn('id', $tarif_filter_id);
                            $query->with([
                                'saison',
                                'tarif' => function ($query) {
                                    $query->with(['personne']);
                                }, 'vol',
                                'type_chambre', 'base_type'
                            ]);
                        }
                    ]);
                }, 'supplement_activite', 'supplement_vue', 'supplement_pension']);
                $query->where(['hebergements.id' => $my_request['id']]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name', 'duration_min', 'status', 'image', 'heure_ouverture', 'heure_fermeture', 'adresse', 'description', 'type_hebergement_id', 'ville_id', 'prestataire_id', 'caution', 'ile_id', 'etoil', 'fond_image'],
                // set columns to searchIn
                ['id', 'name', 'description', 'duration_min', 'type_hebergement.name', 'prestataire.name', 'iles.name']
            );

        $collection = $data->getCollection();
        $collection = json_decode(json_encode($collection));
        //dd($collection);
        $collection = collect($collection)->map(function ($data) {
            $data->chambre = collect($data->chambre)->map(function ($data_chambre) {
                $tarif_sans_vol = collect($data_chambre->tarif)->filter(function ($data) {
                    return $data->vol == null;
                })->values();

                /** filtre base double sans vol */
                $tarif_sans_vol_base_double = collect($tarif_sans_vol)->filter(function ($data) {
                    return $data->base_type->reference_prix == 1;
                })->values();
                $tarif_sans_vol = count($tarif_sans_vol_base_double) > 0 ? json_decode(json_encode($tarif_sans_vol_base_double)) : json_decode(json_encode($tarif_sans_vol));
                /** */

                $tarif_avec_vol = collect($data_chambre->tarif)->filter(function ($data) {
                    /* check chambre disponible */
                    $chambre_commander = LigneCommandeChambre::where(['chambre_id' => $data->type_chambre->id])->sum('quantite_chambre');
                    return $data->vol != null && (intval($data->type_chambre->nombre_chambre) - (intval($chambre_commander)) > 0);
                })->values();

                /** filtre base double avec vol */
                $tarif_avec_vol_base_double = collect($tarif_avec_vol)->filter(function ($data) {
                    return $data->base_type->reference_prix == 1;
                })->values();
                $tarif_avec_vol = count($tarif_avec_vol_base_double) > 0 ? json_decode(json_encode($tarif_avec_vol_base_double)) : json_decode(json_encode($tarif_avec_vol));
                /** */

                $tarif_avec_vol = collect($tarif_avec_vol)->map(function ($data) {
                    /* check chambre disponible */
                    $chambre_commander = LigneCommandeChambre::where(['chambre_id' => $data->type_chambre->id])->sum('quantite_chambre');
                    $chambre_commande_other = ChambreEnCommande::where([
                        'chambre_id' => $data->type_chambre->id
                    ])->sum('nombre');
                    $data->quantite_stock = intval($data->type_chambre->nombre_chambre) - (intval($chambre_commander) + intval($chambre_commande_other));
                    $adulte = collect($data->tarif)->filter(function ($personne) {
                        return $personne->personne->reference_prix == 1;
                    });
                    if (count($adulte) == 0) {
                        $min = collect($data->tarif)->filter(function ($_data_interne) use ($data) {
                            return $_data_interne->prix_vente == collect($data)->min('prix_vente');
                        })->first();
                        $data->tarif = $min;
                        return $data;
                    } else {
                        $data->tarif = collect($adulte)->first();
                        return $data;
                    }
                    return $data;
                })->values();

                /* min sans vol */
                $tarif_sans_vol_min = collect($tarif_sans_vol)->map(function ($data) {
                    $adulte = collect($data->tarif)->filter(function ($personne) {
                        return $personne->personne->reference_prix == 1;
                    });
                    if (count($adulte) == 0) {
                        $min = collect($data->tarif)->filter(function ($_data_interne) use ($data) {
                            return $_data_interne->prix_vente == collect($data)->min('prix_vente');
                        })->first();
                        $data->tarif = $min;
                        return $data;
                    } else {
                        $data->tarif = collect($adulte)->first();
                        return $data;
                    }
                });
                /** filtre saison 1 */
                $tarif_sans_vol_min_1 = collect($tarif_sans_vol_min)->filter(function ($data) use ($tarif_sans_vol_min) {
                    $saion_ranger = self::rangerSaison([
                        'debut' => $data->saison->debut,
                        'fin' => $data->saison->fin
                    ]);
                    $data->saison->debut = $saion_ranger['debut'];
                    $data->saison->fin = $saion_ranger['fin'];
                    return now()->greaterThanOrEqualTo($data->saison->debut) && now()->lessThanOrEqualTo($data->saison->fin);
                    //return $data->tarif->prix_vente == collect($tarif_sans_vol_min)->min('tarif.prix_vente');
                })->values();
                /** filtre saison 2 */
                if (count($tarif_sans_vol_min_1) == 0) {
                    $tarif_sans_vol_min_2 = collect($tarif_sans_vol_min)->filter(function ($data) use ($tarif_sans_vol_min) {
                        $saion_ranger = self::rangerSaison([
                            'debut' => $data->saison->debut,
                            'fin' => $data->saison->fin
                        ]);
                        $data->saison->debut = $saion_ranger['debut'];
                        $data->saison->fin = $saion_ranger['fin'];
                        return now()->greaterThanOrEqualTo($data->saison->debut);
                    })->values();
                    /** finalisation filtre saison */
                    $tarif_sans_vol_min = collect($tarif_sans_vol_min_2)->filter(function ($data) use ($tarif_sans_vol_min_2) {
                        return $data->saison->debut->getTimestamp() == collect($tarif_sans_vol_min_2)->map(function ($convert_time) {
                            return $convert_time->saison->debut->getTimestamp();
                        })->min();
                    })->first();
                } else {
                    /** finalisation filtre saison */
                    $tarif_sans_vol_min = collect($tarif_sans_vol_min_1)->filter(function ($data) use ($tarif_sans_vol_min_1) {
                        return $data->saison->fin->getTimestamp() == collect($tarif_sans_vol_min_1)->map(function ($convert_time) {
                            return $convert_time->saison->fin->getTimestamp();
                        })->max();
                    })->first();
                }

                /** */
                $tarif_min = $tarif_avec_vol;

                if ($tarif_sans_vol_min != null) {
                    $tarif_min[] = collect($tarif_sans_vol)->filter(function ($data) use ($tarif_sans_vol_min) {
                        return $tarif_sans_vol_min->id == $data->id;
                    })->first();
                }
                $data_chambre->tarif = $tarif_min;
                return $data_chambre;
            });
            return $data;
        });

        $collection = collect($collection)->map(function ($data) {
            $tarif = [];
            collect($data->chambre)->map(function ($data_chambre) use (&$tarif) {
                collect($data_chambre->tarif)->map(function ($data_tarif) use (&$tarif) {
                    $data_tarif->type_chambre->formule = collect(config('formule-heb'))->filter(function ($formule) use ($data_tarif) {
                        return $data_tarif->type_chambre->formule == $formule['id'];
                    })->first();
                    $tarif[] = $data_tarif;
                });
            });
            /****    *****/
            unset($data->chambre);
            $data->tarif = $tarif;
            $data->tarif = collect($data->tarif)->filter(function ($data_tarif) {
                return $data_tarif->tarif != null;
            });
            return $data;
        });

        $data->setCollection(collect(json_decode(json_encode($collection), true)));
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        //dd($data->toArray());
        return $this->viewCustom('front.hebergement.hebergement-host', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null)
        ]);
    }

    public function productavecvol(Request $request)
    {

        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request);
        //
        $data = AdminListing::create(Tarif::class)
            ->modifyQuery(
                function ($query) use ($request, $my_request) {
                    $query->join('saisons', 'saisons.id', 'tarifs.saison_id');
                    $query->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id');
                    $query->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id');
                    $query->leftjoin('allotements', 'allotements.id', 'hebergement_vol.allotement_id');
                    $query->leftjoin('compagnie_transport', 'compagnie_transport.id', 'allotements.compagnie_transport_id')->limit(1);
                    $query->with([
                        'type_chambre',
                        'saison',
                        'vol' => function ($query) {
                            $query->with(['allotement' => function ($query) {
                                $query->with(['compagnie' => function ($query) {
                                    $query->with(['ville']);
                                }, 'depart', 'arrive']);
                            }]);
                        },
                        'hebergement' => function ($query) {
                            $query->with([
                                'type',
                                'ile',
                                'supplement_activite' => function ($query) {
                                    $query->with(['tarif', 'prestataire' => function ($query) {
                                        $query->with(['ville']);
                                    }]);
                                },
                                /*
                                'supplement_vue' => function ($query) {
                                    $query->with(['tarif']);
                                },
                                */
                                'supplement_pension' => function ($query) {
                                    $query->with(['tarif', 'prestataire' => function ($query) {
                                        $query->with(['ville']);
                                    }]);
                                }
                            ]);
                        },
                        'tarif' => function ($query) {
                            $query->with(['personne']);
                        },
                        'base_type'
                    ])
                        ->whereNotNull('hebergement_vol.id')
                        ->where(['tarifs.id' => $my_request['id']]);
                }
            )
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                [
                    'id',
                    'titre',
                    'type_chambre_id',
                    'saison_id',
                    'base_type_id',
                    'description',
                    'taxe_active',
                    'taxe',
                    'jour_min',
                    'jour_max',
                    'nuit_min',
                    'nuit_max',
                    'hebergement_id'
                ],
                // set columns to searchIn
                [
                    'id',
                    'saisons.titre',
                    'allotements.titre',
                    'compagnie_transport.nom',
                    'hebergement_vol.lien_depart',
                    'hebergement_vol.lien_arrive',
                    'hebergement_vol.depart',
                    'hebergement_vol.arrive',
                    'type_chambre.name',
                    'jour_min',
                    'jour_max',
                    'nuit_min',
                    'nuit_max',
                    'hebergement_id'
                ]
            );
        $collection = $data->getCollection();
        $collection = collect($collection)->map(function ($data) use ($my_request, $request) { //filtrage si chambre / filtrage si tarif
            /** supplement vue */
            $data->hebergement->supplement_vue = $data->type_chambre->supplement_vue()
                ->with(['tarif'])
                ->get()
                ->toArray();
            /** */
            $data->reference_tarif = collect($data->tarif)->filter(function ($tarif) use ($data) {

                $has_adulte = collect($data->tarif)->filter(function ($personne) {
                    return $personne->personne->reference_prix == "1";
                })->values();
                if (count($has_adulte)) {
                    return $tarif->type_personne_id == $has_adulte[0]->type_personne_id; // check personne adulte
                } else {
                    return $tarif->prix_vente == collect($data->tarif)->min('prix_vente'); //reference prix
                }
            })->first();
            /*** */
            $_calendars = [];
            $_chambre_dispo = intval($data->type_chambre->nombre_chambre);

            $saion = [
                'debut' => $data->saison->debut,
                'fin' => $data->saison->fin
            ];
            $saion_ranger = self::rangerSaison($saion);
            $data->saison->debut = $saion_ranger['debut'];
            $data->saison->fin = $saion_ranger['fin'];

            for ($i = 0; $i < parse_date($data->saison->fin, true)->diffInDays(parse_date($data->saison->debut, true)) + 1; $i++) {
                $has_date = parse_date($data->saison->debut, true)->addDays($i);
                /* check chambre disponible for saison */
                /** */
                $calendar_commander_ligne = LigneCommandeChambre::where(['chambre_id' => $data->type_chambre->id])
                    ->whereDate('date_debut', '<=', $has_date)
                    ->whereDate('date_fin', '>=', $has_date)
                    ->sum('quantite_chambre');
                $calendar_commander_panier = ChambreEnCommande::where([
                    'chambre_id' => $data->type_chambre->id
                ])->where(function ($query) use ($my_request, $request) {
                    if (isset($my_request['panier']) && $my_request['panier'] == 'true') {
                        $query->whereNotIn('session_id', [$request->session()->getId()])
                            ->whereNotIn('commande_id', [$my_request['index_produit']]);
                    }
                })
                    ->whereDate('date_debut', '<=', $has_date)
                    ->whereDate('date_fin', '>=', $has_date)
                    ->sum('nombre');
                $calendar_commander_dispo = intval($data->type_chambre->nombre_chambre) - (intval($calendar_commander_ligne) + intval($calendar_commander_panier));
                /** */
                if (intval($calendar_commander_ligne) > 0) {
                    $_calendars[] = $calendar_commander_ligne;
                }
                if (intval($calendar_commander_panier) > 0) {
                    $_calendars[] = $calendar_commander_panier;
                }
                if (intval($calendar_commander_dispo) > 0) {
                    $_calendars[] = $calendar_commander_dispo;
                }
                if ($calendar_commander_dispo < $_chambre_dispo) {
                    $_chambre_dispo = $calendar_commander_dispo;
                }
            }
            $data->chambre_dispo = $_chambre_dispo;

            /** */
            $data->type_chambre->formule = collect(config('formule-heb'))->filter(function ($formule) use ($data) {
                return $data->type_chambre->formule == $formule['id'];
            })->first();

            /** */
            $tarif_saison_base = json_decode(json_encode(
                Tarif::select('tarifs.*', 'base_type.nombre as nombre_base')
                    ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                    ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                    ->leftjoin('base_type', 'base_type.id', 'tarifs.base_type_id')
                    ->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                    ->leftJoin('allotements','allotements.id','hebergement_vol.allotement_id')
                    ->with(['saison', 'tarif' => function ($query) {
                        $query->with(['personne']);
                    }])
                    ->whereNotNull('hebergement_vol.id')
                    ->where([
                        'allotements.id' => $data->vol->allotement->id,
                        'saisons.id' => $data->saison->id,
                        'tarifs.type_chambre_id' => $data->type_chambre->id,
                    ])
                    ->get()
            ));

            $tarif_saison_base = collect($tarif_saison_base)->map(function ($data) {
                $data->reference_tarif = collect($data->tarif)->filter(function ($tarif) use ($data) {
                    $has_adulte = collect($data->tarif)->filter(function ($personne) {
                        return $personne->personne->reference_prix == "1";
                    })->values();
                    if (count($has_adulte)) {
                        return $tarif->type_personne_id == $has_adulte[0]->type_personne_id; // check personne adulte
                    } else {
                        return $tarif->prix_vente == collect($data->tarif)->min('prix_vente'); //reference prix
                    }
                })->values();
                return $data;
            });
            $tarif_saison_base = collect($tarif_saison_base)->groupBy('base_type_id')->values();
            $data->tarif_base = collect($tarif_saison_base)->map(function ($_data) {
                $_temp = [
                    'saison' => collect($_data)->first(),
                    'nombre_base' => count($_data) > 0 ? $_data[0]->nombre_base : 0, //nombre_base
                ];
                return $_temp;
            });
            /** */
            return $data;
        })->values();

        $data->setCollection($collection);
        //dd(json_decode(json_encode($data)));
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        $tarif = Tarif::with(['hebergement'])->find($my_request['id']);
        //dd($data->toArray());
        return $this->viewCustom('front.hebergement.hebergement-product-avec-vol', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'personne' => $tarif->hebergement->personne()->get(),
            'typeChambre' => TypeChambre::find($my_request['id']),
            'commande_saved' => GestionCommandeUtilisateurController::modifier($request, 'hebergement', $my_request['id'], collect($my_request)->get('date_commande')),
            'edit_pannier' => isset($my_request['panier']) && $my_request['panier'] == true,
            'produit_associer' => collect($this->produit_associer([], $my_request['id']))
        ]);
    }


    public function productPrice(Request $request)
    {
        $interval_saison = [];
        $chambre = TypeChambre::find($request->chambre_id);
        $_calendars = [];
        $_chambre_dispo = intval($chambre->nombre_chambre);
        for ($i = 0; $i < parse_date($request->fin_saison, true)->diffInDays(parse_date($request->debut_saison, true)) + 1; $i++) {
            $has_date = parse_date($request->debut_saison, true)->addDays($i);
            /* check chambre disponible for saison */
            /** */
            $calendar_commander_ligne = [
                'color' => 'red',
                'date' => $has_date,
                'desc' => 'Occupée',
                'nb' => LigneCommandeChambre::where(['chambre_id' => $request->chambre_id])
                    ->whereDate('date_debut', '<=', $has_date)
                    ->whereDate('date_fin', '>=', $has_date)
                    ->sum('quantite_chambre')
            ];
            $calendar_commander_panier = [
                'color' => 'blue',
                'date' => $has_date,
                'desc' => 'En commande',
                'nb' => ChambreEnCommande::where([
                    'chambre_id' => $request->chambre_id
                ])->where(function ($query) use ($request) {
                    if ($request->edit == 'true') {
                        $query->whereNotIn('session_id', [$request->session()->getId()])
                            ->whereNotIn('commande_id', [$request->index_commande]);
                    }
                })
                    ->whereDate('date_debut', '<=', $has_date)
                    ->whereDate('date_fin', '>=', $has_date)
                    ->sum('nombre')
            ];
            $calendar_commander_dispo = [
                'color' => 'green',
                'date' => $has_date,
                'desc' => 'Disponible',
                'nb' => intval($chambre->nombre_chambre) - (intval($calendar_commander_ligne['nb']) + intval($calendar_commander_panier['nb']))
            ];
            /** */
            if (intval($calendar_commander_ligne['nb']) > 0) {
                $_calendars[] = $calendar_commander_ligne;
            }
            if (intval($calendar_commander_panier['nb']) > 0) {
                $_calendars[] = $calendar_commander_panier;
            }
            if (intval($calendar_commander_dispo['nb']) > 0) {
                $_calendars[] = $calendar_commander_dispo;
            }
            if ($calendar_commander_dispo['nb'] < $_chambre_dispo) {
                $_chambre_dispo = $calendar_commander_dispo['nb'];
            }
        }

        $debut_saison = Tarif::select('tarifs.*', 'base_type.nombre as nombre_base')
            ->join('saisons', 'saisons.id', 'tarifs.saison_id')
            ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
            ->leftjoin('base_type', 'base_type.id', 'tarifs.base_type_id')
            ->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
            ->with(['saison', 'tarif'])
            ->where([
                'tarifs.type_chambre_id' => $request->chambre_id,
            ])
            ->whereNull('hebergement_vol.id')
            ->where(function ($query) use ($request) {
                $query->where(function ($query)  use ($request) {
                    $query->whereMonth('saisons.debut', '<', parse_date($request->debut_saison)->month)
                        ->orWhere(function ($query) use ($request) {
                            $query->whereMonth('saisons.debut', '=', parse_date($request->debut_saison)->month)
                                ->whereDay('saisons.debut', '<=', parse_date($request->debut_saison)->day);
                        });
                })
                    ->orWhere(function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->whereColumn(DB::raw('month(saisons.fin)'), '<', DB::raw('month(saisons.debut)'))
                                ->whereMonth('saisons.debut', '>', parse_date($request->debut_saison)->month)
                                ->where(function ($query) use ($request) {
                                    $query->whereMonth('saisons.fin', '>', parse_date($request->debut_saison)->month)
                                        ->orWhere(function ($query) use ($request) {
                                            $query->whereMonth('saisons.fin', '=', parse_date($request->debut_saison)->month)
                                                ->whereDay('saisons.fin', '>=', parse_date($request->debut_saison)->day);
                                        });
                                });
                        })
                            ->orWhere(function ($query) use ($request) {
                                $query->whereColumn(DB::raw('month(saisons.fin)'), '=', DB::raw('month(saisons.debut)'))
                                    ->whereColumn(DB::raw('day(saisons.fin)'), '<', DB::raw('day(saisons.debut)'))
                                    ->whereDay('saisons.debut', '>', parse_date($request->debut_saison)->day)
                                    ->whereDay('saisons.fin', '>', parse_date($request->debut_saison)->day);
                            });
                    });
            })
            ->get()
            ->toArray();

        $debut_saison = collect($debut_saison)->map(function ($data_tarif) {
            $saion_ranger = self::rangerSaison($data_tarif['saison']);
            $data_tarif['saison']['debut'] = $saion_ranger['debut'];
            $data_tarif['saison']['fin'] = $saion_ranger['fin'];
            return $data_tarif;
        });

        if (count($debut_saison) == 0) abort(501);

        $debut_saison_base = collect($debut_saison)->groupBy('base_type_id')->values();

        $debut_saison_base = collect($debut_saison_base)->map(function ($data_base) {
            return collect($data_base)->filter(function ($data) use ($data_base) {

                return parse_date($data['saison']['fin'], false)->getTimestamp() == collect($data_base)->map(function ($data) {
                    return parse_date($data['saison']['fin'])->getTimestamp();
                })->max();
            })->first();
        });
        /** */

        $interval_saison = [];
        collect($debut_saison_base)->map(function ($debut_saison, $index) use ($request, &$interval_saison) {
            /** */
            $_temp_interval_saison = [];
            $_temp_interval_saison[] = $debut_saison;
            /** */
            $queue_saison = Tarif::select('tarifs.*', 'base_type.nombre as nombre_base')
                ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                ->leftjoin('base_type', 'base_type.id', 'tarifs.base_type_id')
                ->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                ->with(['saison', 'tarif'])
                ->where([
                    'tarifs.type_chambre_id' => $request->chambre_id,
                    'tarifs.base_type_id' => $debut_saison['base_type_id']
                ])
                ->whereNull('hebergement_vol.id')
                ->where(function ($query) use ($debut_saison, $request) {
                    $fin_debut = add_days($debut_saison['saison']['fin'], 1);
                    $query->whereMonth('saisons.debut', '<', $fin_debut->month)
                        ->orWhere(function ($query) use ($fin_debut) {
                            $query->whereMonth('saisons.debut', '=', $fin_debut->month)
                                ->whereDay('saisons.debut', '<=', $fin_debut->day);
                        });
                })
                ->where(function ($query) use ($debut_saison, $request) {
                    $fin = Carbon::parse($debut_saison['saison']['fin']);
                    $fin_request = parse_date($request->fin_saison);
                    if ($fin_request->year == $fin->year) {
                        $query->whereMonth('saisons.debut', '<', $fin_request->month)
                            ->orWhere(function ($query) use ($fin_request) {
                                $query->whereMonth('saisons.debut', '=', $fin_request->month)
                                    ->whereDay('saisons.debut', '<=', $fin_request->day);
                            });
                    } else if ($fin_request->year < $fin->year) {
                        $query->where(['tarifs.id' => 0]);
                    }
                    $query->whereMonth('saisons.debut', '<', $fin_request->month)
                        ->orWhere(function ($query) use ($fin_request) {
                            $query->whereMonth('saisons.debut', '=', $fin_request->month)
                                ->whereDay('saisons.debut', '<=', $fin_request->day);
                        });
                })
                ->where(function ($query) use ($debut_saison, $request) {
                    $fin_debut = parse_date($debut_saison['saison']['fin']);
                    $query->where(function ($query) use ($fin_debut) {
                        $query->whereColumn(DB::raw('month(saisons.debut)'), '<', DB::raw('month(saisons.fin)'))
                            ->where(function ($query) use ($fin_debut) {
                                $query->whereMonth('saisons.fin', '>', $fin_debut->month)
                                    ->orWhere(function ($query) use ($fin_debut) {
                                        $query->whereMonth('saisons.fin', '=', $fin_debut->month)
                                            ->whereDay('saisons.fin', '>', $fin_debut->day);
                                    });
                            });
                    })
                        ->orWhere(function ($query) use ($fin_debut) {
                            $query->whereColumn(DB::raw('month(saisons.debut)'), '=', DB::raw('month(saisons.fin)'))
                                ->whereColumn(DB::raw('day(saisons.debut)'), '<', DB::raw('day(saisons.fin)'))
                                ->where(function ($query) use ($fin_debut) {
                                    $query->whereMonth('saisons.fin', '>', $fin_debut->month)
                                        ->orWhere(function ($query) use ($fin_debut) {
                                            $query->whereMonth('saisons.fin', '=', $fin_debut->month)
                                                ->whereDay('saisons.fin', '>', $fin_debut->day);
                                        });
                                });
                        })
                        ->orWhere(function ($query) use ($fin_debut) {
                            $query->where(function ($query) use ($fin_debut) {
                                $query->whereColumn(DB::raw('month(saisons.debut)'), '>', DB::raw('month(saisons.fin)'))
                                    ->where(function ($query) use ($fin_debut) {
                                        $query->whereMonth('saisons.fin', '<', $fin_debut->month)
                                            ->orWhere(function ($query) use ($fin_debut) {
                                                $query->whereMonth('saisons.fin', '=', $fin_debut->month)
                                                    ->whereDay('saisons.fin', '<', $fin_debut->day);
                                            });
                                    });
                            });
                        });
                })
                ->get()
                ->toArray();

            $trouver = false;
            /** */
            $debut_saison__fin = Carbon::parse($debut_saison['saison']['fin']);
            $last_year = $debut_saison__fin->year;
            /** */

            while ($trouver == false && count($queue_saison) > 0) {
                $queue_saison = collect($debut_saison)->map(function ($data_tarif) use (&$last_year) {
                    $saion_ranger = self::rangerSaison($data_tarif['saison']);
                    $data_tarif['saison']['debut'] = $saion_ranger['debut'];
                    $data_tarif['saison']['fin'] = $saion_ranger['fin'];
                    return $data_tarif;
                });
                $queue_saison = collect($queue_saison)->filter(function ($data) use ($queue_saison) {
                    return parse_date($data['saison']['fin'], false)->getTimestamp() == collect($queue_saison)->map(function ($data) {
                        return parse_date($data['saison']['fin'], false)->getTimestamp();
                    })->max();
                })->first();
                /** */
                $queue_saison__fin = Carbon::parse($queue_saison['saison']['fin']);
                $last_year = $queue_saison__fin->year;
                /** */
                $_temp_interval_saison[] = $queue_saison;
                /** */
                if (parse_date($queue_saison['saison']['fin'], false)->greaterThanOrEqualTo(parse_date($request->fin_saison))) {
                    $trouver = true;
                } else {
                    $queue_saison = Tarif::select('tarifs.*', 'base_type.nombre as nombre_base')
                        ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                        ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                        ->leftjoin('base_type', 'base_type.id', 'tarifs.base_type_id')
                        ->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                        ->with(['saison', 'tarif'])
                        ->where([
                            'tarifs.type_chambre_id' => $request->chambre_id,
                        ])
                        ->whereNull('hebergement_vol.id')
                        ->where(function ($query) use ($queue_saison, $request) {
                            $fin_queue = add_days($queue_saison['saison']['fin'], 1);
                            $query->whereMonth('saisons.debut', '<', $fin_queue->month)
                                ->orWhere(function ($query) use ($fin_queue) {
                                    $query->whereMonth('saisons.debut', '=', $fin_queue->month)
                                        ->whereDay('saisons.debut', '<=', $fin_queue->day);
                                });
                        })
                        ->where(function ($query) use ($queue_saison, $request) {
                            $fin = Carbon::parse($queue_saison['saison']['fin']);
                            $fin_request = parse_date($request->fin_saison);
                            if ($fin_request->year == $fin->year) {
                                $query->whereMonth('saisons.debut', '<', $fin_request->month)
                                    ->orWhere(function ($query) use ($fin_request) {
                                        $query->whereMonth('saisons.debut', '=', $fin_request->month)
                                            ->whereDay('saisons.debut', '<=', $fin_request->day);
                                    });
                            } else if ($fin_request->year < $fin->year) {
                                $query->where(['tarifs.id' => 0]);
                            }
                            $query->whereMonth('saisons.debut', '<', $fin_request->month)
                                ->orWhere(function ($query) use ($fin_request) {
                                    $query->whereMonth('saisons.debut', '=', $fin_request->month)
                                        ->whereDay('saisons.debut', '<=', $fin_request->day);
                                });
                        })
                        ->where(function ($query) use ($queue_saison, $request) {
                            $fin_queue = parse_date($queue_saison['saison']['fin']);
                            $query->where(function ($query) use ($fin_queue) {
                                $query->whereColumn(DB::raw('month(saisons.debut)'), '<', DB::raw('month(saisons.fin)'))
                                    ->where(function ($query) use ($fin_queue) {
                                        $query->whereMonth('saisons.fin', '>', $fin_queue->month)
                                            ->orWhere(function ($query) use ($fin_queue) {
                                                $query->whereMonth('saisons.fin', '=', $fin_queue->month)
                                                    ->whereDay('saisons.fin', '>', $fin_queue->day);
                                            });
                                    });
                            })
                                ->orWhere(function ($query) use ($fin_queue) {
                                    $query->whereColumn(DB::raw('month(saisons.debut)'), '=', DB::raw('month(saisons.fin)'))
                                        ->whereColumn(DB::raw('day(saisons.debut)'), '<', DB::raw('day(saisons.fin)'))
                                        ->where(function ($query) use ($fin_queue) {
                                            $query->whereMonth('saisons.fin', '>', $fin_queue->month)
                                                ->orWhere(function ($query) use ($fin_queue) {
                                                    $query->whereMonth('saisons.fin', '=', $fin_queue->month)
                                                        ->whereDay('saisons.fin', '>', $fin_queue->day);
                                                });
                                        });
                                })
                                ->orWhere(function ($query) use ($fin_queue) {
                                    $query->where(function ($query) use ($fin_queue) {
                                        $query->whereColumn(DB::raw('month(saisons.debut)'), '>', DB::raw('month(saisons.fin)'))
                                            ->where(function ($query) use ($fin_queue) {
                                                $query->whereMonth('saisons.fin', '<', $fin_queue->month)
                                                    ->orWhere(function ($query) use ($fin_queue) {
                                                        $query->whereMonth('saisons.fin', '=', $fin_queue->month)
                                                            ->whereDay('saisons.fin', '<', $fin_queue->day);
                                                    });
                                            });
                                    });
                                });
                        })
                        ->get()
                        ->toArray();
                }
            }
            /** */
            $_temp_interval_saison = collect($_temp_interval_saison)->map(function ($data, $index_) use ($_temp_interval_saison, $request, $index) {
                $d1 = $index_ == 0 ? parse_date($request->debut_saison) : add_days($data['saison']['debut'], -1, false);
                $d2 = count($_temp_interval_saison) - 1 == $index_ ? parse_date($request->fin_saison) : parse_date($_temp_interval_saison[$index_ + 1]['saison']['debut'], false);
                return [
                    'jours' => $d2->diffInDays($d1),
                    'debut' => $d1,
                    'fin' => $d2,
                    'tarif' => $data
                ];
            });
            /** */
            $min_nuit = 0;
            $max_nuit = 0;
            $_temp_interval_saison = collect($_temp_interval_saison)->filter(function ($data) use (&$min_nuit, &$max_nuit) {
                if ($data['jours'] > 0) {
                    $min_nuit = $min_nuit + (($data['tarif']['nuit_min'] != null || $data['jours'] > intval($data['tarif']['nuit_min'])) ? $data['tarif']['nuit_min'] : $data['jours']);
                    $max_nuit =  $max_nuit + (($data['tarif']['nuit_max'] != null || $data['jours'] < intval($data['tarif']['nuit_max'])) ? $data['tarif']['nuit_max'] : $data['jours']);
                    return true;
                }
                return false;
            });
            /** */
            $interval_saison[$index] = [
                'saison' => $_temp_interval_saison,
                'nombre_base' => count($_temp_interval_saison) > 0 ? $_temp_interval_saison[0]['tarif']['nombre_base'] : 0, //nombre_base
                'min_nuit' => $min_nuit,
                'max_nuit' => $max_nuit
            ];
            /** */
        });

        /** */
        return [
            'base_type' => $interval_saison,
            'chambre_disponible' => $_chambre_dispo < 0 ? 0 : $_chambre_dispo,
            'info_detail' => $_calendars
        ];
    }

    public function productsansvol(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request);
        //
        $chambre_saison = [];
        $data = AdminListing::create(Tarif::class)
            ->modifyQuery(
                function ($query) use ($request, $my_request) {
                    $query->join('saisons', 'saisons.id', 'tarifs.saison_id');
                    $query->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id');
                    $query->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id');
                    $query->with([
                        'type_chambre',
                        'saison',
                        'vol' => function ($query) {
                            $query->with(['allotement' => function ($query) {
                                $query->with(['compagnie', 'depart', 'arrive']);
                            }]);
                        },
                        'hebergement' => function ($query) {
                            $query->with([
                                'type',
                                'ile',
                                'supplement_activite' => function ($query) {
                                    $query->with(['tarif', 'prestataire' => function ($query) {
                                        $query->with(['ville']);
                                    }]);
                                },
                                /*
                                'supplement_vue' => function ($query) {
                                    $query->with(['tarif']);
                                },
                                */
                                'supplement_pension' => function ($query) {
                                    $query->with(['tarif', 'prestataire' => function ($query) {
                                        $query->with(['ville']);
                                    }]);
                                }
                            ]);
                        },
                        'tarif' => function ($query) {
                            $query->with(['personne']);
                        },
                        'base_type'
                    ])
                        ->where(['tarifs.id' => $my_request['id']])
                        ->whereNull('hebergement_vol.id');
                }
            )
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                [
                    'id',
                    'titre',
                    'type_chambre_id',
                    'saison_id',
                    'base_type_id',
                    'description',
                    'taxe_active',
                    'taxe',
                    'jour_min',
                    'jour_max',
                    'nuit_min',
                    'nuit_max',
                    'hebergement_id',
                ],
                // set columns to searchIn
                [
                    'id',
                    'saisons.titre',
                    'type_chambre.name',
                    'jour_min',
                    'jour_max',
                    'nuit_min',
                    'nuit_max',
                    'hebergement_id'
                ]
            );
        $collection = $data->getCollection();
        $collection = $collection->map(function ($data) use (&$chambre_saison) { //filtrage si chambre / filtrage si tarif
            /** supplement vue */
            $data->hebergement->supplement_vue = $data->type_chambre->supplement_vue()
                ->with(['tarif'])
                ->get()
                ->toArray();
            /** */
            $data->reference_tarif = $data->tarif->filter(function ($tarif) use ($data) {
                $has_adulte = $data->tarif->filter(function ($personne) {
                    return $personne->personne->reference_prix == "1";
                })->values();
                if (count($has_adulte)) {
                    return $tarif->type_personne_id == $has_adulte[0]['type_personne_id']; // check personne adulte
                } else {
                    return $tarif->prix_vente == $data->tarif->min('prix_vente'); //reference prix
                }
            })->values();
            /*** */
            $data->chambre_dispo = $data->type_chambre->nombre_chambre;
            /** */
            $reference_tarif = $data->reference_tarif;
            $reference_tarif = collect($reference_tarif)->filter(function ($data) use ($reference_tarif) {
                return $data->prix_vente == collect($reference_tarif)->min('prix_vente');
            });
            $data->reference_tarif = collect($reference_tarif)->first();

            /* set saisnons */
            $chambre_saison = Saison::select('saisons.*')->join('tarifs', 'tarifs.saison_id', 'saisons.id')
                ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                ->where(['type_chambre.id' => $data->type_chambre_id])
                ->where(function ($query) {
                    $query->WhereMonth('saisons.debut', '>=', Carbon::today()->month)
                        ->orWhereMonth('saisons.fin', '>=', Carbon::today()->month)
                        ->orWhereColumn(DB::raw('month(saisons.fin)'), '<', DB::raw('month(saisons.debut)'));
                })
                ->get()
                ->toArray();
            $chambre_saison = collect($chambre_saison)->map(function ($data_saison) {
                $saion_ranger = self::rangerSaison([
                    'debut' => $data_saison['debut'],
                    'fin' => $data_saison['fin']
                ]);
                $data_saison['debut'] = $saion_ranger['debut'];
                $data_saison['fin'] = $saion_ranger['fin'];
                return $data_saison;
            });

            /* set saison */
            $data->type_chambre->formule = collect(config('formule-heb'))->filter(function ($formule) use ($data) {
                return $data->type_chambre->formule == $formule['id'];
            })->first();
            /** */
            return $data;
        })->values();
        //dd($data->toArray());

        $data->setCollection($collection);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        $tarif = Tarif::with(['hebergement'])->find($my_request['id']);
        //dd($chambre_saison);
        return $this->viewCustom('front.hebergement.hebergement-product-sans-vol', [
            'data' => $data,
            'chambre_saison' => collect($chambre_saison),
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'personne' => $tarif->hebergement->personne()->get(),
            'typeChambre' => TypeChambre::find($my_request['id']),
            'commande_saved' => GestionCommandeUtilisateurController::modifier($request, 'hebergement', $my_request['id'], collect($my_request)->get('date_commande')),
            'edit_pannier' => isset($my_request['panier']) && $my_request['panier'] == true,
            'produit_associer' => collect($this->produit_associer([], $my_request['id']))
        ]);
    }

    private function produit_associer($my_request = [], $exculde_id = 0)
    {
        if (isset($my_request['customer_search'])) {

            $customer_search = (object) $my_request['customer_search'];
            $ile_id = explode(',', $customer_search->ile);
            $columns_search = [
                'iles.name',
                'villes.name',
                'type_chambre.name',
                'hebergements.name',
                'type_hebergement.name',
                'tarifs.titre'
            ];
            $mot_cle = isset($customer_search->mot_cle) ? $customer_search->mot_cle : '';
            $price = explode(',', $customer_search->price);
            $search_vol = isset($customer_search->transport) ? $customer_search->transport : '2';
            $tarif_filter = Hebergement::select('tarifs.id')
                ->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id')
                ->join('iles', 'iles.id', 'hebergements.ile_id')
                ->join('villes', 'villes.id', 'hebergements.ville_id')
                ->join('tarifs', 'tarifs.hebergement_id', 'hebergements.id')
                ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                ->join('tarif_type_personne_hebergement', 'tarif_type_personne_hebergement.tarif_id', 'tarifs.id')
                ->leftJoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                ->join('type_chambre', 'type_chambre.id', 'tarifs.type_chambre_id')
                ->where(['hebergements.id' => $my_request['id']])
                ->whereIn('iles.id', $ile_id)
                ->where(function ($query) use ($columns_search, $mot_cle) {
                    array_map(function ($array) use (&$query, $mot_cle) {
                        $query = $query->orWhere(DB::raw('lower(' . $array . ')'), 'like', '%' . strtolower($mot_cle) . '%');
                    }, $columns_search);
                })
                ->whereBetween('tarif_type_personne_hebergement.prix_vente', $price);
            switch ($search_vol) {
                case '0':
                    $tarif_filter =  $tarif_filter->whereNull('hebergement_vol.tarif_id');
                    $tarif_filter = $tarif_filter->where(function ($query) {
                        $query->whereMonth('saisons.fin', '>', Carbon::today()->month())
                            ->orWhere(function ($query) {
                                $query->whereMonth('saisons.fin', '=', Carbon::today()->month)
                                    ->whereDay('saisons.fin', '>', Carbon::today()->format('d'));
                            });
                    });
                    break;

                case '1':
                    $tarif_filter =  $tarif_filter->whereNotNull('hebergement_vol.tarif_id');
                    $tarif_filter = $tarif_filter->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                    break;
                default:
                    $tarif_filter =  $tarif_filter->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where(function ($query) {
                                $query->whereMonth('saisons.fin', '>', Carbon::today()->month)
                                    ->orWhere(function ($query) {
                                        $query->whereMonth('saisons.fin', '=', Carbon::today()->month)
                                            ->whereDay('saisons.fin', '>', Carbon::today()->format('d'));
                                    });
                            })
                                ->whereNull('hebergement_vol.tarif_id');
                        })
                            ->orWhere(function ($query) {
                                $query->whereNotNull('hebergement_vol.tarif_id')
                                    ->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                            });
                    });
                    break;
            }
            $tarif_filter =  $tarif_filter->get();
            $tarif_filter_id = $tarif_filter->map(function ($data_collection) {
                return $data_collection->id;
            })->values();
        } else {
            $tarif_filter = Tarif::select('tarifs.*')
                ->join('saisons', 'saisons.id', 'tarifs.saison_id')
                ->leftJoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
                ->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereMonth('saisons.fin', '>', Carbon::today()->month)
                                ->orWhere(function ($query) {
                                    $query->whereMonth('saisons.fin', '=', Carbon::today()->month)
                                        ->whereDay('saisons.fin', '>', Carbon::today()->format('d'));
                                });
                        })
                            ->whereNull('hebergement_vol.tarif_id');
                    })
                        ->orWhere(function ($query) {
                            $query->whereNotNull('hebergement_vol.tarif_id')
                                ->whereDate('hebergement_vol.depart', '>=', Carbon::today());
                        });
                })
                ->get();

            $tarif_filter_id = $tarif_filter->map(function ($data_collection) {
                return $data_collection->id;
            })->values();
        }

        if (count($tarif_filter_id) == 0) {
            $tarif_filter_id = [0];
        }
        /* search */
        $collection = Hebergement::select('hebergements.id', 'hebergements.name', 'hebergements.duration_min', 'hebergements.status', 'hebergements.image', 'hebergements.heure_ouverture', 'hebergements.heure_fermeture', 'hebergements.adresse', 'hebergements.description', 'hebergements.type_hebergement_id', 'hebergements.ville_id', 'hebergements.prestataire_id', 'hebergements.caution', 'hebergements.ile_id', 'hebergements.etoil', 'hebergements.fond_image')
            ->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id')
            ->join('prestataire', 'prestataire.id', 'hebergements.prestataire_id')
            ->with(['type', 'ville', 'ile', 'chambre' => function ($query) use ($tarif_filter_id, $exculde_id) {
                $query->with([
                    'tarif' => function ($query) use ($tarif_filter_id, $exculde_id) {
                        $query->whereIn('id', $tarif_filter_id)
                            ->whereNotIn('id', [$exculde_id])
                            ->with([
                                'saison',
                                'tarif' => function ($query) {
                                    $query->with(['personne']);
                                }, 'vol',
                                'type_chambre',
                                'base_type'
                            ]);
                    }
                ]);
            }, 'supplement_activite', 'supplement_vue', 'supplement_pension'])
            ->limit(10, 'desc')
            ->get();

        $collection = json_decode(json_encode($collection));
        //dd($collection);
        $collection = collect($collection)->map(function ($data) {
            $data->chambre = collect($data->chambre)->map(function ($data_chambre) {
                $tarif_sans_vol = collect($data_chambre->tarif)->filter(function ($data) {
                    return $data->vol == null;
                })->values();

                /** filtre base double sans vol */
                $tarif_sans_vol_base_double = collect($tarif_sans_vol)->filter(function ($data) {
                    return $data->base_type->reference_prix == 1;
                })->values();
                $tarif_sans_vol = count($tarif_sans_vol_base_double) > 0 ? json_decode(json_encode($tarif_sans_vol_base_double)) : json_decode(json_encode($tarif_sans_vol));
                /** */

                $tarif_avec_vol = collect($data_chambre->tarif)->filter(function ($data) {
                    /* check chambre disponible */
                    $chambre_commander = LigneCommandeChambre::where(['chambre_id' => $data->type_chambre->id])->sum('quantite_chambre');
                    return $data->vol != null && (intval($data->type_chambre->nombre_chambre) - (intval($chambre_commander)) > 0);
                })->values();

                /** filtre base double avec vol */
                $tarif_avec_vol_base_double = collect($tarif_avec_vol)->filter(function ($data) {
                    return $data->base_type->reference_prix == 1;
                })->values(); 
                $tarif_avec_vol = count($tarif_avec_vol_base_double) > 0 ? json_decode(json_encode($tarif_avec_vol_base_double)) : json_decode(json_encode($tarif_avec_vol));
                /** */

                $tarif_avec_vol = collect($tarif_avec_vol)->map(function ($data) {
                    /* check chambre disponible */
                    $chambre_commander = LigneCommandeChambre::where(['chambre_id' => $data->type_chambre->id])->sum('quantite_chambre');
                    $chambre_commande_other = ChambreEnCommande::where([
                        'chambre_id' => $data->type_chambre->id
                    ])->sum('nombre');
                    $data->quantite_stock = intval($data->type_chambre->nombre_chambre) - (intval($chambre_commander) + intval($chambre_commande_other));
                    $adulte = collect($data->tarif)->filter(function ($personne) {
                        return $personne->personne->reference_prix == 1;
                    });
                    if (count($adulte) == 0) {
                        $min = collect($data->tarif)->filter(function ($_data_interne) use ($data) {
                            return $_data_interne->prix_vente == collect($data)->min('prix_vente');
                        })->first();
                        $data->tarif = $min;
                        return $data;
                    } else {
                        $data->tarif = collect($adulte)->first();
                        return $data;
                    }
                    return $data;
                })->values();

                /* min sans vol */
                $tarif_sans_vol_min = collect($tarif_sans_vol)->map(function ($data) {
                    $adulte = collect($data->tarif)->filter(function ($personne) {
                        return $personne->personne->reference_prix == 1;
                    });
                    if (count($adulte) == 0) {
                        $min = collect($data->tarif)->filter(function ($_data_interne) use ($data) {
                            return $_data_interne->prix_vente == collect($data)->min('prix_vente');
                        })->first();
                        $data->tarif = $min;
                        return $data;
                    } else {
                        $data->tarif = collect($adulte)->first();
                        return $data;
                    }
                });
                /** filtre saison 1 */
                $tarif_sans_vol_min_1 = collect($tarif_sans_vol_min)->filter(function ($data) use ($tarif_sans_vol_min) {
                    $saion_ranger = self::rangerSaison([
                        'debut' => $data->saison->debut,
                        'fin' => $data->saison->fin
                    ]);
                    $data->saison->debut = $saion_ranger['debut'];
                    $data->saison->fin = $saion_ranger['fin'];
                    return now()->greaterThanOrEqualTo($data->saison->debut) && now()->lessThanOrEqualTo($data->saison->fin);
                    //return $data->tarif->prix_vente == collect($tarif_sans_vol_min)->min('tarif.prix_vente');
                })->values();
                /** filtre saison 2 */
                if (count($tarif_sans_vol_min_1) == 0) {
                    $tarif_sans_vol_min_2 = collect($tarif_sans_vol_min)->filter(function ($data) use ($tarif_sans_vol_min) {
                        $saion_ranger = self::rangerSaison([
                            'debut' => $data->saison->debut,
                            'fin' => $data->saison->fin
                        ]);
                        $data->saison->debut = $saion_ranger['debut'];
                        $data->saison->fin = $saion_ranger['fin'];
                        return now()->greaterThanOrEqualTo($data->saison->debut);
                    })->values();
                    /** finalisation filtre saison */
                    $tarif_sans_vol_min = collect($tarif_sans_vol_min_2)->filter(function ($data) use ($tarif_sans_vol_min_2) {
                        return $data->saison->debut->getTimestamp() == collect($tarif_sans_vol_min_2)->map(function ($convert_time) {
                            return $convert_time->saison->debut->getTimestamp();
                        })->min();
                    })->first();
                } else {
                    /** finalisation filtre saison */
                    $tarif_sans_vol_min = collect($tarif_sans_vol_min_1)->filter(function ($data) use ($tarif_sans_vol_min_1) {
                        return $data->saison->fin->getTimestamp() == collect($tarif_sans_vol_min_1)->map(function ($convert_time) {
                            return $convert_time->saison->fin->getTimestamp();
                        })->max();
                    })->first();
                }

                /** */
                $tarif_min = $tarif_avec_vol;

                if ($tarif_sans_vol_min != null) {
                    $tarif_min[] = collect($tarif_sans_vol)->filter(function ($data) use ($tarif_sans_vol_min) {
                        return $tarif_sans_vol_min->id == $data->id;
                    })->first();
                }
                $data_chambre->tarif = $tarif_min;
                return $data_chambre;
            });
            return $data;
        });

        $all_chambre_associer = [];

        collect($collection)->map(function ($data) use (&$all_chambre_associer) {
            collect($data->chambre)->map(function ($data_chambre) use (&$all_chambre_associer, $data) {
                collect($data_chambre->tarif)->map(function ($data_tarif) use (&$all_chambre_associer, $data) {
                    $data_tarif->type_chambre->formule = collect(config('formule-heb'))->filter(function ($formule) use ($data_tarif) {
                        return $data_tarif->type_chambre->formule == $formule['id'];
                    })->first();
                    $hebergement = $data;
                    unset($data->tarif);
                    $all_chambre_associer[] = [
                        'hebergement' => $hebergement,
                        'tarif' => $data_tarif
                    ];
                });
            });
            return $data;
        });
        return ['data' => $all_chambre_associer];
    }
}

/*
 * Album::with('images')->get()->map(function($album) {
    $album->setRelation('images', $album->images->take(3));
    return $album;
});
 * 
 * 
 * $collection = collect([
    ['name' => 'Desk', 'price' => 200],
    ['name' => 'Chair', 'price' => 100],
    ['name' => 'Bookcase', 'price' => 150],
]);

$sorted = $collection->sortBy('price');
 */