<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitInfoPratique\StoreProduitInfoPratique;
use App\Models\ProduitInfoPratique;
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

class ProduitInfoPratiqueHebergementController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProduitInfoPratique $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProduitInfoPratique $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $produitInfoPratique = ProduitInfoPratique::where([
            'model_id' => 'hebergement_' . $sanitized['model_id']
        ])->first();

        if ($produitInfoPratique) {
            $produitInfoPratique->update([
                'info_pratique' => $sanitized['info_pratique']
            ]);
        } else {
            $produitInfoPratique = ProduitInfoPratique::create([
                'model_id' => 'hebergement_' . $sanitized['model_id'],
                'info_pratique' => $sanitized['info_pratique']
            ]);
        }
        if ($request->ajax()) {
            return ['redirect' => url('admin/hebergement-produit-info-pratiques/' . $sanitized['model_id']), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/hebergement-produit--info-pratiques/' . $sanitized['model_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param ProduitInfoPratique $produitInfoPratique
     * @throws AuthorizationException
     * @return void
     */
    public function show(Hebergement $hebergement)
    {
        $this->authorize('admin.produit-info-pratique.show', $hebergement);

        // TODO your code goes here

        $infoPratique = ProduitInfoPratique::where([
            'model_id' => 'hebergement_' . $hebergement->id
        ])->first();

        if (!$infoPratique) {
            $infoPratique = collect([
                'model_id' => '',
                'info_pratique' => null
            ]);
        }

        if ($this->request->ajax()) {
            return $infoPratique;
        }

        return view('admin.hebergement.produit-info-pratique.index', [
            'hebergement' => Hebergement::find($hebergement->id),
            'data' => $infoPratique
        ]);
    }
}
