<?php

namespace App\Http\Controllers;

use App\Exports\AttemptTask;
use App\Http\Controllers\Admin\CoupCoeurProduitController;
use App\Http\Controllers\Front\GestionCommandeUtilisateurController;
use App\Http\Controllers\Front\GestionRequestUtilisateurController;
use App\Http\Controllers\Front\HomeController;
use App\Models\GestionRequestUtilisateur;
use App\Models\Ile;
use App\Models\ModePayement;
use App\Models\Prestataire;
use App\Models\Produit;
use App\Models\Saison;
use App\Models\ServicePort;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use App\Models\TypePersonne;
use App\Models\Ville;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $request;
    protected $typeSupplement;
    protected $selfAttempt = [
        'GestionCommandeUtilisateurController@deleteCommandeTimeout'
    ];

    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
        $this->typeSupplement = collect([
            ['id' => 1, 'value' => 'dejeneur', 'icon' => 'assets/img/supplement/repas.png'],
            ['id' => 2, 'value' => 'activite', 'icon' => 'assets/img/supplement/activity.png'],
            ['id' => 3, 'value' => 'autres', 'icon' => 'assets/img/supplement/autre.png']
        ])->map(function ($data) {
            $data = collect($data)->put('label', trans('admin.supplement-excursion.type.' . $data['value']));
            return $data;
        });
        /** delete commande timeout */
        GestionCommandeUtilisateurController::delete_commande_timeout();
        /* delete request timeout */
        GestionRequestUtilisateurController::delete_request_timeout();
        /* attempts controller at other controller */
        if (Route::current() != null && preg_match("/^admin\/./", Route::current()->getName())) {
            $this->attemptParentFront();
        } else if (Route::current() != null) {
            $model = null;
            if (preg_match("/^hebergements/", Route::current()->getName()) || preg_match("/^hebergements\/./", Route::current()->getName())) {
                $model = Produit::where(['sigle' => 'hebergement'])->first();
            }
            if (preg_match("/^excursions/", Route::current()->getName()) || preg_match("/^excursions\/./", Route::current()->getName())) {
                $model = Produit::where(['sigle' => 'excursion'])->first();
            }
            if (preg_match("/^locations/", Route::current()->getName()) || preg_match("/^locations\/./", Route::current()->getName())) {
                $model = Produit::where(['sigle' => 'location'])->first();
            }
            if (preg_match("/^billetteries/", Route::current()->getName()) || preg_match("/^billetteries\/./", Route::current()->getName())) {
                $model = Produit::where(['sigle' => 'billetterie'])->first();
            }
            if (preg_match("/^transferts/", Route::current()->getName()) || preg_match("/^transferts\/./", Route::current()->getName())) {
                $model = Produit::where(['sigle' => 'transfert'])->first();
            }
            if ($model != null) {
                $this->controleStatusProduitFront($model);
            }
        }
    }

    protected function attemptParentFront()
    {
        if (!in_array(class_basename(Route::currentRouteAction()), $this->selfAttempt)) {
            /*AttemptTask::passer(url("timeout-commande"), [
                'parms' => []
            ], 'test_test');*/
        }
    }

    protected function controleStatusProduitFront($model)
    {
        if ($model->status == 0) {
            return redirect()->to('/')->send();
        }
    }

    protected function viewCustom($view = null, $data = [], $mergeData = [])
    {
        $commande = GestionCommandeUtilisateurController::all($this->request);
        $count_commande = 0;
        collect($commande)->map(function ($first_item) use (&$count_commande) {
            $count_commande = $count_commande + collect($first_item)->count();
        });
        /** */
        $produdit = [];
        foreach (Produit::all() as $key => $value) {
            $produdit[$value->sigle] = $value;
        }

        /** */
        $partenaire = Prestataire::all();
        $flot = collect(TypeTransfertVoyage::with(['vehicule'])->get())->map(function ($data) {
            $data = json_decode(json_encode($data));
            $data->vehicule = collect($data->vehicule)->map(function ($vehicule) {
                return collect($vehicule->image)->map(function ($data) {
                    return $data->name;
                })->first();
            })->first();
            return $data;
        });
        $paiement = ModePayement::all();
        /* */
        $aside = collect(collect($data)->get('aside', []));
        $aside->put('produit', $produdit);
        $aside->put('ile', Ile::all());
        $aside->put('ville', Ville::all());
        $aside->put('personne', TypePersonne::whereNull('model')->whereNull('model_id')->get());
        $aside->put('coup_coeur', CoupCoeurProduitController::all_coup_coeur());
        $aside->put('count_commande', $count_commande);
        $aside->put('partenaire', json_decode(json_encode($partenaire)));
        $aside->put('flot', json_decode(json_encode($flot)));
        $aside->put('paiement', json_decode(json_encode($paiement)));
        /* */
        $data['aside'] = $aside->toJson();
        return view($view, $data, $mergeData);
    }

    public static function rangerSaison($sasion)
    {
        $debut = Carbon::parse($sasion['debut']);
        $fin = Carbon::parse($sasion['fin']);
        if (($fin->month < $debut->month) || ($fin->month == $debut->month && $fin->day < $debut->day)) {
            if (now()->month > $fin->month || (now()->month == $debut->month && now()->day > $fin->day)) {
                $debut->year(now()->year);
                $fin->year(now()->year + 1);
            } else {
                $debut->year(now()->year - 1);
                $fin->year(now()->year);
            }
        } else {
            if (now()->month > $fin->month || (now()->month == $debut->month && now()->day > $fin->day)) {
                $debut->year(now()->year + 1);
                $fin->year(now()->year + 1);
            } else {
                $debut->year(now()->year);
                $fin->year(now()->year);
            }
        }
        return [
            'debut' => $debut,
            'fin' => $fin
        ];
    }
}

/**
 * 
 * 
 * if (($fin->month < $debut->month) || ($fin->month == $debut->month && $fin->day < $debut->day)) {
            if (now()->month > $debut->month || (now()->month == $debut->month && now()->day > $debut->day)) {
                $debut->year(now()->year);
                $fin->year(now()->year + 1);
            } else if (now()->month < $fin->month || (now()->month == $fin->month && now()->day < $fin->day)) {
                $debut->year(now()->year);
                $fin->year(now()->year);
            } else {
                $debut->year(now()->year);
                $fin->year(now()->year + 1);
            }
        } else {
            if (now()->month < $debut->month || (now()->month == $debut->month && now()->day < $debut->day)) {
                $debut->year(now()->year);
                $fin->year(now()->year);
            } else if (now()->month > $fin->month || (now()->month == $fin->month && now()->day > $fin->day)) {
                $debut->year(now()->year + 1);
                $fin->year(now()->year + 1);
            } else {
                $debut->year(now()->year);
                $fin->year(now()->year + 1);
            }
        }
 */
