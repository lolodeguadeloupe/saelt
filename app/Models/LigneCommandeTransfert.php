<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeTransfert extends Model
{
    protected $table = 'ligne_commande_transfert';

    protected $fillable = [
        'transfert_id',
        'titre',
        'date_depart',
        'date_retour',
        'image',
        'quantite',
        'lieu_depart_id',
        'lieu_depart_name',
        'lieu_arrive_id',
        'lieu_arrive_name',
        'parcours',
        'heure_depart',
        'heure_retour',
        'prix_unitaire',
        'prix_total',
        'commande_id',
        'prime_depart',
        'prime_retour',
        'prestataire_id'
    
    ];
    
    
    protected $dates = [
        'date_depart',
        'date_retour',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-transferts/'.$this->getKey());
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
}
