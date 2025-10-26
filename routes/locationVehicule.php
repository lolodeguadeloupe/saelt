<?php

use Illuminate\Support\Facades\Route;

/* Auto-generated admin routes */

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('famille-vehicules')->name('famille-vehicules/')->group(static function () {
            Route::get('/', 'FamilleVehiculeController@index')->name('index');
            Route::get('/create', 'FamilleVehiculeController@create')->name('create');
            Route::post('/', 'FamilleVehiculeController@store')->name('store');
            Route::get('/{familleVehicule}/edit', 'FamilleVehiculeController@edit')->name('edit');
            Route::post('/bulk-destroy', 'FamilleVehiculeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{familleVehicule}', 'FamilleVehiculeController@update')->name('update');
            Route::post('/{familleVehicule}/delete', 'FamilleVehiculeController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('categorie-vehicules')->name('categorie-vehicules/')->group(static function () {
            Route::get('/', 'CategorieVehiculeController@index')->name('index');
            Route::get('/create', 'CategorieVehiculeController@create')->name('create');
            Route::post('/', 'CategorieVehiculeController@store')->name('store');
            Route::get('/{categorieVehicule}/edit', 'CategorieVehiculeController@edit')->name('edit');
            Route::post('/bulk-destroy', 'CategorieVehiculeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{categorieVehicule}', 'CategorieVehiculeController@update')->name('update');
            Route::post('/{categorieVehicule}/delete', 'CategorieVehiculeController@destroy')->name('destroy');
        });
    });
});



/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('vehicule-locations')->name('vehicule-locations/')->group(static function () {
            Route::get('/', 'VehiculeLocationController@index')->name('index');
            Route::get('/create', 'VehiculeLocationController@create')->name('create');
            Route::post('/', 'VehiculeLocationController@store')->name('store');
            Route::post('/prestataire', 'VehiculeLocationController@storewithprestataire')->name('store-prestataire');
            Route::get('/{vehiculeLocation}/edit', 'VehiculeLocationController@edit')->name('edit');
            Route::post('/bulk-destroy', 'VehiculeLocationController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{vehiculeLocation}', 'VehiculeLocationController@update')->name('update');
            Route::post('/{vehiculeLocation}/{suffix}', 'VehiculeLocationController@destroy')->where(['vehiculeLocation' => '[0-9]+', 'suffix' => 'delete'])->name('destroy');
            Route::post('/{vehiculeLocation}/prestataire/{prestataire}', 'VehiculeLocationController@updatePrestataire')->name('update-prestataire');
            Route::post('/{vehiculeLocation}/calendar', 'VehiculeLocationController@calendar')->name('calendar');
            Route::get('/{vehiculeLocation}', 'VehiculeLocationController@show')->name('show');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('location-vehicule-saisons')->name('location-vehicule-saisons/')->group(static function () {
            Route::get('/{locationVehicule}',                                             'LocationVehiculeSaisonsController@index')->where(['locationVehicule' => '[0-9]+'])->name('index');
            Route::get('/{locationVehicule}/{suffix}',                                       'LocationVehiculeSaisonsController@create')->where(['locationVehicule' => '[0-9]+', 'suffix' => 'create'])->name('create');
            Route::post('/{locationVehicule}/{suffix}',                                            'LocationVehiculeSaisonsController@store')->where(['locationVehicule' => '[0-9]+', 'suffix' => 'store'])->name('store');
            Route::get('/{saison}/{suffix}',                'LocationVehiculeSaisonsController@edit')->where(['saison' => '[0-9]+', 'suffix' => 'edit'])->name('edit');
            Route::post('/bulk-destroy',                                'LocationVehiculeSaisonsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{saison}',                    'LocationVehiculeSaisonsController@update')->name('update');
            Route::post('/{saison}/{suffix}',                  'LocationVehiculeSaisonsController@destroy')->where(['saison' => '[0-9]+', 'suffix' => 'delete'])->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('location-vehicule-tranche-saisons')->name('location-vehicule-tranche-saisons/')->group(static function () {
            Route::get('/',                                             'LocationVehiculeTrancheSaisonController@index')->name('index');
            Route::get('/create',                                       'LocationVehiculeTrancheSaisonController@create')->name('create');
            Route::post('/',                                            'LocationVehiculeTrancheSaisonController@store')->name('store');
            Route::get('/{trancheSaison}/edit',                         'LocationVehiculeTrancheSaisonController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'LocationVehiculeTrancheSaisonController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{trancheSaison}',                             'LocationVehiculeTrancheSaisonController@update')->name('update');
            Route::post('/{trancheSaison}/delete',                           'LocationVehiculeTrancheSaisonController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('tarif-tranche-saison-locations')->name('tarif-tranche-saison-locations/')->group(static function () {
            Route::get('/{vehicule}',                                             'TarifTrancheSaisonLocationController@index')->name('index');
            Route::get('/create/{vehicule}',                                       'TarifTrancheSaisonLocationController@create')->name('create');
            Route::post('/',                                            'TarifTrancheSaisonLocationController@store')->name('store');
            Route::get('/{tarifTrancheSaisonLocation}/edit',            'TarifTrancheSaisonLocationController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TarifTrancheSaisonLocationController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarifTrancheSaisonLocation}',                'TarifTrancheSaisonLocationController@update')->name('update');
            Route::post('/{tarifTrancheSaisonLocation}/{suffix}',              'TarifTrancheSaisonLocationController@destroy')->where(['tarifTrancheSaisonLocation' => '[0-9]+', 'suffix' => 'delete'])->name('destroy');
            Route::get('/{vehicule}/{saison}/show', 'TarifTrancheSaisonLocationController@show')->name('show');
        });
    });
});



/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('marque-vehicules')->name('marque-vehicules/')->group(static function () {
            Route::get('/',                                             'MarqueVehiculeController@index')->name('index');
            Route::get('/create',                                       'MarqueVehiculeController@create')->name('create');
            Route::post('/',                                            'MarqueVehiculeController@store')->name('store');
            Route::get('/{marqueVehicule}/edit',                        'MarqueVehiculeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MarqueVehiculeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{marqueVehicule}',                            'MarqueVehiculeController@update')->name('update');
            Route::post('/{marqueVehicule}/delete',                          'MarqueVehiculeController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('modele-vehicules')->name('modele-vehicules/')->group(static function () {
            Route::get('/',                                             'ModeleVehiculeController@index')->name('index');
            Route::get('/create',                                       'ModeleVehiculeController@create')->name('create');
            Route::post('/',                                            'ModeleVehiculeController@store')->name('store');
            Route::get('/{modeleVehicule}/edit',                        'ModeleVehiculeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ModeleVehiculeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{modeleVehicule}',                            'ModeleVehiculeController@update')->name('update');
            Route::post('/{modeleVehicule}/delete',                          'ModeleVehiculeController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('agence-locations')->name('agence-locations/')->group(static function () {
            Route::get('/',                                             'AgenceLocationController@index')->name('index');
            Route::get('/create',                                       'AgenceLocationController@create')->name('create');
            Route::post('/',                                            'AgenceLocationController@store')->name('store');
            Route::get('/{agenceLocation}/edit',                        'AgenceLocationController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AgenceLocationController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{agenceLocation}',                            'AgenceLocationController@update')->name('update');
            Route::post('/{agenceLocation}/{suffix}',                          'AgenceLocationController@destroy')->where(['agenceLocation' => '[0-9]+', 'suffix' => 'delete'])->name('destroy');
            Route::post('/{agenceLocation}/calendar', 'AgenceLocationController@calendar')->name('calendar');
            Route::get('/{agenceLocation}', 'AgenceLocationController@show')->name('show');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('vehicule-info-teches')->name('vehicule-info-teches/')->group(static function () {
            Route::get('/',                                             'VehiculeInfoTechController@index')->name('index');
            Route::get('/create',                                       'VehiculeInfoTechController@create')->name('create');
            Route::post('/',                                            'VehiculeInfoTechController@store')->name('store');
            Route::get('/{vehiculeInfoTech}/edit',                      'VehiculeInfoTechController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VehiculeInfoTechController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{vehiculeInfoTech}',                          'VehiculeInfoTechController@update')->name('update');
            Route::post('/{vehiculeInfoTech}/delete',                        'VehiculeInfoTechController@destroy')->name('destroy');
        });
    });
});



/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('vehicule-categorie-supplements')->name('vehicule-categorie-supplements/')->group(static function () {
            Route::get('/{categorie}',                                             'VehiculeCategorieSupplementController@index')->name('index');
            Route::get('/create/{categorie}',                                       'VehiculeCategorieSupplementController@create')->name('create');
            Route::post('/{suffix}',                                            'VehiculeCategorieSupplementController@storeAll')->where(['suffix' => 'store-all'])->name('store-all');
            Route::post('/',                                            'VehiculeCategorieSupplementController@store')->name('store');
            Route::get('/{vehiculeCategorieSupplement}/edit/{categorie}',           'VehiculeCategorieSupplementController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VehiculeCategorieSupplementController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{vehiculeCategorieSupplement}',               'VehiculeCategorieSupplementController@update')->name('update');
            Route::post('/{vehiculeCategorieSupplement}/delete',             'VehiculeCategorieSupplementController@destroy')->name('destroy');
        });
    });
});



/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('restriction-trajet-vehicules')->name('restriction-trajet-vehicules/')->group(static function () {
            Route::get('/',                                             'RestrictionTrajetVehiculeController@index')->name('index');
            Route::get('/create',                                       'RestrictionTrajetVehiculeController@create')->name('create');
            Route::post('/',                                            'RestrictionTrajetVehiculeController@store')->name('store');
            Route::get('/{restrictionTrajetVehicule}/edit',             'RestrictionTrajetVehiculeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RestrictionTrajetVehiculeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{restrictionTrajetVehicule}',                 'RestrictionTrajetVehiculeController@update')->name('update');
            Route::post('/{restrictionTrajetVehicule}/delete',               'RestrictionTrajetVehiculeController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('vehicule-locations-produit-condition-tarifaires')->name('vehicule-locations-produit-condition-tarifaires/')->group(static function () {
            Route::get('/{locationVehicule}',                             'ProduitConditionTarifaireLocationVehiculeController@show')->name('show');
            Route::post('/',                                            'ProduitConditionTarifaireLocationVehiculeController@store')->name('store');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('supplement-location-vehicules')->name('supplement-location-vehicules/')->group(static function () {
            Route::get('/{locationVehicule}',                                             'SupplementLocationVehiculeController@index')->name('index');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('supplement-jeune-conducteur-location-vehicules')->name('supplement-jeune-conducteur-location-vehicules/')->group(static function () {
            Route::get('/{supplementJeune}/edit',      'SupplementJeuneConducteurLocationVehiculeController@edit')->name('edit');
            Route::post('/{supplementJeune}', 'SupplementJeuneConducteurLocationVehiculeController@update')->name('update');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('conducteur-supplemetaire-location-vehicules')->name('conducteur-supplemetaire-location-vehicules/')->group(static function () {
            Route::get('/{conducteurSupplemetaire}/edit',      'ConducteurSupplemetaireLocationVehiculeController@edit')->name('edit');
            Route::post('/{conducteurSupplemetaire}',   'ConducteurSupplemetaireLocationVehiculeController@update')->name('update');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin\LocationVehicule')->name('admin/')->group(static function () {
        Route::prefix('interet-retard-restitution-vehicules')->name('interet-retard-restitution-vehicules/')->group(static function () {
            Route::get('/',                                             'InteretRetardRestitutionVehiculeController@index')->name('index');
            Route::get('/create',                                       'InteretRetardRestitutionVehiculeController@create')->name('create');
            Route::post('/',                                            'InteretRetardRestitutionVehiculeController@store')->name('store');
            Route::get('/{interet}/edit',      'InteretRetardRestitutionVehiculeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'InteretRetardRestitutionVehiculeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{interet}',          'InteretRetardRestitutionVehiculeController@update')->name('update');
            Route::delete('/{interet}',        'InteretRetardRestitutionVehiculeController@destroy')->name('destroy');
        });
    });
});
