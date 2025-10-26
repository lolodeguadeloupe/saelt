<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\SupplementVue\BulkDestroySupplementVue;
use App\Http\Requests\Admin\Hebergement\SupplementVue\DestroySupplementVue;
use App\Http\Requests\Admin\Hebergement\SupplementVue\IndexSupplementVue;
use App\Http\Requests\Admin\Hebergement\SupplementVue\StoreSupplementVue;
use App\Http\Requests\Admin\Hebergement\SupplementVue\UpdateSupplementVue;
use App\Models\Hebergement\Hebergement;
use App\Models\Hebergement\SupplementVue;
use App\Models\Hebergement\TypeChambre;
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

class SupplementVueController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSupplementVue $request
     * @return array|Factory|View
     */
    public function index(IndexSupplementVue $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SupplementVue::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['tarif','prestataire']);
                if (isset($request->heb)) {
                    $query->where(['hebergement_id' => $request->heb]);
                }
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'regle_tarif', 'hebergement_id','prestataire_id'],
                // set columns to searchIn
                ['id', 'titre', 'description', 'regle_tarif','prestataire_id']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        if (!(isset($request->heb) && \App\Models\Hebergement\Hebergement::find($request->heb))) {
            return redirect('admin/hebergements');
        }

        return view('admin.hebergement.supplement-vue.index', [
            'data' => $data,
            'hebergement' => \App\Models\Hebergement\Hebergement::find($request->heb),
            'supp_appliquer' => json_encode(config('supp-appliquer'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.supplement-vue.create');

        if (!$this->request->ajax() && !isset($this->request->heb)) {
            abort(404);
        }
        $heb = Hebergement::find($this->request->heb);
        if ($heb == null) {
            abort(404);
        }
        return [
            'chambre' => $heb->chambre()->get()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupplementVue $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSupplementVue $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        if (!isset($this->request->heb)) {
            abort(404);
        }
        $heb = Hebergement::find($this->request->heb);
        if ($heb == null) {
            abort(404);
        }
        //
        $sanitized['hebergement_id'] = $heb->id;
        // Store the SupplementVue
        $supplementVue = SupplementVue::create($sanitized);

        $supplementVue->chambre()->sync($sanitized['chambre']);

        \App\Models\Hebergement\TarifSupplementVue::create([
            'marge' => $sanitized['marge'],
            'prix_achat' => $sanitized['prix_achat'],
            'prix_vente' => $sanitized['prix_vente'],
            'supplement_id' => $supplementVue->id,
        ]);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-vues'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementVue' => $supplementVue
            ];
        }

        return redirect('admin/supplement-vues');
    }

    /**
     * Display the specified resource.
     *
     * @param SupplementVue $supplementVue
     * @throws AuthorizationException
     * @return void
     */
    public function show(SupplementVue $supplementVue)
    {
        $this->authorize('admin.supplement-vue.show', $supplementVue);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }
        $supplementVue = SupplementVue::with(['tarif','prestataire'])->find($supplementVue->id);
        return [
            'supplementVue' => $supplementVue,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SupplementVue $supplementVue
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SupplementVue $supplementVue)
    {
        $this->authorize('admin.supplement-vue.edit', $supplementVue);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $supplementVue = SupplementVue::with(['tarif','prestataire'])
            ->with(['chambre'])
            ->find($supplementVue->id);
        $heb =  Hebergement::find($supplementVue->hebergement_id);
        return [
            'supplementVue' => $supplementVue,
            'chambre' => $heb->chambre()->get()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplementVue $request
     * @param SupplementVue $supplementVue
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSupplementVue $request, SupplementVue $supplementVue)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SupplementVue
        $supplementVue->update($sanitized);

        $supplementVue->chambre()->sync($sanitized['chambre']);

        $tarif = \App\Models\Hebergement\TarifSupplementVue::where([
            'supplement_id' => $supplementVue->id,
        ])->get()
            ->first();
        if ($tarif) {
            $tarif->update([
                'marge' => $sanitized['marge'],
                'prix_achat' => $sanitized['prix_achat'],
                'prix_vente' => $sanitized['prix_vente'],
                'supplement_id' => $supplementVue->id,
            ]);
        } else {
            \App\Models\Hebergement\TarifSupplementVue::create([
                'marge' => $sanitized['marge'],
                'prix_achat' => $sanitized['prix_achat'],
                'prix_vente' => $sanitized['prix_vente'],
                'supplement_id' => $supplementVue->id,
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-vues'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementVue' => $supplementVue
            ];
        }

        return redirect('admin/supplement-vues');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySupplementVue $request
     * @param SupplementVue $supplementVue
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySupplementVue $request, SupplementVue $supplementVue)
    {
        $supplementVue->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySupplementVue $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySupplementVue $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SupplementVue::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
