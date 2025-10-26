<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventDateHeure;
use App\Models\MediaImageUpload;

class TypeChambre extends Model {

    protected $table = 'type_chambre';
    protected $fillable = [
        'name',
        'hebergement_id',
        'nombre_chambre',
        'nombre_adulte_max',
        'cout_supplementaire',
        'image',
        'description',
        'capacite',
        'hebergement_id',
        'status',
        'formule'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url','image','calendar'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/type-chambres/' . $this->getKey());
    }
    
    public function getImageAttribute() {
        return MediaImageUpload::where(['id_model' => $this->id . '_type_chambre'])->get();
    }
    
    public function getCalendarAttribute() {
        return EventDateHeure::where(['model_event' => $this->id . '_type_chambre'])->get();
    }
        
    //
    public function hebergement() {
        return $this->belongsTo(Hebergement::class, "hebergement_id", "id");
    }

    public function tarif() {
        return $this->hasMany(Tarif::class,'type_chambre_id','id');
    }

    public function supplement_vue(){
        return $this->belongsToMany(SupplementVue::class, 'supplement_vue_chambre', 'type_chambre_id', 'supplement_vue_id');
    }
    
    /*
     * $typeChambre['image'] = \App\Models\MediaImageUpload::where(['id_model' => $typeChambre->id . '_type_chambre'])->get();
        $typeChambre['calendar'] = EventDateHeure::where(['model_event' => $typeChambre->id . '_type_chambre'])->get();
     */

}
