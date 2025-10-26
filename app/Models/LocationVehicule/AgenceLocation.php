<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;

class AgenceLocation extends Model {

    protected $table = 'agence_location';
    protected $fillable = [
        'code_agence',
        'name',
        'adresse',
        'phone',
        'email',
        'logo',
        'ville_id',
        'heure_ouverture',
        'heure_fermeture'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url','calendar'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/agence-locations/' . $this->getKey());
    }

    public function getCalendarAttribute() {
        return \App\Models\EventDateHeure::where(['model_event' => $this->id . '_agence_location'])->get();
    }

    public function ville() {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }

}
