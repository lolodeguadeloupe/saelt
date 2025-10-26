<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BilleterieMaritime extends Model
{

    protected $table = 'billeterie_maritime';
    protected $fillable = [
        'availability',
        'titre',
        'lieu_depart_id',
        'lieu_arrive_id',
        'date_depart',
        'date_arrive',
        'date_acquisition',
        'date_limite',
        'image',
        'quantite',
        'compagnie_transport_id',
        'duree_trajet',
        'parcours'
    ];

    /*
     * $table->string('prix_achat_aller')->default('0');
      $table->string('prix_achat_aller_retour')->default('0');
      $table->float('marge_aller')->default(0);
      $table->float('marge_aller_retour')->default(0);
      $table->string('prix_vente_aller')->default('0');
      $table->string('prix_vente_aller_retour')->default('0');
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/billeterie-maritimes/' . $this->getKey());
    } 

    public function compagnie()
    {
        return $this->belongsTo(\App\Models\CompagnieTransport::class, "compagnie_transport_id", "id");
    }

    public function tarif()
    {
        return $this->hasMany(TarifBilleterieMaritime::class, "billeterie_maritime_id", "id")->orderBy('type_personne_id', 'asc');
    }

    public function depart()
    {
        return $this->belongsTo(\App\Models\ServicePort::class, "lieu_depart_id", "id");
    }

    public function arrive()
    {
        return $this->belongsTo(\App\Models\ServicePort::class, "lieu_arrive_id", "id");
    }

    public function personne()
    {
        return $this->morphMany(TypePersonne::class, 'type_personne', 'model', 'model_id');
    }
}
