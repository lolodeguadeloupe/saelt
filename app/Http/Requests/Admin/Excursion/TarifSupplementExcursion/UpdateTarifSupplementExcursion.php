<?php

namespace App\Http\Requests\Admin\Excursion\TarifSupplementExcursion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTarifSupplementExcursion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-supplement-excursion.edit', $this->tarifSupplementExcursion);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'supplement_excursion_id' => ['sometimes', 'string'],
            'type_personne_id' => ['sometimes', 'string'],
            'marge' => ['sometimes', 'string'],
            'prix_achat' => ['sometimes', 'string'],
            'prix_vente' => ['sometimes', 'string'],
            
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
