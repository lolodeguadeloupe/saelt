<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class InteretRetardRestitutionVehicule extends Model
{
    protected $table = 'interet_retard_restitution_vehicule';

    protected $fillable = [
        'titre',
        'duree_retard',
        'valeur_pourcent',
        'valeur_devises',
        'valeur_appliquer',
        'descciption',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/interet-retard-restitution-vehicules/'.$this->getKey());
    }
}
