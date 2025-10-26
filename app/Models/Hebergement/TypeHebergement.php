<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class TypeHebergement extends Model
{
    protected $table = 'type_hebergement';

    protected $fillable = [
        'name',
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
        return url('/admin/type-hebergements/'.$this->getKey());
    }
    
     public function hebergement() {
        return $this->hasMany(Hebergement::class, 'type_hebergement_id', 'id');
    }
}
