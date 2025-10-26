<?php

namespace App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTarifTrancheSaisonLocation extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.tarif-tranche-saison-location.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'saisons_id' => ['required', 'string'],
            'vehicule_location_id' => ['required', 'string'],
            //
            'prix_vente' => ['required', 'array'],
            'prix_achat' => ['required', 'array'],
            'marge' => ['required', 'array'],
            'tranche_saison_id' =>['required','array'],
            //
            'prix_vente.*' => ['required', 'string'],
            'prix_achat.*' => ['required', 'string'],
            'marge.*' => ['required', 'string'],
            'tranche_saison_id.*' => ['required', 'string'],
        ];
    }

    public function getValidatorInstance() {

        $isTrue = true;
        $i = 0;
        $array_tranche_saison_id = [];
        $array_prix_achat = [];
        $array_prix_vente = [];
        $array_marge = [];

        while ($isTrue) {

            if (!isset($this->{'tranche_saison_id_' . $i})) {
                $isTrue = false;
            } else {
                $array_tranche_saison_id[] = $this->{'tranche_saison_id_' . $i};
                $array_marge[] = $this->{'marge_' . $i};
                $array_prix_achat[] = $this->{'prix_achat_' . $i};
                $array_prix_vente[] = $this->{'prix_vente_' . $i};
            }

            $i++;
        }
        
        $this->merge(['tranche_saison_id' => $array_tranche_saison_id,
            'prix_achat' => $array_prix_achat,
            'prix_vente' => $array_prix_vente,
            'marge' => $array_marge
        ]);
        return parent::getValidatorInstance();
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }

}
