<?php

namespace App\Models\Excursion;

use Illuminate\Database\Eloquent\Model;

class ItineraireDescriptionExcursion extends Model
{
    protected $table = 'itineraire_description_excursion';

    protected $fillable = [
        'description',
        'excursion_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/itineraire-description-excursions/'.$this->getKey());
    }
}
