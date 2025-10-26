<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\Allotement\BulkDestroyAllotement;
use App\Http\Requests\Admin\Hebergement\Allotement\DestroyAllotement;
use App\Http\Requests\Admin\Hebergement\Allotement\IndexAllotement;
use App\Http\Requests\Admin\Hebergement\Allotement\StoreAllotement;
use App\Http\Requests\Admin\Hebergement\Allotement\UpdateAllotement;
use App\Models\Hebergement\Allotement;
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

class AllotementsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexAllotement $request
     * @return array|Factory|View
     */
    public function index(IndexAllotement $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Allotement::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('compagnie_transport', 'compagnie_transport.id', 'allotements.compagnie_transport_id');
                    $query->join('service_aeroport', 'service_aeroport.id', 'allotements.lieu_depart_id');
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'quantite', 'date_depart', 'date_acquisition', 'date_limite', 'compagnie_transport_id', 'heure_depart', 'heure_arrive', 'lieu_depart_id', 'lieu_arrive_id'],
                // set columns to searchIn
                ['id', 'titre', 'quantite', 'date_depart', 'date_acquisition', 'date_limite', 'heure_depart', 'heure_arrive', 'lieu_depart', 'lieu_arrive', 'compagnie_transport.nom', 'service_aeroport.name', 'service_aeroport.code_service'], function ($query) use ($request) {

            $query->with(['compagnie', 'depart' => function($query) {
                    $query->with(['ville' => function($query) {
                            $query->with(['pays']);
                        }]);
                }, 'arrive' => function($query) {
                    $query->with(['ville' => function($query) {
                            $query->with(['pays']);
                        }]);
                }]);
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
        
        return view('admin.allotement.index', [
            'hebergement' => \App\Models\Hebergement\Hebergement::find($request->heb),
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.allotement.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'compagnie' => \App\Models\CompagnieTransport::where(['type_transport' => 'Aérien'])->get()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAllotement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAllotement $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Allotement
        $allotement = Allotement::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/allotements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'compagnie' => \App\Models\CompagnieTransport::where(['type_transport' => 'Aérien'])->get()
            ];
        }

        return redirect('admin/allotements');
    }

    /**
     * Display the specified resource.
     *
     * @param Allotement $allotement
     * @throws AuthorizationException
     * @return void
     */
    public function show(Allotement $allotement) {
        $this->authorize('admin.allotement.show', $allotement);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }
        return [
            'compagnie' => \App\Models\CompagnieTransport::where(['type_transport' => 'Aérien'])->get(),
            'allotement' => $allotement
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Allotement $allotement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Allotement $allotement) {
        $this->authorize('admin.allotement.edit', $allotement);


        if (!$this->request->ajax()) {
            abort(404);
        }

        $allotement = Allotement::with(['compagnie', 'depart' => function($query) {
                        $query->with(['ville' => function($query) {
                                $query->with(['pays']);
                            }]);
                    }, 'arrive' => function($query) {
                        $query->with(['ville' => function($query) {
                                $query->with(['pays']);
                            }]);
                    }])->find($allotement->id);
        return [
            'compagnie' => \App\Models\CompagnieTransport::where(['type_transport' => 'Aérien'])->get(),
            'allotement' => $allotement,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAllotement $request
     * @param Allotement $allotement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAllotement $request, Allotement $allotement) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Allotement
        $allotement->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/allotements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'allotement' => $allotement,
            ];
        }

        return redirect('admin/allotements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAllotement $request
     * @param Allotement $allotement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAllotement $request, Allotement $allotement) {
        $allotement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAllotement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAllotement $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        Allotement::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
