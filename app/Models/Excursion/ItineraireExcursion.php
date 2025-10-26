<?php

namespace App\Models\Excursion;

use Illuminate\Database\Eloquent\Model;

class ItineraireExcursion extends Model
{
    protected $table = 'itineraire_excursion';

    protected $fillable = [
        'excursion_id',
        'titre',
        'image',
        'rang',
        'description',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/itineraire-excursions/'.$this->getKey());
    }
}
