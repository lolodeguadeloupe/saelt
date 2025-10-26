<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompagnieTransport extends Model {

    protected $table = 'compagnie_transport';
    protected $fillable = [
        'code_compagnie',
        'nom',
        'email',
        'phone',
        'adresse',
        'type_transport',
        'ville_id',
        'logo',
        'heure_ouverture',
        'heure_fermeture'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/compagnie-transports/' . $this->getKey());
    }

    public function ville() {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }

    public function billeterie() {
        return $this->hasMany(BilleterieMaritime::class, "compagnie_transport_id", "id");
    }

}
