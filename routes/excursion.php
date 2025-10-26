<?php

use Illuminate\Support\Facades\Route;

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('excursions')->name('excursions/')->group(static function() {
            Route::get('/', 'ExcursionsController@index')->name('index');
            Route::get('/create', 'ExcursionsController@create')->name('create');
            Route::post('/', 'ExcursionsController@store')->name('store');
            Route::get('/{excursion}/edit', 'ExcursionsController@edit')->name('edit');
            Route::post('/bulk-destroy', 'ExcursionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/prestataire', 'ExcursionsController@storewithprestataire')->name('store-prestataire');
            Route::post('/{excursion}', 'ExcursionsController@update')->name('update');
            Route::post('/{excursion}/{suffix}', 'ExcursionsController@destroy')->where(['excursion'=>'[0-9]+','suffix'=>'delete'])->name('destroy');
            Route::post('/{excursion}/prestataire/{prestataire}', 'ExcursionsController@updatePrestataire')->name('update-prestataire');
            Route::post('/{excursion}/calendar', 'ExcursionsController@calendar')->name('calendar');
            Route::get('/{excursion}', 'ExcursionsController@show')->name('show');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('supplement-excursions')->name('supplement-excursions/')->group(static function() {
            Route::get('/', 'SupplementExcursionController@index')->name('index');
            Route::get('/create', 'SupplementExcursionController@create')->name('create');
            Route::post('/', 'SupplementExcursionController@store')->name('store');
            Route::get('/{supplementExcursion}/edit', 'SupplementExcursionController@edit')->name('edit');
            Route::post('/bulk-destroy', 'SupplementExcursionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{supplementExcursion}', 'SupplementExcursionController@update')->name('update');
            Route::post('/{supplementExcursion}/delete', 'SupplementExcursionController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('tarif-excursions')->name('tarif-excursions/')->group(static function() {
            Route::get('/', 'TarifExcursionController@index')->name('index');
            Route::get('/create', 'TarifExcursionController@create')->name('create');
            Route::post('/', 'TarifExcursionController@store')->name('store');
            Route::get('/{tarifExcursion}/{suffix}', 'TarifExcursionController@edit')->where(['tarifExcursion'=>'[0-9]+','suffix'=>'edit'])->name('edit');
            Route::post('/bulk-destroy', 'TarifExcursionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarifExcursion}', 'TarifExcursionController@update')->name('update');
            Route::post('/{tarifExcursion}/{suffix}', 'TarifExcursionController@destroy')->where(['tarifExcursion'=>'[0-9]+','suffix'=>'delete'])->name('destroy');
            Route::get('/{excursion}', 'TarifExcursionController@show')->name('show');
            Route::get('/{excursion}/{saison}', 'TarifExcursionController@showTarifSaison')->where(['excursion'=>'[0-9]+','saison'=>'[0-9]+'])->name('show-tarif-saison');
            Route::post('/{excursion}/update', 'TarifExcursionController@updateAll')->name('update-all');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('compagnie-liaison-excursions')->name('compagnie-liaison-excursions/')->group(static function() {
            Route::get('/',                                             'CompagnieLiaisonExcursionController@index')->name('index');
            Route::get('/{suffix}/{excursion}',                                       'CompagnieLiaisonExcursionController@create')->where(['excursion'=>'[0-9]+','suffix'=>'create'])->name('create');
            Route::post('/',                                            'CompagnieLiaisonExcursionController@store')->name('store');
            Route::get('/{excursion}/{suffix}',             'CompagnieLiaisonExcursionController@edit')->where(['excursion'=>'[0-9]+','suffix'=>'edit'])->name('edit');
            Route::post('/bulk-destroy/compagnie-liaison',                                'CompagnieLiaisonExcursionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{compagnieLiaisonExcursion}',                 'CompagnieLiaisonExcursionController@update')->name('update');
            Route::post('/{compagnieLiaisonExcursion}/delete',               'CompagnieLiaisonExcursionController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('tarif-supplement-excursions')->name('tarif-supplement-excursions/')->group(static function() {
            Route::get('/',                                             'TarifSupplementExcursionController@index')->name('index');
            Route::get('/create',                                       'TarifSupplementExcursionController@create')->name('create');
            Route::post('/',                                            'TarifSupplementExcursionController@store')->name('store');
            Route::get('/{tarifSupplementExcursion}/edit',              'TarifSupplementExcursionController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TarifSupplementExcursionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarifSupplementExcursion}',                  'TarifSupplementExcursionController@update')->name('update');
            Route::post('/{tarifSupplementExcursion}/delete',                'TarifSupplementExcursionController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('excursion-produit-descriptifs')->name('excursion-produit-descriptifs/')->group(static function() {
            Route::get('/{excursion}',                             'ProduitDescriptifExcursionController@show')->name('show');
            Route::post('/',                                            'ProduitDescriptifExcursionController@store')->name('store');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('excursion-produit-condition-tarifaires')->name('excursion-produit-condition-tarifaires/')->group(static function() {
            Route::get('/{excursion}',                             'ProduitConditionTarifaireExcursionController@show')->name('show');
            Route::post('/',                                            'ProduitConditionTarifaireExcursionController@store')->name('store');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('excursion-produit-info-pratiques')->name('excursion-produit-info-pratiques/')->group(static function() {
            Route::get('/{excursion}',                             'ProduitInfoPratiqueExcursionController@show')->name('show');
            Route::post('/',                                            'ProduitInfoPratiqueExcursionController@store')->name('store');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('itineraire-excursions')->name('itineraire-excursions/')->group(static function() {
            Route::get('/{excursion}',                                             'ItineraireExcursionController@index')->name('index');
            Route::get('/create/{excursion}',                                       'ItineraireExcursionController@create')->name('create');
            Route::post('/',                                            'ItineraireExcursionController@store')->name('store');
            Route::get('/{itineraireExcursion}/edit',                   'ItineraireExcursionController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ItineraireExcursionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{itineraireExcursion}',                       'ItineraireExcursionController@update')->name('update');
            Route::post('/{itineraireExcursion}/delete',                     'ItineraireExcursionController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Excursion')->name('admin/')->group(static function() {
        Route::prefix('itineraire-description-excursions')->name('itineraire-description-excursions/')->group(static function() {
            Route::get('/{excursion}',                             'ItineraireDescriptionExcursionController@show')->name('show');
            Route::post('/',                                            'ItineraireDescriptionExcursionController@store')->name('store');
        });
    });
});