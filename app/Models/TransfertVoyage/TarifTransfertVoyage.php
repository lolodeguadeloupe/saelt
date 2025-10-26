<?php

namespace App\Models\TransfertVoyage;

use Illuminate\Database\Eloquent\Model;

class TarifTransfertVoyage extends Model { 

    protected $table = 'tarif_transfert_voyage';
    protected $fillable = [
        'trajet_transfert_voyage_id',
        'type_personne_id',
        'tranche_transfert_voyage_id',
        'prix_achat_aller',
        'prix_achat_aller_retour',
        'marge_aller',
        'marge_aller_retour',
        'prix_vente_aller',
        'prix_vente_aller_retour',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/tarif-transfert-voyages/' . $this->getKey());
    }

    public function personne() {
        return $this->belongsTo(\App\Models\TypePersonne::class, "type_personne_id", "id");
    }

    public function trajet() {
        return $this->belongsTo(TrajetTransfertVoyage::class, "trajet_transfert_voyage_id", "id");
    }

    public function tranche() {
        return $this->belongsTo(TranchePersonneTransfertVoyage::class, "tranche_transfert_voyage_id", "id");
    }

}
