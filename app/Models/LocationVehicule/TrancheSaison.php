<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class TrancheSaison extends Model {

    protected $table = 'tranche_saison';
    protected $fillable = [
        'titre',
        'nombre_min',
        'nombre_max',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/tranche-saisons/' . $this->getKey());
    }

    public function tarif() {
        return $this->hasMany(TarifTrancheSaisonLocation::class, 'tranche_saison_id', 'id');
    }

}
