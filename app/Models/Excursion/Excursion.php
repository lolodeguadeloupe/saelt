<?php

namespace App\Models\Excursion;

use App\Models\BilleterieMaritime;
use App\Models\Prestataire;
use App\Models\Saison;
use App\Models\TypePersonne;
use Illuminate\Database\Eloquent\Model;

class Excursion extends Model
{

    protected $fillable = [
        'title',
        'lunch',
        'lunch_prestataire_id',
        'ticket',
        'ticket_billeterie_id',
        'availability',
        'duration',
        'participant_min',
        'card',
        'ville_id',
        'status',
        'description',
        'prestataire_id',
        'heure_depart',
        'heure_arrive',
        'lieu_depart_id',
        'lieu_arrive_id',
        'ile_id',
        'adresse_depart',
        'adresse_arrive',
        'fond_image'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url', 'image', 'descriptif', 'condition_tarifaire', 'info_pratique', 'calendar', 'lunch_prestataire', 'ticket_billeterie'];

    /*     * *********************** ACCESSOR ************************* */
    public function getResourceUrlAttribute()
    {
        return url('/admin/excursions/' . $this->getKey());
    }

    public function getCalendarAttribute()
    {
        return \App\Models\EventDateHeure::where(['model_event' => $this->id . 'excursion'])->get();
    }

    public function getImageAttribute()
    {
        return \App\Models\MediaImageUpload::where(['id_model' => $this->id . '_excursion'])->get();
    }

    public function getConditionTarifaireAttribute()
    {
        $conditionTarifaire = \App\Models\ProduitConditionTarifaire::where(['model_id' => 'excursion_' . $this->id])->first();
        return $conditionTarifaire ?: ['condition_tarifaire' => ''];
    }

    public function getDescriptifAttribute()
    {
        $descriptif = \App\Models\ProduitDescriptif::where(['model_id' => 'excursion_' . $this->id])->first();
        return $descriptif ?: ['descriptif' => null];
    }

    public function getInfoPratiqueAttribute()
    {
        $descriptif = \App\Models\ProduitInfoPratique::where(['model_id' => 'excursion_' . $this->id])->first();
        return $descriptif ?: ['info_pratique' => null];
    }

    public function getLunchPrestataireAttribute()
    {
        if ($this->lunch_prestataire_id == null) {
            return [];
        }
        $_ids = explode(',', $this->lunch_prestataire_id);
        $lunch = collect($_ids)->map(function ($_id) {
            return Prestataire::with(['ville' => function ($query) {
                $query->with(['pays']);
            }])->find($_id);
        });
        return collect($lunch)->filter(function ($data) {
            return $data != null;
        })->values();
    }

    public function getTicketBilleterieAttribute()
    {
        if ($this->ticket_billeterie_id == null) {
            return [];
        }
        $_ids = explode(',', $this->ticket_billeterie_id);
        $billet = collect($_ids)->map(function ($_id) {
            return BilleterieMaritime::with(['compagnie' => function ($query) {
                $query->with(['ville' => function ($query) {
                    $query->with(['pays']);
                }]);
            }, 'depart' => function ($query) {
                $query->with(['ville' => function ($query) {
                    $query->with(['pays']);
                }]);
            }, 'arrive' => function ($query) {
                $query->with(['ville' => function ($query) {
                    $query->with(['pays']);
                }]);
            }])->find($_id);
        });
        return collect($billet)->filter(function ($data) {
            return $data != null;
        })->values();
    }

    public function ville()
    {
        return $this->belongsTo(\App\Models\Ville::class, "ville_id", "id");
    }

    public function prestataire()
    {
        return $this->belongsTo(\App\Models\Prestataire::class, "prestataire_id", "id");
    }

    public function tarif()
    {
        return $this->hasMany(TarifExcursion::class, 'excursion_id', 'id')->orderBy('type_personne_id', 'asc');
    }

    public function supplement()
    {
        return $this->hasMany(SupplementExcursion::class, 'excursion_id', 'id');
    }

    public function taxe()
    {
        return $this->belongsToMany(\App\Models\Taxe::class, "excursion_taxe");
    }

    public function compagnie()
    {
        return $this->belongsToMany(\App\Models\CompagnieTransport::class, "compagnie_liaison_excursion"); /* meme relation mais compagnie_liaison_excursion seulement */
    }

    public function depart()
    {
        return $this->belongsTo(\App\Models\ServicePort::class, "lieu_depart_id", "id");
    }
    public function arrive()
    {
        return $this->belongsTo(\App\Models\ServicePort::class, "lieu_arrive_id", "id");
    }
    public function ile()
    {
        return $this->belongsTo(\App\Models\Ile::class, 'ile_id', 'id');
    }

    public function compagnie_liaison()
    {
        return $this->hasMany(CompagnieLiaisonExcursion::class, 'excursion_id', 'id'); /* meme relation mais reflete vers compagnie */
    }

    /*public function itineraire() {
        return $this->hasMany(ItineraireExcursion::class, 'excursion_id', 'id')->orderBy('rang','asc');
    }*/

    public function itineraire()
    {
        return $this->hasOne(ItineraireDescriptionExcursion::class, 'excursion_id', 'id');
    }

    public function saison()
    {
        return $this->morphMany(Saison::class, 'saison', 'model', 'model_id');
    }

    public function personne()
    {
        return $this->morphMany(TypePersonne::class, 'type_personne', 'model', 'model_id');
    }
}
