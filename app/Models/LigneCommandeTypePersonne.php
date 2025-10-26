<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeTypePersonne extends Model
{
    protected $table = 'ligne_commande_type_personne';

    protected $fillable = [
        'type',
        'age',
        'prix',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-type-personnes/'.$this->getKey());
    }
}
