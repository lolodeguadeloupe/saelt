<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TarifBilleterieMaritime\BulkDestroyTarifBilleterieMaritime;
use App\Http\Requests\Admin\TarifBilleterieMaritime\DestroyTarifBilleterieMaritime;
use App\Http\Requests\Admin\TarifBilleterieMaritime\IndexTarifBilleterieMaritime;
use App\Http\Requests\Admin\TarifBilleterieMaritime\StoreTarifBilleterieMaritime;
use App\Http\Requests\Admin\TarifBilleterieMaritime\UpdateTarifBilleterieMaritime;
use App\Models\TarifBilleterieMaritime;
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

class TarifBilleterieMaritimeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTarifBilleterieMaritime $request
     * @return array|Factory|View
     */
    public function index(IndexTarifBilleterieMaritime $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TarifBilleterieMaritime::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'billeterie_maritime_id', 'type_personne_id', 'tarif'],

            // set columns to searchIn
            ['id', 'tarif']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.tarif-billeterie-maritime.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.tarif-billeterie-maritime.create');

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTarifBilleterieMaritime $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTarifBilleterieMaritime $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TarifBilleterieMaritime
        $tarifBilleterieMaritime = TarifBilleterieMaritime::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/tarif-billeterie-maritimes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/tarif-billeterie-maritimes');
    }

    /**
     * Display the specified resource.
     *
     * @param TarifBilleterieMaritime $tarifBilleterieMaritime
     * @throws AuthorizationException
     * @return void
     */
    public function show(TarifBilleterieMaritime $tarifBilleterieMaritime)
    {
        $this->authorize('admin.tarif-billeterie-maritime.show', $tarifBilleterieMaritime);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TarifBilleterieMaritime $tarifBilleterieMaritime
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TarifBilleterieMaritime $tarifBilleterieMaritime)
    {
        $this->authorize('admin.tarif-billeterie-maritime.edit', $tarifBilleterieMaritime);

        $tarifBilleterieMaritime = TarifBilleterieMaritime::with(['personne'])->find($tarifBilleterieMaritime->id);

        return [
            'tarifBilleterieMaritime' => $tarifBilleterieMaritime,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTarifBilleterieMaritime $request
     * @param TarifBilleterieMaritime $tarifBilleterieMaritime
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTarifBilleterieMaritime $request, TarifBilleterieMaritime $tarifBilleterieMaritime)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TarifBilleterieMaritime
        $tarifBilleterieMaritime->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tarif-billeterie-maritimes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/tarif-billeterie-maritimes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTarifBilleterieMaritime $request
     * @param TarifBilleterieMaritime $tarifBilleterieMaritime
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTarifBilleterieMaritime $request, TarifBilleterieMaritime $tarifBilleterieMaritime)
    {
        $tarifBilleterieMaritime->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTarifBilleterieMaritime $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTarifBilleterieMaritime $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TarifBilleterieMaritime::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
