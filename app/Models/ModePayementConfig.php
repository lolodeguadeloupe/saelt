<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModePayementConfig extends Model
{
    protected $table = 'mode_payement_config';

    protected $fillable = [
        'key_test',
        'key_prod',
        'base_url_test',
        'base_url_prod',
        'api_version',
        'mode',
        'mode_payement_id',
    
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/mode-payement-configs/'.$this->getKey());
    }
}
