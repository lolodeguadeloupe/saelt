<?php

namespace App\Http\Requests\Admin\LigneCommandeLocation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexLigneCommandeLocation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-location.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,location_id,titre,immatriculation,duration_min,franchise,franchise_non_rachatable,caution,marque_vehicule_id,marque_vehicule_titre,modele_vehicule_id,modele_vehicule_titre,categorie_vehicule_id,categorie_vehicule_titre,famille_vehicule_id,famille_vehicule_titre,prestataire_id,agence_recuperation_name,agence_recuperation_id,agence_restriction_name,agence_restriction_id,date_recuperation,date_restriction,heure_recuperation,heure_restriction,nom_conducteur,prenom_conducteur,adresse_conducteur,ville_conducteur,code_postal_conducteur,telephone_conducteur,email_conducteur,date_naissance_conducteur,lieu_naissance_conducteur,num_permis_conducteur,date_permis_conducteur,lieu_deliv_permis_conducteur,num_identite_conducteur,date_emis_identite_conducteur,lieu_deliv_identite_conducteur,order_comments,prix_unitaire,prix_total,commande_id|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
