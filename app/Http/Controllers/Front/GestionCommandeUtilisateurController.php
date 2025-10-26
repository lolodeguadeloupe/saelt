<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChambreEnCommande;
use App\Models\GestionRequestUtilisateur;
use App\Models\Hebergement\TypeChambre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GestionCommandeUtilisateurController extends Controller
{

    protected $commande = "utilisateur_commande";
    protected $identifiant_session;
    protected $name = 'commande_session';


    public function putCommande(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $timeout = env("REQUEST_SESSION", 1800000); // 30 minutes

        if ($request->commande == 'hebergement') {
            $chambre = TypeChambre::find(json_decode($request->data)->item->type_chambre_id);
            $chambre_commande_other = ChambreEnCommande::where([
                'chambre_id' => json_decode($request->data)->item->type_chambre_id
            ])->where(function ($query) use ($request) {
                if ($request->edit_pannier == 'true') {
                    $query->whereNotIn('session_id', [$request->session()->getId()])
                        ->whereNotIn('commande_id', [$request->index_commande]);
                }
            })->get();
            $chambre_dispo = intval($chambre->nombre_chambre) - intval(collect($chambre_commande_other)->sum('nombre'));

            if ($chambre_dispo < intval($request->form['nb_chambre'])) {
                return response()
                    ->json(['error_cmd' => 'Votre commande n\'est pas disponible! '], 422);
            }
        }


        $all_request = $request->all();
        if (!isset($request->date_commande) || $request->date_commande == null) {
            $all_request['date_commande'] = time();
        }
        $this->identifiant_session = bin2hex(random_bytes(20));
        $commande_store = collect([]);
        $request_commande = GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => $this->name
        ])->first();

        if ($request_commande) {
            $request_commande->getData();
            $commande_store =  collect($request_commande->data);
        } else {
            $request_commande = new GestionRequestUtilisateur;
            $request_commande->session_id = $request->session()->getId();
            $request_commande->identifiant_session = $this->identifiant_session;
            $request_commande->name = $this->name;
            /*$Request->data = json_encode($request->all());
            $Request->save();*/
        }

        $sub_commande = collect($commande_store)->get($request->commande, collect([]));
        $sub_commande = collect($sub_commande)->filter(function ($data, $index) use ($request) {
            if ($request->edit_pannier == 'true' && $request->index_commande == $index) {
                if ($request->commande == 'hebergement') {
                    ChambreEnCommande::where([
                        'chambre_id' => json_decode($data->data)->item->type_chambre_id,
                        'session_id' => $request->session()->getId(),
                    ])->delete();
                }
                return false;
            }
            return true;
        })->values();
        /** */
        $sub_commande = $sub_commande->map(function ($data, $index) {
            $data = collect($data)->put('index_produit', $index);
            return $data;
        });
        $all_request['index_produit'] = count($sub_commande);
        /** */
        $sub_commande->push($all_request);
        /** */
        if ($request->commande == 'hebergement') {
            ChambreEnCommande::create([
                'nombre' => intval($request->form['nb_chambre']),
                'chambre_id' => json_decode($request->data)->item->type_chambre_id,
                'session_id' => $request_commande->session_id,
                'commande_id' => $all_request['index_produit'],
                'date' => $all_request['date_commande'],
                'date_debut' => parse_date(Carbon::createFromFormat('d/m/Y', json_decode($request->computed)->dateDebutCalendar)),
                'date_fin' => parse_date(Carbon::createFromFormat('d/m/Y', json_decode($request->computed)->dateEndCalendar)),
            ]);
        }

        $commande_store->put($request->commande, $sub_commande);
        /** */
        $request_commande->data = json_encode($commande_store);
        $request_commande->timeout = $timeout;
        $request_commande->save();
        /** */
        return collect($all_request);
    }

    public function deleteCommande(Request $request)
    {

        if (!$request->ajax()) {
            abort(404);
        }
        $commande_store = collect([]);
        $request_commande = GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => $this->name
        ])->first();

        if ($request_commande) {
            $request_commande->getData();
            $commande_store =  collect($request_commande->data);
        } else {
            return collect([]);
        }
        $sub_commande = collect($commande_store)->get($request->commande, collect([]));
        $sub_commande = collect($sub_commande)->filter(function ($data, $index) use ($request) {
            if (collect($data)->get('id') == $request->id && $request->index_produit == $index) {
                if ($request->commande == 'hebergement') {
                    ChambreEnCommande::where([
                        'chambre_id' => json_decode($data->data)->item->type_chambre_id,
                        'session_id' => $request->session()->getId(),
                        'commande_id' => $index
                    ])->delete();
                }
                return false;
            }
            return true;
        })->values();
        $sub_commande = $sub_commande->map(function ($data, $index) {
            return collect($data)->put('index_produit', $index);
        });
        $commande_store->put($request->commande, $sub_commande);
        /** */
        $request_commande->data = json_encode($commande_store);
        $request_commande->save();
        /** */
        return PanierController::transform_panier(GestionCommandeUtilisateurController::all($request));
    }

    public function allCommande(Request $request)
    {
        $request_commande = GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => $this->name
        ])->first();
        if ($request_commande) {
            $request_commande->getData();
            return collect($request_commande->data);
        } else {
            return collect([]);
        }
    }

    public static function all(Request $request)
    {
        $request_commande = GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => 'commande_session'
        ])->first();

        if ($request_commande) {
            $request_commande->getData();
            return collect($request_commande->data);
        } else {
            return collect([]);
        }
    }

    public static function modifier(Request $request, $commande, $commande_id, $date_commande)
    {
        $commande_store = collect([]);
        $request_commande = GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => 'commande_session'
        ])->first();

        if ($request_commande) {
            $request_commande->getData();
            $commande_store =  collect($request_commande->data);
        } else {
            return collect([]);
        }

        $sub_commande = $commande_store->get($commande, collect([]));
        $sub_commande = collect($sub_commande)->filter(function ($data) use ($commande_id, $date_commande) {
            return collect($data)->get('id') == $commande_id && collect($data)->get('date_commande') == $date_commande;
        })->values();
        return $sub_commande;
    }

    public static function delete_all(Request $request)
    {
        return GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => 'commande_session'
        ])->delete() &&
            ChambreEnCommande::where([
                'session_id' => $request->session()->getId()
            ])->delete();;
    }

    public static function  identifiantSession(Request $request)
    {
        $_session = GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => 'commande_session'
        ])->first();
        return $_session != null ? $_session->identifiant_session : null;
    }

    public function checkCommandeTimeout(Request $request)
    {
        $count_commande = 0;
        $delay_commande = [];
        collect(GestionRequestUtilisateur::where([
            'session_id' => $request->session()->getId(),
            'name' => 'commande_session'
        ])->get())->map(function ($data) use (&$count_commande, &$delay_commande) {
            foreach (json_decode($data->data) as $key => $value) {
                $count_commande = $count_commande + count($value);
            }
            $time = $data->timeout ? intval($data->timeout) : 1800000;
            $delay = $time - Carbon::now()->diffInMilliseconds($data->created_at);
            if ($delay > 0) {
                $delay = $delay / 60000;
                $delay_commande[] = $delay > 1 ? intval($delay) : 1;
            } else {
                $delay_commande[] = 0;
            }
        });
        return [
            'commande' => $count_commande,
            'timeout' => [
                'title' => 'Veuillez valider votre commandes',
                'message' => 'Votre commande va bientôt éxpirer dans <b>' . collect($delay_commande)->min() . ' munites</b>'
            ]
        ];
    }

    public static function delete_commande_timeout()
    {
        collect(GestionRequestUtilisateur::where([
            'name' => 'commande_session'
        ])->get())->map(function ($data) {
            $created = Carbon::parse($data->created_at);
            $time = $data->timeout ? $data->timeout : 1800000;
            /*if (Carbon::now()->diffInMilliseconds($created) >= intval($time)) {
                ChambreEnCommande::where([
                    'session_id' => $data->session_id,
                ])->delete();
                $data->delete();
            }*/
        });
    }
}
