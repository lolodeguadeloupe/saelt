<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\AgenceLocation\BulkDestroyAgenceLocation;
use App\Http\Requests\Admin\LocationVehicule\AgenceLocation\DestroyAgenceLocation;
use App\Http\Requests\Admin\LocationVehicule\AgenceLocation\IndexAgenceLocation;
use App\Http\Requests\Admin\LocationVehicule\AgenceLocation\StoreAgenceLocation;
use App\Http\Requests\Admin\LocationVehicule\AgenceLocation\UpdateAgenceLocation;
use App\Http\Requests\Admin\LocationVehicule\AgenceLocation\AutocompletionAgenceLocation;
use App\Models\LocationVehicule\AgenceLocation;
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
use MyCLabs\Enum\Enum;

class AgenceLocationController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexAgenceLocation $request
     * @return array|Factory|View
     */
    
    public function index(IndexAgenceLocation $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AgenceLocation::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('villes', 'villes.id', 'agence_location.ville_id');
                    $query->with(['ville' => function($query) {
                            $query->with(['pays']);
                        }]);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'code_agence', 'name', 'adresse', 'phone', 'email', 'ville_id','heure_ouverture','heure_fermeture'],
                // set columns to searchIn
                ['id', 'code_agence', 'name', 'adresse', 'phone', 'email', 'logo', 'ville.name','heure_ouverture','heure_fermeture']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.location-vehicule.agence-location.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.agence-location.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAgenceLocation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAgenceLocation $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AgenceLocation
        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Store the ServicePort
        $agenceLocation = AgenceLocation::create($sanitized);

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $agenceLocation->id . '_agence_location';
            \App\Models\EventDateHeure::create($value);
        }

        $agenceLocation = AgenceLocation::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($agenceLocation->id);
        $agenceLocation['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $agenceLocation->id . '_agence_location'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/agence-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'agenceLocation' => $agenceLocation,
            ];
        }

        return redirect('admin/agence-locations');
    }

    /**
     * Display the specified resource.
     *
     * @param AgenceLocation $agenceLocation
     * @throws AuthorizationException
     * @return void
     */
    public function show(AgenceLocation $agenceLocation) {
        $this->authorize('admin.agence-location.show', $agenceLocation);

        $agenceLocation = AgenceLocation::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($agenceLocation->id);
        $agenceLocation['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $agenceLocation->id . '_agence_location'])->get();

        return view('admin.location-vehicule.agence-location.detail', [
            'data' => json_encode($agenceLocation),
            'agenceLocation' => $agenceLocation
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AgenceLocation $agenceLocation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AgenceLocation $agenceLocation) {
        $this->authorize('admin.agence-location.edit', $agenceLocation);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $agenceLocation = AgenceLocation::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($agenceLocation->id);
        $agenceLocation['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $agenceLocation->id . '_agence_location'])->get();

        return [
            'agenceLocation' => $agenceLocation,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAgenceLocation $request
     * @param AgenceLocation $agenceLocation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAgenceLocation $request, AgenceLocation $agenceLocation) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Update changed values AgenceLocation
        $agenceLocation->update($sanitized);

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $agenceLocation->id . '_agence_location';
            \App\Models\EventDateHeure::create($value);
        }

        $agenceLocation = AgenceLocation::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($agenceLocation->id);
        $agenceLocation['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $agenceLocation->id . '_agence_location'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/agence-locations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'agenceLocation' => $agenceLocation,
            ];
        }

        return redirect('admin/agence-locations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAgenceLocation $request
     * @param AgenceLocation $agenceLocation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAgenceLocation $request, AgenceLocation $agenceLocation) {
        $agenceLocation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAgenceLocation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAgenceLocation $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        AgenceLocation::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function calendar($agenceLocation) {
        $agenceLocation = AgenceLocation::find($agenceLocation);
        return [
            'agenceLocation' => $agenceLocation,
            'calendar' => $agenceLocation ? \App\Models\EventDateHeure::where(['model_event' => $agenceLocation->id . '_agence_location'])->get() : []
        ];
    }

    public function autocompletion(AutocompletionAgenceLocation $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = AgenceLocation::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->where(function($query) use($sanitized) {
                    $query->where('name', 'like', '%' . $sanitized['search'] . '%')
                    ->orWhere('code_agence', 'like', '%' . $sanitized['search'] . '%');
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
