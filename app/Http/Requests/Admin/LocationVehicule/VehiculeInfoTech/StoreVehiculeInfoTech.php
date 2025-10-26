<?php

namespace App\Http\Requests\Admin\LocationVehicule\VehiculeInfoTech;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreVehiculeInfoTech extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.vehicule-info-tech.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'nombre_place' => ['required', 'integer'],
            'nombre_porte' => ['required', 'integer'],
            'vitesse_maxi' => ['nullable', 'string'],
            'nombre_vitesse' => ['required', 'string'],
            'boite_vitesse' => ['required', 'string'],
            'kilometrage' => ['nullable', 'string'],
            'type_carburant' => ['required', 'string'],
            'fiche_technique' => ['nullable', 'string'],
            'vehicule_id' => ['required', 'string'],
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
