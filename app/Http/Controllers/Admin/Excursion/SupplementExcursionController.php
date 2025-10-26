<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excursion\SupplementExcursion\BulkDestroySupplementExcursion;
use App\Http\Requests\Admin\Excursion\SupplementExcursion\DestroySupplementExcursion;
use App\Http\Requests\Admin\Excursion\SupplementExcursion\IndexSupplementExcursion;
use App\Http\Requests\Admin\Excursion\SupplementExcursion\StoreSupplementExcursion;
use App\Http\Requests\Admin\Excursion\SupplementExcursion\UpdateSupplementExcursion;
use App\Models\Excursion\Excursion;
use App\Models\Excursion\SupplementExcursion;
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

class SupplementExcursionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSupplementExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexSupplementExcursion $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SupplementExcursion::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->where(['excursion_id' => $request->excursion]);
                $query->with(['tarif' => function ($query) use ($request) {
                    $query->with(['personne']);
                },'prestataire']);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'titre', 'type', 'description', 'excursion_id','prestataire_id'],
                // set columns to searchIn
                ['id', 'titre', 'description','prestataire_id']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        if (!(isset($request->excursion) && Excursion::find($request->excursion))) {
            return redirect('admin/excursions');
        }

        return view('admin.excursion.supplement-excursion.index', [
            'data' => $data,
            'excursion' => Excursion::find($request->excursion),
            'typeSupplement' => $this->typeSupplement
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
        $this->authorize('admin.supplement-excursion.create');

        if (!$this->request->ajax()) {
            abort(404);
        }
        $exc = Excursion::find($this->request->excursion);
        if ($exc == null) {
            abort(404);
        }
        return [
            'typePersonne' => $exc->personne()->get()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupplementExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSupplementExcursion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the SupplementExcursion
        $supplementExcursion = SupplementExcursion::create($sanitized);

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            \App\Models\Excursion\TarifSupplementExcursion::create([
                'marge' => $sanitized['marge'][$i],
                'prix_achat' => $sanitized['prix_achat'][$i],
                'prix_vente' => $sanitized['prix_vente'][$i],
                'type_personne_id' => $sanitized['type_personne_id'][$i],
                'supplement_excursion_id' => $supplementExcursion->id,
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementExcursion' => SupplementExcursion::with(['tarif' => function ($query) {
                    $query->with(['personne']);
                }])->find($supplementExcursion->id),
            ];
        }

        return redirect('admin/supplement-excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param SupplementExcursion $supplementExcursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(SupplementExcursion $supplementExcursion)
    {
        $this->authorize('admin.supplement-excursion.show', $supplementExcursion);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SupplementExcursion $supplementExcursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SupplementExcursion $supplementExcursion)
    {
        $this->authorize('admin.supplement-excursion.edit', $supplementExcursion);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $supplementExcursion = SupplementExcursion::with(['tarif' => function ($query) {
            $query->with(['personne']);
        },'prestataire'])->find($supplementExcursion->id);
        $exc = Excursion::find($supplementExcursion->excursion_id);
        return [
            'supplementExcursion' => $supplementExcursion,
            'typePersonne' => $exc->personne()->get()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplementExcursion $request
     * @param SupplementExcursion $supplementExcursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSupplementExcursion $request, SupplementExcursion $supplementExcursion)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SupplementExcursion
        $supplementExcursion->update($sanitized);

        for ($i = 0; $i < count($sanitized['type_personne_id']); $i++) {
            $tarif = \App\Models\Excursion\TarifSupplementExcursion::where([
                'type_personne_id' => $sanitized['type_personne_id'][$i],
                'supplement_excursion_id' => $supplementExcursion->id,
            ])->get()
                ->first();
            if ($tarif) {
                $tarif->update([
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'supplement_excursion_id' => $supplementExcursion->id,
                ]);
            } else {
                \App\Models\Excursion\TarifSupplementExcursion::create([
                    'marge' => $sanitized['marge'][$i],
                    'prix_achat' => $sanitized['prix_achat'][$i],
                    'prix_vente' => $sanitized['prix_vente'][$i],
                    'type_personne_id' => $sanitized['type_personne_id'][$i],
                    'supplement_excursion_id' => $supplementExcursion->id,
                ]);
            }
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementExcursion' => SupplementExcursion::with(['tarif' => function ($query) {
                    $query->with(['personne']);
                }])->find($supplementExcursion->id),
            ];
        }

        return redirect('admin/supplement-excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySupplementExcursion $request
     * @param SupplementExcursion $supplementExcursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySupplementExcursion $request, SupplementExcursion $supplementExcursion)
    {
        $supplementExcursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySupplementExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySupplementExcursion $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SupplementExcursion::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
