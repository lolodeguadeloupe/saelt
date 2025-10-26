<?php

namespace App\Http\Requests\Admin\LocationVehicule\VehiculeCategorieSupplement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAllVehiculeCategorieSupplement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.vehicule-categorie-supplement.create-all');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tarif' => ['required', 'array'],
            'restriction_trajet_id' => ['required', 'array'],
            'categorie_vehicule_id' => ['required', 'array'],
            //
            'tarif.*' => ['required', 'string'],
            'restriction_trajet_id.*' => ['required', 'string'],
            'categorie_vehicule_id.*' => ['required', 'string'],

        ];
    }

    public function getValidatorInstance()
    {

        $isTrue = true;
        $i = 0;
        $array_tarif = [];
        $array_categorie_vehicule_id = [];
        $array_restriction_trajet_id = [];

        while ($isTrue) {

            if (!isset($this->{'categorie_vehicule_id_' . $i})) {
                $isTrue = false;
            } else {
                $array_categorie_vehicule_id[] = $this->{'categorie_vehicule_id_' . $i};
                $array_tarif[] = $this->{'tarif_' . $i};
                $array_restriction_trajet_id[] = $this->{'restriction_trajet_id_' . $i};
            }

            $i++;
        }
        $_all_merge = [
            'tarif' => $array_tarif,
            'restriction_trajet_id' => $array_restriction_trajet_id,
            'categorie_vehicule_id' => $array_categorie_vehicule_id,
        ];
        $this->merge($_all_merge);
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
