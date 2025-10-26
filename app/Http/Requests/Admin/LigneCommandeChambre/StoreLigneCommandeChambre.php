<?php

namespace App\Http\Requests\Admin\LigneCommandeChambre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreLigneCommandeChambre extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-chambre.create');
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
            'chambre_id' => ['required', 'string'],
            'chambre_name' => ['required', 'string'],
            'chambre_image' => ['nullable', 'string'],
            'chambre_capacite' => ['required', 'integer'],
            'chambre_base_type_titre' => ['required', 'string'],
            'chambre_base_type_nombre' => ['required', 'string'],
            'quantite_chambre' => ['required', 'integer'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
            'prix_unitaire' => ['nullable', 'numeric'],
            'prix_total' => ['nullable', 'numeric'],
            'commande_id' => ['required', 'string'],
            'ville_id' => ['required', 'string'],
            'ile_id' => ['required', 'string'],
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
