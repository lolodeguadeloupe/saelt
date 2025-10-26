<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitConditionTarifaire\StoreProduitConditionTarifaire;
use App\Models\ProduitConditionTarifaire;
use App\Models\Hebergement\Hebergement;
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

class ProduitConditionTarifaireHebergementController extends Controller {

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
            'model_id' => 'hebergement_' . $sanitized['model_id']
        ])->first();

        if ($produitConditionTarifaire) {
            $produitConditionTarifaire->update([
                'condition_tarifaire' => $sanitized['condition_tarifaire']
            ]);
        } else {
            $produitConditionTarifaire = ProduitConditionTarifaire::create([
                'model_id' => 'hebergement_' . $sanitized['model_id'],
                'condition_tarifaire' => $sanitized['condition_tarifaire']
            ]);
        }
        
        $produitConditionTarifaire = ProduitConditionTarifaire::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/hebergement-produit-condition-tarifaires/'.$sanitized['model_id']), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/hebergement-produit-condition-tarifaires/'.$sanitized['model_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param ProduitConditionTarifaire $produitConditionTarifaire
     * @throws AuthorizationException
     * @return void
     */
    public function show(Hebergement $hebergement) {
        $this->authorize('admin.produit-condition-tarifaire.show', $hebergement);

        // TODO your code goes here
        $produitConditionTarifaire = ProduitConditionTarifaire::where([
            'model_id' => 'hebergement_' . $hebergement->id
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

        return view('admin.hebergement.produit-condition-tarifaire.index', [
            'hebergement' => Hebergement::find($hebergement->id),
            'data' => $produitConditionTarifaire
        ]);
    }

}
