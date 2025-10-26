<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class ModeleVehicule extends Model
{
    protected $table = 'modele_vehicule';

    protected $fillable = [
        'titre',
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
        return url('/admin/modele-vehicules/'.$this->getKey());
    }
}
