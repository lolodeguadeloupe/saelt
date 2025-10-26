<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    protected $table = 'taxe';

    protected $fillable = [
        'titre',
        'sigle',
        'valeur_pourcent',
        'valeur_devises',
        'taxe_appliquer',
        'descciption',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/taxes/'.$this->getKey());
    }
}
