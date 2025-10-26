<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\CategorieVehicule\BulkDestroyCategorieVehicule;
use App\Http\Requests\Admin\LocationVehicule\CategorieVehicule\DestroyCategorieVehicule;
use App\Http\Requests\Admin\LocationVehicule\CategorieVehicule\IndexCategorieVehicule;
use App\Http\Requests\Admin\LocationVehicule\CategorieVehicule\StoreCategorieVehicule;
use App\Http\Requests\Admin\LocationVehicule\CategorieVehicule\UpdateCategorieVehicule;
use App\Http\Requests\Admin\LocationVehicule\CategorieVehicule\AutocompletionCategorieVehicule;
use App\Models\LocationVehicule\CategorieVehicule;
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

class CategorieVehiculeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexCategorieVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexCategorieVehicule $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CategorieVehicule::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->with(['famille']);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'famille_vehicule_id'],
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

        return view('admin.location-vehicule.categorie-vehicule.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.categorie-vehicule.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategorieVehicule $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCategorieVehicule $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the CategorieVehicule
        $categorieVehicule = CategorieVehicule::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/categorie-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'categorieVehicule' => $categorieVehicule
            ];
        }

        return redirect('admin/categorie-vehicules');
    }

    /**
     * Display the specified resource.
     *
     * @param CategorieVehicule $categorieVehicule
     * @throws AuthorizationException
     * @return void
     */
    public function show(CategorieVehicule $categorieVehicule) {
        $this->authorize('admin.categorie-vehicule.show', $categorieVehicule);


        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CategorieVehicule $categorieVehicule
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(CategorieVehicule $categorieVehicule) {
        $this->authorize('admin.categorie-vehicule.edit', $categorieVehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'categorieVehicule' => CategorieVehicule::with(['famille'])->find($categorieVehicule->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategorieVehicule $request
     * @param CategorieVehicule $categorieVehicule
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCategorieVehicule $request, CategorieVehicule $categorieVehicule) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values CategorieVehicule
        $categorieVehicule->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/categorie-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'categorieVehicule' => $categorieVehicule,
            ];
        }

        return redirect('admin/categorie-vehicules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCategorieVehicule $request
     * @param CategorieVehicule $categorieVehicule
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCategorieVehicule $request, CategorieVehicule $categorieVehicule) {
        $categorieVehicule->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCategorieVehicule $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCategorieVehicule $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        CategorieVehicule::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionCategorieVehicule $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = CategorieVehicule::with(['famille'])->where('titre', 'like', '%' . $sanitized['search'] . '%')
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
