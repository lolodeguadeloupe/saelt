<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class SupplementPension extends Model
{
    protected $table = 'supplement_pension';

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

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/supplement-pensions/'.$this->getKey());
    }
    
    public function tarif() {
        return $this->hasMany(TarifSupplementPension::class, "supplement_id", "id");
    }
    
    public function prestataire()
    {
        return $this->belongsTo(\App\Models\Prestataire::class, "prestataire_id", "id");
    }
}
