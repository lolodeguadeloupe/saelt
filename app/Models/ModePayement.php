<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModePayement extends Model
{
    protected $table = 'mode_payement';

    protected $fillable = [
        'titre',
        'icon'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/mode-payements/'.$this->getKey());
    }

    public function config(){
        return $this->hasOne(ModePayementConfig::class,'mode_payement_id','id');
    }
}
