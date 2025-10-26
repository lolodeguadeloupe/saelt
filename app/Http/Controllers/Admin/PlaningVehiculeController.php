<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlaningVehicule\BulkDestroyPlaningVehicule;
use App\Http\Requests\Admin\PlaningVehicule\DestroyPlaningVehicule;
use App\Http\Requests\Admin\PlaningVehicule\IndexPlaningVehicule;
use App\Http\Requests\Admin\PlaningVehicule\StorePlaningVehicule;
use App\Http\Requests\Admin\PlaningVehicule\UpdatePlaningVehicule;
use App\Models\LigneCommandeLocation;
use App\Models\LocationVehicule\VehiculeLocation;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PlaningVehiculeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPlaningVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexPlaningVehicule $request)
    {
        $month = isset($request->month) ? $request->month : Carbon::now()->format('m');
        $year = isset($request->year) ? $request->year : Carbon::now()->format('Y');
        $length_month = isset($request->length_month) ? $request->length_month : 0;
        $vehicule_selected = [];
        if (isset($request->categorie_id) && $request->categorie_id != "null") {
            $vehicule_selected = VehiculeLocation::with(['categorie'])->where(['categorie_vehicule_id' => $request->categorie_id, 'entite_modele' => 'location_vehicule'])->get();
        } else if (isset($request->location_id) && $request->location_id != "null") {
            $vehicule_selected = VehiculeLocation::with(['categorie'])->where(['id' => $request->location_id])->get();
        } else {
            $vehicule_selected = VehiculeLocation::with(['categorie'])->where(['entite_modele' => 'location_vehicule'])->limit(10)->get();
        }
        $location_id = collect($vehicule_selected)->map(function ($data) {
            return $data->id;
        })->values();

        $debut = Carbon::createFromDate($year, $month, 1);
        $fin = ((Carbon::createFromDate($year, $month, 1))->addMonth($length_month + 1))->addDay(-1);
        $option = ['location_vehicule', 'vehicule_transfert_voyage'];
        $vehicule = LigneCommandeLocation::select('ligne_commande_location.*')
            ->join('commande', 'commande.id', 'ligne_commande_location.commande_id')
            ->with(['commande' => function ($query) {
                $query->with(['facture']);
            }])
            ->whereIn('location_id', $location_id)
            ->whereDate('date_recuperation', '>=', DB::raw("date('{$debut->toDateString()}')"))
            ->whereDate('date_recuperation', '<=', DB::raw("date('{$fin->toDateString()}')"))
            ->whereIn('commande.status', ['1'])
            ->get();
        $vehicule_not_allowed = VehiculeLocation::with(['marque', 'modele', 'categorie' => function ($query) {
            $query->with(['famille']);
        }])
            ->where(function ($query) use ($request, $vehicule) {
                $query->where(['entite_modele' => 'location_vehicule']);
                if (isset($request->categorie_id) && $request->categorie_id != "null") {
                    $query->whereNotIn('id', collect($vehicule)->map(function ($data) {
                        return $data->location_id;
                    })->values())
                        ->where(['categorie_vehicule_id' => $request->categorie_id]);
                } else if (isset($request->location_id) && $request->location_id != "null") {
                    if (count($vehicule) == 0) {
                        $query->where('id', $request->location_id);
                    } else {
                        $query->where('id', 0);
                    }
                } else {
                    $query->whereNotIn('id', collect($vehicule)->map(function ($data) {
                        return $data->location_id;
                    })->values());
                }
            })->get();
        $vehicule_not_allowed = collect($vehicule_not_allowed)->map(function ($data) {
            $data = json_decode(json_encode($data));
            $data->location_id = $data->id;
            $data->titre = $data->titre;
            $data->marque_vehicule_id = 1;
            $data->marque_vehicule_titre = $data->marque->titre;
            $data->modele_vehicule_titre = $data->modele->titre;
            $data->categorie_vehicule_titre = $data->categorie->titre;
            $data->famille_vehicule_id = $data->categorie->famille->id;
            $data->famille_vehicule_titre = $data->categorie->famille->titre;
            return $data;
        });
        $vehicule = collect($vehicule)->mergeRecursive($vehicule_not_allowed);
        $vehicule = collect($vehicule)->groupBy('categorie_vehicule_id')->values();
        $vehicule = collect($vehicule)->map(function ($data) {
            return collect($data)->groupBy('location_id')->values();
        });
        //dd(json_decode(json_encode($vehicule)));
        if ($request->ajax()) {
            return [
                'option' => $option,
                'vehicule' => $vehicule,
                'month' => intval($month),
                'year' => $year,
            ];
        }
        return view('admin.planing-vehicule.index', ['data' => collect([
            'option' => $option,
            'vehicule' => $vehicule,
            'month' => intval($month),
            'year' => $year,
        ])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePlaningVehicule $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePlaningVehicule $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePlaningVehicule $request
     * @param PlaningVehicule $planingVehicule
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePlaningVehicule $request, $planingVehicule)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPlaningVehicule $request
     * @param PlaningVehicule $planingVehicule
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPlaningVehicule $request,  $planingVehicule)
    {
    }
}
