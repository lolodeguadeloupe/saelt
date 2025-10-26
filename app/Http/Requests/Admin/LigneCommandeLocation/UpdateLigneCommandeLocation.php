<?php

namespace App\Http\Requests\Admin\LigneCommandeLocation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateLigneCommandeLocation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-location.edit', $this->ligneCommandeLocation);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'location_id' => ['sometimes', 'string'],
            'titre' => ['nullable', 'string'],
            'immatriculation' => ['sometimes', 'string'],
            'duration_min' => ['sometimes', 'integer'],
            'franchise' => ['nullable', 'numeric'],
            'franchise_non_rachatable' => ['nullable', 'numeric'],
            'caution' => ['nullable', 'numeric'],
            'marque_vehicule_id' => ['sometimes', 'string'],
            'marque_vehicule_titre' => ['sometimes', 'string'],
            'modele_vehicule_id' => ['sometimes', 'string'],
            'modele_vehicule_titre' => ['sometimes', 'string'],
            'categorie_vehicule_id' => ['sometimes', 'string'],
            'categorie_vehicule_titre' => ['sometimes', 'string'],
            'famille_vehicule_id' => ['sometimes', 'string'],
            'famille_vehicule_titre' => ['sometimes', 'string'],
            'prestataire_id' => ['nullable', 'string'],
            'agence_recuperation_name' => ['sometimes', 'string'],
            'agence_recuperation_id' => ['sometimes', 'string'],
            'agence_restriction_name' => ['sometimes', 'string'],
            'agence_restriction_id' => ['sometimes', 'string'],
            'date_recuperation' => ['sometimes', 'date'],
            'date_restriction' => ['sometimes', 'date'],
            'heure_recuperation' => ['sometimes', 'string'],
            'heure_restriction' => ['sometimes', 'string'],
            'nom_conducteur' => ['sometimes', 'string'],
            'prenom_conducteur' => ['sometimes', 'string'],
            'adresse_conducteur' => ['sometimes', 'string'],
            'ville_conducteur' => ['sometimes', 'string'],
            'code_postal_conducteur' => ['sometimes', 'string'],
            'telephone_conducteur' => ['sometimes', 'string'],
            'email_conducteur' => ['sometimes', 'string'],
            'date_naissance_conducteur' => ['sometimes', 'string'],
            'lieu_naissance_conducteur' => ['sometimes', 'string'],
            'num_permis_conducteur' => ['sometimes', 'string'],
            'date_permis_conducteur' => ['sometimes', 'string'],
            'lieu_deliv_permis_conducteur' => ['sometimes', 'string'],
            'num_identite_conducteur' => ['sometimes', 'string'],
            'date_emis_identite_conducteur' => ['sometimes', 'string'],
            'lieu_deliv_identite_conducteur' => ['sometimes', 'string'],
            'order_comments' => ['sometimes', 'string'],
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
