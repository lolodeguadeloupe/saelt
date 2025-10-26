<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excursion\ItineraireDescriptionExcursion\BulkDestroyItineraireDescriptionExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireDescriptionExcursion\DestroyItineraireDescriptionExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireDescriptionExcursion\IndexItineraireDescriptionExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireDescriptionExcursion\StoreItineraireDescriptionExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireDescriptionExcursion\UpdateItineraireDescriptionExcursion;
use App\Models\Excursion\Excursion;
use App\Models\Excursion\ItineraireDescriptionExcursion;
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

class ItineraireDescriptionExcursionController extends Controller
{

    public function store(StoreItineraireDescriptionExcursion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ProduitDescriptif
        $itinerareDescription = ItineraireDescriptionExcursion::where([
            'excursion_id' => $sanitized['excursion_id']
        ])->first();

        if ($itinerareDescription) {
            $itinerareDescription->update([
                'description' => $sanitized['description']
            ]);
        } else {
            $itinerareDescription = ItineraireDescriptionExcursion::create([
                'excursion_id' =>  $sanitized['excursion_id'],
                'description' => $sanitized['description']
            ]);
        }


        if ($request->ajax()) {
            return ['redirect' => url('admin/itineraire-description-excursions/' . $sanitized['excursion_id']), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/itineraire-description-excursions/' . $sanitized['excursion_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param ProduitDescriptif $produitDescriptif
     * @throws AuthorizationException
     * @return void
     */
    public function show(Excursion $excursion)
    {
        $this->authorize('admin.itineraire-description-excursion.show', $excursion);

        // TODO your code goes here

        $itinerareDescription = ItineraireDescriptionExcursion::where([
            'excursion_id' => $excursion->id
        ])->first();

        if (!$itinerareDescription) {
            $itinerareDescription = collect([
                'excursion_id' => '',
                'description' => null
            ]);
        }

        if ($this->request->ajax()) {
            return $itinerareDescription;
        }

        return view('admin.excursion.itineraire-description-excursion.index', [
            'excursion' => Excursion::find($excursion->id),
            'data' => $itinerareDescription
        ]);
    }
}
