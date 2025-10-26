<?php

namespace App\Http\Requests\Admin\Hebergement\TarifSupplementActivite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTarifSupplementActivite extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-supplement-activite.edit', $this->tarifSupplementActivite);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'prix_achat' => ['sometimes', 'string'],
            'marge' => ['sometimes', 'numeric'],
            'prix_vente' => ['sometimes', 'string'],
            'type_personne_id' => ['sometimes', 'string'],
            'supplement_id' => ['sometimes', 'string'],
            
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
