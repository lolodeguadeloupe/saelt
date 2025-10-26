<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaxeExcursion\BulkDestroyTaxeExcursion;
use App\Http\Requests\Admin\TaxeExcursion\DestroyTaxeExcursion;
use App\Http\Requests\Admin\TaxeExcursion\IndexTaxeExcursion;
use App\Http\Requests\Admin\TaxeExcursion\StoreTaxeExcursion;
use App\Http\Requests\Admin\TaxeExcursion\UpdateTaxeExcursion;
use App\Models\TaxeExcursion;
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

class TaxeExcursionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTaxeExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexTaxeExcursion $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TaxeExcursion::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'tarif_excursion_id', 'taxe_id'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.taxe-excursion.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.taxe-excursion.create');

        return view('admin.taxe-excursion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaxeExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTaxeExcursion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the TaxeExcursion
        $taxeExcursion = TaxeExcursion::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/taxe-excursions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/taxe-excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param TaxeExcursion $taxeExcursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(TaxeExcursion $taxeExcursion)
    {
        $this->authorize('admin.taxe-excursion.show', $taxeExcursion);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TaxeExcursion $taxeExcursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TaxeExcursion $taxeExcursion)
    {
        $this->authorize('admin.taxe-excursion.edit', $taxeExcursion);


        return view('admin.taxe-excursion.edit', [
            'taxeExcursion' => $taxeExcursion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaxeExcursion $request
     * @param TaxeExcursion $taxeExcursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTaxeExcursion $request, TaxeExcursion $taxeExcursion)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TaxeExcursion
        $taxeExcursion->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/taxe-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/taxe-excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTaxeExcursion $request
     * @param TaxeExcursion $taxeExcursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTaxeExcursion $request, TaxeExcursion $taxeExcursion)
    {
        $taxeExcursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTaxeExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTaxeExcursion $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TaxeExcursion::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
