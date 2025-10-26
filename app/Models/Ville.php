<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $fillable = [
        'name',
        'pays_id',
        'code_postal'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/villes/'.$this->getKey());
    }
    
    public function pays(){
        return $this->belongsTo(Pay::class,"pays_id","id");
    }
}
