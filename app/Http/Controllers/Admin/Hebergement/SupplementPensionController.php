<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\SupplementPension\BulkDestroySupplementPension;
use App\Http\Requests\Admin\Hebergement\SupplementPension\DestroySupplementPension;
use App\Http\Requests\Admin\Hebergement\SupplementPension\IndexSupplementPension;
use App\Http\Requests\Admin\Hebergement\SupplementPension\StoreSupplementPension;
use App\Http\Requests\Admin\Hebergement\SupplementPension\UpdateSupplementPension;
use App\Models\Hebergement\Hebergement;
use App\Models\Hebergement\SupplementPension;
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

class SupplementPensionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSupplementPension $request
     * @return array|Factory|View
     */
    public function index(IndexSupplementPension $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SupplementPension::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->with(['tarif' => function ($query) {
                    $query->with(['personne']);
                },'prestataire']);
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

        return view('admin.hebergement.supplement-pension.index', [
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
        $this->authorize('admin.supplement-pension.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        $heb = Hebergement::find($this->request->heb);

        if ($heb == null) {
            abort(404);
        }

        return [
            'typePersonne' => $heb->personne()->get()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupplementPension $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSupplementPension $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the SupplementPension
        $supplementPension = SupplementPension::create($sanitized);

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            \App\Models\Hebergement\TarifSupplementPension::create([
                'marge' => $sanitized['marge'][$i],
                'prix_achat' => $sanitized['prix_achat'][$i],
                'prix_vente' => $sanitized['prix_vente'][$i],
                'type_personne_id' => $sanitized['type_personne_id'][$i],
                'supplement_id' => $supplementPension->id,
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-pensions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementPension' => $supplementPension
            ];
        }

        return redirect('admin/supplement-pensions');
    }

    /**
     * Display the specified resource.
     *
     * @param SupplementPension $supplementPension
     * @throws AuthorizationException
     * @return void
     */
    public function show(SupplementPension $supplementPension)
    {
        $this->authorize('admin.supplement-pension.show', $supplementPension);

        // TODO your code goes here

        if (!$this->request->ajax()) {
            abort(404);
        }
        $supplementPension = SupplementPension::with(['tarif' => function ($query) {
            $query->with(['personne']);
        },'prestataire'])->find($supplementPension->id);
        $heb = Hebergement::find($supplementPension->hebergement_id);
        return [
            'supplementPension' => $supplementPension,
            'typePersonne' => $heb->personne()->get()
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SupplementPension $supplementPension
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SupplementPension $supplementPension)
    {
        $this->authorize('admin.supplement-pension.edit', $supplementPension);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $supplementPension = SupplementPension::with(['tarif' => function ($query) {
            $query->with(['personne']);
        },'prestataire'])->find($supplementPension->id);
        $heb = Hebergement::find($supplementPension->hebergement_id);
        return [
            'supplementPension' => $supplementPension,
            'typePersonne' => $heb->personne()->get()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplementPension $request
     * @param SupplementPension $supplementPension
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSupplementPension $request, SupplementPension $supplementPension)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SupplementPension
        $supplementPension->update($sanitized);

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            $tarif = \App\Models\Hebergement\TarifSupplementPension::where([
                'type_personne_id' => $sanitized['type_personne_id'][$i],
                'supplement_id' => $supplementPension->id,
            ])->get()
                ->first();
            if ($tarif) {
                $tarif->update([
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'supplement_id' => $supplementPension->id,
                ]);
            } else {
                \App\Models\Hebergement\TarifSupplementPension::create([
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'supplement_id' => $supplementPension->id,
                ]);
            }
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-pensions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'suppelementPension' => $supplementPension
            ];
        }

        return redirect('admin/supplement-pensions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySupplementPension $request
     * @param SupplementPension $supplementPension
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySupplementPension $request, SupplementPension $supplementPension)
    {
        $supplementPension->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySupplementPension $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySupplementPension $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SupplementPension::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
