<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class TarifTypePersonneHebergement extends Model
{
    protected $table = 'tarif_type_personne_hebergement';

    protected $fillable = [
        'prix_achat',
        'marge',
        'prix_vente',
        'type_personne_id',
        'tarif_id',
        /** */
        'prix_achat_supp',
        'marge_supp',
        'prix_vente_supp'

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/tarif-type-personne-hebergements/' . $this->getKey());
    }

    public function personne()
    {
        return $this->belongsTo(\App\Models\TypePersonne::class, "type_personne_id", "id");
    }
}
