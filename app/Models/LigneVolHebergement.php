<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneVolHebergement extends Model
{
    protected $table = 'ligne_vol_hebergement';

    protected $fillable = [
        'ligne_commande_model',
        'ligne_commande_id',
        'depart',
        'arrive',
        'nombre_jour',
        'nombre_nuit',
        'heure_depart',
        'heure_arrive',
        'allotement_id',
        'titre',
        'compagnie_transport_id',
        'lieu_depart_id',
        'lieu_depart',
        'lieu_arrive_id',
        'lieu_arrive',
        'compagnie_nom',
        'compagnie_email',
        'compagnie_phone',
        'compagnie_adresse',
        'compagnie_logo',
        'type_transport',
        'compagnie_heure_ouverture',
        'compagnie_heure_fermeture',
        'compagnie_ville_id',
        'compagnie_ville_name',
    
    ];
    
    
    protected $dates = [
        'depart',
        'arrive',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-vol-hebergements/'.$this->getKey());
    }
}
