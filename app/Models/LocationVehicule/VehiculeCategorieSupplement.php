<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class VehiculeCategorieSupplement extends Model
{
    protected $table = 'vehicule_categorie_supplement';

    protected $fillable = [
        'tarif',
        'restriction_trajet_id',
        'categorie_vehicule_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/vehicule-categorie-supplements/'.$this->getKey());
    }
    
    public function categorie() {
        return $this->belongsTo(CategorieVehicule::class, "categorie_vehicule_id", "id");
    }
    
    public function trajet() {
        return $this->belongsTo(RestrictionTrajetVehicule::class, "restriction_trajet_id", "id");
    }
}
