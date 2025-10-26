<?php

namespace App\Http\Requests\Admin\LocationVehicule\VehiculeInfoTech;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateVehiculeInfoTech extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.vehicule-info-tech.edit', $this->vehiculeInfoTech);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'nombre_place' => ['sometimes', 'integer'],
            'nombre_porte' => ['sometimes', 'integer'],
            'vitesse_maxi' => ['nullable', 'string'],
            'nombre_vitesse' => ['sometimes', 'string'],
            'boite_vitesse' => ['sometimes', 'string'],
            'kilometrage' => ['nullable', 'string'],
            'type_carburant' => ['sometimes', 'string'],
            'fiche_technique' => ['nullable', 'string'],
            'vehicule_id' => ['sometimes', 'string'],
        ];
    }

    public function getValidatorInstance()
    {
        $fiche_technique = [];
        if (isset($this->fiche_technique)) {
            $fiche_technique['fiche_technique'] = RequestUploadImage::upload($this->fiche_technique,'fiche-technique');
        }
        $this->merge($fiche_technique);
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
