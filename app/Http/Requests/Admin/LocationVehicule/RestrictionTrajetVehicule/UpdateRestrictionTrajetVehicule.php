<?php

namespace App\Http\Requests\Admin\LocationVehicule\RestrictionTrajetVehicule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRestrictionTrajetVehicule extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.restriction-trajet-vehicule.edit', $this->restrictionTrajetVehicule);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['nullable', 'string'],
            'agence_location_depart' => ['sometimes', 'string',Rule::unique('restriction_trajet_vehicule', 'agence_location_depart')->where('agence_location_arrive', $this->agence_location_arrive)->ignore($this->restrictionTrajetVehicule->getKey(), $this->restrictionTrajetVehicule->getKeyName())],
            'agence_location_arrive' => ['sometimes', 'string',Rule::notIn([$this->agence_location_depart])],
            
        ];
    }
    
    public function getValidatorInstance() {
        $this->merge(['titre' => isset($this->titre) && $this->titre != '' ? $this->titre : $this->agence_location_depart_titre . ' - ' . $this->agence_location_arrive_titre]);
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
