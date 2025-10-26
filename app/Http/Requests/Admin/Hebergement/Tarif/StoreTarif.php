<?php

namespace App\Http\Requests\Admin\Hebergement\Tarif;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTarif extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        $has_chambre_prix = DB::table('tarifs')
            ->select('tarifs.id')
            ->leftjoin('hebergement_vol', 'hebergement_vol.tarif_id', 'tarifs.id')
            ->where([
                'tarifs.hebergement_id' => $this->hebergement_id,
                'tarifs.type_chambre_id' => $this->type_chambre_id,
                'tarifs.base_type_id' => $this->base_type_id,
                'tarifs.saison_id' => $this->saison_id,
            ])
            ->whereNull('hebergement_vol.tarif_id')
            ->get();

        return [
            'titre' => ['nullable', 'string'],
            'type_chambre_id' => ['required', 'string', Rule::unique('tarifs')->where(function ($query) use ($has_chambre_prix) {
                $query->whereIn('id', collect($has_chambre_prix)->map(function ($data) {
                    return $data->id;
                })->toArray());
            })],
            'base_type_id' => ['required', 'string'],
            'saison_id' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'jour_min' => ['nullable', 'integer'],
            'jour_max' => ['nullable', 'integer'],
            'nuit_min' => ['nullable', 'integer'],
            'nuit_max' => ['nullable', 'integer'],
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
            /*'taxe' => ['required','numeric'],
            'taxe_active' => ['required','integer']*/
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
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
