<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AppConfig extends Model
{
    use Notifiable;
    protected $table = 'app_config';

    protected $fillable = [
        'email',
        'nom',
        'adresse',
        'site_web',
        'telephone',
        'ville_id',
        'logo'

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/app-configs/' . $this->getKey());
    }

    public function ville()
    {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }
}
