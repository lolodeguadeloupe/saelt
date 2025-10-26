<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeBilletterie extends Model
{
    protected $table = 'ligne_commande_billetterie';

    protected $fillable = [
        'billeterie_id',
        'titre',
        'date_depart',
        'date_retour',
        'image',
        'quantite',
        'compagnie_transport_id',
        'compagnie_transport_name',
        'lieu_depart_id',
        'lieu_depart_name',
        'lieu_arrive_id',
        'lieu_arrive_name',
        'parcours',
        'heure_aller',
        'heure_retour',
        'prix_unitaire',
        'prix_total',
        'commande_id',
    
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
        return url('/admin/ligne-commande-billetteries/'.$this->getKey());
    }

    public function supplement(){
        return $this->morphMany(LigneCommandeSupplement::class,'ligne_commande','ligne_commande_model','ligne_commande_id');
    }

    public function personne()
    {
        return $this->morphMany(LigneCommandeTypePersonne::class, 'ligne_commande', 'ligne_commande_model', 'ligne_commande_id');
    }

    public function compagnie(){
        return $this->belongsTo(CompagnieTransport::class,'compagnie_transport_id','id');
    }
}
