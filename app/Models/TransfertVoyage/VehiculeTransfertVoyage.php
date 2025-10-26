<?php

namespace App\Models\TransfertVoyage;

use Illuminate\Database\Eloquent\Model;

class VehiculeTransfertVoyage extends Model
{
    protected $table = 'vehicule_transfert_voyage';

    protected $fillable = [
        'type_transfert_voyage_id',
        'vehicule_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/vehicule-transfert-voyages/'.$this->getKey());
    }
    
    public function type() {
        return $this->belongsTo(TypeTransfertVoyage::class, "type_transfert_voyage_id", "id");
    }
}
