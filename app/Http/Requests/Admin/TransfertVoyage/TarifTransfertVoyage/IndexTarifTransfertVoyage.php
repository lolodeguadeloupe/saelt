<?php

namespace App\Http\Requests\Admin\TransfertVoyage\TarifTransfertVoyage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexTarifTransfertVoyage extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.tarif-transfert-voyage.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'orderBy' => 'in:id,tranche_personne_transfert_voyage.titre,type_transfert_voyage.titre,trajet_transfert_voyage.titre,prime_nuit,type_personne.type,prix_achat_aller_retour,prix_achat_aller,|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',
        ];
    }

}
