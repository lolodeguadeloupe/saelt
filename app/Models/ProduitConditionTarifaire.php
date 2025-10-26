<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitConditionTarifaire extends Model
{
    protected $table = 'produit_condition_tarifaire';

    protected $fillable = [
        'model_id',
        'condition_tarifaire',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/produit-condition-tarifaires/'.$this->getKey());
    }
}
