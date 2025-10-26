<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitConditionTarifaire\StoreProduitConditionTarifaire;
use App\Models\ProduitConditionTarifaire;
use App\Models\Excursion\Excursion;
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

class ProduitConditionTarifaireExcursionController extends Controller {

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProduitConditionTarifaire $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProduitConditionTarifaire $request) {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ProduitConditionTarifaire
        $produitConditionTarifaire = ProduitConditionTarifaire::where([
            'model_id' => 'excursion_' . $sanitized['model_id']
        ])->first();

        if ($produitConditionTarifaire) {
            $produitConditionTarifaire->update([
                'condition_tarifaire' => $sanitized['condition_tarifaire']
            ]);
        } else {
            $produitConditionTarifaire = ProduitConditionTarifaire::create([
                'model_id' => 'excursion_' . $sanitized['model_id'],
                'condition_tarifaire' => $sanitized['condition_tarifaire']
            ]);
        }
        
        $produitConditionTarifaire = ProduitConditionTarifaire::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/excursion-produit-condition-tarifaires/'.$sanitized['model_id']), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/excursion-produit-condition-tarifaires/'.$sanitized['model_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param ProduitConditionTarifaire $produitConditionTarifaire
     * @throws AuthorizationException
     * @return void
     */
    public function show(Excursion $excursion) {
        $this->authorize('admin.produit-condition-tarifaire.show', $excursion);

        // TODO your code goes here
        $produitConditionTarifaire = ProduitConditionTarifaire::where([
            'model_id' => 'excursion_' . $excursion->id
        ])->first();

        if (!$produitConditionTarifaire) {
            $produitConditionTarifaire = collect([
                'model_id' => '',
                'condition_tarifaire' => null
            ]);
        }

        if ($this->request->ajax()) {
            return $produitConditionTarifaire;
        }

        return view('admin.excursion.produit-condition-tarifaire.index', [
            'excursion' => Excursion::find($excursion->id),
            'data' => $produitConditionTarifaire
        ]);
    }

}
