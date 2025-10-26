<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HebergementTaxe extends Model
{
    protected $table = 'hebergement_taxe';

    protected $fillable = [
        'hebergement_id',
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
        return url('/admin/hebergement-taxes/'.$this->getKey());
    }
}
