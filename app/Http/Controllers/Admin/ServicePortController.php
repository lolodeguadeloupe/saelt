<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServicePort\BulkDestroyServicePort;
use App\Http\Requests\Admin\ServicePort\DestroyServicePort;
use App\Http\Requests\Admin\ServicePort\IndexServicePort;
use App\Http\Requests\Admin\ServicePort\StoreServicePort;
use App\Http\Requests\Admin\ServicePort\UpdateServicePort;
use App\Http\Requests\Admin\ServicePort\AutocompletionServicePort;
use App\Models\ServicePort;
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

class ServicePortController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexServicePort $request
     * @return array|Factory|View
     */
    public function index(IndexServicePort $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ServicePort::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('villes', 'villes.id', 'service_port.ville_id');
                    $query->with(['ville'=>function($query){$query->with(['pays']);}]);
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

        return view('admin.service-port.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.service-port.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreServicePort $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreServicePort $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Store the ServicePort
        $servicePort = ServicePort::create($sanitized);

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $servicePort->id . '_port';
            \App\Models\EventDateHeure::create($value);
        }

        $servicePort = ServicePort::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($servicePort->id);
        $servicePort['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $servicePort->id . '_port'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/service-ports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'servicePort' => $servicePort,
            ];
        }

        return redirect('admin/service-ports');
    }

    /**
     * Display the specified resource.
     *
     * @param ServicePort $servicePort
     * @throws AuthorizationException
     * @return void
     */
    public function show(ServicePort $servicePort) {
        $this->authorize('admin.service-port.show', $servicePort);
        
        $servicePort = ServicePort::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($servicePort->id);
        $servicePort['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $servicePort->id . '_port'])->get();

        return view('admin.service-port.detail', [
            'data' => json_encode($servicePort),
            'servicePort' => $servicePort,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServicePort $servicePort
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ServicePort $servicePort) {
        $this->authorize('admin.service-port.edit', $servicePort);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $servicePort = ServicePort::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($servicePort->id);
        $servicePort['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $servicePort->id . '_port'])->get();

        return [
            'servicePort' => $servicePort,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServicePort $request
     * @param ServicePort $servicePort
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateServicePort $request, ServicePort $servicePort) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Update changed values ServicePort
        $servicePort->update($sanitized);

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $servicePort->id . '_port';
            \App\Models\EventDateHeure::create($value);
        }

        $servicePort = ServicePort::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($servicePort->id);
        $servicePort['calendar'] = \App\Models\EventDateHeure::where(['model_event' => $servicePort->id . '_port'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/service-ports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'servicePort' => $servicePort,
            ];
        }

        return redirect('admin/service-ports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyServicePort $request
     * @param ServicePort $servicePort
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyServicePort $request, ServicePort $servicePort) {
        $servicePort->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyServicePort $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyServicePort $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        ServicePort::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    
    public function calendar($servicePort) {
        $servicePort = ServicePort::find($servicePort);
        return [
            'servicePort' => $servicePort,
            'calendar' => $servicePort ? \App\Models\EventDateHeure::where(['model_event' => $servicePort->id . '_port'])->get() : []
        ];
    }
    
    public function autocompletion(AutocompletionServicePort $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = ServicePort::with(['ville' => function($query) {
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
