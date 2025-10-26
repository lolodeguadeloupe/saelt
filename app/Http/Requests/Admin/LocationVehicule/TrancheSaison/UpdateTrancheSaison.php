<?php

namespace App\Http\Requests\Admin\LocationVehicule\TrancheSaison;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTrancheSaison extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.tranche-saison.edit', $this->trancheSaison);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'titre' => ['sometimes', 'string'/*, Rule::unique('tranche_saison')->ignore($this->trancheSaison->getKey(), $this->trancheSaison->getKeyName())->where(function($query){
                $query->where(['model_saison'=> $this->model_saison,'titre'=> $this->titre]);
            })*/],
            'nombre_min' => ['sometimes', 'integer'],
            'nombre_max' => ['sometimes', 'integer'],
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
