<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeLocation extends Model
{
    protected $table = 'ligne_commande_location';

    protected $fillable = [
        'location_id',
        'titre',
        'immatriculation',
        'duration_min',
        'franchise',
        'franchise_non_rachatable',
        'caution',
        'image',
        'marque_vehicule_id',
        'marque_vehicule_titre',
        'modele_vehicule_id',
        'modele_vehicule_titre',
        'categorie_vehicule_id',
        'categorie_vehicule_titre',
        'famille_vehicule_id',
        'famille_vehicule_titre',
        'prestataire_id',
        'agence_recuperation_name',
        'agence_recuperation_id',
        'agence_restriction_name',
        'agence_restriction_id',
        'date_recuperation',
        'date_restriction',
        'heure_recuperation',
        'heure_restriction',
        'nom_conducteur',
        'prenom_conducteur',
        'adresse_conducteur',
        'ville_conducteur',
        'code_postal_conducteur',
        'telephone_conducteur',
        'email_conducteur',
        'date_naissance_conducteur',
        'lieu_naissance_conducteur',
        'num_permis_conducteur',
        'date_permis_conducteur',
        'lieu_deliv_permis_conducteur',
        'num_identite_conducteur',
        'date_emis_identite_conducteur',
        'lieu_deliv_identite_conducteur',
        'order_comments',
        'prix_unitaire',
        'prix_total',
        'commande_id',
        'deplacement_lieu_tarif'
    
    ];
    
    
    protected $dates = [
        'date_recuperation',
        'date_restriction',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-locations/'.$this->getKey());
    }

    public function supplement(){
        return $this->morphMany(LigneCommandeSupplement::class,'ligne_commande','ligne_commande_model','ligne_commande_id');
    }

    public function personne()
    {
        return $this->morphMany(LigneCommandeTypePersonne::class, 'ligne_commande', 'ligne_commande_model', 'ligne_commande_id');
    }

    public function prestataire(){
        return $this->belongsTo(Prestataire::class,'prestataire_id','id');
    }

    public function commande(){
        return $this->belongsTo(Commande::class,'commande_id','id');
    }

}
