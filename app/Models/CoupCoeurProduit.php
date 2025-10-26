<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoupCoeurProduit extends Model
{
    protected $table = 'coup_coeur_produit';

    protected $fillable = [
        'model',
        'model_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/coup-coeur-produits/'.$this->getKey());
    }
}
