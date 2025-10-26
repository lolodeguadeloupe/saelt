<?php

namespace App\Models\TransfertVoyage;

use Illuminate\Database\Eloquent\Model;

class TranchePersonneTransfertVoyage extends Model {

    protected $table = 'tranche_personne_transfert_voyage';
    protected $fillable = [
        'titre',
        'nombre_min',
        'nombre_max',
        'type_transfert_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/tranche-personne-transfert-voyages/' . $this->getKey());
    }

    public function type() {
        return $this->belongsTo(TypeTransfertVoyage::class, "type_transfert_id", "id");
    }
    
    public function tarif() {
        return $this->hasMany(TarifTransfertVoyage::class, "tranche_transfert_voyage_id", "id");
    }

}
