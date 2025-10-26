<?php

namespace App\Http\Requests\Admin\LocationVehicule\ConducteurSupplemetaireLocationVehicule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateConducteurSupplemetaireLocationVehicule extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.conducteur-supplemetaire-location-vehicule.edit', $this->conducteurSupplemetaireLocationVehicule);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'valeur_pourcent' => ['sometimes', 'numeric'],
            'valeur_devises' => ['sometimes', 'numeric'],
            'valeur_appliquer' => ['sometimes', 'string']
            
        ];
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
