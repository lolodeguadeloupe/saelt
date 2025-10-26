<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\AutocompletionVehiculeLocation;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\BulkDestroyVehiculeLocation;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\DestroyVehiculeLocation;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\IndexVehiculeLocation;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\StoreVehiculeLocation;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\UpdateVehiculeLocation;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\StoreVehiculeLocationPrestataire;
use App\Http\Requests\Admin\LocationVehicule\VehiculeLocation\UpdateVehiculeLocationPrestataire;
use App\Models\Prestataire;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\LocationVehicule\VehiculeInfoTech;
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

class VehiculeLocationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVehiculeLocation $request
     * @return array|Factory|View
     */
    public function index(IndexVehiculeLocation $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VehiculeLocation::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('prestataire', 'prestataire.id', 'vehicule_location.prestataire_id');
                $query->join('categorie_vehicule', 'categorie_vehicule.id', 'vehicule_location.categorie_vehicule_id');
                $query->join('famille_vehicule', 'famille_vehicule.id', 'categorie_vehicule.famille_vehicule_id');
                $query->with(['prestataire', 'marque', 'modele', 'info_tech', 'categorie' => function ($query) {
                    $query->with(['famille']);
                }]);
                $query->where(['entite_modele' => 'location_vehicule']);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'status', 'duration_min', 'prestataire_id', 'categorie_vehicule_id', 'franchise', 'franchise_non_rachatable', 'caution'],
                // set columns to searchIn
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'franchise', 'franchise_non_rachatable', 'caution', 'description', 'prestataire.name', 'categorie.titre', 'categorie_vehicule.titre', 'famille_vehicule.titre']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.location-vehicule.vehicule-location.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.vehicule-location.create');

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVehiculeLocation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVehiculeLocation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Store the VehiculeLocation
        $sanitized['entite_modele'] = 'location_vehicule';
        $vehiculeLocation = VehiculeLocation::create($sanitized);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $vehiculeLocation->id . '_vehicule_location';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $vehiculeLocation->id . '_vehicule_location';
            \App\Models\EventDateHeure::create($value);
        }

        $vehiculeLocation = VehiculeLocation::with(['prestataire', 'info_tech', 'categorie' => function ($query) {
            $query->with(['famille']);
        }])->find($vehiculeLocation->id);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeLocation' => $vehiculeLocation,
            ];
        }

        return redirect('admin/vehicule-locations');
    }

    public function storewithprestataire(StoreVehiculeLocationPrestataire $request)
    {
        // Sanitize input
        $sanitizedVehicule = $request->getSanitizedVehicule();

        $sanitizedPrest = $request->getSanitizedPrestataire();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        $vehicule = null;

        if ((isset($sanitizedVehicule['prestataire_id']) && $sanitizedVehicule['prestataire_id'] == '') || !isset($sanitizedVehicule['prestataire_id'])) {
            $prestataire = Prestataire::create($sanitizedPrest);
        } else {
            $prestataire = Prestataire::find($sanitizedVehicule['prestataire_id']);
        }

        $sanitizedVehicule['prestataire_id'] = $prestataire->id;

        // Store the Hebergement
        $sanitizedVehicule['entite_modele'] = 'location_vehicule';
        $vehiculeLocation = VehiculeLocation::create($sanitizedVehicule);

        //info tech
        $infoTech = $request->getInfoTechnique();
        $infoTech['vehicule_id'] = $vehiculeLocation->id;
        if (VehiculeInfoTech::where(['vehicule_id' => $vehiculeLocation->id])->count() > 0) {
            VehiculeInfoTech::where(['vehicule_id' => $vehiculeLocation->id])->update($infoTech);
        } else {
            VehiculeInfoTech::create($infoTech);
        }

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $vehiculeLocation->id . '_vehicule_location';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $vehiculeLocation->id . '_vehicule_location';
            \App\Models\EventDateHeure::create($value);
        }

        $vehiculeLocation = VehiculeLocation::with(['prestataire', 'info_tech', 'categorie' => function ($query) {
            $query->with(['famille']);
        }])->find($vehiculeLocation->id);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeLocation' => $vehiculeLocation,
            ];
        }

        return redirect('admin/vehicule-locations');
    }

    /**
     * Display the specified resource.
     *
     * @param VehiculeLocation $vehiculeLocation
     * @throws AuthorizationException
     * @return void
     */
    public function show(\Illuminate\Http\Request $request, VehiculeLocation $vehiculeLocation)
    {
        $this->authorize('admin.vehicule-location.show', $vehiculeLocation);

        $vehiculeLocation = VehiculeLocation::with(['prestataire' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'categorie' => function ($qeury) {
            $qeury->with(['famille']);
        }, 'marque', 'modele', 'info_tech'])->find($vehiculeLocation->id);

        if ($request->ajax()) {
            return [
                'data' => $vehiculeLocation,
            ];
        }

        return view('admin.location-vehicule.vehicule-location.detail', [
            'data' => json_encode($vehiculeLocation),
            'vehiculeLocation' => $vehiculeLocation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VehiculeLocation $vehiculeLocation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VehiculeLocation $vehiculeLocation)
    {
        $this->authorize('admin.vehicule-location.edit', $vehiculeLocation);


        if (!$this->request->ajax()) {
            abort(404);
        }

        $vehiculeLocation = VehiculeLocation::with(['prestataire' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'categorie' => function ($qeury) {
            $qeury->with(['famille']);
        }, 'marque', 'modele', 'info_tech'])->find($vehiculeLocation->id);
        return [
            'vehiculeLocation' => $vehiculeLocation,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVehiculeLocation $request
     * @param VehiculeLocation $vehiculeLocation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVehiculeLocation $request, VehiculeLocation $vehiculeLocation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();


        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Update changed values VehiculeLocation
        $vehiculeLocation->update($sanitized);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $vehiculeLocation->id . '_vehicule_location';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $vehiculeLocation->id . '_vehicule_location';
            \App\Models\EventDateHeure::create($value);
        }

        $vehiculeLocation = VehiculeLocation::with(['prestataire' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'categorie' => function ($qeury) {
            $qeury->with(['famille']);
        }, 'marque', 'modele', 'info_tech'])->find($vehiculeLocation->id);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeLocation' => $vehiculeLocation,
            ];
        }

        return redirect('admin/vehicule-locations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVehiculeLocation $request
     * @param VehiculeLocation $vehiculeLocation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVehiculeLocation $request, VehiculeLocation $vehiculeLocation)
    {
        $vehiculeLocation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVehiculeLocation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVehiculeLocation $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VehiculeLocation::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function updatePrestataire(UpdateVehiculeLocationPrestataire $request, VehiculeLocation $vehiculeLocation, Prestataire $prestataire)
    {

        $vehiculeLocation['prestataire_id'] = $prestataire->id;
        $vehiculeLocation->update();

        $vehiculeLocation = VehiculeLocation::with(['prestataire' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'categorie' => function ($qeury) {
            $qeury->with(['famille']);
        }])->find($vehiculeLocation->id);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeLocation' => $vehiculeLocation,
            ];
        }

        return redirect('admin/vehicule-locations');
    }

    public function calendar($vehiculeLocation)
    {
        $vehiculeLocation = VehiculeLocation::find($vehiculeLocation);
        return [
            'vehiculeLocation' => $vehiculeLocation,
            'calendar' => $vehiculeLocation ? \App\Models\EventDateHeure::where(['model_event' => $vehiculeLocation->id . '_vehicule_location'])->get() : []
        ];
    }

    public function autocompletion(AutocompletionVehiculeLocation $request)
    {
        $sanitized = $request->getSanitized();

        $search = VehiculeLocation::where('titre', 'like', '%' . $sanitized['search'] . '%')->where(['entite_modele' => 'location_vehicule'])
            ->where(function ($query) use ($request) {
                if (isset($request->categorie_vehicule_id) && $request->categorie_vehicule_id != "null") {
                    $query->where(['categorie_vehicule_id' => $request->categorie_vehicule_id]);
                }
            })
            ->with(['modele', 'marque', 'categorie'])
            ->limit(20)
            ->get();

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'search' => $search,
        ];
    }
}
