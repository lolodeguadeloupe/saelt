<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FraisDossier;
use App\Models\Produit;
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

class AppSupplementController extends Controller
{
    public function all(Request $request)
    {
        $this->authorize('admin.app-supplement.all');
        $data = [
            'frais_dossier' => FraisDossier::all(),
            'produit' => Produit::all()
        ];
        if ($request->ajax()) {
            return  $data;
        }
        return view('admin.app-supplement.all', [
            'data' => collect($data)
        ]);
    }
}
