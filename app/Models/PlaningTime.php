<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaningTime extends Model
{
    protected $table = 'planing_time';

    protected $fillable = [
        'id_model',
        'debut',
        'fin',
        'availability'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/planing-times/'.$this->getKey());
    }
}
