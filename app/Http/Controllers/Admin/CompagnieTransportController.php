<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompagnieTransport\BulkDestroycompagnieTransport;
use App\Http\Requests\Admin\CompagnieTransport\DestroyCompagnieTransport;
use App\Http\Requests\Admin\CompagnieTransport\IndexCompagnieTransport;
use App\Http\Requests\Admin\CompagnieTransport\StoreCompagnieTransport;
use App\Http\Requests\Admin\CompagnieTransport\UpdateCompagnieTransport;
use App\Models\CompagnieTransport;
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

class CompagnieTransportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @paramIndexCompagnieTransport $request
     * @return array|Factory|View
     */
    public function index(IndexCompagnieTransport $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CompagnieTransport::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->with(['ville' => function($query) {
                            $query->with(['pays']);
                        }]);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'nom', 'email', 'phone', 'adresse', 'type_transport','ville_id'],
                // set columns to searchIn
                ['id', 'nom', 'email', 'phone', 'adresse', 'type_transport'], function($query) use($request) {
            if (isset($request->transport)) {
                $query->where(['type_transport' => $request->transport]);
            }
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

        if (isset($request->heb)) {
            if (\App\Models\Hebergement\Hebergement::find($request->heb)) {
                return view('admin.hebergement.compagnie-transport.index', [
                    'data' => $data,
                    'hebergement' => \App\Models\Hebergement\Hebergement::find($request->heb),
                ]);
            }
            return redirect('/admin/hebergements');
        } else if (isset($request->excursion)) {
            if (\App\Models\Excursion\Excursion::find($request->excursion)) {
                return view('admin.excursion.compagnie-transport.index', [
                    'data' => $data,
                    'excursion' => \App\Models\Excursion\Excursion::find($request->excursion),
                ]);
            }
            return redirect('/admin/excursions');
        }
        return view('admin.compagnie-transport.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.compagnie-transport.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompagnieTransport $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCompagnieTransport $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the compagnieTransport
        $compagnieTransport = CompagnieTransport::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/compagnie-transports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'compagnieTransport' => $compagnieTransport,
            ];
        }

        return redirect('admin/compagnie-transports');
    }

    /**
     * Display the specified resource.
     *
     * @param CompagnieTransport $compagnieTransport
     * @throws AuthorizationException
     * @return void
     */
    public function show(CompagnieTransport $compagnieTransport) {
        $this->authorize('admin.compagnie-transport.show', $compagnieTransport);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }
        return [
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CompagnieTransport $compagnieTransport
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(CompagnieTransport $compagnieTransport) {
        $this->authorize('admin.compagnie-transport.edit', $compagnieTransport);

        if (!$this->request->ajax()) {
            abort(404);
        }
        
        $compagnieTransport = CompagnieTransport::with(['ville'=>function($query){$query->with(['pays']);}])->find($compagnieTransport->id);

        return [
            'compagnieTransport' => $compagnieTransport,
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompagnieTransport $request
     * @param CompagnieTransport $compagnieTransport
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCompagnieTransport $request, CompagnieTransport $compagnieTransport) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values compagnieTransport
        $compagnieTransport->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/compagnie-transports'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'compagnieTransport' => $compagnieTransport,
            ];
        }

        return redirect('admin/compagnie-transports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCompagnieTransport $request
     * @param CompagnieTransport $compagnieTransport
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCompagnieTransport $request, CompagnieTransport $compagnieTransport) {
        $compagnieTransport->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroycompagnieTransport $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroycompagnieTransport $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        CompagnieTransport::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
