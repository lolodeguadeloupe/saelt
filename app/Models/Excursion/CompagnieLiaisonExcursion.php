<?php

namespace App\Models\Excursion;

use Illuminate\Database\Eloquent\Model;

class CompagnieLiaisonExcursion extends Model
{
    protected $table = 'compagnie_liaison_excursion';

    protected $fillable = [
        'excursion_id',
        'compagnie_transport_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/compagnie-liaison-excursions/'.$this->getKey());
    }
    
    public function compagnie() {
        return $this->belongsTo(\App\Models\CompagnieTransport::class, "compagnie_transport_id", "id");
    }
    
    public function excursion() {
        return $this->belongsTo(Excursion::class, "excursion_id", "id");
    }
}
