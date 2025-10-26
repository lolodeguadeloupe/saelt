<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ile extends Model {

    protected $fillable = [
        'name',
        'card',
        'pays_id',
        'background_image',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/iles/' . $this->getKey());
    }

    public function pays(){
        return $this->belongsTo(Pay::class,"pays_id","id");
    }
    
    public function hebergement(){
        return $this->hasMany(Hebergement\Hebergement::class,"ile_id","id");
    }
    
    public function excursion(){
        return $this->hasMany(Excursion\Excursion::class,"ile_id","id");
    }
    
}
