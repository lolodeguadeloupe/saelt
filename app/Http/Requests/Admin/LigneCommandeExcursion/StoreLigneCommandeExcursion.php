<?php

namespace App\Http\Requests\Admin\LigneCommandeExcursion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreLigneCommandeExcursion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-excursion.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'excursion_id' => ['required', 'string'],
            'title' => ['required', 'string'],
            'participant_min' => ['required', 'integer'],
            'fond_image' => ['nullable', 'string'],
            'card' => ['nullable', 'string'],
            'lunch' => ['required', 'integer'],
            'ticket' => ['required', 'integer'],
            'adresse_arrive' => ['nullable', 'string'],
            'adresse_depart' => ['nullable', 'string'],
            'ville_id' => ['required', 'string'],
            'ile_id' => ['required', 'string'],
            'prestataire_id' => ['nullable', 'string'],
            'lieu_depart_id' => ['nullable', 'string'],
            'lieu_arrive_id' => ['nullable', 'string'],
            'quantite_chambre' => ['required', 'integer'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
            'prix_unitaire' => ['nullable', 'numeric'],
            'prix_total' => ['nullable', 'numeric'],
            'commande_id' => ['required', 'string'],
            
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
