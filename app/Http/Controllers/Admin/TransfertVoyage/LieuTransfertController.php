<?php

namespace App\Http\Controllers\Admin\TransfertVoyage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransfertVoyage\LieuTransfert\BulkDestroyLieuTransfert;
use App\Http\Requests\Admin\TransfertVoyage\LieuTransfert\DestroyLieuTransfert;
use App\Http\Requests\Admin\TransfertVoyage\LieuTransfert\IndexLieuTransfert;
use App\Http\Requests\Admin\TransfertVoyage\LieuTransfert\StoreLieuTransfert;
use App\Http\Requests\Admin\TransfertVoyage\LieuTransfert\UpdateLieuTransfert;
use App\Http\Requests\Admin\TransfertVoyage\LieuTransfert\AutocompletionLieuTransfert;
use App\Models\TransfertVoyage\LieuTransfert;
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

class LieuTransfertController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexLieuTransfert $request
     * @return array|Factory|View
     */
    public function index(IndexLieuTransfert $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LieuTransfert::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->leftjoin('villes', 'villes.id', 'lieu_transfert.ville_id');
                    $query->with(['ville' => function($query) {
                            $query->with(['pays']);
                        }]);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'adresse', 'ville_id'],
                // set columns to searchIn
                ['id', 'titre', 'adresse','ville.name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.transfert-voyage.lieu-transfert.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.lieu-transfert.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLieuTransfert $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLieuTransfert $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LieuTransfert
        $lieuTransfert = LieuTransfert::create($sanitized);

        $lieuTransfert = LieuTransfert::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($lieuTransfert->id);
                    
        if ($request->ajax()) {
            return [
                'redirect' => url('admin/lieu-transferts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'lieuTransfert' => $lieuTransfert,
            ];
        }

        return redirect('admin/lieu-transferts');
    }

    /**
     * Display the specified resource.
     *
     * @param LieuTransfert $lieuTransfert
     * @throws AuthorizationException
     * @return void
     */
    public function show(LieuTransfert $lieuTransfert) {
        $this->authorize('admin.lieu-transfert.show', $lieuTransfert);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        $lieuTransfert = LieuTransfert::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($lieuTransfert->id);

        return ['lieuTransfert' => $lieuTransfert];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LieuTransfert $lieuTransfert
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LieuTransfert $lieuTransfert) {
        $this->authorize('admin.lieu-transfert.edit', $lieuTransfert);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $lieuTransfert = LieuTransfert::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($lieuTransfert->id);

        return [
            'lieuTransfert' => $lieuTransfert,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLieuTransfert $request
     * @param LieuTransfert $lieuTransfert
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLieuTransfert $request, LieuTransfert $lieuTransfert) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LieuTransfert
        $lieuTransfert->update($sanitized);

        $lieuTransfert = LieuTransfert::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->find($lieuTransfert->id);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/lieu-transferts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'lieuTransfert' => $lieuTransfert,
            ];
        }

        return redirect('admin/lieu-transferts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLieuTransfert $request
     * @param LieuTransfert $lieuTransfert
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLieuTransfert $request, LieuTransfert $lieuTransfert) {
        $lieuTransfert->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLieuTransfert $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLieuTransfert $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        LieuTransfert::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionLieuTransfert $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = LieuTransfert::with(['ville' => function($query) {
                        $query->with(['pays']);
                    }])->where(function($query) use($sanitized) {
                    $query->where('titre', 'like', '%' . $sanitized['search'] . '%');
                })
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
