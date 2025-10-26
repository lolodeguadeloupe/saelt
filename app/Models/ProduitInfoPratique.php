<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitInfoPratique extends Model
{
    protected $table = 'produit_info_pratique';

    protected $fillable = [
        'model_id',
        'info_pratique',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/produit-info-pratiques/'.$this->getKey());
    }
}
