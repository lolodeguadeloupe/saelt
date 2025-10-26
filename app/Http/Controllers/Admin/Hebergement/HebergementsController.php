<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\Hebergement\BulkDestroyHebergement;
use App\Http\Requests\Admin\Hebergement\Hebergement\DestroyHebergement;
use App\Http\Requests\Admin\Hebergement\Hebergement\IndexHebergement;
use App\Http\Requests\Admin\Hebergement\Hebergement\StoreHebergement;
use App\Http\Requests\Admin\Hebergement\Hebergement\UpdateHebergement;
use App\Http\Requests\Admin\Hebergement\Hebergement\StoreHebergementPrestataire;
use App\Http\Requests\Admin\Hebergement\Hebergement\UpdateHebergementPrestataire;
use App\Models\EventDateHeure;
use App\Models\Hebergement\Hebergement;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HebergementsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexHebergement $request
     * @return array|Factory|View
     */
    public function index(IndexHebergement $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Hebergement::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('type_hebergement', 'hebergements.type_hebergement_id', 'type_hebergement.id');
                $query->join('prestataire', 'prestataire.id', 'hebergements.prestataire_id');
                $query->join('iles', 'iles.id', 'hebergements.ile_id');
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name', 'duration_min', 'status', 'image', 'heure_ouverture', 'heure_fermeture', 'adresse', 'description', 'type_hebergement_id', 'ville_id', 'prestataire_id', 'caution', 'ile_id', 'etoil'],
                // set columns to searchIn
                ['id', 'name', 'description', 'duration_min', 'type_hebergement.name', 'prestataire.name', 'iles.name'],
                function ($query) use ($request) {

                    $query->with(['type', 'ville', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }, 'taxe', 'ile']);
                }
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.hebergement.hebergement.index', [
            'data' => $data,
            'type_hebergements' => json_encode(\App\Models\Hebergement\TypeHebergement::all())
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
        $this->authorize('admin.hebergement.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
            'taxe' => \App\Models\Taxe::all(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHebergement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreHebergement $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        // Store the Hebergement
        $hebergement = Hebergement::create($sanitized);

        /** */
        $type_personne = TypePersonne::whereNull('model')->whereNull('model_id')->get();

        collect($type_personne)->map(function ($data) use ($hebergement) {
            DB::table('type_personne')->insert([
                'type' => $data->type,
                'age' => $data->age,
                'description' => $data->description,
                'reference_prix' => $data->reference_prix,
                'model' => get_class($hebergement),
                'model_id' => $hebergement->id,
                'original_id' => $data->id
            ]);
        });
        /** */

        $hebergement->taxe()->sync($sanitized['taxes']);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $hebergement->id . '_heb';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergement' => Hebergement::with(['taxe'])->find($hebergement->id),
                'calendar' => EventDateHeure::where(['model_event' => $hebergement->id . 'heb'])->get()
            ];
        }

        return redirect('admin/hebergements');
    }

    public function storewithprestataire(StoreHebergementPrestataire $request)
    {
        // Sanitize input
        $sanitizedHeb = $request->getSanitizedHebergement();

        $sanitizedPrest = $request->getSanitizedPrestataire();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        $prestataire = null;

        if (!isset($sanitizedHeb['prestataire_id']) || $sanitizedHeb['prestataire_id'] == '') {
            $prestataire = \App\Models\Prestataire::create($sanitizedPrest);
        } else {
            $prestataire = Prestataire::find($sanitizedHeb['prestataire_id']);
        }

        $sanitizedHeb['prestataire_id'] = $prestataire->id;

        // Store the Hebergement
        $hebergement = Hebergement::create($sanitizedHeb);
        /** */
        $type_personne = TypePersonne::whereNull('model')->whereNull('model_id')->get();

        collect($type_personne)->map(function ($data) use ($hebergement) {
            DB::table('type_personne')->insert([
                'type' => $data->type,
                'age' => $data->age,
                'description' => $data->description,
                'reference_prix' => $data->reference_prix,
                'model' => get_class($hebergement),
                'model_id' => $hebergement->id,
                'original_id' => $data->id
            ]);
        });
        /** */

        if (isset($sanitizedHeb['taxes'])) {
            $hebergement->taxe()->sync($sanitizedHeb['taxes']);
        }

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $hebergement->id . '_heb';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $hebergement->id . 'heb';
            EventDateHeure::create($value);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergement' => Hebergement::with(['taxe'])->find($hebergement->id),
                'calendar' => EventDateHeure::where(['model_event' => $hebergement->id . 'heb'])->get()
            ];
        }

        return redirect('admin/hebergements');
    }

    /**
     * Display the specified resource.
     *
     * @param Hebergement $hebergement
     * @throws AuthorizationException
     * @return void
     */
    public function show(Hebergement $hebergement, \Illuminate\Http\Request $request)
    {
        $this->authorize('admin.hebergement.show', $hebergement);

        $hebergement_array = Hebergement::with([
            'taxe',
            'ile',
            'type',
            'prestataire' => function ($query) {
                $query->with(['ville' => function ($query) {
                    $query->with(['pays']);
                }]);
            },
            'ville' => function ($query) {
                $query->with(['pays']);
            }
        ])->find($hebergement->id)->toArray();

        $hebergement_array['image'] = \App\Models\MediaImageUpload::where(['id_model' => $hebergement->id . '_heb'])->get();

        if ($request->ajax()) {
            return [
                'data' => $hebergement_array,
            ];
        }

        return view('admin.hebergement.hebergement.detail', [
            'data' => json_encode($hebergement_array),
            'hebergement' => $hebergement,
            'calendar' => EventDateHeure::where(['model_event' => $hebergement->id . 'heb'])->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hebergement $hebergement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Hebergement $hebergement)
    {
        $this->authorize('admin.hebergement.edit', $hebergement);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $hebergement = Hebergement::with(['taxe', 'ile', 'ville' => function ($query) {
            $query->with(['pays']);
        }])->find($hebergement->id);

        $hebergement['image'] = \App\Models\MediaImageUpload::where(['id_model' => $hebergement->id . '_heb'])->get();

        return [
            'hebergement' => $hebergement,
            'prestataire' => \App\Models\Prestataire::find($hebergement->prestataire_id),
            'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
            'calendar' => EventDateHeure::where(['model_event' => $hebergement->id . 'heb'])->get(),
            'taxe' => \App\Models\Taxe::all(),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHebergement $request
     * @param Hebergement $hebergement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateHebergement $request, Hebergement $hebergement)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Update changed values Hebergement
        $hebergement->update($sanitized);

        $hebergement->taxe()->sync($sanitized['taxes']);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $hebergement->id . '_heb';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $hebergement->id . 'heb';
            EventDateHeure::create($value);
        }

        $hebergement = Hebergement::with(['taxe'])->find($hebergement->id);
        $hebergement['type'] = \App\Models\Hebergement\TypeHebergement::find($hebergement['type_hebergement_id']);
        $hebergement['ville'] = \App\Models\Ville::find($hebergement['ville_id']);
        $hebergement['image'] = \App\Models\MediaImageUpload::where(['id_model' => $hebergement['id'] . '_heb'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergement' => $hebergement,
                'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
                'pays' => \App\Models\Pay::all(),
                'villes' => \App\Models\Ville::all(),
                'calendar' => EventDateHeure::where(['model_event' => $hebergement['id'] . 'heb'])->get()
            ];
        }

        return redirect('admin/hebergements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyHebergement $request
     * @param Hebergement $hebergement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyHebergement $request, Hebergement $hebergement)
    {
        $hebergement->personne()->delete();
        $hebergement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyHebergement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyHebergement $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    collect(Hebergement::whereIn('id', $bulkChunk)->get())->map(function ($hebergement) {
                        $hebergement->personne()->delete();
                        $hebergement->delete();
                    });
                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function updatePrestataire(UpdateHebergementPrestataire $request, Hebergement $hebergement, Prestataire $prestataire)
    {

        $hebergement['prestataire_id'] = $prestataire->id;
        $hebergement->update();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergement' => $hebergement,
                'prestataire' => Prestataire::with(['ville' => function ($query) {
                    $query->with(['pays']);
                }])->find($prestataire->id),
                'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
                'pays' => \App\Models\Pay::all(),
                'villes' => \App\Models\Ville::all(),
            ];
        }

        return redirect('admin/hebergements');
    }

    public function calendar($hebergement)
    {
        $hebergement = Hebergement::find($hebergement);
        return [
            'hebergement' => $hebergement,
            'calendar' => $hebergement ? EventDateHeure::where(['model_event' => $hebergement->id . 'heb'])->get() : []
        ];
    }
}
