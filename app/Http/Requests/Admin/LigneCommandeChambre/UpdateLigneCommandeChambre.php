<?php

namespace App\Http\Requests\Admin\LigneCommandeChambre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateLigneCommandeChambre extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-chambre.edit', $this->ligneCommandeChambre);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'hebergement_id' => ['nullable', 'string'],
            'hebergement_name' => ['nullable', 'string'],
            'hebergement_type' => ['nullable', 'string'],
            'hebergement_duration_min' => ['nullable', 'integer'],
            'hebergement_caution' => ['nullable', 'numeric'],
            'hebergement_etoil' => ['nullable', 'integer'],
            'chambre_id' => ['sometimes', 'string'],
            'chambre_name' => ['sometimes', 'string'],
            'chambre_image' => ['nullable', 'string'],
            'chambre_capacite' => ['sometimes', 'integer'],
            'chambre_base_type_titre' => ['sometimes', 'string'],
            'chambre_base_type_nombre' => ['sometimes', 'string'],
            'quantite_chambre' => ['sometimes', 'integer'],
            'date_debut' => ['sometimes', 'date'],
            'date_fin' => ['sometimes', 'date'],
            'prix_unitaire' => ['nullable', 'numeric'],
            'prix_total' => ['nullable', 'numeric'],
            'commande_id' => ['sometimes', 'string'],
            'ville_id' => ['sometimes', 'string'],
            'ile_id' => ['sometimes', 'string'],
            'prestataire_id' => ['nullable', 'string'],
            
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
