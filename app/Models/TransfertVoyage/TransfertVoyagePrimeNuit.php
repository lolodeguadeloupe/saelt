<?php

namespace App\Models\TransfertVoyage;

use Illuminate\Database\Eloquent\Model;

class TransfertVoyagePrimeNuit extends Model
{
    protected $table = 'transfert_voyage_prime_nuit';

    protected $fillable = [
        'trajet_id',
        'type_transfert_id',
        'prime_nuit',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/transfert-voyage-prime-nuits/'.$this->getKey());
    }
}
