<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcursionTaxe extends Model
{
    protected $table = 'excursion_taxe';

    protected $fillable = [
        'excursion_id',
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
        return url('/admin/excursion-taxes/'.$this->getKey());
    }
}
