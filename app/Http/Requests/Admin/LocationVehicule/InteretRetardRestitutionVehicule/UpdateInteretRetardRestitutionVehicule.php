<?php

namespace App\Http\Requests\Admin\LocationVehicule\InteretRetardRestitutionVehicule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateInteretRetardRestitutionVehicule extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.interet-retard-restitution-vehicule.edit', $this->interetRetardRestitutionVehicule);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['sometimes', 'string'],
            'duree_retard' => ['nullable', 'string'],
            'valeur_pourcent' => ['sometimes', 'numeric'],
            'valeur_devises' => ['sometimes', 'numeric'],
            'descciption' => ['nullable', 'string'],
            
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
