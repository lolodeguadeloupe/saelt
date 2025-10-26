<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestataire extends Model
{
    protected $table = 'prestataire';

    protected $fillable = [
        'name',
        'adresse',
        'phone',
        'email',
        'ville_id',
        'logo',
        'heure_ouverture',
        'heure_fermeture'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/prestataires/'.$this->getKey());
    }
    
    public function ville(){
        return $this->belongsTo(\App\Models\Ville::class,"ville_id","id");
    }
}
