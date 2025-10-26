<?php

namespace App\Http\Requests\Admin\Excursion\TarifExcursion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAllTarifExcursion extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.tarif-excursion.update-all');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'excursion_id' => ['required', 'string'],
            'saison_id' => ['required', 'string',],
            //
            'type_personne_id' => ['required', 'array'],
            'type_personne_id.*' => ['required', 'string'],
            //
            'prix_vente' => ['required', 'array'],
            'prix_achat' => ['required', 'array'],
            'marge' => ['required', 'array'],
            //
            'prix_vente.*' => ['required', 'string'],
            'prix_achat.*' => ['required', 'string'],
            'marge.*' => ['required', 'string'],
        ];
    }

    public function getValidatorInstance() {

        $isTrue = true;
        $i = 0;
        $array_type_personnne_id = [];
        $array_prix_achat = [];
        $array_prix_vente = [];
        $array_marge = [];

        while ($isTrue) {

            if (!isset($this->{'type_personne_id_' . $i})) {
                $isTrue = false;
            } else {
                $array_type_personnne_id[] = $this->{'type_personne_id_' . $i};
                $array_marge[] = $this->{'marge_' . $i};
                $array_prix_achat[] = $this->{'prix_achat_' . $i};
                $array_prix_vente[] = $this->{'prix_vente_' . $i};
            }

            $i++;
        }
        $this->merge(['type_personne_id' => $array_type_personnne_id,
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
