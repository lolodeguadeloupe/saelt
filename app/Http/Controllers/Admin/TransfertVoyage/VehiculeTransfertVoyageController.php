<?php

namespace App\Http\Controllers\Admin\TransfertVoyage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage\BulkDestroyVehiculeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage\DestroyVehiculeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage\IndexVehiculeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage\StoreVehiculeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage\UpdateVehiculeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage\StoreVehiculeTransfertVoyagePrestataire;
use App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage\UpdateVehiculeTransfertVoyagePrestataire;
use App\Models\TransfertVoyage\VehiculeTransfertVoyage;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use App\Models\Prestataire;
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

class VehiculeTransfertVoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVehiculeTransfertVoyage $request
     * @return array|Factory|View
     */
    public function index(IndexVehiculeTransfertVoyage $request)
    {

        if (!isset($request->transfert)) {
            abort(404);
        }
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(VehiculeLocation::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('vehicule_transfert_voyage', 'vehicule_transfert_voyage.vehicule_id', 'vehicule_location.id');
                $query->join('prestataire', 'prestataire.id', 'vehicule_location.prestataire_id');
                $query->join('categorie_vehicule', 'categorie_vehicule.id', 'vehicule_location.categorie_vehicule_id');
                $query->join('famille_vehicule', 'famille_vehicule.id', 'categorie_vehicule.famille_vehicule_id');
                $query->with(['prestataire', 'marque', 'modele', 'categorie' => function ($query) {
                    $query->with(['famille']);
                }]);
                $query->where(['entite_modele' => 'vehicule_transfert_voyage']);
                $query->where(['type_transfert_voyage_id' => $request->transfert]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'status', 'duration_min', 'prestataire_id', 'categorie_vehicule_id'],
                // set columns to searchIn
                ['id', 'titre', 'immatriculation', 'marque_vehicule_id', 'modele_vehicule_id', 'description', 'prestataire.name', 'categorie.titre', 'categorie_vehicule.titre', 'famille_vehicule.titre']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        $typeTransfertVoyage = TypeTransfertVoyage::find($request->transfert);

        if ($typeTransfertVoyage == null) {
            abort(404);
        }

        return view('admin.transfert-voyage.vehicule-transfert.index', [
            'data' => $data,
            'typeTransfertVoyage' => $typeTransfertVoyage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.vehicule-transfert-voyage.create');

        if (!isset($this->request->transfert)) {
            abort(404);
        }

        $typeTransfertVoyage = TypeTransfertVoyage::find($this->request->transfert);

        if($typeTransfertVoyage == null){
            abort(404);
        }

        return ['typeTransfertVoyage' => $typeTransfertVoyage];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVehiculeTransfertVoyage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVehiculeTransfertVoyage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        $sanitizedTypeTransfer = $request->getTypeTransfert();

        // Store the VehiculeTransfertVoyage transfert_voyage
        $sanitized['entite_modele'] = 'vehicule_transfert_voyage';
        $vehiculeTransfertVoyage = null;

        DB::transaction(function () use ($sanitized, $sanitizedImage, $sanitizedCalendar, $sanitizedTypeTransfer, &$vehiculeTransfertVoyage) {

            $vehiculeTransfertVoyage = VehiculeLocation::create($sanitized);

            $vehiculeTransfertVoyage->transfert_voyage()->sync([$sanitizedTypeTransfer]);

            foreach ($sanitizedImage['image'] as $value) {
                $input['id_model'] = $vehiculeTransfertVoyage->id . '_vehicule_location';
                $input['name'] = $value;
                \App\Models\MediaImageUpload::create($input);
            }

            foreach ($sanitizedCalendar as $value) {
                $value['model_event'] = $vehiculeTransfertVoyage->id . '_vehicule_location';
                \App\Models\EventDateHeure::create($value);
            }

            $vehiculeTransfertVoyage = VehiculeLocation::with([
                'prestataire', 'categorie' => function ($query) {
                    $query->with(['famille']);
                },
                'transfert_voyage'
            ])->find($vehiculeTransfertVoyage->id);
        });

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeTransfertVoyage' => $vehiculeTransfertVoyage,
            ];
        }

        return redirect('admin/vehicule-transfert-voyages');
    }

    public function storewithprestataire(StoreVehiculeTransfertVoyagePrestataire $request)
    {

        // Sanitize input
        $sanitizedVehicule = $request->getSanitizedVehicule();

        $sanitizedPrest = $request->getSanitizedPrestataire();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        $sanitizedTypeTransfer = $request->getTypeTransfert();

        $sanitizedVehicule['entite_modele'] = 'vehicule_transfert_voyage';

        $vehiculeTransfertVoyage = null;

        DB::transaction(function () use ($sanitizedVehicule, $sanitizedPrest, $sanitizedImage, $sanitizedCalendar, $sanitizedTypeTransfer, &$vehiculeTransfertVoyage) {

            if ((isset($sanitizedVehicule['prestataire_id']) && $sanitizedVehicule['prestataire_id'] == '') || !isset($sanitizedVehicule['prestataire_id'])) {
                $prestataire = Prestataire::create($sanitizedPrest);
            } else {
                $prestataire = Prestataire::find($sanitizedVehicule['prestataire_id']);
            }

            $sanitizedVehicule['prestataire_id'] = $prestataire->id;

            $vehiculeTransfertVoyage = VehiculeLocation::create($sanitizedVehicule);

            $vehiculeTransfertVoyage->transfert_voyage()->sync([$sanitizedTypeTransfer]);

            foreach ($sanitizedImage['image'] as $value) {
                $input['id_model'] = $vehiculeTransfertVoyage->id . '_vehicule_location';
                $input['name'] = $value;
                \App\Models\MediaImageUpload::create($input);
            }

            foreach ($sanitizedCalendar as $value) {
                $value['model_event'] = $vehiculeTransfertVoyage->id . '_vehicule_location';
                \App\Models\EventDateHeure::create($value);
            }

            $vehiculeTransfertVoyage = VehiculeLocation::with([
                'prestataire', 'categorie' => function ($query) {
                    $query->with(['famille']);
                },
                'transfert_voyage'
            ])->find($vehiculeTransfertVoyage->id);
        });


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeTransfertVoyage' => $vehiculeTransfertVoyage,
            ];
        }

        return redirect('admin/vehicule-locations');
    }

    /**
     * Display the specified resource.
     *
     * @param VehiculeTransfertVoyage $vehiculeTransfertVoyage
     * @throws AuthorizationException
     * @return void
     */
    public function show(\Illuminate\Http\Request $request, VehiculeLocation $vehiculeTransfertVoyage)
    {

        $this->authorize('admin.vehicule-transfert-voyage.show', $vehiculeTransfertVoyage);

        if(!isset($request->transfert)){
            abort(404);
        }

        $typeTransfertVoyage = TypeTransfertVoyage::find($request->transfert);

        if($typeTransfertVoyage == null){
            abort(404);
        }

        // TODO your code goes here

        $vehiculeTransfertVoyage = VehiculeLocation::with([
            'prestataire' => function ($query) {
                $query->with(['ville' => function ($query) {
                    $query->with(['pays']);
                }]);
            }, 'categorie' => function ($qeury) {
                $qeury->with(['famille']);
            }, 'marque',
            'modele',
            'transfert_voyage'
        ])->find($vehiculeTransfertVoyage->id);

        if ($request->ajax()) {
            return [
                'data' => $vehiculeTransfertVoyage,
            ];
        }

        return view('admin.transfert-voyage.vehicule-transfert.detail', [
            'data' => json_encode($vehiculeTransfertVoyage),
            'vehiculeTransfertVoyage' => $vehiculeTransfertVoyage,
            'typeTransfertVoyage' => $typeTransfertVoyage
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VehiculeTransfertVoyage $vehiculeTransfertVoyage
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(VehiculeLocation $vehiculeTransfertVoyage)
    {
        $this->authorize('admin.vehicule-transfert-voyage.edit', $vehiculeTransfertVoyage);


        if (!$this->request->ajax()) {
            abort(404);
        }

        $vehiculeTransfertVoyage = VehiculeLocation::with(['prestataire' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }, 'categorie' => function ($qeury) {
            $qeury->with(['famille']);
        }, 'marque', 'modele'])->find($vehiculeTransfertVoyage->id);

        return [
            'vehiculeTransfertVoyage' => $vehiculeTransfertVoyage,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVehiculeTransfertVoyage $request
     * @param VehiculeTransfertVoyage $vehiculeTransfertVoyage
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVehiculeTransfertVoyage $request, VehiculeLocation $vehiculeTransfertVoyage)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        $sanitizedTypeTransfer = $request->getTypeTransfert();

        // Update changed values VehiculeTransfertVoyage

        $vehiculeTransfertVoyage = null;

        DB::transaction(function () use ($sanitized, $sanitizedImage, $sanitizedCalendar, $sanitizedTypeTransfer, &$vehiculeTransfertVoyage) {


            $vehiculeTransfertVoyage->update($sanitized);

            $vehiculeTransfertVoyage->transfert_voyage()->sync([$sanitizedTypeTransfer]);

            foreach ($sanitizedImage['image'] as $value) {
                $input['id_model'] = $vehiculeTransfertVoyage->id . '_vehicule_location';
                $input['name'] = $value;
                \App\Models\MediaImageUpload::create($input);
            }

            foreach ($sanitizedCalendar as $value) {
                $value['model_event'] = $vehiculeTransfertVoyage->id . '_vehicule_location';
                \App\Models\EventDateHeure::create($value);
            }

            $vehiculeTransfertVoyage = VehiculeLocation::with([
                'prestataire', 'categorie' => function ($query) {
                    $query->with(['famille']);
                },
                'transfert_voyage'
            ])->find($vehiculeTransfertVoyage->id);
        });

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeTransfertVoyage' => $vehiculeTransfertVoyage,
            ];
        }

        return redirect('admin/vehicule-transfert-voyages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVehiculeTransfertVoyage $request
     * @param VehiculeTransfertVoyage $vehiculeTransfertVoyage
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVehiculeTransfertVoyage $request, VehiculeTransfertVoyage $vehiculeTransfertVoyage)
    {
        $vehiculeTransfertVoyage->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVehiculeTransfertVoyage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVehiculeTransfertVoyage $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VehiculeTransfertVoyage::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function updatePrestataire(UpdateVehiculeTransfertVoyagePrestataire $request, VehiculeLocation $vehiculeTransfertVoyage, Prestataire $prestataire)
    {

        $vehiculeTransfertVoyage['prestataire_id'] = $prestataire->id;
        $vehiculeTransfertVoyage->update();

        $vehiculeTransfertVoyage = VehiculeLocation::with([
            'prestataire', 'categorie' => function ($query) {
                $query->with(['famille']);
            },
            'transfert_voyage'
        ])->find($vehiculeTransfertVoyage->id);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vehicule-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'vehiculeTransfertVoyage' => $vehiculeTransfertVoyage,
            ];
        }

        return redirect('admin/vehicule-locations');
    }

    public function calendar($vehiculeTransfertVoyage)
    {
        $vehiculeTransfertVoyage = VehiculeLocation::find($vehiculeTransfertVoyage);
        return [
            'vehiculeTransfertVoyage' => $vehiculeTransfertVoyage,
            'calendar' => $vehiculeTransfertVoyage ? \App\Models\EventDateHeure::where(['model_event' => $vehiculeTransfertVoyage->id . '_vehicule_location'])->get() : []
        ];
    }
}
