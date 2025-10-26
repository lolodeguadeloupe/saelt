<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class ConducteurSupplemetaireLocationVehicule extends Model
{
    protected $table = 'conducteur_supplemetaire_location_vehicule';

    protected $fillable = [
        'sigle',
        'valeur_pourcent',
        'valeur_devises',
        'valeur_appliquer'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/conducteur-supplemetaire-location-vehicules/'.$this->getKey());
    }
}
