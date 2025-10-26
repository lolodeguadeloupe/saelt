<?php

namespace App\Models\TransfertVoyage;

use Illuminate\Database\Eloquent\Model;

class TrajetTransfertVoyage extends Model {

    protected $table = 'trajet_transfert_voyage';
    protected $fillable = [ 
        'titre',
        'point_depart',
        'point_arrive',
        'description',
        'card',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/trajet-transfert-voyages/' . $this->getKey());
    }
    
    public function point_depart() {
        return $this->belongsTo(LieuTransfert::class, "point_depart", "id");
    }
    
    public function point_arrive() {
        return $this->belongsTo(LieuTransfert::class, "point_arrive", "id");
    }

}
