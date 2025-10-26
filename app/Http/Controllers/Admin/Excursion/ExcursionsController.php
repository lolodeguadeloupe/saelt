<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excursion\Excursion\BulkDestroyExcursion;
use App\Http\Requests\Admin\Excursion\Excursion\DestroyExcursion;
use App\Http\Requests\Admin\Excursion\Excursion\IndexExcursion;
use App\Http\Requests\Admin\Excursion\Excursion\StoreExcursion;
use App\Http\Requests\Admin\Excursion\Excursion\UpdateExcursion;
use App\Http\Requests\Admin\Excursion\Excursion\StoreExcursionPrestataire;
use App\Http\Requests\Admin\Excursion\Excursion\UpdateExcursionPrestataire;
use App\Models\Excursion\Excursion;
use App\Models\Prestataire;
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

//lunch_prestataire_id,ticket_billeterie

class ExcursionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexExcursion $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Excursion::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('prestataire', 'prestataire.id', 'excursions.prestataire_id');
                    $query->leftjoin('villes', 'villes.id', 'excursions.ville_id');
                    $query->leftJoin('service_port as lieu_depart', 'lieu_depart.id', 'excursions.lieu_depart_id');
                    $query->leftJoin('service_port as lieu_arrive', 'lieu_arrive.id', 'excursions.lieu_arrive_id');
                    $query->join('iles', 'iles.id', 'excursions.ile_id');
                    $query->with(['ville', 'prestataire', 'taxe', 'depart', 'arrive', 'ile']);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'title', 'lunch','lunch_prestataire_id', 'ticket','ticket_billeterie_id', 'availability', 'participant_min', 'card', 'heure_depart', 'description', 'ville_id', 'prestataire_id', 'status', 'duration', 'lieu_depart_id', 'lieu_arrive_id', 'ile_id', 'adresse_depart', 'adresse_arrive','fond_image'],
                // set columns to searchIn
                ['id', 'title', 'lunch', 'ticket', 'availability', 'participant_min', 'card', 'heure_depart', 'prestataire.name', 'lieu_depart.name', 'lieu_arrive.name', 'iles.name', 'adresse_depart', 'adresse_arrive']);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        //dd(json_decode(json_encode($data)));
        return view('admin.excursion.excursion.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.excursion.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
            'taxe' => \App\Models\Taxe::all(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreExcursion $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Store the Excursion
        $excursion = Excursion::create($sanitized);

         /** */
         $type_personne = TypePersonne::whereNull('model')->whereNull('model_id')->get();

         collect($type_personne)->map(function ($data) use ($excursion) {
             DB::table('type_personne')->insert([
                 'type' => $data->type,
                 'age' => $data->age,
                 'description' => $data->description,
                 'reference_prix' => $data->reference_prix,
                 'model' => get_class($excursion),
                 'model_id' => $excursion->id,
                 'original_id' => $data->id
             ]);
         });
         /** */

        $excursion->taxe()->sync($sanitized['taxes']);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $excursion->id . '_excursion';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $excursion->id . 'excursion';
            \App\Models\EventDateHeure::create($value);
        }


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'excursion' => Excursion::with(['taxe'])->find($excursion->id),
                'calendar' => \App\Models\EventDateHeure::where(['model_event' => $excursion->id . 'excursion'])->get()
            ];
        }

        return redirect('admin/excursions');
    }

    public function storewithprestataire(StoreExcursionPrestataire $request) {
        // Sanitize input
        $sanitizedExcursion = $request->getSanitizedExcursion();

        $sanitizedPrest = $request->getSanitizedPrestataire();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        $prestataire = null;

        if ((isset($sanitizedExcursion['prestataire_id']) && $sanitizedExcursion['prestataire_id'] == '') || !isset($sanitizedExcursion['prestataire_id'])) {
            $prestataire = Prestataire::create($sanitizedPrest);
        } else {
            $prestataire = Prestataire::find($sanitizedExcursion['prestataire_id']);
        }

        $sanitizedExcursion['prestataire_id'] = $prestataire->id;

        // Store the Hebergement
        $excursion = Excursion::create($sanitizedExcursion);

        /** */
        $type_personne = TypePersonne::whereNull('model')->whereNull('model_id')->get();

        collect($type_personne)->map(function ($data) use ($excursion) {
            DB::table('type_personne')->insert([
                'type' => $data->type,
                'age' => $data->age,
                'description' => $data->description,
                'reference_prix' => $data->reference_prix,
                'model' => get_class($excursion),
                'model_id' => $excursion->id,
                'original_id' => $data->id
            ]);
        });
        /** */

        $excursion->taxe()->sync($sanitizedExcursion['taxes']);


        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $excursion->id . '_excursion';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $excursion->id . 'excursion';
            \App\Models\EventDateHeure::create($value);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'excursion' => Excursion::with(['taxe'])->find($excursion->id),
                'calendar' => \App\Models\EventDateHeure::where(['model_event' => $excursion->id . 'excursion'])->get()
            ];
        }

        return redirect('admin/excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param Excursion $excursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(Excursion $excursion, \Illuminate\Http\Request $request) {
        $this->authorize('admin.excursion.show', $excursion);

        $excursion_array = Excursion::with(['ville', 'prestataire' => function($query) {
                        $query->with(['ville' => function($query) {
                                $query->with(['pays']);
                            }]);
                    }, 'taxe', 'depart', 'arrive', 'ile'])->find($excursion->id);

        $excursion_array['image'] = \App\Models\MediaImageUpload::where(['id_model' => $excursion->id . '_excursion'])->get();
        if ($request->ajax()) {
            return [
                'data' => $excursion_array,
            ];
        }
        return view('admin.excursion.excursion.detail', [
            'data' => json_encode($excursion_array),
            'excursion' => $excursion,
            'calendar' => \App\Models\EventDateHeure::where(['model_event' => $excursion->id . 'excursion'])->get(),
            'taxe' => \App\Models\Taxe::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Excursion $excursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Excursion $excursion) {
        $this->authorize('admin.excursion.edit', $excursion);


        if (!$this->request->ajax()) {
            abort(404);
        }

        $excursion = Excursion::with(['taxe', 'depart', 'arrive', 'ile', 'ville' => function($query) {
                        $query->with('pays');
                    }])->find($excursion->id);
        $excursion['image'] = \App\Models\MediaImageUpload::where(['id_model' => $excursion->id . '_excursion'])->get();

        return [
            'excursion' => $excursion,
            'prestataire' => \App\Models\Prestataire::find($excursion->prestataire_id),
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
            'calendar' => \App\Models\EventDateHeure::where(['model_event' => $excursion->id . 'excursion'])->get(),
            'taxe' => \App\Models\Taxe::all(),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExcursion $request
     * @param Excursion $excursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateExcursion $request, Excursion $excursion) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Update changed values Hebergement
        $excursion->update($sanitized);


        $excursion->taxe()->sync($sanitized['taxes']);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $excursion->id . '_excursion';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $excursion->id . 'excursion';
            \App\Models\EventDateHeure::create($value);
        }

        $excursion = Excursion::with(['taxe'])->find($excursion->id);
        $excursion['ville'] = \App\Models\Ville::find($excursion['ville_id']);
        $excursion['image'] = \App\Models\MediaImageUpload::where(['id_model' => $excursion['id'] . '_excursion'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'excursion' => $excursion,
                'pays' => \App\Models\Pay::all(),
                'villes' => \App\Models\Ville::all(),
                'calendar' => \App\Models\EventDateHeure::where(['model_event' => $excursion['id'] . 'excursion'])->get()
            ];
        }

        return redirect('admin/excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyExcursion $request
     * @param Excursion $excursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyExcursion $request, Excursion $excursion) {

        $excursion->personne()->delete();
        $excursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyExcursion $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        collect(Excursion::whereIn('id', $bulkChunk)->get())->map(function($excursion){
                            $excursion->personne()->delete();
                            $excursion->delete();
                        });
                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function updatePrestataire(UpdateExcursionPrestataire $request, Excursion $excursion, Prestataire $prestataire) {

        $excursion['prestataire_id'] = $prestataire->id;
        $excursion->update();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'excursion' => $excursion,
                'prestataire' => Prestataire::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($prestataire->id),
                'pays' => \App\Models\Pay::all(),
                'villes' => \App\Models\Ville::all(),
            ];
        }

        return redirect('admin/excursions');
    }

    public function calendar($excursion) {
        $excursion = Excursion::find($excursion);
        return [
            'excursion' => $excursion,
            'calendar' => $excursion ? \App\Models\EventDateHeure::where(['model_event' => $excursion->id . 'excursion'])->get() : []
        ];
    }

}
