<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppConfig\BulkDestroyAppConfig;
use App\Http\Requests\Admin\AppConfig\DestroyAppConfig;
use App\Http\Requests\Admin\AppConfig\IndexAppConfig;
use App\Http\Requests\Admin\AppConfig\StoreAppConfig;
use App\Http\Requests\Admin\AppConfig\UpdateAppConfig;
use App\Models\AppConfig;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AppConfigController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAppConfig $request
     * @return array|Factory|View
     */
    public function index(IndexAppConfig $request)
    {
        $data = AppConfig::with(['ville'])->first();

        return view('admin.app-config.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.app-config.create');

        return view('admin.app-config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAppConfig $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAppConfig $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AppConfig
        $appConfig = AppConfig::create($sanitized);

        if ($request->ajax()) {
            return [
                'appConfig' => $appConfig,
                'redirect' => url('admin/app-configs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')
            ];
        }

        return redirect('admin/app-configs');
    }

    /**
     * Display the specified resource.
     *
     * @param AppConfig $appConfig
     * @throws AuthorizationException
     * @return void
     */
    public function show(AppConfig $appConfig)
    {
        $this->authorize('admin.app-config.show', $appConfig);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AppConfig $appConfig
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Request $request, AppConfig $appConfig)
    {
        $this->authorize('admin.app-config.edit', $appConfig);

        if (!$request->ajax())
            abort(404);
        return [
            'appConfig' => $appConfig,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAppConfig $request
     * @param AppConfig $appConfig
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAppConfig $request, AppConfig $appConfig)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values AppConfig
        $appConfig->update($sanitized);

        if ($request->ajax()) {
            return [
                'appConfig' => $appConfig,
                'redirect' => url('admin/app-configs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/app-configs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAppConfig $request
     * @param AppConfig $appConfig
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAppConfig $request, AppConfig $appConfig)
    {
        $appConfig->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAppConfig $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAppConfig $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    AppConfig::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
