<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FraisDossier\IndexFraisDossier;
use App\Http\Requests\Admin\FraisDossier\UpdateFraisDossier;
use App\Models\FraisDossier;
use App\Models\Saison;
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

class FraisDossierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexFraisDossier $request
     * @return array|Factory|View
     */
    public function index(IndexFraisDossier $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        return ['frais_dossier' => FraisDossier::all()];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FraisDossier $fraisDossier
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Request $request, FraisDossier $fraisDossier)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $this->authorize('admin.frais-dossier.edit', $fraisDossier);


        return  [
            'fraisDossier' => $fraisDossier,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFraisDossier $request
     * @param FraisDossier $fraisDossier
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateFraisDossier $request, FraisDossier $fraisDossier)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        if (!$this->request->ajax()) {
            abort(404);
        }
        // Update changed values FraisDossier
        $fraisDossier->update($sanitized);

        return ['frais_dossier' => FraisDossier::all()];
    }
}
