<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InteretRetardRestitutionVehicule\BulkDestroyInteretRetardRestitutionVehicule;
use App\Http\Requests\Admin\InteretRetardRestitutionVehicule\DestroyInteretRetardRestitutionVehicule;
use App\Http\Requests\Admin\InteretRetardRestitutionVehicule\IndexInteretRetardRestitutionVehicule;
use App\Http\Requests\Admin\InteretRetardRestitutionVehicule\StoreInteretRetardRestitutionVehicule;
use App\Http\Requests\Admin\InteretRetardRestitutionVehicule\UpdateInteretRetardRestitutionVehicule;
use App\Models\InteretRetardRestitutionVehicule;
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

class InteretRetardRestitutionVehiculeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexInteretRetardRestitutionVehicule $request
     * @return array|Factory|View
     */
    public function index(IndexInteretRetardRestitutionVehicule $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(InteretRetardRestitutionVehicule::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'titre', 'duree_retard', 'valeur_pourcent', 'valeur_devises'],

            // set columns to searchIn
            ['id', 'titre', 'duree_retard', 'descciption']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.interet-retard-restitution-vehicule.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.interet-retard-restitution-vehicule.create');

        return view('admin.interet-retard-restitution-vehicule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInteretRetardRestitutionVehicule $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreInteretRetardRestitutionVehicule $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the InteretRetardRestitutionVehicule
        $interetRetardRestitutionVehicule = InteretRetardRestitutionVehicule::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/interet-retard-restitution-vehicules'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/interet-retard-restitution-vehicules');
    }

    /**
     * Display the specified resource.
     *
     * @param InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule
     * @throws AuthorizationException
     * @return void
     */
    public function show(InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule)
    {
        $this->authorize('admin.interet-retard-restitution-vehicule.show', $interetRetardRestitutionVehicule);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule)
    {
        $this->authorize('admin.interet-retard-restitution-vehicule.edit', $interetRetardRestitutionVehicule);


        return view('admin.interet-retard-restitution-vehicule.edit', [
            'interetRetardRestitutionVehicule' => $interetRetardRestitutionVehicule,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInteretRetardRestitutionVehicule $request
     * @param InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateInteretRetardRestitutionVehicule $request, InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values InteretRetardRestitutionVehicule
        $interetRetardRestitutionVehicule->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/interet-retard-restitution-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/interet-retard-restitution-vehicules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyInteretRetardRestitutionVehicule $request
     * @param InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyInteretRetardRestitutionVehicule $request, InteretRetardRestitutionVehicule $interetRetardRestitutionVehicule)
    {
        $interetRetardRestitutionVehicule->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyInteretRetardRestitutionVehicule $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyInteretRetardRestitutionVehicule $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    InteretRetardRestitutionVehicule::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
