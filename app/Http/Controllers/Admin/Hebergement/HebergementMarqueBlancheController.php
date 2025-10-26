<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\HebergementMarqueBlanche\BulkDestroyHebergementMarqueBlanche;
use App\Http\Requests\Admin\Hebergement\HebergementMarqueBlanche\DestroyHebergementMarqueBlanche;
use App\Http\Requests\Admin\Hebergement\HebergementMarqueBlanche\IndexHebergementMarqueBlanche;
use App\Http\Requests\Admin\Hebergement\HebergementMarqueBlanche\StoreHebergementMarqueBlanche;
use App\Http\Requests\Admin\Hebergement\HebergementMarqueBlanche\UpdateHebergementMarqueBlanche;
use App\Models\Hebergement\HebergementMarqueBlanche;
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

class HebergementMarqueBlancheController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexHebergementMarqueBlanche $request
     * @return array|Factory|View
     */
    public function index(IndexHebergementMarqueBlanche $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(HebergementMarqueBlanche::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('type_hebergement', 'hebergement_marque_blanche.type_hebergement_id', 'type_hebergement.id');
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'liens', 'description', 'image', 'type_hebergement_id'],
                // set columns to searchIn
                ['id', 'liens','type_hebergement.name','description'], function ($query) use ($request) {
            $query->with(['type']);
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

        return view('admin.hebergement.hebergement-marque-blanche.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.hebergement-marque-blanche.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHebergementMarqueBlanche $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreHebergementMarqueBlanche $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        // Store the HebergementMarqueBlanche
        $hebergementMarqueBlanche = HebergementMarqueBlanche::create($sanitized);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $hebergementMarqueBlanche->id . '_hebMQ';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergement-marque-blanches'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergementMarqueBlanche' => $hebergementMarqueBlanche,
            ];
        }

        return redirect('admin/hebergement-marque-blanches');
    }

    /**
     * Display the specified resource.
     *
     * @param HebergementMarqueBlanche $hebergementMarqueBlanche
     * @throws AuthorizationException
     * @return void
     */
    public function show(HebergementMarqueBlanche $hebergementMarqueBlanche) {
        $this->authorize('admin.hebergement-marque-blanche.show', $hebergementMarqueBlanche);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        $hebergementMarqueBlanche['image'] = \App\Models\MediaImageUpload::where(['id_model' => $hebergementMarqueBlanche->id . '_hebMQ'])->get();

        return [
            'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
            'hebergementMarqueBlanche' => $hebergementMarqueBlanche,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HebergementMarqueBlanche $hebergementMarqueBlanche
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(HebergementMarqueBlanche $hebergementMarqueBlanche) {
        $this->authorize('admin.hebergement-marque-blanche.edit', $hebergementMarqueBlanche);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $hebergementMarqueBlanche['image'] = \App\Models\MediaImageUpload::where(['id_model' => $hebergementMarqueBlanche->id . '_hebMQ'])->get();

        return [
            'hebergementMarqueBlanche' => $hebergementMarqueBlanche,
            'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHebergementMarqueBlanche $request
     * @param HebergementMarqueBlanche $hebergementMarqueBlanche
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateHebergementMarqueBlanche $request, HebergementMarqueBlanche $hebergementMarqueBlanche) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        // Update changed values HebergementMarqueBlanche
        $hebergementMarqueBlanche->update($sanitized);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $hebergementMarqueBlanche->id . '_hebMQ';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergement-marque-blanches'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergementMarqueBlanche' => $hebergementMarqueBlanche,
                'type_hebergements' => \App\Models\Hebergement\TypeHebergement::all(),
            ];
        }

        return redirect('admin/hebergement-marque-blanches');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyHebergementMarqueBlanche $request
     * @param HebergementMarqueBlanche $hebergementMarqueBlanche
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyHebergementMarqueBlanche $request, HebergementMarqueBlanche $hebergementMarqueBlanche) {
        $hebergementMarqueBlanche->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyHebergementMarqueBlanche $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyHebergementMarqueBlanche $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        HebergementMarqueBlanche::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
