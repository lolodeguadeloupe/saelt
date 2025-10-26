<?php

namespace App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateVehiculeCategorieSupplement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.vehicule-categorie-supplement.edit', $this->vehiculeCategorieSupplement);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tarif' => ['sometimes', 'string'],
            'restriction_trajet_id' => ['sometimes', 'string',Rule::unique('vehicule_categorie_supplement')->where('restriction_trajet_id', $this->restriction_trajet_id)->where('categorie_vehicule_id',$this->categorie_vehicule_id)->ignore($this->vehiculeCategorieSupplement->getKey())],
            'categorie_vehicule_id' => ['sometimes', 'string'],
            
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
