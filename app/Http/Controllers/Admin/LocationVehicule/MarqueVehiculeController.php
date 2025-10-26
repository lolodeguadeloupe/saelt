<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\MarqueVehicule\BulkDestroyMarqueVehicule;
use App\Http\Requests\Admin\LocationVehicule\MarqueVehicule\DestroyMarqueVehicule;
use App\Http\Requests\Admin\LocationVehicule\MarqueVehicule\IndexMarqueVehicule;
use App\Http\Requests\Admin\LocationVehicule\MarqueVehicule\StoreMarqueVehicule;
use App\Http\Requests\Admin\LocationVehicule\MarqueVehicule\UpdateMarqueVehicule;
use App\Http\Requests\Admin\LocationVehicule\MarqueVehicule\AutocompletionMarqueVehicule;
use App\Models\LocationVehicule\MarqueVehicule;
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

class MarqueVehiculeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexMarqueVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexMarqueVehicule $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(MarqueVehicule::class)->processRequestAndGet(
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

        return view('admin.location-vehicule.marque-vehicule.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.marque-vehicule.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMarqueVehicule $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMarqueVehicule $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the MarqueVehicule
        $marqueVehicule = MarqueVehicule::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/marque-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'marqueVehicule' => $marqueVehicule,
            ];
        }

        return redirect('admin/marque-vehicules');
    }

    /**
     * Display the specified resource.
     *
     * @param MarqueVehicule $marqueVehicule
     * @throws AuthorizationException
     * @return void
     */
    public function show(MarqueVehicule $marqueVehicule) {
        $this->authorize('admin.marque-vehicule.show', $marqueVehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }

        // TODO your code goes here

        return [
            'marqueVehicule' => $marqueVehicule,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MarqueVehicule $marqueVehicule
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(MarqueVehicule $marqueVehicule) {
        $this->authorize('admin.marque-vehicule.edit', $marqueVehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'marqueVehicule' => $marqueVehicule,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMarqueVehicule $request
     * @param MarqueVehicule $marqueVehicule
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMarqueVehicule $request, MarqueVehicule $marqueVehicule) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values MarqueVehicule
        $marqueVehicule->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/marque-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'marqueVehicule' => $marqueVehicule,
            ];
        }

        return redirect('admin/marque-vehicules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMarqueVehicule $request
     * @param MarqueVehicule $marqueVehicule
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMarqueVehicule $request, MarqueVehicule $marqueVehicule) {
        $marqueVehicule->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMarqueVehicule $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMarqueVehicule $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        MarqueVehicule::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionMarqueVehicule $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = MarqueVehicule::where('titre', 'like', '%' . $sanitized['search'] . '%')
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
