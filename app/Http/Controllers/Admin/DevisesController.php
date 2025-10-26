<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Devise\BulkDestroyDevise;
use App\Http\Requests\Admin\Devise\DestroyDevise;
use App\Http\Requests\Admin\Devise\IndexDevise;
use App\Http\Requests\Admin\Devise\StoreDevise;
use App\Http\Requests\Admin\Devise\UpdateDevise;
use App\Models\Devise;
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

class DevisesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexDevise $request
     * @return array|Factory|View
     */
    public function index(IndexDevise $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Devise::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'symbole'],
                // set columns to searchIn
                ['id', 'titre', 'symbole']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.devise.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.devise.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDevise $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDevise $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Devise
        $devise = Devise::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/devises'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'devises' => Devise::all()
            ];
        }

        return redirect('admin/devises');
    }

    /**
     * Display the specified resource.
     *
     * @param Devise $devise
     * @throws AuthorizationException
     * @return void
     */
    public function show(Devise $devise) {
        $this->authorize('admin.devise.show', $devise);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }
        return ['devises' => $devise];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Devise $devise
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Devise $devise) {
        $this->authorize('admin.devise.edit', $devise);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'devise' => $devise,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDevise $request
     * @param Devise $devise
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDevise $request, Devise $devise) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Devise
        $devise->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/devises'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/devises');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDevise $request
     * @param Devise $devise
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDevise $request, Devise $devise) {
        $devise->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDevise $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDevise $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        Devise::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
