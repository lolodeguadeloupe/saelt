<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class FamilleVehicule extends Model {

    protected $table = 'famille_vehicule';
    protected $fillable = [
        'titre',
        'description',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/famille-vehicules/' . $this->getKey());
    }

    public function categorie() {
        return $this->hasMany(CategorieVehicule::class, 'famille_vehicule_id', 'id');
    }

}
