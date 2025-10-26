<?php

namespace App\Http\Requests\Admin\Hebergement\TarifSupplementPension;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTarifSupplementPension extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-supplement-pension.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'prix_achat' => ['required', 'string'],
            'marge' => ['required', 'numeric'],
            'prix_vente' => ['required', 'string'],
            'type_personne_id' => ['required', 'string'],
            'supplement_id' => ['required', 'string'],
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
