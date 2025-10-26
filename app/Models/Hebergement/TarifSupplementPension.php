<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class TarifSupplementPension extends Model
{
    protected $table = 'tarif_supplement_pension';

    protected $fillable = [
        'prix_achat',
        'marge',
        'prix_vente',
        'type_personne_id',
        'supplement_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/tarif-supplement-pensions/'.$this->getKey());
    }
    
    public function personne() {
        return $this->belongsTo(\App\Models\TypePersonne::class, "type_personne_id", "id");
    }
}
