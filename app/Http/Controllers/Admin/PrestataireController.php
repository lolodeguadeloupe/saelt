<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Prestataire\BulkDestroyPrestataire;
use App\Http\Requests\Admin\Prestataire\DestroyPrestataire;
use App\Http\Requests\Admin\Prestataire\IndexPrestataire;
use App\Http\Requests\Admin\Prestataire\StorePrestataire;
use App\Http\Requests\Admin\Prestataire\UpdatePrestataire;
use App\Models\Prestataire;
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
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Prestataire\AutocompletionPrestataire;

class PrestataireController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexPrestataire $request
     * @return array|Factory|View
     */
    public function index(IndexPrestataire $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Prestataire::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->with(['ville' => function($query) {
                            $query->with(['pays']);
                        }]);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name', 'adresse', 'phone', 'email','ville_id'],
                // set columns to searchIn
                ['id', 'name', 'adresse', 'phone', 'email']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.prestataire.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.prestataire.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePrestataire $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePrestataire $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Prestataire
        $prestataire = Prestataire::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/prestataires'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'prestataire' => Prestataire::with(['ville'])->find($prestataire->id)
            ];
        }

        return redirect('admin/prestataires');
    }

    /**
     * Display the specified resource.
     *
     * @param Prestataire $prestataire
     * @throws AuthorizationException
     * @return void
     */
    public function show(Prestataire $prestataire) {
        $this->authorize('admin.prestataire.show', $prestataire);

        // TODO your code goes here

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'prestataire' => Prestataire::with(['ville'])->find($prestataire->id),
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Prestataire $prestataire
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Prestataire $prestataire, \Illuminate\Http\Request $request) {
        $this->authorize('admin.prestataire.edit', $prestataire);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'prestataire' => Prestataire::with(['ville'])->find($prestataire->id),
            'pays' => \App\Models\Pay::all(),
            'villes' => \App\Models\Ville::all(),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePrestataire $request
     * @param Prestataire $prestataire
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePrestataire $request, Prestataire $prestataire) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Prestataire
        $prestataire->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/prestataires'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'prestataire' => Prestataire::with(['ville'])->find($prestataire->id)
            ];
        }

        return redirect('admin/prestataires');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPrestataire $request
     * @param Prestataire $prestataire
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPrestataire $request, Prestataire $prestataire) {
        $prestataire->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPrestataire $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPrestataire $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        Prestataire::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionPrestataire $resquest) {
        $sanitized = $resquest->getSanitized();

        $prestataire = Prestataire::with(['ville'=>function($query){$query->with(['pays']);}])->where('name', 'like', '%' . $sanitized['search'] . '%')
                ->limit(20)
                ->get();

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'search' => $prestataire,
        ];
    }

}
