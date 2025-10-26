<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraisDossier extends Model
{
    protected $table = 'frais_dossier';

    protected $fillable = [
        'titre',
        'sigle',
        'prix',
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/frais-dossiers/' . $this->getKey());
    }
}
