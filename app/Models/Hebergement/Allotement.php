<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class Allotement extends Model
{
    protected $fillable = [
        'titre',
        'quantite',
        'date_depart',
        'date_arrive',
        'date_acquisition',
        'date_limite',
        'heure_depart',
        'heure_arrive',
        'lieu_depart_id',
        'lieu_arrive_id',
        'compagnie_transport_id',
    
    ];
    
    
    protected $dates = [
        'date_depart',
        'date_arrive',
        'date_acquisition',
        'date_limite',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/allotements/'.$this->getKey());
    }
    
    public function compagnie(){
        return $this->belongsTo(\App\Models\CompagnieTransport::class,"compagnie_transport_id","id");
    }
    public function depart(){
        return $this->belongsTo(\App\Models\ServiceAeroport::class,"lieu_depart_id","id");
    }
    public function arrive(){
        return $this->belongsTo(\App\Models\ServiceAeroport::class,"lieu_arrive_id","id");
    }
}
