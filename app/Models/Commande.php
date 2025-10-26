<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table = 'commande';

    protected $fillable = [
        'date',
        'status',
        'status_payement',
        'prix',
        'tva',
        'frais_dossier',
        'prix_total',
        'mode_payement_id',
        'paiement_id',

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
        return url('/admin/commandes/' . $this->getKey());
    }

    public function hebergement()
    {
        return $this->hasMany(LigneCommandeChambre::class, 'commande_id', 'id');
    }

    public function excursion()
    {
        return $this->hasMany(LigneCommandeExcursion::class, 'commande_id', 'id');
    }

    public function location()
    {
        return $this->hasMany(LigneCommandeLocation::class, 'commande_id', 'id');
    }

    public function billeterie()
    {
        return $this->hasMany(LigneCommandeBilletterie::class, 'commande_id', 'id');
    }

    public function transfert()
    {
        return $this->hasMany(LigneCommandeTransfert::class, 'commande_id', 'id');
    }

    public function mode_payement()
    {
        return $this->belongsTo(ModePayement::class, 'mode_payement_id', 'id');
    }

    public function facture()
    {
        return $this->belongsTo(FacturationCommande::class, 'id', 'commande_id');
    }
}
