<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class SupplementJeuneConducteurLocationVehicule extends Model
{
    protected $table = 'supplement_jeune_conducteur_location_vehicule';

    protected $fillable = [
        'sigle',
        'min_age',
        'max_age',
        'valeur_pourcent',
        'valeur_devises',
        'valeur_appliquer',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/supplement-jeune-conducteur-location-vehicules/'.$this->getKey());
    }
}
