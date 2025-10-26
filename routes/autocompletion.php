<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('autocompletion')->name('autocompletion/')->group(static function() {

            /*  prestataires  */
            Route::prefix('prestataires')->name('prestataires/')->group(static function() {
                Route::post('/', 'PrestataireController@autocompletion')->name('index');
            });

            /*  famille vehicule  */
            Route::prefix('famille-vehicules')->name('famille-vehicules/')->group(static function() {
                Route::post('/', 'LocationVehicule\FamilleVehiculeController@autocompletion')->name('index');
            });
            /* categorie vehicule */
            Route::prefix('categorie-vehicules')->name('categorie-vehicules/')->group(static function() {
                Route::post('/', 'LocationVehicule\CategorieVehiculeController@autocompletion')->name('index');
            });
            /* marque vehicule */
            Route::prefix('marque-vehicules')->name('marque-vehicules/')->group(static function() {
                Route::post('/', 'LocationVehicule\MarqueVehiculeController@autocompletion')->name('index');
            });
            /* modele vehicule */
            Route::prefix('modele-vehicules')->name('modele-vehicules/')->group(static function() {
                Route::post('/', 'LocationVehicule\ModeleVehiculeController@autocompletion')->name('index');
            });

            /* vehicule */
            Route::prefix('vehicule-locations')->name('vehicule-locations/')->group(static function() {
                Route::post('/', 'LocationVehicule\VehiculeLocationController@autocompletion')->name('index');
            });


            /* villes */
            Route::prefix('villes')->name('villes/')->group(static function() {
                Route::post('/', 'VillesController@autocompletion')->name('index');
            });

            /* villes */
            Route::prefix('iles')->name('iles/')->group(static function() {
                Route::post('/', 'IlesController@autocompletion')->name('index');
            });

            /* pays */
            Route::prefix('pays')->name('pays/')->group(static function() {
                Route::post('/', 'PaysController@autocompletion')->name('index');
            });

            /* aeroport */
            Route::prefix('service-aeroport')->name('service-aeroports/')->group(static function() {
                Route::post('/', 'ServiceAeroportController@autocompletion')->name('index');
            });

            /* port */
            Route::prefix('service-port')->name('service-ports/')->group(static function() {
                Route::post('/', 'ServicePortController@autocompletion')->name('index');
            });

            /* lieu transfert */
            Route::prefix('lieu-transferts')->name('lieu-transferts/')->group(static function() {
                Route::post('/', 'TransfertVoyage\LieuTransfertController@autocompletion')->name('index');
            });

            /* agence location */
            Route::prefix('agence-locations')->name('agence-locations/')->group(static function() {
                Route::post('/', 'LocationVehicule\AgenceLocationController@autocompletion')->name('index');
            });

            /* trajet restriction location */
            Route::prefix('restriction-trajet-locations')->name('restriction-trajet-locations/')->group(static function() {
                Route::post('/', 'LocationVehicule\RestrictionTrajetVehiculeController@autocompletion')->name('index');
            });

            /* type transfert voyage */
            Route::prefix('type-transfert-voyages')->name('type-transfert-voyages/')->group(static function() {
                Route::post('/', 'TransfertVoyage\TypeTransfertVoyageController@autocompletion')->name('index');
            });

            /* type transfert voyage */
            Route::prefix('tranche-personne-transfert-voyages')->name('tranche-personne-transfert-voyages/')->group(static function() {
                Route::post('/', 'TransfertVoyage\TranchePersonneTransfertVoyageController@autocompletion')->name('index');
            });

            /* type transfert voyage */
            Route::prefix('trajet-transfert-voyages')->name('trajet-transfert-voyages/')->group(static function() {
                Route::post('/', 'TransfertVoyage\TrajetTransfertVoyageController@autocompletion')->name('index');
            });

            /* saison location vehicule */
            Route::prefix('saisonnalites')->name('saisonnalites/')->group(static function() {
                Route::post('/', 'SaisonsController@autocompletion')->name('index');
            });
            /*  billeteire  */
            Route::prefix('billeteries')->name('billeteries/')->group(static function() {
                Route::post('/', 'BilleterieMaritimeController@autocompletion')->name('index');
            });
             /*  type personne  */
             Route::prefix('type-personnes')->name('type-personnes/')->group(static function() {
                Route::post('/', 'TypePersonneController@autocompletion')->name('index');
            });
            /*  */
        });
    });
});
