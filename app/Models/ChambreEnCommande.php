<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChambreEnCommande extends Model
{
    protected $table = 'chambre_en_commande';

    protected $fillable = [
        'nombre',
        'chambre_id',
        'session_id',
        'commande_id',
        'date',
        'date_debut',
        'date_fin',

    ];


    protected $dates = [
        'date',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/chambre-en-commandes/' . $this->getKey());
    }
}
