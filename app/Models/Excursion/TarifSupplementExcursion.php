<?php

namespace App\Models\Excursion;

use Illuminate\Database\Eloquent\Model;

class TarifSupplementExcursion extends Model {

    protected $table = 'tarif_supplement_excursion';
    protected $fillable = [
        'supplement_excursion_id',
        'type_personne_id',
        'prix_achat',
        'marge',
        'prix_vente',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/tarif-supplement-excursions/' . $this->getKey());
    }

    public function personne() {
        return $this->belongsTo(\App\Models\TypePersonne::class, "type_personne_id", "id");
    }

    public function supplement() {
        return $this->belongsTo(SupplementExcursion::class, "supplement_excursion_id", "id");
    }

}
