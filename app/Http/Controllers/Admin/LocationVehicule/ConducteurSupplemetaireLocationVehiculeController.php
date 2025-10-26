<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\ConducteurSupplemetaireLocationVehicule\UpdateConducteurSupplemetaireLocationVehicule;
use App\Models\LocationVehicule\ConducteurSupplemetaireLocationVehicule;
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

class ConducteurSupplemetaireLocationVehiculeController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param ConducteurSupplemetaireLocationVehicule $conducteurSupplemetaire
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ConducteurSupplemetaireLocationVehicule $conducteurSupplemetaire)
    {
        $this->authorize('admin.conducteur-supplemetaire-location-vehicule.edit', $conducteurSupplemetaire);


        return [
            'conducteurSupplemetaireLocationVehicule' => $conducteurSupplemetaire,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateConducteurSupplemetaireLocationVehicule $request
     * @param ConducteurSupplemetaireLocationVehicule $conducteurSupplemetaire
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateConducteurSupplemetaireLocationVehicule $request, ConducteurSupplemetaireLocationVehicule $conducteurSupplemetaire)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ConducteurSupplemetaireLocationVehicule
        $conducteurSupplemetaire->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/conducteur-supplemetaire-location-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'conducteurSupplemetaireLocationVehicule' => $conducteurSupplemetaire,
            ];
        }

        return redirect('admin/conducteur-supplemetaire-location-vehicules');
    }
}
