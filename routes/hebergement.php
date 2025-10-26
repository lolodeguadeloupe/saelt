<?php

use Illuminate\Support\Facades\Route;

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('type-hebergements')->name('type-hebergements/')->group(static function() {
            Route::get('/',                                             'TypeHebergementController@index')->name('index');
            Route::get('/create',                                       'TypeHebergementController@create')->name('create');
            Route::post('/',                                            'TypeHebergementController@store')->name('store');
            Route::get('/{typeHebergement}/edit',                       'TypeHebergementController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TypeHebergementController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{typeHebergement}',                           'TypeHebergementController@update')->name('update');
            Route::post('/{typeHebergement}/delete',                         'TypeHebergementController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('type-chambres')->name('type-chambres/')->group(static function() {
            Route::get('/',                                             'TypeChambreController@index')->name('index');
            Route::get('/create',                                       'TypeChambreController@create')->name('create');
            Route::post('/',                                            'TypeChambreController@store')->name('store');
            Route::get('/{typeChambre}/edit',                           'TypeChambreController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TypeChambreController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{typeChambre}',                               'TypeChambreController@update')->name('update');
            Route::post('/{typeChambre}/{suffix}',                             'TypeChambreController@destroy')->where(['typeChambre'=>'[0-9]+','suffix'=>'delete'])->name('destroy');
            Route::post('/{typeChambre}/calendar',                                            'TypeChambreController@calendar')->name('calendar');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('hebergements')->name('hebergements/')->group(static function() {
            Route::get('/',                                             'HebergementsController@index')->name('index');
            Route::get('/create',                                       'HebergementsController@create')->name('create');
            Route::post('/',                                            'HebergementsController@store')->name('store');
            Route::post('/prestataire',                                            'HebergementsController@storewithprestataire')->name('store-prestataire');
            Route::get('/{hebergement}/edit',                           'HebergementsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'HebergementsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{hebergement}',                               'HebergementsController@update')->name('update');
            Route::post('/{hebergement}/{suffix}',                             'HebergementsController@destroy')->where(['hebergement'=>'[0-9]+','suffix'=>'delete'])->name('destroy');
            Route::get('/{hebergement}',                             'HebergementsController@show')->name('show');
            Route::post('/{hebergement}/prestataire/{prestataire}',                               'HebergementsController@updatePrestataire')->name('update-prestataire');
            Route::post('/{hebergement}/calendar',                                            'HebergementsController@calendar')->name('calendar');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('tarifs')->name('tarifs/')->group(static function() {
            Route::get('/',                                             'TarifsController@index')->name('index');
            Route::get('/create',                                       'TarifsController@create')->name('create');
            Route::post('/',                                            'TarifsController@store')->name('store');
            Route::post('/vol',                                            'TarifsController@storeWithVol')->name('store-vol');
            Route::get('/{tarif}/edit',                                 'TarifsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TarifsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarif}',                                     'TarifsController@update')->name('update');
            Route::post('/vol/{tarif}',                                     'TarifsController@updateWithVol')->name('update-vol');
            Route::post('/{tarif}/{suffix}',                                   'TarifsController@destroy')->where(['tarif'=>'[0-9]+','suffix'=>'delete'])->name('destroy');
            Route::get('/{tarif}',                             'TarifsController@show')->name('show');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('base-types')->name('base-types/')->group(static function() {
            Route::get('/',                                             'BaseTypeController@index')->name('index');
            Route::get('/create',                                       'BaseTypeController@create')->name('create');
            Route::post('/',                                            'BaseTypeController@store')->name('store');
            Route::get('/{baseType}/edit',                              'BaseTypeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BaseTypeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{baseType}',                                  'BaseTypeController@update')->name('update');
            Route::post('/{baseType}/delete',                                'BaseTypeController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('supplement-pensions')->name('supplement-pensions/')->group(static function() {
            Route::get('/',                                             'SupplementPensionController@index')->name('index');
            Route::get('/create',                                       'SupplementPensionController@create')->name('create');
            Route::post('/',                                            'SupplementPensionController@store')->name('store');
            Route::get('/{supplementPension}/edit',                     'SupplementPensionController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SupplementPensionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{supplementPension}',                         'SupplementPensionController@update')->name('update');
            Route::post('/{supplementPension}/delete',                       'SupplementPensionController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('supplement-activites')->name('supplement-activites/')->group(static function() {
            Route::get('/',                                             'SupplementActiviteController@index')->name('index');
            Route::get('/create',                                       'SupplementActiviteController@create')->name('create');
            Route::post('/',                                            'SupplementActiviteController@store')->name('store');
            Route::get('/{supplementActivite}/edit',                    'SupplementActiviteController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SupplementActiviteController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{supplementActivite}',                        'SupplementActiviteController@update')->name('update');
            Route::post('/{supplementActivite}/delete',                      'SupplementActiviteController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('supplement-vues')->name('supplement-vues/')->group(static function() {
            Route::get('/',                                             'SupplementVueController@index')->name('index');
            Route::get('/create',                                       'SupplementVueController@create')->name('create');
            Route::post('/',                                            'SupplementVueController@store')->name('store');
            Route::get('/{supplementVue}/edit',                         'SupplementVueController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SupplementVueController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{supplementVue}',                             'SupplementVueController@update')->name('update');
            Route::post('/{supplementVue}/delete',                           'SupplementVueController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('hebergement-vols')->name('hebergement-vols/')->group(static function() {
            Route::get('/',                                             'HebergementVolController@index')->name('index');
            Route::get('/create',                                       'HebergementVolController@create')->name('create');
            Route::post('/',                                            'HebergementVolController@store')->name('store');
            Route::get('/{hebergementVol}/edit',                        'HebergementVolController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'HebergementVolController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{hebergementVol}',                            'HebergementVolController@update')->name('update');
            Route::post('/{hebergementVol}/delete',                          'HebergementVolController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('hebergement-marque-blanches')->name('hebergement-marque-blanches/')->group(static function() {
            Route::get('/',                                             'HebergementMarqueBlancheController@index')->name('index');
            Route::get('/create',                                       'HebergementMarqueBlancheController@create')->name('create');
            Route::post('/',                                            'HebergementMarqueBlancheController@store')->name('store');
            Route::get('/{hebergementMarqueBlanche}/edit',              'HebergementMarqueBlancheController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'HebergementMarqueBlancheController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{hebergementMarqueBlanche}',                  'HebergementMarqueBlancheController@update')->name('update');
            Route::post('/{hebergementMarqueBlanche}/delete',                'HebergementMarqueBlancheController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('allotements')->name('allotements/')->group(static function() {
            Route::get('/',                                             'AllotementsController@index')->name('index');
            Route::get('/create',                                       'AllotementsController@create')->name('create');
            Route::post('/',                                            'AllotementsController@store')->name('store');
            Route::get('/{allotement}/edit',                            'AllotementsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AllotementsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{allotement}',                                'AllotementsController@update')->name('update');
            Route::post('/{allotement}/delete',                              'AllotementsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('tarif-supplement-activites')->name('tarif-supplement-activites/')->group(static function() {
            Route::get('/',                                             'TarifSupplementActiviteController@index')->name('index');
            Route::get('/create',                                       'TarifSupplementActiviteController@create')->name('create');
            Route::post('/',                                            'TarifSupplementActiviteController@store')->name('store');
            Route::get('/{tarifSupplementActivite}/edit',               'TarifSupplementActiviteController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TarifSupplementActiviteController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarifSupplementActivite}',                   'TarifSupplementActiviteController@update')->name('update');
            Route::post('/{tarifSupplementActivite}/delete',                 'TarifSupplementActiviteController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('tarif-supplement-pensions')->name('tarif-supplement-pensions/')->group(static function() {
            Route::get('/',                                             'TarifSupplementPensionController@index')->name('index');
            Route::get('/create',                                       'TarifSupplementPensionController@create')->name('create');
            Route::post('/',                                            'TarifSupplementPensionController@store')->name('store');
            Route::get('/{tarifSupplementPension}/edit',                'TarifSupplementPensionController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TarifSupplementPensionController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarifSupplementPension}',                    'TarifSupplementPensionController@update')->name('update');
            Route::post('/{tarifSupplementPension}/delete',                  'TarifSupplementPensionController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('tarif-type-personne-hebergements')->name('tarif-type-personne-hebergements/')->group(static function() {
            Route::get('/',                                             'TarifTypePersonneHebergementController@index')->name('index');
            Route::get('/create',                                       'TarifTypePersonneHebergementController@create')->name('create');
            Route::post('/',                                            'TarifTypePersonneHebergementController@store')->name('store');
            Route::get('/{tarifTypePersonneHebergement}/edit',          'TarifTypePersonneHebergementController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TarifTypePersonneHebergementController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarifTypePersonneHebergement}',              'TarifTypePersonneHebergementController@update')->name('update');
            Route::post('/{tarifTypePersonneHebergement}/delete',            'TarifTypePersonneHebergementController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('hebergement-produit-descriptifs')->name('hebergement-produit-descriptifs/')->group(static function() {
            Route::get('/{hebergement}',                             'ProduitDescriptifHebergementController@show')->name('show');
            Route::post('/',                                            'ProduitDescriptifHebergementController@store')->name('store');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('hebergement-produit-condition-tarifaires')->name('hebergement-produit-condition-tarifaires/')->group(static function() {
            Route::get('/{hebergement}',                             'ProduitConditionTarifaireHebergementController@show')->name('show');
            Route::post('/',                                            'ProduitConditionTarifaireHebergementController@store')->name('store');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\Hebergement')->name('admin/')->group(static function() {
        Route::prefix('hebergement-produit-info-pratiques')->name('hebergement-produit-info-pratiques/')->group(static function() {
            Route::get('/{hebergement}',                             'ProduitInfoPratiqueHebergementController@show')->name('show');
            Route::post('/',                                            'ProduitInfoPratiqueHebergementController@store')->name('store');
        });
    });
});