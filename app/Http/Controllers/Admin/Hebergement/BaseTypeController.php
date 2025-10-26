<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\BaseType\BulkDestroyBaseType;
use App\Http\Requests\Admin\Hebergement\BaseType\DestroyBaseType;
use App\Http\Requests\Admin\Hebergement\BaseType\IndexBaseType;
use App\Http\Requests\Admin\Hebergement\BaseType\StoreBaseType;
use App\Http\Requests\Admin\Hebergement\BaseType\UpdateBaseType;
use App\Models\Hebergement\BaseType;
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

class BaseTypeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexBaseType $request
     * @return array|Factory|View
     */
    public function index(IndexBaseType $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(BaseType::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre','nombre','description','reference_prix'],
                // set columns to searchIn
                ['id', 'titre', 'description','nombre']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.hebergement.base-type.index', [
            'data' => $data,
            'hebergement' => \App\Models\Hebergement\Hebergement::find($request->heb)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.base-type.create');

        if (!$this->request->ajax()){
            abort(404);
        }
        
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBaseType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBaseType $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the BaseType
        $sanitized['reference_prix'] = 0;
        $baseType = BaseType::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/base-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'base_types' => BaseType::all(),
                'baseType'=> $baseType
            ];
        }

        return redirect('admin/base-types');
    }

    /**
     * Display the specified resource.
     *
     * @param BaseType $baseType
     * @throws AuthorizationException
     * @return void
     */
    public function show(BaseType $baseType) {
        $this->authorize('admin.base-type.show', $baseType);

        // TODO your code goes here
        if (!$this->request->ajax()){
            abort(404);
        }
        
        return ['baseType' => $baseType];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BaseType $baseType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(BaseType $baseType) {
        $this->authorize('admin.base-type.edit', $baseType);

        if (!$this->request->ajax()){
            abort(404);
        }

        return [
            'baseType' => $baseType,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBaseType $request
     * @param BaseType $baseType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBaseType $request, BaseType $baseType) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values BaseType
        $baseType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/base-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'baseType' => $baseType,
            ];
        }

        return redirect('admin/base-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBaseType $request
     * @param BaseType $baseType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBaseType $request, BaseType $baseType) {
        $baseType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBaseType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBaseType $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        BaseType::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
