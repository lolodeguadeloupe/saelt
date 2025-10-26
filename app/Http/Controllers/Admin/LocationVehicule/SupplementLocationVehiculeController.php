<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\SupplementLocationVehicule\IndexSupplementLocationVehicule;
use App\Models\LocationVehicule\ConducteurSupplemetaireLocationVehicule;
use App\Models\LocationVehicule\SupplementJeuneConducteurLocationVehicule;
use App\Models\LocationVehicule\VehiculeLocation;
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

class SupplementLocationVehiculeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSupplementLocationVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexSupplementLocationVehicule $request, VehiculeLocation $locationVehicule)
    {
        $supplementLocationVehicule = collect([
            'jeune_conducteur' => SupplementJeuneConducteurLocationVehicule::all(),
            'conducteur_supplementaire' => ConducteurSupplemetaireLocationVehicule::all()
        ]);

        if ($request->ajax()) {
            return ['data' => $supplementLocationVehicule];
        }

        return view('admin.location-vehicule.supplement-location-vehicule.index', [
            'data' => $supplementLocationVehicule,
            'vehiculeLocation' => $locationVehicule
            ]);
    }
}
