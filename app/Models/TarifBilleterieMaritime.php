<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifBilleterieMaritime extends Model
{
    protected $table = 'tarif_billeterie_maritime';

    protected $fillable = [
        'billeterie_maritime_id',
        'type_personne_id',
        'prix_vente_aller',
        'prix_achat_aller',
        'marge_aller',
        'prix_vente_aller_retour',
        'prix_achat_aller_retour',
        'marge_aller_retour'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/tarif-billeterie-maritimes/'.$this->getKey());
    }
    
    public function personne() {
        return $this->belongsTo(\App\Models\TypePersonne::class, "type_personne_id", "id");
    }
}
