<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excursion\CompagnieLiaisonExcursion\BulkDestroyCompagnieLiaisonExcursion;
use App\Http\Requests\Admin\Excursion\CompagnieLiaisonExcursion\DestroyCompagnieLiaisonExcursion;
use App\Http\Requests\Admin\Excursion\CompagnieLiaisonExcursion\IndexCompagnieLiaisonExcursion;
use App\Http\Requests\Admin\Excursion\CompagnieLiaisonExcursion\StoreCompagnieLiaisonExcursion;
use App\Http\Requests\Admin\Excursion\CompagnieLiaisonExcursion\UpdateCompagnieLiaisonExcursion;
use App\Models\Excursion\CompagnieLiaisonExcursion;
use App\Models\Excursion\Excursion;
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

class CompagnieLiaisonExcursionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexCompagnieLiaisonExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexCompagnieLiaisonExcursion $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CompagnieLiaisonExcursion::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->with(['excursion', 'compagnie' => function($query) {
                            $query->with(['billeterie' => function($query) {
                                    $query->join('compagnie_transport', 'compagnie_transport.id', 'billeterie_maritime.compagnie_transport_id');
                                    $query->join('compagnie_liaison_excursion', 'compagnie_liaison_excursion.compagnie_transport_id', 'compagnie_transport.id');
                                    $query->join('excursions', 'excursions.id', 'compagnie_liaison_excursion.excursion_id');
                                    $query->whereColumn('excursions.lieu_depart_id', 'billeterie_maritime.lieu_depart_id');
                                    $query->whereColumn('excursions.lieu_arrive_id', 'billeterie_maritime.lieu_arrive_id');
                                    $query->whereDate('date_limite', '>=', \Carbon\Carbon::now()->toDateString());
                                }]);
                        }]);
                    $query->where(['excursion_id' => $request->excursion]);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'excursion_id', 'compagnie_transport_id'],
                // set columns to searchIn
                ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        if (!(isset($request->excursion) && \App\Models\Excursion\Excursion::find($request->excursion))) {
            return redirect('admin/excursions');
        }

        return view('admin.excursion.compagnie-liaison-excursion.index', [
            'data' => $data,
            'excursion' => \App\Models\Excursion\Excursion::find($request->excursion)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create(Excursion $excursion) {
        $this->authorize('admin.compagnie-liaison-excursion.create');

        if (!$this->request->ajax()) {
            abort(404);
        }
        return [
            'compagnieTransport' => \App\Models\CompagnieTransport::where(['type_transport' => 'Maritime'])->get(),
            'excursion' => \App\Models\Excursion\Excursion::with(['compagnie', 'depart', 'arrive'])->find($excursion->id),
        ];
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompagnieLiaisonExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCompagnieLiaisonExcursion $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $excursion = \App\Models\Excursion\Excursion::find($sanitized['excursion_id']);

        if (count($sanitized['compagnie_id'])) {
            $excursion->update([
                'lieu_depart_id' => $sanitized['lieu_depart_id'],
                'lieu_arrive_id' => $sanitized['lieu_arrive_id'],
            ]);
        }

        $excursion->compagnie()->sync($sanitized['compagnie_id']);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/compagnie-liaison-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/compagnie-liaison-excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param CompagnieLiaisonExcursion $compagnieLiaisonExcursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(CompagnieLiaisonExcursion $compagnieLiaisonExcursion) {
        $this->authorize('admin.compagnie-liaison-excursion.show', $compagnieLiaisonExcursion);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CompagnieLiaisonExcursion $compagnieLiaisonExcursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(\App\Models\Excursion\Excursion $excursion) {
        $this->authorize('admin.compagnie-liaison-excursion.edit', $excursion);

        if (!$this->request->ajax()) {
            abort(404);
        }
        return [
            'excursion' => \App\Models\Excursion\Excursion::with(['compagnie', 'depart', 'arrive'])->find($excursion->id),
            'compagnieTransport' => \App\Models\CompagnieTransport::where(['type_transport' => 'Maritime'])->get()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompagnieLiaisonExcursion $request
     * @param CompagnieLiaisonExcursion $compagnieLiaisonExcursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCompagnieLiaisonExcursion $request, CompagnieLiaisonExcursion $compagnieLiaisonExcursion) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        return redirect('admin/compagnie-liaison-excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCompagnieLiaisonExcursion $request
     * @param CompagnieLiaisonExcursion $compagnieLiaisonExcursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCompagnieLiaisonExcursion $request, CompagnieLiaisonExcursion $compagnieLiaisonExcursion) {
        $compagnieLiaisonExcursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCompagnieLiaisonExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCompagnieLiaisonExcursion $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        CompagnieLiaisonExcursion::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
