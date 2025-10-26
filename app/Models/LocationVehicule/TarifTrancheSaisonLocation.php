<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class TarifTrancheSaisonLocation extends Model {

    protected $table = 'tarif_tranche_saison_location';
    protected $fillable = [
        'marge',
        'prix_achat',
        'prix_vente',
        'tranche_saison_id',
        'vehicule_location_id',
        'saisons_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/tarif-tranche-saison-locations/' . $this->getKey());
    }

    public function trancheSaison() {
        return $this->belongsTo(TrancheSaison::class, "tranche_saison_id", "id");
    }
    
    public function vehicule() {
        return $this->belongsTo(VehiculeLocation::class, "vehicule_location_id", "id");
    }

    public function saison() {
        return $this->belongsTo(\App\Models\Saison::class, "saisons_id", "id");
    }

}
