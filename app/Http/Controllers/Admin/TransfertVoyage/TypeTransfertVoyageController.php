<?php

namespace App\Http\Controllers\Admin\TransfertVoyage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransfertVoyage\TypeTransfertVoyage\BulkDestroyTypeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TypeTransfertVoyage\DestroyTypeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TypeTransfertVoyage\IndexTypeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TypeTransfertVoyage\StoreTypeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TypeTransfertVoyage\UpdateTypeTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TypeTransfertVoyage\AutocompletionTypeTransfertVoyage;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use App\Models\TypePersonne;
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

class TypeTransfertVoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTypeTransfertVoyage $request
     * @return array|Factory|View
     */
    public function index(IndexTypeTransfertVoyage $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TypeTransfertVoyage::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['prestataire' => function ($query) {
                    $query->with(['ville' => function ($query) {
                        $query->with(['pays']);
                    }]);
                }]);
            })
            ->processRequestAndGet(
                // pass the request with params 
                $request,
                // set columns to query
                ['id', 'titre', 'nombre_min', 'nombre_max', 'prestataire_id'],
                // set columns to searchIn
                ['id', 'titre', 'description', 'prestataire_id']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.transfert-voyage.type-transfert-voyage.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.type-transfert-voyage.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTypeTransfertVoyage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTypeTransfertVoyage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TypeTransfertVoyage
        $typeTransfertVoyage = TypeTransfertVoyage::create($sanitized);

        /** */
        $type_personne = TypePersonne::whereNull('model')->whereNull('model_id')->get();

        collect($type_personne)->map(function ($data) use ($typeTransfertVoyage) {
            DB::table('type_personne')->insert([
                'type' => $data->type,
                'age' => $data->age,
                'description' => $data->description,
                'reference_prix' => $data->reference_prix,
                'model' => get_class($typeTransfertVoyage),
                'model_id' => $typeTransfertVoyage->id,
                'original_id' => $data->id
            ]);
        });
        /** */

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/type-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'typeTransfertVoyage' => $typeTransfertVoyage,
            ];
        }

        return redirect('admin/type-transfert-voyages');
    }

    /**
     * Display the specified resource.
     *
     * @param TypeTransfertVoyage $typeTransfertVoyage
     * @throws AuthorizationException
     * @return void
     */
    public function show(TypeTransfertVoyage $typeTransfertVoyage)
    {
        $this->authorize('admin.type-transfert-voyage.show', $typeTransfertVoyage);
        $typeTransfertVoyage = TypeTransfertVoyage::with(['prestataire' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }])
            ->find($typeTransfertVoyage->id);
        if ($this->request->ajax()) {
            return ['data' => $typeTransfertVoyage,];
        }

        return view('admin.transfert-voyage.type-transfert-voyage.detail', [
            'data' => $typeTransfertVoyage,
            'typeTransfertVoyage' => $typeTransfertVoyage,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TypeTransfertVoyage $typeTransfertVoyage
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TypeTransfertVoyage $typeTransfertVoyage)
    {
        $this->authorize('admin.type-transfert-voyage.edit', $typeTransfertVoyage);

        if (!$this->request->ajax()) {
            abort(404);
        }
        $typeTransfertVoyage = TypeTransfertVoyage::with(['prestataire' => function ($query) {
            $query->with(['ville' => function ($query) {
                $query->with(['pays']);
            }]);
        }])->find($typeTransfertVoyage->id);

        return [
            'typeTransfertVoyage' => $typeTransfertVoyage,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTypeTransfertVoyage $request
     * @param TypeTransfertVoyage $typeTransfertVoyage
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTypeTransfertVoyage $request, TypeTransfertVoyage $typeTransfertVoyage)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TypeTransfertVoyage
        $typeTransfertVoyage->update($sanitized);

        $vehicules = $typeTransfertVoyage->vehicule()->get();
        collect($vehicules)->map(function ($vehicule) use ($typeTransfertVoyage) {
            $vehicule->prestataire_id = $typeTransfertVoyage->prestataire_id;
            $vehicule->save();
        });

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/type-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'typeTransfertVoyage' => $typeTransfertVoyage,
            ];
        }

        return redirect('admin/type-transfert-voyages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTypeTransfertVoyage $request
     * @param TypeTransfertVoyage $typeTransfertVoyage
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTypeTransfertVoyage $request, TypeTransfertVoyage $typeTransfertVoyage)
    {
        DB::transaction(static function () use ($request, $typeTransfertVoyage) {
            $all_vehicule = collect($typeTransfertVoyage->vehicule()->get())->map(function ($data) {
                return $data->id;
            })->values();
            $typeTransfertVoyage->personne()->delete();
            $typeTransfertVoyage->delete();
            VehiculeLocation::whereIn('id', $all_vehicule)->delete();
        });

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTypeTransfertVoyage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTypeTransfertVoyage $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    collect(TypeTransfertVoyage::whereIn('id', $bulkChunk)->get())->map(function ($typeTransfertVoyage) {
                        $all_vehicule = collect($typeTransfertVoyage->vehicule()->get())->map(function ($data) {
                            return $data->id;
                        })->values();
                        $typeTransfertVoyage->personne()->delete();
                        $typeTransfertVoyage->delete();
                        VehiculeLocation::whereIn('id', $all_vehicule)->delete();
                    });

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionTypeTransfertVoyage $resquest)
    {
        $sanitized = $resquest->getSanitized();
        $search = TypeTransfertVoyage::with(['tranche'])
            ->where(function ($query) use ($sanitized) {
                $query->where('titre', 'like', '%' . $sanitized['search'] . '%');
            })
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

/*

public function all_tarif() {
        $select = [
            'tranche' => new TranchePersonneTransfertVoyage(),
            'tarif' => new TarifTransfertVoyage(),
            'trajet' => new TrajetTransfertVoyage(),
            'personne' => new \App\Models\TypePersonne(),
            'depart' => new LieuTransfert(),
            'retour' => new LieuTransfert()
        ];

        $select_columns = [];
        array_map(function($array, $keys) use(&$select_columns) {
            $columns = $array->getFillable();
            $columns[] = 'id';
            array_map(function($col) use($keys, &$select_columns) {
                $select_columns[] = $keys . '.' . $col . ' as ' . $keys . '_' . $col;
            }, $columns);
        }, $select, array_keys($select));

        return DB::table('tranche_personne_transfert_voyage as tranche')
                        ->select($select_columns)
                        ->join('tarif_transfert_voyage as tarif', 'tarif.tranche_transfert_voyage_id', 'tranche.id')
                        ->join('trajet_transfert_voyage as trajet', 'trajet.id', 'tarif.trajet_transfert_voyage_id')
                        ->join('type_personne as personne', 'personne.id', 'tarif.type_personne_id')
                        ->join('lieu_transfert as depart', 'depart.id', 'trajet.point_depart')
                        ->join('lieu_transfert as retour', 'retour.id', 'trajet.point_arrive')
                        ->where(['tranche.type_transfert_id' => $this->id])
                        ->get();
    }
*/