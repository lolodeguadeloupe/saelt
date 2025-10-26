<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeLunchPrestataire extends Model
{
    protected $table = 'ligne_commande_lunch_prestataire';

    protected $fillable = [
        'prestataire_id',
        'prestataire_name',
        'prestataire_adresse',
        'prestataire_ville',
        'prestataire_code_postal',
        'prestataire_phone',
        'prestataire_email',
        'prestataire_second_email',
        'model',
        'model_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-lunch-prestataires/'.$this->getKey());
    }
}
