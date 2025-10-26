<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LigneCommandeBilletterie\BulkDestroyLigneCommandeBilletterie;
use App\Http\Requests\Admin\LigneCommandeBilletterie\DestroyLigneCommandeBilletterie;
use App\Http\Requests\Admin\LigneCommandeBilletterie\IndexLigneCommandeBilletterie;
use App\Http\Requests\Admin\LigneCommandeBilletterie\StoreLigneCommandeBilletterie;
use App\Http\Requests\Admin\LigneCommandeBilletterie\UpdateLigneCommandeBilletterie;
use App\Models\LigneCommandeBilletterie;
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

class LigneCommandeBilletterieController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLigneCommandeBilletterie $request
     * @return array|Factory|View
     */
    public function index(IndexLigneCommandeBilletterie $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LigneCommandeBilletterie::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'titre', 'date_depart', 'date_retour', 'quantite', 'compagnie_transport_id', 'compagnie_transport_name', 'lieu_depart_id', 'lieu_depart_name', 'lieu_arrive_id', 'lieu_arrive_name', 'parcours', 'heure_aller', 'heure_retour', 'prix_unitaire', 'prix_total', 'commande_id'],

            // set columns to searchIn
            ['id', 'titre', 'image', 'compagnie_transport_id', 'compagnie_transport_name', 'lieu_depart_id', 'lieu_depart_name', 'lieu_arrive_id', 'lieu_arrive_name', 'heure_aller', 'heure_retour']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.ligne-commande-billetterie.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ligne-commande-billetterie.create');

        return view('admin.ligne-commande-billetterie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLigneCommandeBilletterie $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLigneCommandeBilletterie $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LigneCommandeBilletterie
        $ligneCommandeBilletterie = LigneCommandeBilletterie::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ligne-commande-billetteries'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ligne-commande-billetteries');
    }

    /**
     * Display the specified resource.
     *
     * @param LigneCommandeBilletterie $ligneCommandeBilletterie
     * @throws AuthorizationException
     * @return void
     */
    public function show(LigneCommandeBilletterie $ligneCommandeBilletterie)
    {
        $this->authorize('admin.ligne-commande-billetterie.show', $ligneCommandeBilletterie);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LigneCommandeBilletterie $ligneCommandeBilletterie
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LigneCommandeBilletterie $ligneCommandeBilletterie)
    {
        $this->authorize('admin.ligne-commande-billetterie.edit', $ligneCommandeBilletterie);


        return view('admin.ligne-commande-billetterie.edit', [
            'ligneCommandeBilletterie' => $ligneCommandeBilletterie,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLigneCommandeBilletterie $request
     * @param LigneCommandeBilletterie $ligneCommandeBilletterie
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLigneCommandeBilletterie $request, LigneCommandeBilletterie $ligneCommandeBilletterie)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LigneCommandeBilletterie
        $ligneCommandeBilletterie->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ligne-commande-billetteries'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ligne-commande-billetteries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLigneCommandeBilletterie $request
     * @param LigneCommandeBilletterie $ligneCommandeBilletterie
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLigneCommandeBilletterie $request, LigneCommandeBilletterie $ligneCommandeBilletterie)
    {
        $ligneCommandeBilletterie->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLigneCommandeBilletterie $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLigneCommandeBilletterie $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LigneCommandeBilletterie::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
