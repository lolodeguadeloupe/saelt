<?php

namespace App\Http\Requests\Admin\Hebergement\Tarif;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class RequestTarifWithVol extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif.create') || Gate::allows('admin.tarif.create-vol');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        $startTime = \Carbon\Carbon::parse($this->depart);
        $endTime = \Carbon\Carbon::parse($this->arrive);
        $min_nuit = $this->nombre_jour;

        $has_chambre_prix = DB::table('tarifs')
            ->select('tarifs.id')
            ->join('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
            ->where([
                'tarifs.hebergement_id' => $this->hebergement_id,
                'tarifs.type_chambre_id' => $this->type_chambre_id,
                'tarifs.base_type_id' => $this->base_type_id,
                'tarifs.saison_id' => $this->saison_id,
                'hebergement_vol.allotement_id' => $this->allotement_id
            ])->get();

        return [
            'titre' => ['nullable', 'string'],
            'type_chambre_id' => ['required', 'string', Rule::unique('tarifs')->where(function ($query) use ($has_chambre_prix) {
                $query->whereIn('id', collect($has_chambre_prix)->map(function ($data) {
                    return $data->id;
                })->toArray());
            })],
            'base_type_id'=>['required','string'],
            'saison_id' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'jour_min' => ['nullable', 'numeric'],
            'jour_max' => ['nullable', 'numeric'],
            'nuit_min' => ['nullable', 'numeric'],
            'nuit_max' => ['nullable', 'numeric'],
            'hebergement_id' => ['required', 'string'],
            //
            'type_personne_id' => ['required', 'array'],
            'type_personne_id.*' => ['required', 'string'],
            //
            'prix_vente' => ['required', 'array'],
            'prix_achat' => ['required', 'array'],
            'marge' => ['required', 'array'],
            //
            'prix_vente_supp' => ['nullable', 'array'],
            'prix_achat_supp' => ['nullable', 'array'],
            'marge_supp' => ['nullable', 'array'],
            //
            'prix_vente.*' => ['required', 'string'],
            'prix_achat.*' => ['required', 'string'],
            'marge.*' => ['required', 'string'],
            //
            'prix_vente_supp.*' => ['required', 'string'],
            'prix_achat_supp.*' => ['required', 'string'],
            'marge_supp.*' => ['required', 'string'],
            /* 'taxe' => ['required','numeric'],
              'taxe_active' => ['required','integer'], */

            //vol
            'depart' => ['required', 'date', 'after:now'],
            'arrive' => ['required', 'date', 'after_or_equal:depart'],
            'nombre_jour' => ['required', 'numeric', 'min:1'],
            'nombre_nuit' => ['required', 'integer'],
            'heure_depart' => ['required', 'string'],
            'heure_arrive' => ['required', 'string'],
            'allotement_id' => ['required', 'string'],
            //'tarif_id' => ['required', 'string'], //ici, pas de besoin
        ];
    }

    public function getValidatorInstance()
    {

        $isTrue = true;
        $i = 0;
        $array_type_personnne_id = [];
        $array_prix_achat = [];
        $array_prix_vente = [];
        $array_marge = [];
        /** supp */
        $array_prix_achat_supp = [];
        $array_prix_vente_supp = [];
        $array_marge_supp = [];

        while ($isTrue) {

            if (!isset($this->{'type_personne_id_' . $i})) {
                $isTrue = false;
            } else {
                $array_type_personnne_id[] = $this->{'type_personne_id_' . $i};
                $array_marge[] = $this->{'marge_' . $i};
                $array_prix_achat[] = $this->{'prix_achat_' . $i};
                $array_prix_vente[] = $this->{'prix_vente_' . $i};
                /** test supp personne */
                $_personne_chambre = DB::table('type_chambre')->find($this->type_chambre_id);
                $_chambre_base = DB::table('base_type')->find($this->base_type_id);
                if (intval($_personne_chambre->capacite) > intval($_chambre_base->nombre)) {
                    if (isset($this->{'prix_vente_supp_' . $i})) {
                        $array_marge_supp[] = $this->{'marge_supp_' . $i};
                        $array_prix_achat_supp[] = $this->{'prix_achat_supp_' . $i};
                        $array_prix_vente_supp[] = $this->{'prix_vente_supp_' . $i};
                    }
                }
            }
            $i++;
        }
        $_all_merge = [
            'prix_achat_supp' => $array_prix_achat_supp,
            'prix_vente_supp' => $array_prix_vente_supp,
            'marge_supp' => $array_marge_supp,
            'prix_achat' => $array_prix_achat,
            'prix_vente' => $array_prix_vente,
            'marge' => $array_marge,
            'type_personne_id' => $array_type_personnne_id,
        ];
        $this->merge($_all_merge);
        return parent::getValidatorInstance();
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitizedTarif(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return [
            'hebergement_id' => $sanitized['hebergement_id'],
            'titre' => $sanitized['titre'],
            'marge' => $sanitized['marge'],
            'prix_achat' => $sanitized['prix_achat'],
            'prix_vente' => $sanitized['prix_vente'],
            'type_chambre_id' => $sanitized['type_chambre_id'],
            'base_type_id' => $sanitized['base_type_id'],
            /** */
            'marge_supp' => $sanitized['marge_supp'],
            'prix_achat_supp' => $sanitized['prix_achat_supp'],
            'prix_vente_supp' => $sanitized['prix_vente_supp'],
            /** */
            'type_personne_id' => $sanitized['type_personne_id'],
            'saison_id' => $sanitized['saison_id'],
            'description' => $sanitized['description'],
            'jour_min' => $sanitized['jour_min'],
            'jour_max' => $sanitized['jour_max'],
            'nuit_max' => $sanitized['nuit_max'],
            'nuit_min' => $sanitized['nuit_min'],
            /* 'taxe' => $sanitized['taxe'],
                  'taxe_active' => $sanitized['taxe_active'], */
        ];
    }

    public function getSanitizedVol(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return [
            'depart' => $sanitized['depart'],
            'arrive' => $sanitized['arrive'],
            'nombre_jour' => $sanitized['nombre_jour'],
            'nombre_nuit' => $sanitized['nombre_nuit'],
            'heure_depart' => $sanitized['heure_depart'],
            'heure_arrive' => $sanitized['heure_arrive'],
            'allotement_id' => $sanitized['allotement_id'],
            //'tarif_id' => $sanitized['tarif_id'],
        ];
    }
}
