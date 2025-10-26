<?php

use Illuminate\Support\Facades\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\TransfertVoyage')->name('admin/')->group(static function() {
        Route::prefix('type-transfert-voyages')->name('type-transfert-voyages/')->group(static function() {
            Route::get('/', 'TypeTransfertVoyageController@index')->name('index');
            Route::get('/create', 'TypeTransfertVoyageController@create')->name('create');
            Route::get('/{typeTransfertVoyage}', 'TypeTransfertVoyageController@show')->name('show');
            Route::post('/', 'TypeTransfertVoyageController@store')->name('store');
            Route::get('/{typeTransfertVoyage}/edit', 'TypeTransfertVoyageController@edit')->name('edit');
            Route::post('/bulk-destroy', 'TypeTransfertVoyageController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{typeTransfertVoyage}', 'TypeTransfertVoyageController@update')->name('update');
            Route::post('/{typeTransfertVoyage}/delete', 'TypeTransfertVoyageController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\TransfertVoyage')->name('admin/')->group(static function() {
        Route::prefix('tranche-personne-transfert-voyages')->name('tranche-personne-transfert-voyages/')->group(static function() {
            Route::get('/', 'TranchePersonneTransfertVoyageController@index')->name('index');
            Route::get('/create', 'TranchePersonneTransfertVoyageController@create')->name('create');
            Route::post('/', 'TranchePersonneTransfertVoyageController@store')->name('store');
            Route::get('/{tranchePersonneTransfertVoyage}/edit', 'TranchePersonneTransfertVoyageController@edit')->name('edit');
            Route::post('/bulk-destroy', 'TranchePersonneTransfertVoyageController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tranchePersonneTransfertVoyage}', 'TranchePersonneTransfertVoyageController@update')->name('update');
            Route::post('/{tranchePersonneTransfertVoyage}/delete', 'TranchePersonneTransfertVoyageController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\TransfertVoyage')->name('admin/')->group(static function() {
        Route::prefix('trajet-transfert-voyages')->name('trajet-transfert-voyages/')->group(static function() {
            Route::get('/', 'TrajetTransfertVoyageController@index')->name('index');
            Route::get('/create', 'TrajetTransfertVoyageController@create')->name('create');
            Route::post('/', 'TrajetTransfertVoyageController@store')->name('store');
            Route::get('/{trajetTransfertVoyage}/edit', 'TrajetTransfertVoyageController@edit')->name('edit');
            Route::post('/bulk-destroy', 'TrajetTransfertVoyageController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{trajetTransfertVoyage}', 'TrajetTransfertVoyageController@update')->name('update');
            Route::post('/{trajetTransfertVoyage}/delete', 'TrajetTransfertVoyageController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\TransfertVoyage')->name('admin/')->group(static function() {
        Route::prefix('tarif-transfert-voyages')->name('tarif-transfert-voyages/')->group(static function() {
            Route::get('/', 'TarifTransfertVoyageController@index')->name('index');
            Route::get('/create', 'TarifTransfertVoyageController@create')->name('create');
            Route::post('/', 'TarifTransfertVoyageController@store')->name('store');
            Route::get('/{trajetTranche}/edit', 'TarifTransfertVoyageController@edit')->name('edit');
            Route::post('/bulk-destroy', 'TarifTransfertVoyageController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{trajetTranche}', 'TarifTransfertVoyageController@update')->name('update');
            Route::post('/{trajetTranche}/{suffix}', 'TarifTransfertVoyageController@destroy')->where(['tarifTransfertVoyage'=>'[^0-9_]+','suffix'=>'delete'])->name('destroy');
            Route::get('/{tranchePersonneTransfertVoyage}/{trajetTransfertVoyage}', 'TarifTransfertVoyageController@show')->name('show');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\TransfertVoyage')->name('admin/')->group(static function() {
        Route::prefix('vehicule-transfert-voyages')->name('vehicule-transfert-voyages/')->group(static function() {
            Route::get('/', 'VehiculeTransfertVoyageController@index')->name('index');
            Route::get('/{suffix}', 'VehiculeTransfertVoyageController@create')->where(['suffix'=>'create'])->name('create');
            Route::post('/{suffix}', 'VehiculeTransfertVoyageController@storewithprestataire')->where(['suffix'=>'prestataire'])->name('store-prestataire');
            Route::post('/', 'VehiculeTransfertVoyageController@store')->name('store');
            Route::get('/{vehiculeTransfertVoyage}/edit', 'VehiculeTransfertVoyageController@edit')->name('edit');
            Route::post('/bulk-destroy', 'VehiculeTransfertVoyageController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{vehiculeTransfertVoyage}', 'VehiculeTransfertVoyageController@update')->name('update');
            Route::post('/{vehiculeTransfertVoyage}/{suffix}', 'VehiculeTransfertVoyageController@destroy')->where(['vehiculeTransfertVoyage'=>'[0-9]+','suffix'=>'delete'])->name('destroy');
            Route::post('/{vehiculeTransfertVoyage}/prestataire/{prestataire}', 'VehiculeTransfertVoyageController@updatePrestataire')->name('update-prestataire');
            Route::post('/{vehiculeTransfertVoyage}/{suffix}', 'VehiculeTransfertVoyageController@calendar')->where(['vehiculeTransfertVoyage'=>'[0-9]+','suffix'=>'calendar'])->name('calendar');
            Route::get('/{vehiculeTransfertVoyage}/detail/show', 'VehiculeTransfertVoyageController@show')->name('show');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\TransfertVoyage')->name('admin/')->group(static function() {
        Route::prefix('lieu-transferts')->name('lieu-transferts/')->group(static function() {
            Route::get('/',                                             'LieuTransfertController@index')->name('index');
            Route::get('/create',                                       'LieuTransfertController@create')->name('create');
            Route::post('/',                                            'LieuTransfertController@store')->name('store');
            Route::get('/{lieuTransfert}/edit',                         'LieuTransfertController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'LieuTransfertController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{lieuTransfert}',                             'LieuTransfertController@update')->name('update');
            Route::post('/{lieuTransfert}/delete',                           'LieuTransfertController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\TransfertVoyage')->name('admin/')->group(static function() {
        Route::prefix('type-transfert-voyages-produit-condition-tarifaires')->name('type-transfert-voyages-produit-condition-tarifaires/')->group(static function() {
            Route::get('/{typeTransfertVoyage}',                             'ProduitConditionTarifaireTranfertVoyageController@show')->name('show');
            Route::post('/',                                            'ProduitConditionTarifaireTranfertVoyageController@store')->name('store');
        });
    });
});