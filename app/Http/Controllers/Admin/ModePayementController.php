<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModePayement\BulkDestroyModePayement;
use App\Http\Requests\Admin\ModePayement\DestroyModePayement;
use App\Http\Requests\Admin\ModePayement\IndexModePayement;
use App\Http\Requests\Admin\ModePayement\StoreModePayement;
use App\Http\Requests\Admin\ModePayement\UpdateModePayement;
use App\Models\ModePayement;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ModePayementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexModePayement $request
     * @return array|Factory|View
     */
    public function index(IndexModePayement $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ModePayement::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['config']);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,

                // set columns to query
                ['id', 'titre', 'icon'],

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

        return view('admin.mode-payement.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $this->authorize('admin.mode-payement.create');

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreModePayement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreModePayement $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ModePayement
        $modePayement = ModePayement::create($sanitized);

        $modePayement->config()->create([
            'key_test' => $sanitized['key_test'],
            'key_prod' => $sanitized['key_prod'],
            'base_url_test' => $sanitized['base_url_test'],
            'base_url_prod' => $sanitized['base_url_prod'],
            'api_version' => $sanitized['api_version'],
            'mode' => $sanitized['mode'],
            'api_version' => $sanitized['api_version']
        ]);

        if ($request->ajax()) {
            return ['redirect' => url('admin/mode-payements'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/mode-payements');
    }

    /**
     * Display the specified resource.
     *
     * @param ModePayement $modePayement
     * @throws AuthorizationException
     * @return void
     */
    public function show(Request $request, ModePayement $modePayement)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $this->authorize('admin.mode-payement.show', $modePayement);

        // TODO your code goes here
        return  [
            'modePayement' => $modePayement,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ModePayement $modePayement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Request $request, ModePayement $modePayement)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $this->authorize('admin.mode-payement.edit', $modePayement);


        return  [
            'modePayement' => ModePayement::with(['config'])->find($modePayement->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateModePayement $request
     * @param ModePayement $modePayement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateModePayement $request, ModePayement $modePayement)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ModePayement
        $modePayement->update($sanitized);
        $modePayement->config()->update([
            'key_test' => $sanitized['key_test'],
            'key_prod' => $sanitized['key_prod'],
            'base_url_test' => $sanitized['base_url_test'],
            'base_url_prod' => $sanitized['base_url_prod'],
            'api_version' => $sanitized['api_version'],
            'mode' => $sanitized['mode'],
            'api_version' => $sanitized['api_version']
        ]);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/mode-payements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/mode-payements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyModePayement $request
     * @param ModePayement $modePayement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyModePayement $request, ModePayement $modePayement)
    {
        $modePayement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyModePayement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyModePayement $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ModePayement::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
