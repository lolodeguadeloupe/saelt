<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    protected $fillable = [
        'debut',
        'debut_format',
        'fin',
        'fin_format',
        'titre',
        'description'

    ];


    protected $dates = [
        'debut',
        'fin',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/saisons/' . $this->getKey());
    }

    public function tarif()
    {
        return $this->hasMany(Tarif::class, "tarif_id", "id");
    }
}
