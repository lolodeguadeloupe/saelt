<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeBilletCompagnie extends Model
{
    protected $table = 'ligne_commande_billet_compagnie';

    protected $fillable = [
        'compagnie_id',
        'compagnie_nom',
        'compagnie_email',
        'compagnie_phone',
        'compagnie_adresse',
        'compagnie_ville',
        'compagnie_code_postal',
        'billet_id',
        'billet_titre',
        'billet_date_depart',
        'billet_date_arrive',
        'billet_lieu_depart_id',
        'billet_lieu_arrive_id',
        'billet_lieu_depart_name',
        'billet_lieu_arrive_name',
        'billet_lieu_depart_ville',
        'billet_lieu_arrive_ville',
        'billet_lieu_depart_code_postal',
        'billet_lieu_arrive_code_postal',
        'model',
        'model_id',
    
    ];
    
    
    protected $dates = [
        'billet_date_depart',
        'billet_date_arrive',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-billet-compagnies/'.$this->getKey());
    }
}
