<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pay\BulkDestroyPay;
use App\Http\Requests\Admin\Pay\DestroyPay;
use App\Http\Requests\Admin\Pay\IndexPay;
use App\Http\Requests\Admin\Pay\StorePay;
use App\Http\Requests\Admin\Pay\UpdatePay;
use App\Http\Requests\Admin\Pay\AutocompletionPays;
use App\Models\Pay;
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

class PaysController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexPay $request
     * @return array|Factory|View
     */
    public function index(IndexPay $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Pay::class)->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'nom'],
                // set columns to searchIn
                ['id', 'nom']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.pays.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.pay.create');

        if (!$this->request->ajax()){
            abort(404);
        }
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePay $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePay $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Pay
        $pay = Pay::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/pays'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'pays' => $pay
            ];
        }

        return redirect('admin/pays');
    }

    /**
     * Display the specified resource.
     *
     * @param Pay $pay
     * @throws AuthorizationException
     * @return void
     */
    public function show(Pay $pay) {
        $this->authorize('admin.pay.show', $pay);

        // TODO your code goes here
        if (!$this->request->ajax()){
            abort(404);
        }
        
        return ['pays'=> $pay];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Pay $pay
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Pay $pay) {
        $this->authorize('admin.pay.edit', $pay);
        
        if (!$this->request->ajax()){
            abort(404);
        }

        return [
            'pays' => $pay,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePay $request
     * @param Pay $pay
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePay $request, Pay $pay) {

        if (!$this->request->ajax()){
            abort(404);
        }

        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Pay
        $pay->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/pays'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/pays');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPay $request
     * @param Pay $pay
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPay $request, Pay $pay) {
        $pay->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPay $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPay $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        Pay::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    
    public function autocompletion(AutocompletionPays $resquest) {
        $sanitized = $resquest->getSanitized();

        $search = Pay::where('nom', 'like', '%' . $sanitized['search'] . '%')
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
