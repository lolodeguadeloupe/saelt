<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\ModeleVehicule\BulkDestroyModeleVehicule;
use App\Http\Requests\Admin\LocationVehicule\ModeleVehicule\DestroyModeleVehicule;
use App\Http\Requests\Admin\LocationVehicule\ModeleVehicule\IndexModeleVehicule;
use App\Http\Requests\Admin\LocationVehicule\ModeleVehicule\StoreModeleVehicule;
use App\Http\Requests\Admin\LocationVehicule\ModeleVehicule\UpdateModeleVehicule;
use App\Http\Requests\Admin\LocationVehicule\ModeleVehicule\AutocompletionModeleVehicule;
use App\Models\LocationVehicule\ModeleVehicule;
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

class ModeleVehiculeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexModeleVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexModeleVehicule $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ModeleVehicule::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'description'],
                // set columns to searchIn
                ['id', 'titre', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.location-vehicule.modele-vehicule.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.modele-vehicule.create');

        if (!$this->request->ajax()) {
            abort(404);
        }
        
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreModeleVehicule $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreModeleVehicule $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ModeleVehicule
        $modeleVehicule = ModeleVehicule::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/modele-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'modeleVehicule' => $modeleVehicule,
            ];
        }

        return redirect('admin/modele-vehicules');
    }

    /**
     * Display the specified resource.
     *
     * @param ModeleVehicule $modeleVehicule
     * @throws AuthorizationException
     * @return void
     */
    public function show(ModeleVehicule $modeleVehicule) {
        $this->authorize('admin.modele-vehicule.show', $modeleVehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }
        
        // TODO your code goes here
        return [
            'modeleVehicule' => $modeleVehicule,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ModeleVehicule $modeleVehicule
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ModeleVehicule $modeleVehicule) {
        $this->authorize('admin.modele-vehicule.edit', $modeleVehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'modeleVehicule' => $modeleVehicule,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateModeleVehicule $request
     * @param ModeleVehicule $modeleVehicule
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateModeleVehicule $request, ModeleVehicule $modeleVehicule) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ModeleVehicule
        $modeleVehicule->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/modele-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'modeleVehicule' => $modeleVehicule,
            ];
        }

        return redirect('admin/modele-vehicules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyModeleVehicule $request
     * @param ModeleVehicule $modeleVehicule
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyModeleVehicule $request, ModeleVehicule $modeleVehicule) {
        $modeleVehicule->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyModeleVehicule $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyModeleVehicule $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        ModeleVehicule::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionModeleVehicule $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = ModeleVehicule::where('titre', 'like', '%' . $sanitized['search'] . '%')
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
