<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FacturationCommande\BulkDestroyFacturationCommande;
use App\Http\Requests\Admin\FacturationCommande\DestroyFacturationCommande;
use App\Http\Requests\Admin\FacturationCommande\IndexFacturationCommande;
use App\Http\Requests\Admin\FacturationCommande\StoreFacturationCommande;
use App\Http\Requests\Admin\FacturationCommande\UpdateFacturationCommande;
use App\Models\FacturationCommande;
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

class FacturationCommandeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexFacturationCommande $request
     * @return array|Factory|View
     */
    public function index(IndexFacturationCommande $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(FacturationCommande::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'nom', 'prenom', 'adresse', 'ville', 'code_postal', 'telephone', 'mobile', 'date', 'commande_id'],

            // set columns to searchIn
            ['id', 'nom', 'prenom', 'adresse', 'ville', 'code_postal', 'telephone', 'mobile']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.facturation-commande.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.facturation-commande.create');

        return view('admin.facturation-commande.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFacturationCommande $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreFacturationCommande $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the FacturationCommande
        $facturationCommande = FacturationCommande::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/facturation-commandes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/facturation-commandes');
    }

    /**
     * Display the specified resource.
     *
     * @param FacturationCommande $facturationCommande
     * @throws AuthorizationException
     * @return void
     */
    public function show(FacturationCommande $facturationCommande)
    {
        $this->authorize('admin.facturation-commande.show', $facturationCommande);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FacturationCommande $facturationCommande
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(FacturationCommande $facturationCommande)
    {
        $this->authorize('admin.facturation-commande.edit', $facturationCommande);


        return view('admin.facturation-commande.edit', [
            'facturationCommande' => $facturationCommande,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFacturationCommande $request
     * @param FacturationCommande $facturationCommande
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFacturationCommande $request, FacturationCommande $facturationCommande)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values FacturationCommande
        $facturationCommande->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/facturation-commandes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/facturation-commandes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyFacturationCommande $request
     * @param FacturationCommande $facturationCommande
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyFacturationCommande $request, FacturationCommande $facturationCommande)
    {
        $facturationCommande->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFacturationCommande $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyFacturationCommande $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    FacturationCommande::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
