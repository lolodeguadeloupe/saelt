<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\TypeHebergement\BulkDestroyTypeHebergement;
use App\Http\Requests\Admin\Hebergement\TypeHebergement\DestroyTypeHebergement;
use App\Http\Requests\Admin\Hebergement\TypeHebergement\IndexTypeHebergement;
use App\Http\Requests\Admin\Hebergement\TypeHebergement\StoreTypeHebergement;
use App\Http\Requests\Admin\Hebergement\TypeHebergement\UpdateTypeHebergement;
use App\Models\Hebergement\TypeHebergement;
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

class TypeHebergementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTypeHebergement $request
     * @return array|Factory|View
     */
    public function index(IndexTypeHebergement $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TypeHebergement::class)->processRequestAndGet(
            // pass the request with params
            $request,
            // set columns to query
            ['id', 'name', 'description'],
            // set columns to searchIn
            ['id', 'name', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.hebergement.type-hebergement.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.type-hebergement.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTypeHebergement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTypeHebergement $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TypeHebergement
        $typeHebergement = TypeHebergement::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/type-hebergements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
                'type_hebergement' => $typeHebergement
            ];
        }

        return redirect('admin/type-hebergements');
    }

    /**
     * Display the specified resource.
     *
     * @param TypeHebergement $typeHebergement
     * @throws AuthorizationException
     * @return void
     */
    public function show(TypeHebergement $typeHebergement)
    {
        $this->authorize('admin.type-hebergement.show', $typeHebergement);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        return ['typeHebergement' => $typeHebergement];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TypeHebergement $typeHebergement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TypeHebergement $typeHebergement)
    {
        $this->authorize('admin.type-hebergement.edit', $typeHebergement);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'typeHebergement' => $typeHebergement,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTypeHebergement $request
     * @param TypeHebergement $typeHebergement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTypeHebergement $request, TypeHebergement $typeHebergement)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TypeHebergement
        $typeHebergement->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/type-hebergements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/type-hebergements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTypeHebergement $request
     * @param TypeHebergement $typeHebergement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTypeHebergement $request, TypeHebergement $typeHebergement)
    {
        $typeHebergement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTypeHebergement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTypeHebergement $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TypeHebergement::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
