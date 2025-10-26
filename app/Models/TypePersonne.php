<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePersonne extends Model
{
    protected $table = 'type_personne';

    protected $fillable = [
        'type',
        'age',
        'description',
        'original_id'
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/type-personnes/'.$this->getKey());
    }
    
    public function tarif(){
        return $this->hasMany(Hebergement\Tarif::class,"type_personne_id","id");
    }
}
