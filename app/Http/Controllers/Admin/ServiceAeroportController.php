<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceAeroport\BulkDestroyServiceAeroport;
use App\Http\Requests\Admin\ServiceAeroport\DestroyServiceAeroport;
use App\Http\Requests\Admin\ServiceAeroport\IndexServiceAeroport;
use App\Http\Requests\Admin\ServiceAeroport\StoreServiceAeroport;
use App\Http\Requests\Admin\ServiceAeroport\UpdateServiceAeroport;
use App\Http\Requests\Admin\ServiceAeroport\AutocompletionServiceAeroport;
use App\Models\ServiceAeroport;
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

class ServiceAeroportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexServiceAeroport $request
     * @return array|Factory|View
     */
    public function index(IndexServiceAeroport $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ServiceAeroport::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('villes', 'villes.id', 'service_aeroport.ville_id');
                    $query->with(['ville' => function($query) {
                            $query->with(['pays']);
                        }]);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'code_service', 'name', 'adresse', 'phone', 'email', 'ville_id'],
                // set columns to searchIn
                ['id', 'code_service', 'name', 'adresse', 'phone', 'email', 'logo']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.service-aeroport.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.service-aeroport.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreServiceAeroport $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreServiceAeroport $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Store the ServiceAeroport
        $serviceAeroport = ServiceAeroport::create($sanitized);

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $serviceAeroport->id . '_aeroport';
            \App\Models\EventDateHeure::create($value);
        }

        $serviceAeroport = ServiceAeroport::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($serviceAeroport->id);
        $serviceAeroport['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $serviceAeroport->id . '_aeroport'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/service-aeroports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'serviceAeroport' => $serviceAeroport,
            ];
        }

        return redirect('admin/service-aeroports');
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceAeroport $serviceAeroport
     * @throws AuthorizationException
     * @return void
     */
    public function show(ServiceAeroport $serviceAeroport) {

        $this->authorize('admin.service-aeroport.show', $serviceAeroport);

        $serviceAeroport = ServiceAeroport::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($serviceAeroport->id);
        $serviceAeroport['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $serviceAeroport->id . '_aeroport'])->get();

        return view('admin.service-aeroport.detail', [
            'data' => json_encode($serviceAeroport),
            'serviceAeroport' => $serviceAeroport,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceAeroport $serviceAeroport
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ServiceAeroport $serviceAeroport) {
        $this->authorize('admin.service-aeroport.edit', $serviceAeroport);
        if (!$this->request->ajax()) {
            abort(404);
        }
        $serviceAeroport = ServiceAeroport::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($serviceAeroport->id);
        $serviceAeroport['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $serviceAeroport->id . '_aeroport'])->get();

        return [
            'serviceAeroport' => $serviceAeroport,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServiceAeroport $request
     * @param ServiceAeroport $serviceAeroport
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateServiceAeroport $request, ServiceAeroport $serviceAeroport) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Update changed values ServiceAeroport
        $serviceAeroport->update($sanitized);

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $serviceAeroport->id . '_aeroport';
            \App\Models\EventDateHeure::create($value);
        }

        $serviceAeroport = ServiceAeroport::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($serviceAeroport->id);
        $serviceAeroport['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $serviceAeroport->id . '_aeroport'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/service-aeroports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'serviceAeroport' => $serviceAeroport
            ];
        }

        return redirect('admin/service-aeroports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyServiceAeroport $request
     * @param ServiceAeroport $serviceAeroport
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyServiceAeroport $request, ServiceAeroport $serviceAeroport) {
        $serviceAeroport->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyServiceAeroport $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyServiceAeroport $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        ServiceAeroport::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function calendar($serviceAeroport) {
        $serviceAeroport = ServiceAeroport::find($serviceAeroport);
        return [
            'serviceAeroport' => $serviceAeroport,
            'calendar' => $serviceAeroport ? \App\Models\EventDateHeure::where(['model_event' => $serviceAeroport->id . '_aeroport'])->get() : []
        ];
    }

    public function autocompletion(AutocompletionServiceAeroport $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = ServiceAeroport::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->where(function($query) use($sanitized) {
                    $query->where('name', 'like', '%' . $sanitized['search'] . '%')
                    ->orWhere('code_service', 'like', '%' . $sanitized['search'] . '%');
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
