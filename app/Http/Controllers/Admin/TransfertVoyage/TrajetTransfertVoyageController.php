<?php

namespace App\Http\Controllers\Admin\TransfertVoyage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransfertVoyage\TrajetTransfertVoyage\BulkDestroyTrajetTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TrajetTransfertVoyage\DestroyTrajetTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TrajetTransfertVoyage\IndexTrajetTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TrajetTransfertVoyage\StoreTrajetTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TrajetTransfertVoyage\UpdateTrajetTransfertVoyage;
use App\Http\Requests\Admin\TransfertVoyage\TrajetTransfertVoyage\AutocompletionTrajetTransfertVoyage;
use App\Models\TransfertVoyage\TrajetTransfertVoyage;
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

class TrajetTransfertVoyageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTrajetTransfertVoyage $request
     * @return array|Factory|View
     */
    public function index(IndexTrajetTransfertVoyage $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TrajetTransfertVoyage::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('lieu_transfert', 'lieu_transfert.id', 'trajet_transfert_voyage.point_depart');
                    $query->join('lieu_transfert as arrive', 'arrive.id', 'trajet_transfert_voyage.point_arrive');
                    $query->with(['point_depart', 'point_arrive']);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'point_depart', 'point_arrive', 'card'],
                // set columns to searchIn
                ['id', 'titre', 'point_depart', 'point_arrive', 'description', 'arrive.titre', 'lieu_transfert.titre']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.transfert-voyage.trajet-transfert-voyage.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.trajet-transfert-voyage.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTrajetTransfertVoyage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTrajetTransfertVoyage $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TrajetTransfertVoyage
        $trajetTransfertVoyage = TrajetTransfertVoyage::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trajet-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'trajetTransfertVoyage' => $trajetTransfertVoyage,
            ];
        }

        return redirect('admin/trajet-transfert-voyages');
    }

    /**
     * Display the specified resource.
     *
     * @param TrajetTransfertVoyage $trajetTransfertVoyage
     * @throws AuthorizationException
     * @return void
     */
    public function show(TrajetTransfertVoyage $trajetTransfertVoyage) {
        $this->authorize('admin.trajet-transfert-voyage.show', $trajetTransfertVoyage);
        if (!$this->request->ajax()) {
            abort(404);
        }
        // TODO your code goes here
        $trajetTransfertVoyage = TrajetTransfertVoyage::with(['point_depart', 'point_arrive'])
                ->find($trajetTransfertVoyage->id);
        return [
            'trajetTransfertVoyage' => $trajetTransfertVoyage,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TrajetTransfertVoyage $trajetTransfertVoyage
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TrajetTransfertVoyage $trajetTransfertVoyage) {
        $this->authorize('admin.trajet-transfert-voyage.edit', $trajetTransfertVoyage);

        if (!$this->request->ajax()) {
            abort(404);
        }
        $trajetTransfertVoyage = TrajetTransfertVoyage::with(['point_depart', 'point_arrive'])
                ->find($trajetTransfertVoyage->id);
        return [
            'trajetTransfertVoyage' => $trajetTransfertVoyage,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTrajetTransfertVoyage $request
     * @param TrajetTransfertVoyage $trajetTransfertVoyage
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTrajetTransfertVoyage $request, TrajetTransfertVoyage $trajetTransfertVoyage) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TrajetTransfertVoyage
        $trajetTransfertVoyage->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/trajet-transfert-voyages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'trajetTransfertVoyage' => $trajetTransfertVoyage,
            ];
        }

        return redirect('admin/trajet-transfert-voyages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTrajetTransfertVoyage $request
     * @param TrajetTransfertVoyage $trajetTransfertVoyage
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTrajetTransfertVoyage $request, TrajetTransfertVoyage $trajetTransfertVoyage) {
        $trajetTransfertVoyage->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTrajetTransfertVoyage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTrajetTransfertVoyage $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        TrajetTransfertVoyage::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionTrajetTransfertVoyage $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = TrajetTransfertVoyage::with(['point_depart', 'point_arrive'])
                ->where(function($query) use($sanitized) {
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
