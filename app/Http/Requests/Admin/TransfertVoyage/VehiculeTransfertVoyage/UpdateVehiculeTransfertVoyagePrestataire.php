<?php

namespace App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateVehiculeTransfertVoyagePrestataire extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.vehicule-transfert-voyage.update-prestataire', $this->prestataire);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'name' => ['sometimes', 'string'],
            'adresse' => ['sometimes', 'string'],
            'phone' => ['nullable', 'regex:/^[+0-9\s]*$/'],
            'email' => ['nullable', 'email', 'string'],
            'second_email' => ['nullable', 'email', 'string'],
            'ville_id' => ['sometimes', 'string'],
            'logo'=>['nullable','string'],
            'heure_ouverture' => ['nullable', 'date_format:H:i'],
            'heure_fermeture' => ['nullable', 'date_format:H:i'],
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
