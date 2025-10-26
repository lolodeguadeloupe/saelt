<?php

namespace App\Http\Requests\Admin\FacturationCommande;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateFacturationCommande extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.facturation-commande.edit', $this->facturationCommande);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nom' => ['sometimes', 'string'],
            'prenom' => ['sometimes', 'string'],
            'adresse' => ['sometimes', 'string'],
            'ville' => ['sometimes', 'string'],
            'code_postal' => ['sometimes', 'string'],
            'telephone' => ['sometimes', 'string'],
            'mobile' => ['sometimes', 'string'],
            'date' => ['sometimes', 'date'],
            'commande_id' => ['sometimes', 'string'],
            
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
