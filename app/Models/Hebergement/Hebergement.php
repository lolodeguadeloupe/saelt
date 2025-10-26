<?php

namespace App\Models\Hebergement;

use App\Models\Saison;
use App\Models\TypePersonne;
use Illuminate\Database\Eloquent\Model;

class Hebergement extends Model {

    protected $fillable = [
        'name',
        'image',
        'adresse',
        'ville_id',
        'description',
        'type_hebergement_id',
        'prestataire_id',
        'status',
        'heure_ouverture',
        'heure_fermeture',
        'duration_min',
        'caution',
        'ile_id',
        'etoil',
        'fond_image',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url', 'image', 'descriptif', 'condition_tarifaire','info_pratique'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/hebergements/' . $this->getKey());
    }

    public function getImageAttribute() {
        return \App\Models\MediaImageUpload::where(['id_model' => $this->id . '_heb'])->get();
    }

    public function getConditionTarifaireAttribute() {
        $conditionTarifaire = \App\Models\ProduitConditionTarifaire::where(['model_id' => 'hebergement_' . $this->id])->first();
        return $conditionTarifaire ?: ['condition_tarifaire' => ''];
    }
    
    public function getDescriptifAttribute() {
        $descriptif = \App\Models\ProduitDescriptif::where(['model_id' => 'hebergement_' . $this->id])->first();
        return $descriptif ?: ['descriptif' => null];
    }

    public function getInfoPratiqueAttribute() {
        $descriptif = \App\Models\ProduitInfoPratique::where(['model_id' => 'hebergement_' . $this->id])->first();
        return $descriptif ?: ['info_pratique' => null];
    }

    public function chambre() {
        return $this->hasMany(TypeChambre::class, "hebergement_id", "id");
    }

    public function type() {
        return $this->belongsTo(TypeHebergement::class, "type_hebergement_id", "id");
    }

    public function ville() {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }

    public function prestataire() {
        return $this->belongsTo(\App\Models\Prestataire::class, "prestataire_id", "id");
    }

    public function taxe() {
        return $this->belongsToMany(\App\Models\Taxe::class, "hebergement_taxe");
    }

    public function tarif() {
        return $this->hasMany(Tarif::class, "hebergement_id", "id");
    }

    public function supplement_activite() {
        return $this->hasMany(SupplementActivite::class, "hebergement_id", "id");
    }

    public function supplement_pension() {
        return $this->hasMany(SupplementPension::class, "hebergement_id", "id");
    }

    public function supplement_vue() {
        return $this->hasMany(SupplementVue::class, "hebergement_id", "id");
    }

    public function ile() {
        return $this->belongsTo(\App\Models\Ile::class, 'ile_id', 'id');
    }

    public function saison(){
        return $this->morphMany(Saison::class,'saison','model','model_id');
    }

    public function personne()
    {
        return $this->morphMany(TypePersonne::class, 'type_personne', 'model', 'model_id');
    }

}
