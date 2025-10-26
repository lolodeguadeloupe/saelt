<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAeroport extends Model
{
    protected $table = 'service_aeroport';

    protected $fillable = [
        'code_service',
        'name',
        'adresse',
        'phone',
        'email',
        'logo',
        'ville_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/service-aeroports/'.$this->getKey());
    }
    
    public function ville() {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }
}
