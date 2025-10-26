<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitDescriptif extends Model
{
    protected $table = 'produit_descriptif';

    protected $fillable = [
        'model_id',
        'descriptif',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/produit-descriptifs/'.$this->getKey());
    }
}
