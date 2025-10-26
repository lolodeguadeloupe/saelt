<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BilleterieMaritime;
use App\Models\PlaningTime;
use Brackets\AdminListing\Facades\AdminListing;
use App\Models\Ile;
use App\Models\ServicePort;
use App\Models\TypePersonne;
use Carbon\Carbon;

class BilletterieController extends Controller
{

    public function index(Request $request)
    {
        /* implementation de filtre dans le requet my_request */
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);
        /* */
        $data = AdminListing::create(BilleterieMaritime::class)
            ->modifyQuery(function ($query) use ($request, $my_request) {
                $query->join('compagnie_transport', 'compagnie_transport.id', 'billeterie_maritime.compagnie_transport_id');
                $query->join('service_port as port_depart', 'port_depart.id', 'billeterie_maritime.lieu_depart_id');
                $query->join('service_port as port_arrive', 'port_arrive.id', 'billeterie_maritime.lieu_arrive_id');
                $query->with(['compagnie', 'tarif' => function ($query) use ($request) {
                    $query->with(['personne']);
                }, 'depart' => function ($query) {
                    $query->with(['ville' => function ($query) {
                        $query->with(['pays']);
                    }]);
                }, 'arrive' => function ($query) {
                    $query->with(['ville' => function ($query) {
                        $query->with(['pays']);
                    }]);
                }]);
                if ($request->has('customer_search') && $request->ajax() || $my_request != null) {

                    $customer_search = $request->has('customer_search') ? json_decode($request->customer_search) : (object)$my_request['customer_search'];

                    $query->where([
                        'port_depart.id' => $customer_search->depart,
                        'port_arrive.id' => $customer_search->arrive
                    ]);
                } else {
                    $query->where(['billeterie_maritime.id' => 0]);
                }
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'availability', 'titre', 'lieu_depart_id', 'lieu_arrive_id', 'date_depart', 'date_arrive', 'date_acquisition', 'date_limite', 'image', 'quantite', 'compagnie_transport_id'],
                // set columns to searchIn
                ['id', 'titre', 'lieu_depart', 'lieu_arrive', 'date_depart', 'date_arrive', 'date_acquisition', 'date_limite', 'quantite', 'compagnie_transport.nom', 'service_port.name', 'service_port.code_service']
            );

        $collection = $data->getCollection();

        if ($request->has('customer_search') && $request->ajax() || $my_request != null) {

            $customer_search = $request->has('customer_search') ? json_decode($request->customer_search) : (object)$my_request['customer_search'];
            //
            $personne_total = 0;
            //
            $collection = $collection->map(function ($data, $key_collection) use ($customer_search, &$personne_total) {
                //
                $data = collect($data);
                //
                $personne = [];
                foreach ($customer_search as $key => $value) {
                    if (explode('_', $key)[0] == 'personne') {
                        $personne_total = $personne_total + intval($value);
                        $_personne = TypePersonne::find(explode('_', $key)[1]);
                        $_personne['nb'] = intval($value);
                        $personne[] = $_personne;
                    }
                }

                $tarif = [
                    'marge' => 0,
                    'aller' => 0,
                    'aller_retour' => 0,
                ];
                $personne_exist = [];
                $data->put('tarif', collect($data['tarif'])->map(function ($data_tarif) use ($customer_search, $personne, &$tarif, &$personne_exist) {
                    $data_tarif = collect($data_tarif);
                    $id_array_pers = array_map(function ($pers) use ($data_tarif, &$personne_exist) {
                        $type_pers = TypePersonne::where(['model' => BilleterieMaritime::class, 'model_id' => $data_tarif['billeterie_maritime_id'], 'type' => $pers->type])->first();

                        if ($type_pers != null && $type_pers->original_id == $pers->id) {
                            $type_pers->nb = $pers->nb;
                            $personne_exist[] = $type_pers;
                        }
                        return $type_pers ? $type_pers->id : 0;
                    }, $personne);

                    if (($key = array_search($data_tarif['type_personne_id'], $id_array_pers)) !== false) {

                        $tarif = [
                            'marge' => $tarif['marge'] + (intval($data_tarif['marge_aller']) * intval($personne[$key]['nb'])) + ($customer_search->parcours == 2 ? (intval($data_tarif['marge_aller_retour']) * intval($personne[$key]['nb'])) : 0),
                            'aller' => $tarif['aller'] + (intval($data_tarif['prix_vente_aller']) * intval($personne[$key]['nb'])),
                            'aller_retour' => $tarif['aller_retour'] + (intval($data_tarif['prix_vente_aller_retour']) * intval($personne[$key]['nb'])),
                        ];
                        $data_tarif->put('nb', intval($personne[$key]['nb']));
                    } else {
                        $data_tarif->put('nb', 0);
                    }

                    return $data_tarif;
                }));

                $data->put('personne', $personne_exist);
                $data->put('date_depart', $customer_search->date_depart);
                $data->put('date_retour', isset($customer_search->date_retour) ? $customer_search->date_retour : null);
                $data->put('parcours', $customer_search->parcours);
                $data->put('tarif_calculer', $tarif);
                $data->put('reference_prix', collect($data['tarif'])->min($customer_search->parcours == 2 ? 'prix_vente_aller_retour' : 'prix_vente_aller'));

                $planing_time_aller = PlaningTime::where(['id_model' => 'billeterie_maritime_' . $data['id']])
                    ->where(function ($query) use ($customer_search) {
                        if (isset($customer_search->date_depart)) {
                            $date = parse_date($customer_search->date_depart);
                            $query->where('availability', 'like', '%' . ($date->dayOfWeek == 0 ? 6 : $date->dayOfWeek - 1) . '%');
                        } else {
                            $query->where(['id' => 0]);
                        }
                    })->get();

                $planing_time_aller = collect($planing_time_aller)->filter(function ($data_time) {
                    return $data_time->debut != null;
                })->values();

                $data->put('planing_time_aller', $planing_time_aller);

                if ($customer_search->parcours == 2) {
                    $planing_time_retour = PlaningTime::where(['id_model' => 'billeterie_maritime_' . $data['id']])
                        ->where(function ($query) use ($customer_search) {
                            if (isset($customer_search->date_retour)) {
                                $date = parse_date($customer_search->date_retour);
                                $query->where('availability', 'like', '%' . ($date->dayOfWeek == 0 ? 6 : $date->dayOfWeek - 1) . '%');
                            }
                        })->get();

                    $planing_time_retour = collect($planing_time_retour)->filter(function ($data_time) {
                        return $data_time->fin != null;
                    })->values();

                    $data->put('planing_time_retour', $planing_time_retour);
                }
                //
                return $data;
            })->filter(function ($data) use ($personne_total, $customer_search) {
                return ($customer_search->parcours == 2 && count($data['planing_time_retour']) && count($data['tarif']) > 0 && count($data['planing_time_aller']) > 0 && $data['quantite'] >= $personne_total) ||
                    ($customer_search->parcours == 1 && count($data['tarif']) > 0 && count($data['planing_time_aller']) > 0 && $data['quantite'] >= $personne_total);
            })->values();

            $data->setCollection($personne_total > 0 ? $collection : collect([]));
        } else {
            $data->setCollection(collect([]));
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        /* port */
        $port_grouped = [];
        $trie = [];
        $port = ServicePort::with(['ville'])->get();
        $port = collect($port)->map(function ($_port) {
            $_port->related_id = collect(BilleterieMaritime::select('lieu_arrive_id')->where(['lieu_depart_id' => $_port->id])->get())->map(function ($data) {
                return $data->lieu_arrive_id;
            })->values();
            return $_port;
        });
        //dd(json_decode(json_encode($port)));
        $port = $port->map(function ($data) use (&$port_grouped, $trie) {

            if (($key = array_search($data->ville_id, $trie)) !== false) {
                $port_grouped[$key][] = $data;
            } else {
                $port_grouped[count($trie)][] = $data;
                $trie[] = $data->ville_id;
            }
            return $data;
        });
        return $this->viewCustom('front.billetterie-maritime.billetteries', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'aside' => [
                'port' => $port_grouped,
                'personne' => TypePersonne::whereNull('model')->whereNull('model_id')->get(),
            ]
        ]);
    }
}
