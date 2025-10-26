<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class CategorieVehicule extends Model {

    protected $table = 'categorie_vehicule';
    protected $fillable = [
        'titre',
        'description',
        'famille_vehicule_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/categorie-vehicules/' . $this->getKey());
    }

    public function famille() {
        return $this->belongsTo(FamilleVehicule::class, "famille_vehicule_id", "id");
    }

    public function supplement(){
        return $this->hasMany(VehiculeCategorieSupplement::class,'categorie_vehicule_id','id');
    }

}
