<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeChambre extends Model
{
    protected $table = 'ligne_commande_chambre';

    protected $fillable = [
        'hebergement_id',
        'hebergement_name',
        'hebergement_type',
        'hebergement_duration_min',
        'hebergement_caution',
        'hebergement_etoil',
        'chambre_id',
        'chambre_name',
        'chambre_image',
        'chambre_capacite',
        'chambre_base_type_titre',
        'chambre_base_type_nombre',
        'quantite_chambre',
        'date_debut',
        'date_fin',
        'prix_unitaire',
        'prix_total',
        'commande_id',
        'ville_id',
        'ile_id',
        'prestataire_id',
    
    ];
    
    
    protected $dates = [
        'date_debut',
        'date_fin',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-chambres/'.$this->getKey());
    }

    public function supplement(){
        return $this->morphMany(LigneCommandeSupplement::class,'ligne_commande','ligne_commande_model','ligne_commande_id');
    }

    public function personne()
    {
        return $this->morphMany(LigneCommandeTypePersonne::class, 'ligne_commande', 'ligne_commande_model', 'ligne_commande_id');
    }

    public function vol()
    {
        return $this->morphMany(LigneVolHebergement::class, 'ligne_commande', 'ligne_commande_model', 'ligne_commande_id');
    }

    public function prestataire(){
        return $this->belongsTo(Prestataire::class,'prestataire_id','id');
    }

}
