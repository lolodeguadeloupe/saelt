<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BilleterieMaritime;
use Illuminate\Http\Request;
use App\Models\Ile;
use App\Models\LocationVehicule\AgenceLocation;
use App\Models\ServicePort;
use App\Models\TransfertVoyage\LieuTransfert;
use App\Models\TransfertVoyage\TrajetTransfertVoyage;
use Brackets\AdminListing\AdminListing;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);
        //
        $data = AdminListing::create(Ile::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['hebergement']);
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
            return count($data->hebergement);
        });
        $data->setCollection($collection);

        /* port */
        $port_grouped = [];
        $trie = [];
        $port = ServicePort::with(['ville'])->get();
        $port = collect($port)->map(function ($_port) {
            $_port->related_id = collect(BilleterieMaritime::select('lieu_arrive_id')->where(['lieu_depart_id' => $_port->id])->get())->map(function($data){
                return $data->lieu_arrive_id;
            })->values();
            return $_port;
        });
        $port = $port->map(function ($data) use (&$port_grouped, $trie) {

            if (($key = array_search($data->ville_id, $trie)) !== false) {
                $port_grouped[$key][] = $data;
            } else {
                $port_grouped[count($trie)][] = $data;
                $trie[] = $data->ville_id;
            }
            return $data;
        });
        /* lieu */
        $lieu_grouped = [];
        $trie = [];
        $lieu = LieuTransfert::with(['ville'])->get();
        $lieu = collect($lieu)->map(function($_lieu){
            $_lieu->related_id = collect(TrajetTransfertVoyage::join('tarif_transfert_voyage','tarif_transfert_voyage.trajet_transfert_voyage_id','trajet_transfert_voyage.id')->select('trajet_transfert_voyage.point_arrive')->where(['trajet_transfert_voyage.point_depart' => $_lieu->id])->get())->map(function($data){
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

        return $this->viewCustom('front.home', [
            'data' => $data,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'aside' => [
                'port' => $port_grouped,
                'lieu' => $lieu_grouped,
                'agence_location' => AgenceLocation::all()
            ]
        ]);
    }
}
