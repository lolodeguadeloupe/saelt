<?php

namespace App\Models\Excursion;

use Illuminate\Database\Eloquent\Model;

class TarifExcursion extends Model {

    protected $table = 'tarif_excursion';
    protected $fillable = [
        'prix_achat',
        'marge',
        'prix_vente',
        'excursion_id',
        'saison_id',
        'type_personne_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/tarif-excursions/' . $this->getKey());
    }

    public function saison() {
        return $this->belongsTo(\App\Models\Saison::class, "saison_id", "id");
    }

    public function personne() {
        return $this->belongsTo(\App\Models\TypePersonne::class, "type_personne_id", "id");
    }

    public function excursion() {
        return $this->belongsTo(Excursion::class, "excursion_id", "id");
    }

}
