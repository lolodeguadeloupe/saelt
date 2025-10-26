<?php

namespace App\Http\Controllers\Admin\LocationVehicule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationVehicule\SupplementJeuneConducteurLocationVehicule\UpdateSupplementJeuneConducteurLocationVehicule;
use App\Models\LocationVehicule\SupplementJeuneConducteurLocationVehicule;
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

class SupplementJeuneConducteurLocationVehiculeController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param SupplementJeuneConducteurLocationVehicule $supplementJeune
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SupplementJeuneConducteurLocationVehicule $supplementJeune)
    {
        $this->authorize('admin.supplement-jeune-conducteur-location-vehicule.edit', $supplementJeune);


        return[
            'supplementJeuneConducteurLocationVehicule' => $supplementJeune,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplementJeuneConducteurLocationVehicule $request
     * @param SupplementJeuneConducteurLocationVehicule $supplementJeune
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSupplementJeuneConducteurLocationVehicule $request, SupplementJeuneConducteurLocationVehicule $supplementJeune)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SupplementJeune
        $supplementJeune->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/supplement-jeune-conducteur-location-vehicules'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'supplementJeuneConducteurLocationVehicule' => $supplementJeune,
            ];
        }

        return redirect('admin/supplement-jeune-conducteur-location-vehicules');
    }
}
