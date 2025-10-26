<?php

namespace App\Models\Excursion;

use Illuminate\Database\Eloquent\Model;

class SupplementExcursion extends Model
{

    protected $table = 'supplement_excursion';
    protected $fillable = [
        'titre',
        'type',
        'description',
        'excursion_id',
        'icon',
        'prestataire_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url', 'type_label'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/supplement-excursions/' . $this->getKey());
    }
    public function getTypeLabelAttribute()
    {
        $type = $this->type;
        return collect([
            ['id' => 1, 'value' => 'dejeneur'],
            ['id' => 2, 'value' => 'activite'],
            ['id' => 3, 'value' => 'autres']
        ])->map(function ($data) {
            $data = collect($data)->put('label', trans('admin.supplement-excursion.type.' . $data['value']));
            return $data;
        })->filter(function ($data) use ($type) {
            return collect($data)->get('id') == $type;
        })->first();
    }

    public function tarif()
    {
        return $this->hasMany(TarifSupplementExcursion::class, "supplement_excursion_id", "id");
    }

    public function prestataire()
    {
        return $this->belongsTo(\App\Models\Prestataire::class, "prestataire_id", "id");
    }
}
