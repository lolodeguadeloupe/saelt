<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FacturationCommande extends Model
{
    use Notifiable;
    
    protected $table = 'facturation_commande';

    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'ville',
        'code_postal',
        'telephone',
        'email',
        'date',
        'commande_id',
    
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
        return url('/admin/facturation-commandes/'.$this->getKey());
    }
}
