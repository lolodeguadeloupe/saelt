<?php

namespace App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTarifTrancheSaisonLocation extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.tarif-tranche-saison-location.edit', $this->tarifTrancheSaisonLocation);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'prix_vente' => ['sometimes', 'string'],
            'prix_achat' => ['sometimes', 'string'],
            'marge' => ['sometimes', 'string'],
            //
            'tranche_saison_id' => ['sometimes', 'string'],
            'vehicule_location_id' => ['sometimes', 'string'],
            'saisons_id' => ['sometimes', 'string'],
        ];
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
