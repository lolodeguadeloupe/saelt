<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\FamilleVehicule\BulkDestroyFamilleVehicule;
use App\Http\Requests\Admin\LocationVehicule\FamilleVehicule\DestroyFamilleVehicule;
use App\Http\Requests\Admin\LocationVehicule\FamilleVehicule\IndexFamilleVehicule;
use App\Http\Requests\Admin\LocationVehicule\FamilleVehicule\StoreFamilleVehicule;
use App\Http\Requests\Admin\LocationVehicule\FamilleVehicule\UpdateFamilleVehicule;
use App\Http\Requests\Admin\LocationVehicule\FamilleVehicule\AutocompletionFamilleVehicule;
use App\Models\LocationVehicule\FamilleVehicule;
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

class FamilleVehiculeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexFamilleVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexFamilleVehicule $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(FamilleVehicule::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'titre'],

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

        return view('admin.location-vehicule.famille-vehicule.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.famille-vehicule.create');

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFamilleVehicule $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreFamilleVehicule $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the FamilleVehicule
        $familleVehicule = FamilleVehicule::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/famille-vehicules'), 
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'familleVehicule' => $familleVehicule,
                ];
        }

        return redirect('admin/famille-vehicules');
    }

    /**
     * Display the specified resource.
     *
     * @param FamilleVehicule $familleVehicule
     * @throws AuthorizationException
     * @return void
     */
    public function show(FamilleVehicule $familleVehicule)
    {
        $this->authorize('admin.famille-vehicule.show', $familleVehicule);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FamilleVehicule $familleVehicule
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(FamilleVehicule $familleVehicule)
    {
        $this->authorize('admin.famille-vehicule.edit', $familleVehicule);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return[
            'familleVehicule' => $familleVehicule,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFamilleVehicule $request
     * @param FamilleVehicule $familleVehicule
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFamilleVehicule $request, FamilleVehicule $familleVehicule)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values FamilleVehicule
        $familleVehicule->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/famille-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'familleVehicule' => $familleVehicule,
            ];
        }

        return redirect('admin/famille-vehicules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyFamilleVehicule $request
     * @param FamilleVehicule $familleVehicule
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyFamilleVehicule $request, FamilleVehicule $familleVehicule)
    {
        $familleVehicule->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFamilleVehicule $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyFamilleVehicule $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    FamilleVehicule::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    
    public function autocompletion(AutocompletionFamilleVehicule $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = FamilleVehicule::where('titre', 'like', '%' . $sanitized['search'] . '%')
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
