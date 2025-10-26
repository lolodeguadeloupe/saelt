<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class VoucherCommande extends Model
{
    use Notifiable;
    
    protected $table = 'voucher_commande';

    protected $fillable = [
        'email',
        'name',
        'model',
        'model_id',
        'commande_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/voucher-commandes/'.$this->getKey());
    }
}
