<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model {

    protected $fillable = [
        'titre',
        'type_chambre_id',
        'saison_id',
        'description',
        'taxe',
        'taxe_active',
        'jour_min',
        'jour_max',
        'nuit_min',
        'nuit_max', 
        'hebergement_id',
        'base_type_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/tarifs/' . $this->getKey());
    }

    public function saison() {
        return $this->belongsTo(\App\Models\Saison::class, "saison_id", "id");
    }
    
    public function type_chambre() {
        return $this->belongsTo(TypeChambre::class, "type_chambre_id", "id");
    }

    public function vol() {
        return $this->hasOne(HebergementVol::class, "tarif_id", "id");
    }

    public function tarif() {
        return $this->hasMany(TarifTypePersonneHebergement::class, "tarif_id", "id")->orderBy('type_personne_id','asc');
    }

    public function hebergement() {
        return $this->belongsTo(Hebergement::class, "hebergement_id", "id");
    }

    public function base_type() {
        return $this->belongsTo(BaseType::class, "base_type_id", "id");
    }

}
