<?php

namespace App\Models\Hebergement;

use Illuminate\Database\Eloquent\Model;

class HebergementMarqueBlanche extends Model
{
    protected $table = 'hebergement_marque_blanche';

    protected $fillable = [
        'liens',
        'description',
        'image',
        'type_hebergement_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/hebergement-marque-blanches/'.$this->getKey());
    }
    
    public function type(){
        return $this->belongsTo(TypeHebergement::class,"type_hebergement_id","id");
    }
}
