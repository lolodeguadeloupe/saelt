<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class RestrictionTrajetVehicule extends Model
{
    protected $table = 'restriction_trajet_vehicule';

    protected $fillable = [
        'titre',
        'agence_location_depart',
        'agence_location_arrive',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/restriction-trajet-vehicules/'.$this->getKey());
    }
    
    public function point_depart() {
        return $this->belongsTo(AgenceLocation::class, "agence_location_depart", "id");
    }
    
    public function point_arrive() {
        return $this->belongsTo(AgenceLocation::class, "agence_location_arrive", "id");
    }
}
