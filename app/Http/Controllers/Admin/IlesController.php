<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ile\BulkDestroyIle;
use App\Http\Requests\Admin\Ile\DestroyIle;
use App\Http\Requests\Admin\Ile\IndexIle;
use App\Http\Requests\Admin\Ile\StoreIle;
use App\Http\Requests\Admin\Ile\UpdateIle;
use App\Http\Requests\Admin\Ile\AutocompletionIle;
use App\Models\Ile;
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

class IlesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexIle $request
     * @return array|Factory|View
     */
    public function index(IndexIle $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Ile::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->with(['pays']);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name', 'card', 'background_image', 'pays_id'],
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

        return view('admin.ile.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.ile.create');

        if (!$this->request->ajax()) {
            abort(404);
        }
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIle $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreIle $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Ile
        $ile = Ile::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/iles'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'ile' => $ile
            ];
        }

        return redirect('admin/iles');
    }

    /**
     * Display the specified resource.
     *
     * @param Ile $ile
     * @throws AuthorizationException
     * @return void
     */
    public function show(Ile $ile) {
        $this->authorize('admin.ile.show', $ile);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        $ile = Ile::with(['pays'])->find($ile->id);

        return ['ile' => $ile];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ile $ile
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Ile $ile) {
        $this->authorize('admin.ile.edit', $ile);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $ile = Ile::with(['pays'])->find($ile->id);

        return [
            'ile' => $ile,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIle $request
     * @param Ile $ile
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateIle $request, Ile $ile) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Ile
        $ile->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/iles'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/iles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyIle $request
     * @param Ile $ile
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyIle $request, Ile $ile) {
        $ile->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyIle $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyIle $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        Ile::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionIle $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = Ile::where('name', 'like', '%' . $sanitized['search'] . '%')
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
