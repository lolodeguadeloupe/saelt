<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitDescriptif\StoreProduitDescriptif;
use App\Models\ProduitDescriptif;
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

class ProduitDescriptifHebergementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProduitDescriptif $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProduitDescriptif $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ProduitDescriptif
        $produitDescriptif = ProduitDescriptif::where([
            'model_id' => 'hebergement_' . $sanitized['model_id']
        ])->first();

        if ($produitDescriptif) {
            $produitDescriptif->update([
                'descriptif' => $sanitized['descriptif']
            ]);
        } else {
            $produitDescriptif = ProduitDescriptif::create([
                'model_id' => 'hebergement_' . $sanitized['model_id'],
                'descriptif' => $sanitized['descriptif']
            ]);
        }


        if ($request->ajax()) {
            return ['redirect' => url('admin/hebergement-produit-descriptifs/' . $sanitized['model_id']), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/hebergement-produit-descriptifs/' . $sanitized['model_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param ProduitDescriptif $produitDescriptif
     * @throws AuthorizationException
     * @return void
     */
    public function show(Hebergement $hebergement)
    {
        $this->authorize('admin.produit-descriptif.show', $hebergement);

        // TODO your code goes here

        $descriptif = ProduitDescriptif::where([
            'model_id' => 'hebergement_' . $hebergement->id
        ])->first();

        if (!$descriptif) {
            $descriptif = collect([
                'model_id' => '',
                'descriptif' => null
            ]);
        }

        if ($this->request->ajax()) {
            return $descriptif;
        }

        return view('admin.hebergement.produit-descriptif.index', [
            'hebergement' => Hebergement::find($hebergement->id),
            'data' => $descriptif
        ]);
    }
}
