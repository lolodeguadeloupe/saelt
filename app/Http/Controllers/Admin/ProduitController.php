<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Produit\IndexProduit;
use App\Http\Requests\Admin\Produit\UpdateProduit;
use App\Models\Produit;
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

class ProduitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexProduit $request
     * @return array|Factory|View
     */
    public function index(IndexProduit $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        return ['produit' => Produit::all()];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Produit $produit
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Produit $produit)
    {
        $this->authorize('admin.produit.edit', $produit);
        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'produit' => $produit,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProduit $request
     * @param Produit $produit
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateProduit $request, Produit $produit)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Produit
        $produit->update($sanitized);

        return ['produit' => Produit::all()];
    }
}
