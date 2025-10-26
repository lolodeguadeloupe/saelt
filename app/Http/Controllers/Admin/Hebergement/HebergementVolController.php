<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\HebergementVol\BulkDestroyHebergementVol;
use App\Http\Requests\Admin\Hebergement\HebergementVol\DestroyHebergementVol;
use App\Http\Requests\Admin\Hebergement\HebergementVol\IndexHebergementVol;
use App\Http\Requests\Admin\Hebergement\HebergementVol\StoreHebergementVol;
use App\Http\Requests\Admin\Hebergement\HebergementVol\UpdateHebergementVol;
use App\Models\Hebergement\HebergementVol;
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

class HebergementVolController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexHebergementVol $request
     * @return array|Factory|View
     */
    public function index(IndexHebergementVol $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(HebergementVol::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->join('allotements', 'allotements.id', 'hebergements.allotement_id');
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'depart', 'arrive', 'nombre_jour', 'nombre_nuit', 'heure_depart', 'heure_arrive', 'tarif_id', 'allotement_id'],
                // set columns to searchIn
                ['id', 'allotements.titre']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.hebergement.hebergement-vol.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.hebergement-vol.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'allotement' => \App\Models\Hebergement\Allotement::with(['depart', 'arrive'])->where('date_depart', '>=', date('Y-m-d'))->get()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreHebergementVol $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreHebergementVol $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the HebergementVol
        $hebergementVol = HebergementVol::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergement-vols'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergementVol' => $hebergementVol
            ];
        }

        return redirect('admin/hebergement-vols');
    }

    /**
     * Display the specified resource.
     *
     * @param HebergementVol $hebergementVol
     * @throws AuthorizationException
     * @return void
     */
    public function show(HebergementVol $hebergementVol) {
        $this->authorize('admin.hebergement-vol.show', $hebergementVol);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'hebergementVol' => $hebergementVol,
            'allotement' => \App\Models\Hebergement\Allotement::with(['depart', 'arrive'])
                    ->where(function($query) use ($hebergementVol) {
                                $query->where('date_depart', '>=', date('Y-m-d'))
                                ->orWhere(['id' => $hebergementVol->allotement_id]);
                            })
                    ->get()
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HebergementVol $hebergementVol
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(HebergementVol $hebergementVol) {
        $this->authorize('admin.hebergement-vol.edit', $hebergementVol);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'hebergementVol' => HebergementVol::with(['allotement' => function($query) {
                    $query->with(['depart', 'arrive']);
                }])->find($hebergementVol->id),
            'allotement' => \App\Models\Hebergement\Allotement::with(['depart', 'arrive'])
                    ->where(function($query) use ($hebergementVol) {
                                $query->where('date_depart', '>=', date('Y-m-d'))
                                ->orWhere(['id' => $hebergementVol->allotement_id]);
                            })
                    ->get()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHebergementVol $request
     * @param HebergementVol $hebergementVol
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateHebergementVol $request, HebergementVol $hebergementVol) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values HebergementVol
        $hebergementVol->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/hebergement-vols'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'hebergementVol' => $hebergementVol,
            ];
        }

        return redirect('admin/hebergement-vols');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyHebergementVol $request
     * @param HebergementVol $hebergementVol
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyHebergementVol $request, HebergementVol $hebergementVol) {
        $hebergementVol->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyHebergementVol $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyHebergementVol $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        HebergementVol::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
