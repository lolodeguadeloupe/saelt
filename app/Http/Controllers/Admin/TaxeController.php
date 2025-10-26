<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Taxe\BulkDestroyTaxe;
use App\Http\Requests\Admin\Taxe\DestroyTaxe;
use App\Http\Requests\Admin\Taxe\IndexTaxe;
use App\Http\Requests\Admin\Taxe\StoreTaxe;
use App\Http\Requests\Admin\Taxe\UpdateTaxe;
use App\Models\Taxe;
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

class TaxeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTaxe $request
     * @return array|Factory|View
     */
    public function index(IndexTaxe $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Taxe::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'valeur_pourcent', 'valeur_devises','taxe_appliquer'],
                // set columns to searchIn
                ['id', 'titre', 'descciption']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.taxe.index', [
                    'data' => $data,
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.taxe.create');

        if (!$this->request->ajax()) {
            abort(404);
        }
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaxe $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTaxe $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Taxe
        $taxe = Taxe::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/taxes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'taxe' => $taxe,
            ];
        }

        return redirect('admin/taxes');
    }

    /**
     * Display the specified resource.
     *
     * @param Taxe $taxe
     * @throws AuthorizationException
     * @return void
     */
    public function show(Taxe $taxe) {
        $this->authorize('admin.taxe.show', $taxe);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Taxe $taxe
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Taxe $taxe) {
        $this->authorize('admin.taxe.edit', $taxe);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'taxe' => $taxe,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaxe $request
     * @param Taxe $taxe
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTaxe $request, Taxe $taxe) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Taxe
        $taxe->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/taxes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'taxe' => $taxe,
            ];
        }

        return redirect('admin/taxes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTaxe $request
     * @param Taxe $taxe
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTaxe $request, Taxe $taxe) {
        $taxe->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTaxe $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTaxe $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        Taxe::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

}
