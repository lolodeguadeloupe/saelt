<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommandeExcursion extends Model
{
    protected $table = 'ligne_commande_excursion';

    protected $fillable = [
        'excursion_id',
        'title',
        'participant_min',
        'fond_image',
        'duration',
        'card',
        'lunch',
        'ticket',
        'adresse_arrive',
        'adresse_depart',
        'heure_depart',
        'heure_arrive',
        'ville_id',
        'ile_id',
        'prestataire_id',
        'lieu_depart_id',
        'lieu_arrive_id',
        'date_excursion',
        'prix_unitaire',
        'prix_total',
        'commande_id',
        'lunch_prestataire_id',
        'ticket_compagnie_id'

    ];


    protected $dates = [
        'date_excursion',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/ligne-commande-excursions/' . $this->getKey());
    }

    public function supplement()
    {
        return $this->morphMany(LigneCommandeSupplement::class, 'ligne_commande', 'ligne_commande_model', 'ligne_commande_id');
    }

    public function personne()
    {
        return $this->morphMany(LigneCommandeTypePersonne::class, 'ligne_commande', 'ligne_commande_model', 'ligne_commande_id');
    }

    public function ile()
    {
        return $this->belongsTo(Ile::class, 'ile_id', 'id');
    }

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class, 'prestataire_id', 'id');
    }

    public function lunch_prestataire()
    {
        return $this->morphMany(LigneCommandeLunchPrestataire::class, 'lunch_prestataire', 'model', 'model_id');
    }

    public function billet_compagnie()
    {
        return $this->morphMany(LigneCommandeBilletCompagnie::class, 'billet_compagnie', 'model', 'model_id');
    }
}
