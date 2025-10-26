<?php

namespace App\Http\Controllers\Admin\TransfertVoyage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitConditionTarifaire\StoreProduitConditionTarifaire;
use App\Models\ProduitConditionTarifaire;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
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

class ProduitConditionTarifaireTranfertVoyageController extends Controller {

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
            'model_id' => 'transfert_' . $sanitized['model_id']
        ])->first();

        if ($produitConditionTarifaire) {
            $produitConditionTarifaire->update([
                'condition_tarifaire' => $sanitized['condition_tarifaire']
            ]);
        } else {
            $produitConditionTarifaire = ProduitConditionTarifaire::create([
                'model_id' => 'transfert_' . $sanitized['model_id'],
                'condition_tarifaire' => $sanitized['condition_tarifaire']
            ]);
        }
        
        $produitConditionTarifaire = ProduitConditionTarifaire::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/type-transfert-voyages-produit-condition-tarifaires/'.$sanitized['model_id']), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/type-transfert-voyages-produit-condition-tarifaires/'.$sanitized['model_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param ProduitConditionTarifaire $produitConditionTarifaire
     * @throws AuthorizationException
     * @return void
     */
    public function show(TypeTransfertVoyage $typeTransfertVoyage) {
        $this->authorize('admin.produit-condition-tarifaire.show', $typeTransfertVoyage);

        // TODO your code goes here
        $produitConditionTarifaire = ProduitConditionTarifaire::where([
            'model_id' => 'transfert_' . $typeTransfertVoyage->id
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

        return view('admin.transfert-voyage.produit-condition-tarifaire.index', [
            'typeTransfertVoyage' => TypeTransfertVoyage::find($typeTransfertVoyage->id),
            'data' => $produitConditionTarifaire
        ]);
    }

}
