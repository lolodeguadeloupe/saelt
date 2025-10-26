<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class TarifSupplementVue extends Model
{
    protected $table = 'tarif_supplement_vue';

    protected $fillable = [
        'prix_achat',
        'marge',
        'prix_vente',
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
        return url('/admin/tarif-supplement-vues/'.$this->getKey());
    }
}
