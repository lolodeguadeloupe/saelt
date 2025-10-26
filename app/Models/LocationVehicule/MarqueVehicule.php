<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class MarqueVehicule extends Model
{
    protected $table = 'marque_vehicule';

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
        return url('/admin/marque-vehicules/'.$this->getKey());
    }
}
