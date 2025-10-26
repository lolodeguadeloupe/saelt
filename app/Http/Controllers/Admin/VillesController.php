<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ville\BulkDestroyVille;
use App\Http\Requests\Admin\Ville\DestroyVille;
use App\Http\Requests\Admin\Ville\IndexVille;
use App\Http\Requests\Admin\Ville\StoreVille;
use App\Http\Requests\Admin\Ville\UpdateVille;
use App\Http\Requests\Admin\Ville\AutocompletionVille;
use App\Models\Ville;
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

class VillesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVille $request
     * @return array|Factory|View
     */
    public function index(IndexVille $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Ville::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->join('pays','villes.pays_id','pays.id');
                $query->with(['pays']);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name','code_postal', 'pays_id'],
                // set columns to searchIn
                ['id', 'name','code_postal', 'pays_id']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        
        return view('admin.ville.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create(\Illuminate\Http\Request $request)
    {
        $this->authorize('admin.ville.create');

        if ($request->ajax()) {
            return [
                'pays' => []
            ];
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVille $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVille $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Ville
        $ville = Ville::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/villes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'ville' => $ville
            ];
        }

        return redirect('admin/villes');
    }

    /**
     * Display the specified resource.
     *
     * @param Ville $ville
     * @throws AuthorizationException
     * @return void
     */
    public function show(Ville $ville)
    {
        $this->authorize('admin.ville.show', $ville);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        return ['ville' => $ville];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ville $ville
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Ville $ville)
    {
        $this->authorize('admin.ville.edit', $ville);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'ville' => Ville::with(['pays'])->find($ville->id),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVille $request
     * @param Ville $ville
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVille $request, Ville $ville)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Ville
        $ville->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/villes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/villes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVille $request
     * @param Ville $ville
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVille $request, Ville $ville)
    {
        $ville->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVille $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVille $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Ville::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionVille $resquest)
    {
        $sanitized = $resquest->getSanitized();

        $search = Ville::where('name', 'like', '%' . $sanitized['search'] . '%')
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
