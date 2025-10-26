<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChambreEnCommande;
use App\Models\GestionRequestUtilisateur;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class GestionRequestUtilisateurController extends Controller
{

    protected $identifiant_session = "utilisateur_request_front";
    protected $name = 'request_user';

    public function putRequest(Request $request)
    {

        if (!$request->ajax()) {
            abort(404);
        }

        $this->identifiant_session = bin2hex(random_bytes(20));

        if (count($request->all())) {
            //$request->session()->put($this->identifiant_session, $request->all());
            $Request = new GestionRequestUtilisateur;
            $Request->session_id = $request->session()->getId();
            $Request->identifiant_session = $this->identifiant_session;
            $Request->name = $this->name;
            $Request->data = json_encode($request->all());
            $Request->save();
        }

        //$request->session()->forget($this->identifiant_session);

        return [
            'key' => $this->identifiant_session
        ];
    }

    public static function putIdentifiantKey($data)
    {
        $identifiant_session = bin2hex(random_bytes(20));

        $Request = new GestionRequestUtilisateur;
        $Request->identifiant_session = $identifiant_session;
        $Request->name = 'request_user';
        $Request->data = json_encode($data);
        $Request->save();

        return [
            'key' => $identifiant_session
        ];
    }

    public static function getUniqueKeyRequest(Request $request, $redirect = true)
    {
        if (isset($request->key_)) {
            $Request = GestionRequestUtilisateur::where([
                'session_id' => $request->session()->getId(),
                'identifiant_session' => $request->key_,
                'name' => 'request_user'
            ])->first();

            if ($Request) {
                $Request->updated_at = Carbon::now();
                $Request->save();
                $Request = $Request->getData();
                return $Request->data;
            }

            abort(404);
            //return $request->session()->get($request->key_);
        } else if ($redirect) {
            abort(404);
        } else {
            return null;
        }
    }

    public static function getUniqueKeyIdentifiant(Request $request, $redirect = true)
    {
        if (isset($request->key_)) {
            $Request = GestionRequestUtilisateur::where([
                'identifiant_session' => $request->key_,
                'name' => 'request_user'
            ])->first();

            if ($Request) {
                $Request->updated_at = Carbon::now();
                $Request->save();
                $Request = $Request->getData();
                return $Request->data;
            }

            abort(404);
            //return $request->session()->get($request->key_);
        } else if ($redirect) {
            abort(404);
        } else {
            return null;
        }
    }

    public static function updateSessionId(Request $request, $session_id) 
    {
        $session = GestionRequestUtilisateur::where([
            'session_id' => $session_id
        ])->update(['session_id' => $request->session()->getId()]);
        if ($session) {
            ChambreEnCommande::where([
                'session_id' => $session_id
            ])->update(['session_id' => $request->session()->getId()]);
        }
    }

    public static function delete_request_timeout()
    {
        collect(GestionRequestUtilisateur::where([
            'name' => 'request_user'
        ])->get())->map(function ($data) {
            $created = Carbon::parse($data->updated_at);
            $time = $data->timeout ? $data->timeout : 1800000;
            /*if (Carbon::now()->diffInMilliseconds($created) >= intval($time)) {
                $data->delete();
            }*/
        });
    }
}
