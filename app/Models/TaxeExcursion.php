<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxeExcursion extends Model
{
    protected $table = 'taxe_excursion';

    protected $fillable = [
        'tarif_excursion_id',
        'taxe_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/taxe-excursions/'.$this->getKey());
    }
}
