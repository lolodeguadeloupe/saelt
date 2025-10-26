<?php

use App\Http\Controllers\Front\GestionRequestUtilisateurController;
use App\Http\Controllers\Front\BilletterieController;
use App\Http\Controllers\Front\HebergementController;
use App\Http\Controllers\Front\ExcursionController;
use App\Http\Controllers\Front\LocationController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PanierController;
use App\Http\Controllers\Front\TransfertController;
use App\Http\Controllers\Front\TestController;
use App\Http\Controllers\Front\FacturationController;
use App\Http\Controllers\Front\RemerciementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\GestionCommandeUtilisateurController;
use App\Models\Produit;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
|--------------------------------------------------------------------------
| Front Web Routes
|--------------------------------------------------------------------------
*/

Route::post('/put-request', [GestionRequestUtilisateurController::class, 'putRequest'])->name('put-request');
Route::post('/put-commande', [GestionCommandeUtilisateurController::class, 'putCommande'])->name('put-commande');
Route::post('/get-commande', [GestionCommandeUtilisateurController::class, 'getCommande'])->name('get-commande');
Route::post('/all-commande', [GestionCommandeUtilisateurController::class, 'allCommande'])->name('all-commande');
Route::post('/delete-commande', [GestionCommandeUtilisateurController::class, 'deleteCommande'])->name('delete-commande');
Route::post('/check-commande', [GestionCommandeUtilisateurController::class, 'checkCommandeTimeout'])->name('check-commande');


/** */

Route::post('/paiement-facturation', [FacturationController::class, 'paiement'])->name('paie-facturation');
Route::get('/check-facturation', [FacturationController::class, 'check'])->name('check-facturation');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['prefix' => '/'], function () {
    Route::get('hebergements', [HebergementController::class, 'index'])->name('hebergements');
    Route::get('hebergements/hebergement-product-avec-vol', [HebergementController::class, 'productavecvol'])->name('hebergement-product-avec-vol');
    Route::get('hebergements/hebergement-product-sans-vol', [HebergementController::class, 'productsansvol'])->name('hebergement-product-sans-vol');
    Route::get('hebergements/hebergement-host', [HebergementController::class, 'host'])->name('hebergement-host');
    Route::get('hebergements/hebergement-all-hosts', [HebergementController::class, 'allhosts'])->name('hebergement-all-hosts');
    Route::post('hebergements/product-prices', [HebergementController::class, 'productPrice'])->name('hebergement-product-prices');
});

Route::get('excursions', [ExcursionController::class, 'index'])->name('excursions');
Route::get('excursions/excursion-product', [ExcursionController::class, 'product'])->name('excursion-product');
Route::get('excursions/excursion-all-products', [ExcursionController::class, 'allproducts'])->name('excursion-all-products');
Route::post('excursions/product-prices', [ExcursionController::class, 'productPrice'])->name('excursion-product-prices');

Route::get('locations', [LocationController::class, 'index'])->name('locations');
Route::get('locations/location-product', [LocationController::class, 'product'])->name('location-product');
Route::post('locations/product-prices', [LocationController::class, 'productPrice'])->name('location-product-prices');

Route::get('billetteries', [BilletterieController::class, 'index'])->name('billetteries');

Route::get('transferts', [TransfertController::class, 'index'])->name('transferts');

Route::get('panier', [PanierController::class, 'index'])->name('panier');

Route::get('facturation', [FacturationController::class, 'index'])->name('facturation');

Route::get('remerciement', [RemerciementController::class, 'index'])->name('remerciement');
Route::get('conducteur-info/{id}', [RemerciementController::class, 'infoConducteur'])->name('conducteur-info');


/*
|--------------------------------------------------------------------------
| End Front Web Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Back Web Routes
|--------------------------------------------------------------------------
*/

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| End Back Web Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
