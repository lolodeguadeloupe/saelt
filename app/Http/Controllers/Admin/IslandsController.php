<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Island\BulkDestroyIsland;
use App\Http\Requests\Admin\Island\DestroyIsland;
use App\Http\Requests\Admin\Island\IndexIsland;
use App\Http\Requests\Admin\Island\StoreIsland;
use App\Http\Requests\Admin\Island\UpdateIsland;
use App\Models\Island;
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

class IslandsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexIsland $request
     * @return array|Factory|View
     */
    public function index(IndexIsland $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Island::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.island.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.island.create');

        if (!$this->request->ajax()){
            abort(404);
        }
        
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIsland $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreIsland $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Island
        $island = Island::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/islands'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/islands');
    }

    /**
     * Display the specified resource.
     *
     * @param Island $island
     * @throws AuthorizationException
     * @return void
     */
    public function show(Island $island)
    {
        $this->authorize('admin.island.show', $island);

        // TODO your code goes here
        
        if (!$this->request->ajax()){
            abort(404);
        }
        
        return ['islande' => $island];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Island $island
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Island $island)
    {
        $this->authorize('admin.island.edit', $island);

        if (!$this->request->ajax()){
            abort(404);
        }

        return [
            'island' => $island,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIsland $request
     * @param Island $island
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateIsland $request, Island $island)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Island
        $island->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/islands'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/islands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyIsland $request
     * @param Island $island
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyIsland $request, Island $island)
    {
        $island->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyIsland $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyIsland $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Island::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
