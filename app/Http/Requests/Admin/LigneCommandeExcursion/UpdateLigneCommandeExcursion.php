<?php

namespace App\Http\Requests\Admin\LigneCommandeExcursion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateLigneCommandeExcursion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-excursion.edit', $this->ligneCommandeExcursion);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'excursion_id' => ['sometimes', 'string'],
            'title' => ['sometimes', 'string'],
            'participant_min' => ['sometimes', 'integer'],
            'fond_image' => ['nullable', 'string'],
            'card' => ['nullable', 'string'],
            'lunch' => ['sometimes', 'integer'],
            'ticket' => ['sometimes', 'integer'],
            'adresse_arrive' => ['nullable', 'string'],
            'adresse_depart' => ['nullable', 'string'],
            'ville_id' => ['sometimes', 'string'],
            'ile_id' => ['sometimes', 'string'],
            'prestataire_id' => ['nullable', 'string'],
            'lieu_depart_id' => ['nullable', 'string'],
            'lieu_arrive_id' => ['nullable', 'string'],
            'date_excursion' => ['sometimes', 'date'],
            'prix_unitaire' => ['nullable', 'numeric'],
            'prix_total' => ['nullable', 'numeric'],
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
