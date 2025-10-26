<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitInfoPratique\StoreProduitInfoPratique;
use App\Models\ProduitInfoPratique;
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

class ProduitInfoPratiqueExcursionController extends Controller
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
            'model_id' => 'excursion_' . $sanitized['model_id']
        ])->first();

        if ($produitInfoPratique) {
            $produitInfoPratique->update([
                'info_pratique' => $sanitized['info_pratique']
            ]);
        } else {
            $produitInfoPratique = ProduitInfoPratique::create([
                'model_id' => 'excursion_' . $sanitized['model_id'],
                'info_pratique' => $sanitized['info_pratique']
            ]);
        }
        if ($request->ajax()) {
            return ['redirect' => url('admin/excursion-produit-info-pratiques/' . $sanitized['model_id']), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/excursion-produit--info-pratiques/' . $sanitized['model_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param ProduitInfoPratique $produitInfoPratique
     * @throws AuthorizationException
     * @return void
     */
    public function show(Excursion $excursion)
    {
        $this->authorize('admin.produit-info-pratique.show', $excursion);

        // TODO your code goes here

        $infoPratique = ProduitInfoPratique::where([
            'model_id' => 'excursion_' . $excursion->id
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

        return view('admin.excursion.produit-info-pratique.index', [
            'excursion' => Excursion::find($excursion->id),
            'data' => $infoPratique
        ]);
    }
}
