<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class HebergementVol extends Model
{
    protected $table = 'hebergement_vol';

    protected $fillable = [
        'depart',
        'arrive',
        'nombre_jour',
        'nombre_nuit',
        'heure_depart',
        'heure_arrive',
        'tarif_id',
        'allotement_id'
    
    ];
    
    
    protected $dates = [
        'depart',
        'arrive',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/hebergement-vols/'.$this->getKey());
    }
    
    public function allotement(){
        return $this->belongsTo(Allotement::class,"allotement_id","id");
    }
}
