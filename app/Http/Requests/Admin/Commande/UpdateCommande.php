<?php

namespace App\Http\Requests\Admin\Commande;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCommande extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.commande.edit', $this->commande);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => ['sometimes', 'string'],
            'status' => ['sometimes', 'string'],
            'status_payement' => ['sometimes', 'string'],
            'prix_total' => ['nullable', 'numeric'],
            'prix' => ['nullable', 'numeric'],
            'tva' => ['nullable', 'numeric'],
            'mode_payement_id' => ['sometimes' => 'numeric'],

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
