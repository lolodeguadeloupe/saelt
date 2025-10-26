<?php

namespace App\Models\TransfertVoyage;

use App\Models\Prestataire;
use App\Models\TypePersonne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeTransfertVoyage extends Model {

    protected $table = 'type_transfert_voyage';
    protected $fillable = [
        'titre',
        'description',
        'nombre_min',
        'nombre_max',
        'prestataire_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/type-transfert-voyages/' . $this->getKey());
    }

    public function prime_nuit_trajet() {
        return $this->belongsToMany(TrajetTransfertVoyage::class, "transfert_voyage_prime_nuit", "type_transfert_id", "trajet_id")->withPivot('prime_nuit');
    }

    public function tranche() { 
        return $this->hasMany(TranchePersonneTransfertVoyage::class, 'type_transfert_id', 'id');
    }

    public function vehicule() {
        return $this->belongsToMany(\App\Models\LocationVehicule\VehiculeLocation::class, 'vehicule_transfert_voyage', 'type_transfert_voyage_id', 'vehicule_id');
    }

    public function personne()
    {
        return $this->morphMany(TypePersonne::class, 'type_personne', 'model', 'model_id');
    }

    public function prestataire(){
        return $this->belongsTo(Prestataire::class,'prestataire_id','id');
    }

    //vehicule_transfert_voyage
}
