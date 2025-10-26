<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class SupplementVue extends Model
{

    protected $table = 'supplement_vue';
    protected $fillable = [
        'titre',
        'description',
        'regle_tarif',
        'hebergement_id',
        'icon',
        'prestataire_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/supplement-vues/' . $this->getKey());
    }

    public function tarif()
    {
        return $this->hasMany(TarifSupplementVue::class, "supplement_id", "id");
    }

    public function chambre()
    {
        return $this->belongsToMany(TypeChambre::class, 'supplement_vue_chambre', 'supplement_vue_id', 'type_chambre_id');
    }

    public function prestataire()
    {
        return $this->belongsTo(\App\Models\Prestataire::class, "prestataire_id", "id");
    }
}
