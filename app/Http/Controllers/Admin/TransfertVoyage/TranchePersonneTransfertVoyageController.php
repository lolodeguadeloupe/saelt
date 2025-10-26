<?php

namespace App\Http\Controllers\Admin\TransfertVoyage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransfertVoyage\TranchePersonneTransfertVoyage\BulkDestroyTranchePersonneTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TranchePersonneTransfertVoyage\DestroyTranchePersonneTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TranchePersonneTransfertVoyage\IndexTranchePersonneTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TranchePersonneTransfertVoyage\StoreTranchePersonneTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TranchePersonneTransfertVoyage\UpdateTranchePersonneTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TranchePersonneTransfertVoyage\AutocompletionTranchePersonneTransfertVoyage;
use App\Models\TransfertVoyage\TranchePersonneTransfertVoyage;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
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

class TranchePersonneTransfertVoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTranchePersonneTransfertVoyage $request
     * @return array|Factory|View
     */
    public function index(IndexTranchePersonneTransfertVoyage $request)
    {
        if (!isset($request->transfert)) {
            abort(404);
        }
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TranchePersonneTransfertVoyage::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['type'])
                ->where(['type_transfert_id' => $request->transfert]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'nombre_min', 'nombre_max', 'type_transfert_id'],
                // set columns to searchIn
                ['id', 'titre']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        $typeTransfetVoyage = TypeTransfertVoyage::find($request->transfert);

        if ($typeTransfetVoyage == null) {
            abort(404);
        }

        return view('admin.transfert-voyage.tranche-personne-transfert-voyage.index', [
            'data' => $data,
            'typeTransfertVoyage' => $typeTransfetVoyage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.tranche-personne-transfert-voyage.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTranchePersonneTransfertVoyage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTranchePersonneTransfertVoyage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        if(!isset($request->transfert)){
            abort(404);
        }
        $typeTransfetVoyage = TypeTransfertVoyage::find($request->transfert);

        if($typeTransfetVoyage == null){
            abort(404);
        }

        $sanitized['type_transfert_id'] = $typeTransfetVoyage->id;

        // Store the TranchePersonneTransfertVoyage
        $tranchePersonneTransfertVoyage = TranchePersonneTransfertVoyage::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tranche-personne-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tranchePersonneTransfertVoyage' => $tranchePersonneTransfertVoyage,
            ];
        }

        return redirect('admin/tranche-personne-transfert-voyages');
    }

    /**
     * Display the specified resource.
     *
     * @param TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage
     * @throws AuthorizationException
     * @return void
     */
    public function show(TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage)
    {
        $this->authorize('admin.tranche-personne-transfert-voyage.show', $tranchePersonneTransfertVoyage);

        if (!$this->request->ajax()) {
            abort(404);
        }
        // TODO your code goes here
        $tranchePersonneTransfertVoyage = TranchePersonneTransfertVoyage::with(['type'])->find($tranchePersonneTransfertVoyage->id);
        return [
            'tranchePersonneTransfertVoyage' => $tranchePersonneTransfertVoyage,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage)
    {
        $this->authorize('admin.tranche-personne-transfert-voyage.edit', $tranchePersonneTransfertVoyage);

        if (!$this->request->ajax()) {
            abort(404);
        }


        $tranchePersonneTransfertVoyage = TranchePersonneTransfertVoyage::with(['type'])->find($tranchePersonneTransfertVoyage->id);

        return [
            'tranchePersonneTransfertVoyage' => $tranchePersonneTransfertVoyage,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTranchePersonneTransfertVoyage $request
     * @param TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTranchePersonneTransfertVoyage $request, TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TranchePersonneTransfertVoyage
        $tranchePersonneTransfertVoyage->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/tranche-personne-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'tranchePersonneTransfertVoyage' => $tranchePersonneTransfertVoyage,
            ];
        }

        return redirect('admin/tranche-personne-transfert-voyages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTranchePersonneTransfertVoyage $request
     * @param TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTranchePersonneTransfertVoyage $request, TranchePersonneTransfertVoyage $tranchePersonneTransfertVoyage)
    {
        $tranchePersonneTransfertVoyage->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTranchePersonneTransfertVoyage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTranchePersonneTransfertVoyage $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TranchePersonneTransfertVoyage::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionTranchePersonneTransfertVoyage $resquest)
    {
        $sanitized = $resquest->getSanitized();
        $search = TranchePersonneTransfertVoyage::with(['type']);
        if ($resquest->type_transfert_id) {
            $search = $search->where(['type_transfert_id' => $resquest->type_transfert_id]);
        }
        $search = $search->where(function ($query) use ($sanitized) {
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
