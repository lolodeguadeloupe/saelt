<?php

use App\Http\Controllers\NotificationCommandeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('admin', 'admin.dashboard')->name('dashboard');

/* login */
Route::middleware(['web'])->group(static function () {
    Route::namespace('App\Http\Controllers\Admin\Auth')->group(static function () {
        Route::get('/admin/login', 'LoginController@showLoginForm')->name('admin-auth/login');
        Route::post('/admin/login', 'LoginController@login');

        Route::any('/admin/logout', 'LoginController@logout')->name('admin-auth/logout');

        Route::get('/admin/password-reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin-auth/password/showForgotForm');
        Route::post('/admin/password-reset/send', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/admin/password-reset/{token}', 'ResetPasswordController@showResetForm')->name('admin-auth/password/showResetForm');
        Route::post('/admin/password-reset/reset', 'ResetPasswordController@reset');

        Route::get('/admin/activation/{token}', 'ActivationController@activate')->name('admin-auth/activation/activate');
    });
});

Route::middleware(['web'])->group(static function () {
    Route::namespace('App\Controllers\Admin\Auth')->group(static function () {
        /*Route::get('/admin/activation', 'ActivationEmailController@showLinkRequestForm')->name('admin-auth/activation');
        Route::post('/admin/activation/send', 'ActivationEmailController@sendActivationEmail');*/
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::post('/{adminUser}/delete',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('islands')->name('islands/')->group(static function () {
            Route::get('/',                                             'IslandsController@index')->name('index');
            Route::get('/create',                                       'IslandsController@create')->name('create');
            Route::post('/',                                            'IslandsController@store')->name('store');
            Route::get('/{island}/edit',                                'IslandsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'IslandsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{island}',                                    'IslandsController@update')->name('update');
            Route::post('/{island}/delete',                                  'IslandsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('villes')->name('villes/')->group(static function () {
            Route::get('/',                                             'VillesController@index')->name('index');
            Route::get('/create',                                       'VillesController@create')->name('create');
            Route::post('/',                                            'VillesController@store')->name('store');
            Route::get('/{ville}/edit',                                 'VillesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VillesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{ville}',                                     'VillesController@update')->name('update');
            Route::post('/{ville}/delete',                                   'VillesController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('saisons')->name('saisons/')->group(static function () {
            Route::get('/',                                             'SaisonsController@index')->name('index');
            Route::get('/create',                                       'SaisonsController@create')->name('create');
            Route::post('/',                                            'SaisonsController@store')->name('store');
            Route::get('/{saison}/edit',                                'SaisonsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SaisonsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{saison}',                                    'SaisonsController@update')->name('update');
            Route::post('/{saison}/delete',                                  'SaisonsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('type-personnes')->name('type-personnes/')->group(static function () {
            Route::get('/',                                             'TypePersonneController@index')->name('index');
            Route::get('/create',                                       'TypePersonneController@create')->name('create');
            Route::post('/',                                            'TypePersonneController@store')->name('store');
            Route::get('/{typePersonne}/edit',                          'TypePersonneController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TypePersonneController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{typePersonne}',                              'TypePersonneController@update')->name('update');
            Route::post('/{typePersonne}/delete',                            'TypePersonneController@destroy')->name('destroy');
        });
    });
});
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('type-personnes-prod')->name('type-personnes-prod/')->group(static function () {
            Route::get('/',                                             'TypePersonneController@indexPro')->name('index-prod');
        });
    });
});

require __DIR__ . '/payement.php';
require __DIR__ . '/front.php';
require __DIR__ . '/autocompletion.php';
require __DIR__ . '/hebergement.php';
require __DIR__ . '/excursion.php';
require __DIR__ . '/locationVehicule.php';
require __DIR__ . '/transfertVoyage.php';

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('devises')->name('devises/')->group(static function () {
            Route::get('/',                                             'DevisesController@index')->name('index');
            Route::get('/create',                                       'DevisesController@create')->name('create');
            Route::post('/',                                            'DevisesController@store')->name('store');
            Route::get('/{devise}/edit',                                'DevisesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DevisesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{devise}',                                    'DevisesController@update')->name('update');
            Route::post('/{devise}/delete',                                  'DevisesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('pays')->name('pays/')->group(static function () {
            Route::get('/',                                             'PaysController@index')->name('index');
            Route::get('/create',                                       'PaysController@create')->name('create');
            Route::post('/',                                            'PaysController@store')->name('store');
            Route::get('/{pay}/edit',                                   'PaysController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PaysController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{pay}',                                       'PaysController@update')->name('update');
            Route::post('/{pay}/delete',                                     'PaysController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('prestataires')->name('prestataires/')->group(static function () {
            Route::get('/',                                             'PrestataireController@index')->name('index');
            Route::get('/create',                                       'PrestataireController@create')->name('create');
            Route::post('/',                                            'PrestataireController@store')->name('store');
            Route::get('/{prestataire}/edit',                           'PrestataireController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PrestataireController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{prestataire}',                               'PrestataireController@update')->name('update');
            Route::post('/{prestataire}/delete',                             'PrestataireController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('media-image-uploads')->name('media-image-uploads/')->group(static function () {
            Route::get('/',                                             'MediaImageUploadController@index')->name('index');
            Route::get('/create',                                       'MediaImageUploadController@create')->name('create');
            Route::post('/',                                            'MediaImageUploadController@store')->name('store');
            Route::get('/{mediaImageUpload}/edit',                      'MediaImageUploadController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MediaImageUploadController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{mediaImageUpload}',                          'MediaImageUploadController@update')->name('update');
            Route::post('/{mediaImageUpload}/delete',                        'MediaImageUploadController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('event-date-heures')->name('event-date-heures/')->group(static function () {
            Route::get('/',                                             'EventDateHeureController@index')->name('index');
            Route::get('/create',                                       'EventDateHeureController@create')->name('create');
            Route::post('/',                                            'EventDateHeureController@store')->name('store');
            Route::get('/{eventDateHeure}/edit',                        'EventDateHeureController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'EventDateHeureController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{eventDateHeure}',                            'EventDateHeureController@update')->name('update');
            Route::post('/{eventDateHeure}/delete',                          'EventDateHeureController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('compagnie-transports')->name('compagnie-transports/')->group(static function () {
            Route::get('/',                                             'CompagnieTransportController@index')->name('index');
            Route::get('/all',                                             'CompagnieTransportController@index')->name('all');
            Route::get('/maritime',                                             'CompagnieTransportController@index')->name('maritime');
            Route::get('/aerien',                                             'CompagnieTransportController@index')->name('aerien');
            Route::get('/create',                                       'CompagnieTransportController@create')->name('create');
            Route::post('/',                                            'CompagnieTransportController@store')->name('store');
            Route::get('/{compagnieTransport}/edit',                          'CompagnieTransportController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CompagnieTransportController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{compagnieTransport}',                              'CompagnieTransportController@update')->name('update');
            Route::post('/{compagnieTransport}/delete',                            'CompagnieTransportController@destroy')->name('destroy');
        });
    });
});
/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('all-compagnie-transports')->name('all-compagnie-transports/')->group(static function () {
            Route::get('/',                                             'CompagnieTransportController@index')->name('all');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('maritime-compagnie-transports')->name('maritime-compagnie-transports/')->group(static function () {
            Route::get('/',                                             'CompagnieTransportController@index')->name('maritime');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('aerien-compagnie-transports')->name('aerien-compagnie-transports/')->group(static function () {
            Route::get('/',                                             'CompagnieTransportController@index')->name('aerien');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('taxes')->name('taxes/')->group(static function () {
            Route::get('/',                                             'TaxeController@index')->name('index');
            Route::get('/create',                                       'TaxeController@create')->name('create');
            Route::post('/',                                            'TaxeController@store')->name('store');
            Route::get('/{taxe}/edit',                                  'TaxeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TaxeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{taxe}',                                      'TaxeController@update')->name('update');
            Route::post('/{taxe}/delete',                                    'TaxeController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('excursion-taxes')->name('excursion-taxes/')->group(static function () {
            /*Route::get('/',                                             'ExcursionTaxeController@index')->name('index');
            Route::get('/create',                                       'ExcursionTaxeController@create')->name('create');
            Route::post('/',                                            'ExcursionTaxeController@store')->name('store');
            Route::get('/{excursionTaxe}/edit',                         'ExcursionTaxeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ExcursionTaxeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{excursionTaxe}',                             'ExcursionTaxeController@update')->name('update');
            Route::post('/{excursionTaxe}/delete',                           'ExcursionTaxeController@destroy')->name('destroy');*/
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('hebergement-taxes')->name('hebergement-taxes/')->group(static function () {
            /*Route::get('/',                                             'HebergementTaxeController@index')->name('index');
            Route::get('/create',                                       'HebergementTaxeController@create')->name('create');
            Route::post('/',                                            'HebergementTaxeController@store')->name('store');
            Route::get('/{hebergementTaxe}/edit',                       'HebergementTaxeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'HebergementTaxeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{hebergementTaxe}',                           'HebergementTaxeController@update')->name('update');
            Route::post('/{hebergementTaxe}/delete',                         'HebergementTaxeController@destroy')->name('destroy');*/
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('billeterie-maritimes')->name('billeterie-maritimes/')->group(static function () {
            Route::get('/', 'BilleterieMaritimeController@index')->name('index');
            Route::get('/create', 'BilleterieMaritimeController@create')->name('create');
            Route::post('/', 'BilleterieMaritimeController@store')->name('store');
            Route::get('/{billeterieMaritime}/edit', 'BilleterieMaritimeController@edit')->name('edit');
            Route::post('/bulk-destroy', 'BilleterieMaritimeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{billeterieMaritime}', 'BilleterieMaritimeController@update')->name('update');
            Route::post('/{billeterieMaritime}/delete', 'BilleterieMaritimeController@destroy')->name('destroy');
            Route::get('/{billeterieMaritime}', 'BilleterieMaritimeController@show')->name('show');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('planing-times')->name('planing-times/')->group(static function () {
            Route::get('/',                                             'PlaningTimeController@index')->name('index');
            Route::get('/create',                                       'PlaningTimeController@create')->name('create');
            Route::post('/',                                            'PlaningTimeController@store')->name('store');
            Route::get('/{planingTime}/edit',                           'PlaningTimeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PlaningTimeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{planingTime}',                               'PlaningTimeController@update')->name('update');
            Route::post('/{planingTime}/delete',                             'PlaningTimeController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('tarif-billeterie-maritimes')->name('tarif-billeterie-maritimes/')->group(static function () {
            Route::get('/',                                             'TarifBilleterieMaritimeController@index')->name('index');
            Route::get('/create',                                       'TarifBilleterieMaritimeController@create')->name('create');
            Route::post('/',                                            'TarifBilleterieMaritimeController@store')->name('store');
            Route::get('/{tarifBilleterieMaritime}/edit',               'TarifBilleterieMaritimeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TarifBilleterieMaritimeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tarifBilleterieMaritime}',                   'TarifBilleterieMaritimeController@update')->name('update');
            Route::post('/{tarifBilleterieMaritime}/delete',                 'TarifBilleterieMaritimeController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('service-ports')->name('service-ports/')->group(static function () {
            Route::get('/',                                             'ServicePortController@index')->name('index');
            Route::get('/create',                                       'ServicePortController@create')->name('create');
            Route::post('/',                                            'ServicePortController@store')->name('store');
            Route::get('/{servicePort}/edit',                           'ServicePortController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ServicePortController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{servicePort}',                               'ServicePortController@update')->name('update');
            Route::post('/{servicePort}/{suffix}',                             'ServicePortController@destroy')->where(['servicePort' => '[0-9]+', 'suffix' => 'delete'])->name('destroy');
            Route::post('/{servicePort}/calendar', 'ServicePortController@calendar')->name('calendar');
            Route::get('/{servicePort}', 'ServicePortController@show')->name('show');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('service-aeroports')->name('service-aeroports/')->group(static function () {
            Route::get('/',                                             'ServiceAeroportController@index')->name('index');
            Route::get('/create',                                       'ServiceAeroportController@create')->name('create');
            Route::post('/',                                            'ServiceAeroportController@store')->name('store');
            Route::get('/{serviceAeroport}/edit',                       'ServiceAeroportController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ServiceAeroportController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{serviceAeroport}',                           'ServiceAeroportController@update')->name('update');
            Route::post('/{serviceAeroport}/{suffix}',                         'ServiceAeroportController@destroy')->where(['serviceAeroport' => '[0-9]+', 'suffix' => 'delete'])->name('destroy');
            Route::post('/{serviceAeroport}/calendar', 'ServiceAeroportController@calendar')->name('calendar');
            Route::get('/{serviceAeroport}', 'ServiceAeroportController@show')->name('show');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('service-sessions')->name('service-sessions/')->group(static function () {
            Route::post('/push',                                       'GestionLiensUtilisateurAdminController@pushLiens')->name('push');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('iles')->name('iles/')->group(static function () {
            Route::get('/',                                             'IlesController@index')->name('index');
            Route::get('/create',                                       'IlesController@create')->name('create');
            Route::post('/',                                            'IlesController@store')->name('store');
            Route::get('/{ile}/edit',                                   'IlesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'IlesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{ile}',                                       'IlesController@update')->name('update');
            Route::post('/{ile}/delete',                                     'IlesController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('commandes')->name('commandes/')->group(static function () {
            Route::get('/',                                             'CommandeController@index')->name('index');
            Route::get('/create',                                       'CommandeController@create')->name('create');
            Route::post('/',                                            'CommandeController@store')->name('store');
            Route::get('/{commande}/edit',                              'CommandeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CommandeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{commande}',                                  'CommandeController@update')->name('update');
            Route::post('/{commande}/delete',                                'CommandeController@destroy')->name('destroy');
            Route::get('/{commande}', 'CommandeController@show')->name('show');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('frais-dossiers')->name('frais-dossiers/')->group(static function () {
            Route::get('/',                                             'FraisDossierController@index')->name('index');
            /*Route::get('/create',                                       'FraisDossierController@create')->name('create');
            Route::post('/',                                            'FraisDossierController@store')->name('store');*/
            Route::get('/{fraisDossier}/edit',                          'FraisDossierController@edit')->name('edit');
            /* Route::post('/bulk-destroy',                                'FraisDossierController@bulkDestroy')->name('bulk-destroy');*/
            Route::post('/{fraisDossier}',                              'FraisDossierController@update')->name('update');
            /*Route::post('/{fraisDossier}/delete',                            'FraisDossierController@destroy')->name('destroy');*/
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('mode-payements')->name('mode-payements/')->group(static function () {
            Route::get('/',                                             'ModePayementController@index')->name('index');
            Route::get('/create',                                       'ModePayementController@create')->name('create');
            Route::post('/',                                            'ModePayementController@store')->name('store');
            Route::get('/{modePayement}/edit',                          'ModePayementController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ModePayementController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{modePayement}',                              'ModePayementController@update')->name('update');
            Route::post('/{modePayement}/delete',                            'ModePayementController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('app-configs')->name('app-configs/')->group(static function () {
            Route::get('/',                                             'AppConfigController@index')->name('index');
            Route::get('/create',                                       'AppConfigController@create')->name('create');
            Route::post('/',                                            'AppConfigController@store')->name('store');
            Route::get('/{appConfig}/edit',                             'AppConfigController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AppConfigController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{appConfig}',                                 'AppConfigController@update')->name('update');
            Route::post('/{appConfig}/delete',                               'AppConfigController@destroy')->name('destroy');
        });
    });
});

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('app-supplements')->name('app-supplements/')->group(static function () {
            Route::get('/',                                             'AppSupplementController@all')->name('index');
        });
    });
});

Route::post('notification-client-commande', [NotificationCommandeController::class, 'facturation'])->name('notification-client-commande');
Route::post('notification-prestataire', [NotificationCommandeController::class, 'voucher'])->name('notification-prestataire');
Route::post('notification-application', [NotificationCommandeController::class, 'application'])->name('notification-application');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('produits')->name('produits/')->group(static function() {
            Route::get('/',                                             'ProduitController@index')->name('index');
            /*Route::get('/create',                                       'ProduitController@create')->name('create');
            Route::post('/',                                            'ProduitController@store')->name('store');*/
            Route::get('/{produit}/edit',                               'ProduitController@edit')->name('edit');
            /*Route::post('/bulk-destroy',                                'ProduitController@bulkDestroy')->name('bulk-destroy');*/
            Route::post('/{produit}',                                   'ProduitController@update')->name('update');
            /*Route::post('/{produit}/delete',                               'ProduitController@destroy')->name('destroy');*/
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('planing-vehicules')->name('planing-vehicules/')->group(static function() {
            Route::get('/',                                             'PlaningVehiculeController@index')->name('index');
            Route::get('/create',                                       'PlaningVehiculeController@create')->name('create');
            Route::post('/',                                            'PlaningVehiculeController@store')->name('store');
            Route::get('/{planingVehicule}/edit',                       'PlaningVehiculeController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PlaningVehiculeController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{planingVehicule}',                           'PlaningVehiculeController@update')->name('update');
            Route::post('/{planingVehicule}/delete',                               'PlaningVehiculeController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('coup-coeur-produits')->name('coup-coeur-produits/')->group(static function() {
            Route::get('/',                                             'CoupCoeurProduitController@index')->name('index');
            Route::get('/create',                                       'CoupCoeurProduitController@create')->name('create');
            Route::post('/',                                            'CoupCoeurProduitController@store')->name('store');
            Route::get('/{coupCoeurProduit}/edit',                      'CoupCoeurProduitController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CoupCoeurProduitController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{coupCoeurProduit}',                          'CoupCoeurProduitController@update')->name('update');
            Route::post('/{coupCoeurProduit}/delete',                               'CoupCoeurProduitController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('ligne-commande-locations')->name('ligne-commande-locations/')->group(static function() {
            Route::get('/{ligneCommandeLocation}/edit',                 'LigneCommandeLocationController@edit')->name('edit');
            Route::post('/{ligneCommandeLocation}',                     'LigneCommandeLocationController@update')->name('update');
        });
    });
});
