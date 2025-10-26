<?php

namespace App\Http\Requests\Admin\TransfertVoyage\TarifTransfertVoyage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTarifTransfertVoyage extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-transfert-voyage.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'trajet_transfert_voyage_id' => ['required', 'string'],
            'tranche_transfert_voyage_id' => ['required', 'string'],
            //
            'type_personne_id' => ['required', 'array'],
            /** */
            'prix_achat_aller' => ['required', 'array'],
            'prix_achat_aller_retour' => ['required', 'array'],
            'marge_aller' => ['required', 'array'],
            'marge_aller_retour' => ['required', 'array'],
            'prix_vente_aller' => ['required', 'array'],
            'prix_vente_aller_retour' => ['required', 'array'],
            //
            'type_personne_id.*' => ['required', 'integer'],
            /** */
            'prix_achat_aller.*' => ['required', 'string'],
            'prix_achat_aller_retour.*' => ['required', 'string'],
            'marge_aller.*' => ['required', 'string'],
            'marge_aller_retour.*' => ['required', 'string'],
            'prix_vente_aller.*' => ['required', 'string'],
            'prix_vente_aller_retour.*' => ['required', 'string'],
            'prime_nuit' => ['required', 'string'],
        ];
    }

    public function getValidatorInstance()
    {

        $isTrue = true;
        $i = 0;
        $array_type_personnne_id = [];

        $array_prix_achat_aller = [];
        $array_prix_vente_aller = [];
        $array_marge_aller = [];
        //
        $array_prix_achat_aller_retour = [];
        $array_prix_vente_aller_retour = [];
        $array_marge_aller_retour = [];

        while ($isTrue) {

            if (!isset($this->{'type_personne_type_' . $i})) {
                $isTrue = false;
            } else {
                $array_type_personnne_id[] = $this->{'type_personne_id_' . $i};

                $array_marge_aller[] = $this->{'marge_aller_' . $i};
                $array_prix_achat_aller[] = $this->{'prix_achat_aller_' . $i};
                $array_prix_vente_aller[] = $this->{'prix_vente_aller_' . $i};
                //
                $array_marge_aller_retour[] = $this->{'marge_aller_retour_' . $i};
                $array_prix_achat_aller_retour[] = $this->{'prix_achat_aller_retour_' . $i};
                $array_prix_vente_aller_retour[] = $this->{'prix_vente_aller_retour_' . $i};
            }

            $i++;
        }

        $this->merge([
            'type_personne_id' => $array_type_personnne_id,
            'prix_achat_aller' => $array_prix_achat_aller,
            'prix_vente_aller' => $array_prix_vente_aller,
            'marge_aller' => $array_marge_aller,
            //
            'prix_achat_aller_retour' => $array_prix_achat_aller_retour,
            'prix_vente_aller_retour' => $array_prix_vente_aller_retour,
            'marge_aller_retour' => $array_marge_aller_retour
        ]);
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
