<?php

namespace App\Http\Requests\Admin\LigneCommandeSupplement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreLigneCommandeSupplement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-supplement.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['required', Rule::unique('ligne_commande_supplement', 'titre'), 'string'],
            'icon' => ['nullable', 'string'],
            'regle_tarif' => ['required', 'string'],
            'prix' => ['nullable', 'numeric'],
            'commande_id' => ['required', 'string'],
            'ligne_commande_model' => ['required', 'string'],
            'ligne_commande_id' => ['required', 'integer'],
            
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
