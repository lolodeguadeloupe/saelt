<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePort extends Model
{
    protected $table = 'service_port';

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
        return url('/admin/service-ports/'.$this->getKey());
    }
    
    public function ville() {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }
}
