<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlaningTime\BulkDestroyPlaningTime;
use App\Http\Requests\Admin\PlaningTime\DestroyPlaningTime;
use App\Http\Requests\Admin\PlaningTime\IndexPlaningTime;
use App\Http\Requests\Admin\PlaningTime\StorePlaningTime;
use App\Http\Requests\Admin\PlaningTime\UpdatePlaningTime;
use App\Models\PlaningTime;
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

class PlaningTimeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexPlaningTime $request
     * @return array|Factory|View
     */
    public function index(IndexPlaningTime $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(PlaningTime::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'id_model', 'debut', 'fin','availability'],
                // set columns to searchIn
                ['id', 'id_model']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.planing-time.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.planing-time.create');

        return view('admin.planing-time.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePlaningTime $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePlaningTime $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the PlaningTime
        $planingTime = PlaningTime::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/planing-times'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'planingTime' => $sanitized,
            ];
        }

        return redirect('admin/planing-times');
    }

    /**
     * Display the specified resource.
     *
     * @param PlaningTime $planingTime
     * @throws AuthorizationException
     * @return void
     */
    public function show(PlaningTime $planingTime) {
        $this->authorize('admin.planing-time.show', $planingTime);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PlaningTime $planingTime
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(PlaningTime $planingTime) {
        $this->authorize('admin.planing-time.edit', $planingTime);


        return view('admin.planing-time.edit', [
            'planingTime' => $planingTime,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePlaningTime $request
     * @param PlaningTime $planingTime
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePlaningTime $request, PlaningTime $planingTime) { 
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values PlaningTime
        $planingTime->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/planing-times'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/planing-times');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPlaningTime $request
     * @param PlaningTime $planingTime
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPlaningTime $request, PlaningTime $planingTime) {
        $planingTime->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPlaningTime $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPlaningTime $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        PlaningTime::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
