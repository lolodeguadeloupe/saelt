<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class BaseType extends Model
{
    protected $table = 'base_type';

    protected $fillable = [
        'titre',
        'nombre',
        'description',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/base-types/'.$this->getKey());
    }
}
