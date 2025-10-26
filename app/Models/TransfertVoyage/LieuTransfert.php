<?php

namespace App\Models\TransfertVoyage;

use Illuminate\Database\Eloquent\Model;

class LieuTransfert extends Model
{
    protected $table = 'lieu_transfert';

    protected $fillable = [
        'titre',
        'adresse',
        'ville_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/lieu-transferts/'.$this->getKey());
    }
    
    public function ville() {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }
}
