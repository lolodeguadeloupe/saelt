<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CoupCoeurProduit\BulkDestroyCoupCoeurProduit;
use App\Http\Requests\Admin\CoupCoeurProduit\DestroyCoupCoeurProduit;
use App\Http\Requests\Admin\CoupCoeurProduit\IndexCoupCoeurProduit;
use App\Http\Requests\Admin\CoupCoeurProduit\StoreCoupCoeurProduit;
use App\Http\Requests\Admin\CoupCoeurProduit\UpdateCoupCoeurProduit;
use App\Models\BilleterieMaritime;
use App\Models\CoupCoeurProduit;
use App\Models\Excursion\Excursion;
use App\Models\Hebergement\Hebergement;
use App\Models\Hebergement\TypeChambre;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\Produit;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
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

class CoupCoeurProduitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCoupCoeurProduit $request
     * @return array|Factory|View
     */
    public function index(IndexCoupCoeurProduit $request)
    {
        $options = Produit::where(function ($query) use ($request) {
            $query->where(['status' => 1]);
            if (isset($request->produit)) {
                $query->whereIn('id', explode(',', $request->produit));
            } else {
                $query->whereIn('sigle', ['hebergement', 'excursion']);
            }
        })->get();

        $hebergement = collect([]);
        $excursion = collect([]);
        $transfert = collect([]);
        $location = collect([]);
        $billetterie = collect([]);

        collect($options)->map(function ($data) use (&$hebergement, &$excursion, &$transfert, &$location, &$billetterie, $request) {
            switch ($data->sigle) {
                case 'hebergement':

                    collect(
                        Hebergement::select('hebergements.*')
                            ->leftjoin('villes', 'villes.id', 'hebergements.ville_id')
                            ->leftjoin('iles', 'iles.id', 'hebergements.ile_id')
                            ->with(['ville', 'ile'])
                            ->where(function ($query) use ($request) {
                                if ((isset($request->all_coup_coeur) && $request->all_coup_coeur == "true") || !isset($request->all_coup_coeur)) {
                                    $query->whereIn('hebergements.id', collect(CoupCoeurProduit::where(['model' => Hebergement::class])->get())->map(function ($data) {
                                        return $data->model_id;
                                    })->values());
                                }
                            })
                            ->where(function ($query) use ($request) {
                                if (isset($request->mot_cles) && trim($request->mot_cles) != "") {
                                    $query->whereRaw("UPPER(villes.name) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(iles.name) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(hebergements.name) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhere('hebergements.id', $request->mot_cles);
                                }
                            })
                            ->limit(isset($request->item_limit) ? $request->item_limit : 6)
                            ->get()
                    )->map(function ($data)  use (&$hebergement) {
                        $coup_coeur  = CoupCoeurProduit::where(['model' => Hebergement::class, 'model_id' => $data->id])->first();
                        $hebergement->push([
                            'sigle' => 'hebergement',
                            'id' => $data->id,
                            'titre' => $data->name,
                            'description' => $data->description,
                            'ville' => $data->ville ? $data->ville->name : null,
                            'ile' => $data->ile ? $data->ile->name : null,
                            'image' => $data->fond_image,
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null
                        ]);
                    });
                    break;

                case 'excursion':

                    collect(
                        Excursion::select('excursions.*')
                            ->leftjoin('villes', 'villes.id', 'excursions.ville_id')
                            ->leftjoin('iles', 'iles.id', 'excursions.ile_id')
                            ->with(['ville', 'ile'])
                            ->where(function ($query) use ($request) {
                                if ((isset($request->all_coup_coeur) && $request->all_coup_coeur == "true") || !isset($request->all_coup_coeur)) {
                                    $query->whereIn('excursions.id', collect(CoupCoeurProduit::where(['model' => Excursion::class])->get())->map(function ($data) {
                                        return $data->model_id;
                                    })->values());
                                }
                            })
                            ->where(function ($query) use ($request) {
                                if (isset($request->mot_cles) && trim($request->mot_cles) != "") {
                                    $query->whereRaw("UPPER(villes.name) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(iles.name) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(excursions.title) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhere('excursions.id', $request->mot_cles);
                                }
                            })
                            ->limit(isset($request->item_limit) ? $request->item_limit : 6)
                            ->get()
                    )->map(function ($data) use (&$excursion) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => Excursion::class, 'model_id' => $data->id])->first();
                        $excursion->push([
                            'sigle' => 'excursion',
                            'id' => $data->id,
                            'titre' => $data->title,
                            'description' => $data->description,
                            'ville' => $data->ville ? $data->ville->name : null,
                            'ile' => $data->ile ? $data->ile->name : null,
                            'image' => $data->fond_image,
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null
                        ]);
                    });
                    break;
                case 'transfert':

                    collect(
                        TypeTransfertVoyage::select('type_transfert_voyage.*')
                            ->with(['vehicule'])
                            ->where(function ($query) use ($request) {
                                if ((isset($request->all_coup_coeur) && $request->all_coup_coeur == "true") || !isset($request->all_coup_coeur)) {
                                    $query->whereIn('type_transfert_voyage.id', collect(CoupCoeurProduit::where(['model' => TypeTransfertVoyage::class])->get())->map(function ($data) {
                                        return $data->model_id;
                                    })->values());
                                }
                            })
                            ->where(function ($query) use ($request) {
                                if (isset($request->mot_cles) && trim($request->mot_cles) != "") {
                                    $query->whereRaw("UPPER(type_transfert_voyage.titre) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhere('type_transfert_voyage.id', $request->mot_cles);
                                }
                            })
                            ->limit(isset($request->item_limit) ? $request->item_limit : 6)
                            ->get()
                    )->map(function ($data)  use (&$transfert) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => TypeTransfertVoyage::class, 'model_id' => $data->id])->first();
                        $transfert->push([
                            'sigle' => 'transfert',
                            'id' => $data->id,
                            'titre' => $data->titre,
                            'description' => $data->description,
                            'ville' => null,
                            'ile' => null,
                            'image' => collect($data->vehicule)->map(function ($data) {
                                return collect($data->image)->map(function ($data) {
                                    return $data->name;
                                })->first();
                            })->first(),
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null
                        ]);
                    });
                    break;
                case 'location':

                    collect(
                        VehiculeLocation::select('vehicule_location.*')
                            ->leftjoin('modele_vehicule', 'modele_vehicule.id', 'vehicule_location.modele_vehicule_id')
                            ->leftjoin('marque_vehicule', 'marque_vehicule.id', 'vehicule_location.marque_vehicule_id') //titre
                            ->leftjoin('categorie_vehicule', 'categorie_vehicule.id', 'vehicule_location.categorie_vehicule_id') //titre
                            ->with(['modele', 'marque'])
                            ->where(function ($query) use ($request) {
                                if ((isset($request->all_coup_coeur) && $request->all_coup_coeur == "true") || !isset($request->all_coup_coeur)) {
                                    $query->whereIn('vehicule_location.id', collect(CoupCoeurProduit::where(['model' => VehiculeLocation::class])->get())->map(function ($data) {
                                        return $data->model_id;
                                    })->values());
                                }
                            })
                            ->where(function ($query) use ($request) {
                                if (isset($request->mot_cles) && trim($request->mot_cles) != "") {
                                    $query->whereRaw("UPPER(modele_vehicule.titre) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(marque_vehicule.titre) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(categorie_vehicule.titre) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(vehicule_location.immatriculation) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhere('vehicule_location.id', $request->mot_cles);
                                }
                            })
                            ->limit(isset($request->item_limit) ? $request->item_limit : 6)
                            ->get()
                    )->map(function ($data) use (&$location) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => VehiculeLocation::class, 'model_id' => $data->id])->first();
                        $location->push([
                            'sigle' => 'location',
                            'id' => $data->id,
                            'titre' => $data->immatriculation,
                            'description' => $data->description,
                            'ville' => null,
                            'ile' => null,
                            'image' => collect($data->image)->map(function ($data) {
                                return $data->name;
                            })->first(),
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null
                        ]);
                    });
                    break;
                case 'billetterie':

                    collect(
                        BilleterieMaritime::select('billeterie_maritime.*')
                            ->leftjoin('service_port as port_depart', 'port_depart.id', 'billeterie_maritime.lieu_depart_id')
                            ->leftjoin('service_port as port_arrivee', 'port_arrivee.id', 'billeterie_maritime.lieu_arrive_id')
                            ->with(['depart' => function ($query) {
                                $query->with(['ville']);
                            }, 'arrive'])
                            ->where(function ($query) use ($request) {
                                if ((isset($request->all_coup_coeur) && $request->all_coup_coeur == "true") || !isset($request->all_coup_coeur)) {
                                    $query->whereIn('billeterie_maritime.id', collect(CoupCoeurProduit::where(['model' => BilleterieMaritime::class])->get())->map(function ($data) {
                                        return $data->model_id;
                                    })->values());
                                }
                            })
                            ->where(function ($query) use ($request) {
                                if (isset($request->mot_cles) && trim($request->mot_cles) != "") {
                                    $query->whereRaw("UPPER(port_depart.name) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(port_arrivee.name) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhereRaw("UPPER(billeterie_maritime.titre) LIKE '%" . strtoupper($request->mot_cles) . "%'");
                                    $query->orWhere('billeterie_maritime.id', $request->mot_cles);
                                }
                            })
                            ->limit(isset($request->item_limit) ? $request->item_limit : 6)
                            ->get()
                    )->map(function ($data) use (&$billetterie) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => BilleterieMaritime::class, 'model_id' => $data->id])->first();
                        $billetterie->push([
                            'sigle' => 'billetterie',
                            'id' => $data->id,
                            'titre' => $data->titre,
                            'description' => null,
                            'port_depart' => $data->depart ? $data->depart->name : null,
                            'port_arrivee' => $data->arrive ? $data->arrive->name : null,
                            'ville' => $data->depart->ville ? $data->depart->ville->name : null,
                            'ile' => null,
                            'image' => $data->image,
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null
                        ]);
                    });
                    break;
            }
        });

        if ($request->ajax()) {
            return [
                'hebergement' => $hebergement->all(),
                'excursion' => $excursion->all(),
                'transfert' => $transfert->all(),
                'location' => $location->all(),
                'billetterie' => $billetterie->all(),
            ];
        }
        return view('admin.coup-coeur-produit.index', [
            'data' => collect([
                'hebergement' => $hebergement->all(),
                'excursion' => $excursion->all(),
                'transfert' => $transfert->all(),
                'location' => $location->all(),
                'billetterie' => $billetterie->all(),
            ]),
            'options' => collect($options)->map(function ($data) {
                return [
                    'id' => $data->id,
                    'sigle' => $data->sigle
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCoupCoeurProduit $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCoupCoeurProduit $request)
    {

        if (!$request->ajax()) {
            abort(404);
        }
        // Sanitize input
        $sanitized = $request->getSanitized();

        $coupCoeurProduit = null;

        switch ($sanitized['sigle']) {
            case 'hebergement':
                $coupCoeurProduit = CoupCoeurProduit::create(['model' => Hebergement::class, 'model_id' => $sanitized['id']]);
                break;

            case 'excursion':
                $coupCoeurProduit = CoupCoeurProduit::create(['model' => Excursion::class, 'model_id' => $sanitized['id']]);
                break;
            case 'transfert':
                $coupCoeurProduit = CoupCoeurProduit::create(['model' => TypeTransfertVoyage::class, 'model_id' => $sanitized['id']]);
                break;
            case 'location':
                $coupCoeurProduit = CoupCoeurProduit::create(['model' => VehiculeLocation::class, 'model_id' => $sanitized['id']]);
                break;
            case 'billetterie':
                $coupCoeurProduit = CoupCoeurProduit::create(['model' => BilleterieMaritime::class, 'model_id' => $sanitized['id']]);
                break;
        }

        return [
            'redirect' => url('admin/coup-coeur-produits'),
            'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            'coup_coeur' => $coupCoeurProduit != null,
            'resource_url' => $coupCoeurProduit ? $coupCoeurProduit->resource_url : null
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCoupCoeurProduit $request
     * @param CoupCoeurProduit $coupCoeurProduit
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCoupCoeurProduit $request, CoupCoeurProduit $coupCoeurProduit)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $coupCoeurProduit->delete();

        return response([
            'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            'coup_coeur' => false,
            'resource_url' => null
        ]);
    }


    public static function all_coup_coeur()
    {
        $options = Produit::where(function ($query) {
            $query->where(['status' => 1]);
        })->get();

        $all = collect([]);

        collect($options)->map(function ($data) use (&$all, &$billetterie) {
            switch ($data->sigle) {
                case 'hebergement':

                    collect(
                        Hebergement::select('hebergements.*')
                            ->leftjoin('villes', 'villes.id', 'hebergements.ville_id')
                            ->leftjoin('iles', 'iles.id', 'hebergements.ile_id')
                            ->with(['ville', 'ile', 'tarif' => function ($query) {
                                $query->with(['tarif' => function ($query) {
                                    $query->with(['personne']);
                                }, 'type_chambre', 'base_type']);
                            }])
                            ->where(function ($query) {
                                $query->whereIn('hebergements.id', collect(CoupCoeurProduit::where(['model' => Hebergement::class])->get())->map(function ($data) {
                                    return $data->model_id;
                                })->values());
                            })
                            ->limit(20)
                            ->get()
                    )->map(function ($data)  use (&$all) {
                        $coup_coeur  = CoupCoeurProduit::where(['model' => Hebergement::class, 'model_id' => $data->id])->first();

                        /** */
                        $data = json_decode(json_encode($data));

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
                            /** formule */
                            $tarif->type_chambre->formule = collect(config('formule-heb'))->filter(function ($formule) use ($tarif) {
                                return  $tarif->type_chambre->formule == $formule['id'];
                            })->first();
                            /** */
                            return $tarif->tarif->prix_vente == collect($data->tarif)->map(function ($tarif_map) {
                                return $tarif_map->tarif->prix_vente;
                            })->min();
                        })->values();

                        $data->tarif = collect($data->tarif)->first();

                        /** */

                        $all->push([
                            'sigle' => 'hebergement',
                            'id' => $data->id,
                            'titre' => $data->name,
                            'description' => $data->description,
                            'ville' => $data->ville ? $data->ville->name : null,
                            'ile' => $data->ile ? $data->ile->name : null,
                            'image' => $data->fond_image,
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null,
                            'url' => route('hebergement-host'),
                            'id_produit' => $data->id,
                            'data' => $data
                        ]);
                    });
                    break;

                case 'excursion':

                    collect(
                        Excursion::select('excursions.*')
                            ->leftjoin('villes', 'villes.id', 'excursions.ville_id')
                            ->leftjoin('iles', 'iles.id', 'excursions.ile_id')
                            ->with(['ville', 'ile', 'tarif' => function ($query) {
                                $query->with(['personne', 'saison']);
                            }, 'supplement' => function ($query) {
                                $query->with(['tarif']);
                            }, 'compagnie' => function ($query) {
                                $query->with(['ville', 'billeterie']);
                            }])
                            ->where(function ($query) {
                                $query->whereIn('excursions.id', collect(CoupCoeurProduit::where(['model' => Excursion::class])->get())->map(function ($data) {
                                    return $data->model_id;
                                })->values());
                            })
                            ->limit(20)
                            ->get()
                    )->map(function ($data) use (&$all) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => Excursion::class, 'model_id' => $data->id])->first();
                        $data = json_decode(json_encode($data));
                        /** */
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
                        /** */
                        $data->tarif = collect($data->tarif)->filter(function ($_data) use ($data) {
                            return $_data->prix_vente == collect($data->tarif)->min('prix_vente');
                        })->first();
                        /** */

                        $all->push([
                            'sigle' => 'excursion',
                            'id' => $data->id,
                            'titre' => $data->title,
                            'description' => $data->description,
                            'ville' => $data->ville ? $data->ville->name : null,
                            'ile' => $data->ile ? $data->ile->name : null,
                            'image' => $data->fond_image,
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null,
                            'url' => route('excursion-product'),
                            'id_produit' => $data->id,
                            'data' => $data
                        ]);
                    });
                    break;
                case 'transfert':

                    collect(
                        TypeTransfertVoyage::select('type_transfert_voyage.*')
                            ->with(['vehicule'])
                            ->where(function ($query) {
                                $query->whereIn('type_transfert_voyage.id', collect(CoupCoeurProduit::where(['model' => TypeTransfertVoyage::class])->get())->map(function ($data) {
                                    return $data->model_id;
                                })->values());
                            })
                            ->limit(20)
                            ->get()
                    )->map(function ($data)  use (&$all) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => TypeTransfertVoyage::class, 'model_id' => $data->id])->first();
                        $all->push([
                            'sigle' => 'transfert',
                            'id' => $data->id,
                            'titre' => $data->titre,
                            'description' => $data->description,
                            'ville' => null,
                            'ile' => null,
                            'image' => collect($data->vehicule)->map(function ($data) {
                                return collect($data->image)->map(function ($data) {
                                    return $data->name;
                                })->first();
                            })->first(),
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null,
                            'url' => route('transferts'),
                            'id_produit' => $data->id,
                        ]);
                    });
                    break;
                case 'location':

                    collect(
                        VehiculeLocation::select('vehicule_location.*')
                            ->leftjoin('modele_vehicule', 'modele_vehicule.id', 'vehicule_location.modele_vehicule_id')
                            ->leftjoin('marque_vehicule', 'marque_vehicule.id', 'vehicule_location.marque_vehicule_id') //titre
                            ->leftjoin('categorie_vehicule', 'categorie_vehicule.id', 'vehicule_location.categorie_vehicule_id') //titre
                            ->with(['modele', 'marque'])
                            ->where(function ($query) {
                                $query->whereIn('vehicule_location.id', collect(CoupCoeurProduit::where(['model' => VehiculeLocation::class])->get())->map(function ($data) {
                                    return $data->model_id;
                                })->values());
                            })
                            ->limit(20)
                            ->get()
                    )->map(function ($data) use (&$all) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => VehiculeLocation::class, 'model_id' => $data->id])->first();
                        $all->push([
                            'sigle' => 'location',
                            'id' => $data->id,
                            'titre' => $data->immatriculation,
                            'description' => $data->description,
                            'ville' => null,
                            'ile' => null,
                            'image' => collect($data->image)->map(function ($data) {
                                return $data->name;
                            })->first(),
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null,
                            'url' => route('locations'),
                            'id_produit' => $data->id
                        ]);
                    });
                    break;
                case 'billetterie':

                    collect(
                        BilleterieMaritime::select('billeterie_maritime.*')
                            ->leftjoin('service_port as port_depart', 'port_depart.id', 'billeterie_maritime.lieu_depart_id')
                            ->leftjoin('service_port as port_arrivee', 'port_arrivee.id', 'billeterie_maritime.lieu_arrive_id')
                            ->with(['depart' => function ($query) {
                                $query->with(['ville']);
                            }, 'arrive'])
                            ->where(function ($query) {
                                $query->whereIn('billeterie_maritime.id', collect(CoupCoeurProduit::where(['model' => BilleterieMaritime::class])->get())->map(function ($data) {
                                    return $data->model_id;
                                })->values());
                            })
                            ->limit(20)
                            ->get()
                    )->map(function ($data) use (&$all) {
                        $coup_coeur = CoupCoeurProduit::where(['model' => BilleterieMaritime::class, 'model_id' => $data->id])->first();
                        $all->push([
                            'sigle' => 'billetterie',
                            'id' => $data->id,
                            'titre' => $data->titre,
                            'description' => null,
                            'port_depart' => $data->depart ? $data->depart->name : null,
                            'port_arrivee' => $data->arrive ? $data->arrive->name : null,
                            'ville' => $data->depart->ville ? $data->depart->ville->name : null,
                            'ile' => null,
                            'image' => $data->image,
                            'coup_coeur' => $coup_coeur != null,
                            'resource_url' => $coup_coeur ? $coup_coeur->resource_url : null,
                            'url' => route('billetteries'),
                            'id_produit' => $data->id
                        ]);
                    });
                    break;
            }
        });
        //
        return $all->all();
    }
}
