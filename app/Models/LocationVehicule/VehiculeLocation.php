<?php

namespace App\Models\LocationVehicule;

use App\Models\Saison;
use Illuminate\Database\Eloquent\Model;

class VehiculeLocation extends Model {

    protected $table = 'vehicule_location';
    protected $fillable = [
        'titre',
        'immatriculation',
        'marque_vehicule_id',
        'modele_vehicule_id',
        'status',
        'description',
        'duration_min',
        'prestataire_id',
        'categorie_vehicule_id',
        'entite_modele',
        'franchise',
        'franchise_non_rachatable',
        'caution'
    ];
    protected $dates = [
        'date_ouverture',
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url', 'image', 'calendar'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/vehicule-locations/' . $this->getKey());
    }

    public function getImageAttribute() {
        return \App\Models\MediaImageUpload::where(['id_model' => $this->id . '_vehicule_location'])->get();
    }

    public function getCalendarAttribute() {
        return \App\Models\EventDateHeure::where(['model_event' => $this->id . '_vehicule_location'])->get();
    }

    public function prestataire() {
        return $this->belongsTo(\App\Models\Prestataire::class, "prestataire_id", "id");
    }

    public function categorie() {
        return $this->belongsTo(CategorieVehicule::class, "categorie_vehicule_id", "id");
    }

    public function marque() {
        return $this->belongsTo(MarqueVehicule::class, "marque_vehicule_id", "id");
    }

    public function modele() {
        return $this->belongsTo(ModeleVehicule::class, "modele_vehicule_id", "id");
    }

    public function transfert_voyage() {
        return $this->belongsToMany(\App\Models\TransfertVoyage\TypeTransfertVoyage::class, "vehicule_transfert_voyage", "vehicule_id", "type_transfert_voyage_id");
    }

    public function info_tech() {
        return $this->hasOne(VehiculeInfoTech::class, 'vehicule_id', 'id');
    }

    public function tarif_location() {
        return $this->hasMany(TarifTrancheSaisonLocation::class, "vehicule_location_id", "id");
    } 

    public function saison()
    {
        return $this->morphMany(Saison::class, 'saison', 'model', 'model_id');
    }

    public function tranche_saison()
    {
        return $this->morphMany(TrancheSaison::class, 'tranche_saison', 'model', 'model_id');
    }

}
