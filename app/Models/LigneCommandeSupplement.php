<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeSupplement extends Model
{
    protected $table = 'ligne_commande_supplement';

    protected $fillable = [
        'titre',
        'icon',
        'regle_tarif',
        'prix',
        'commande_id',
        'ligne_commande_model',
        'ligne_commande_id',
        /** */
        'prestataire_id',
        'prestataire_name',
        'prestataire_adresse',
        'prestataire_ville',
        'prestataire_code_postal',
        'prestataire_phone',
        'prestataire_email',
        'prestataire_second_email'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-supplements/'.$this->getKey());
    }

    public function personne()
    {
        return $this->morphMany(LigneCommandeTypePersonne::class, 'ligne_commande', 'ligne_commande_model', 'ligne_commande_id');
    }
}
