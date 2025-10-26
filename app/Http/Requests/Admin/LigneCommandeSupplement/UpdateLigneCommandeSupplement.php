<?php

namespace App\Http\Requests\Admin\LigneCommandeSupplement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateLigneCommandeSupplement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-supplement.edit', $this->ligneCommandeSupplement);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['sometimes', Rule::unique('ligne_commande_supplement', 'titre')->ignore($this->ligneCommandeSupplement->getKey(), $this->ligneCommandeSupplement->getKeyName()), 'string'],
            'icon' => ['nullable', 'string'],
            'regle_tarif' => ['sometimes', 'string'],
            'prix' => ['nullable', 'numeric'],
            'commande_id' => ['sometimes', 'string'],
            'ligne_commande_model' => ['sometimes', 'string'],
            'ligne_commande_id' => ['sometimes', 'integer'],
            
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
