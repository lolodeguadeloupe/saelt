<?php

namespace App\Http\Requests\Admin\LigneCommandeChambre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexLigneCommandeChambre extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-chambre.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,hebergement_id,hebergement_name,hebergement_type,hebergement_duration_min,hebergement_caution,hebergement_etoil,chambre_id,chambre_name,chambre_capacite,chambre_base_type_titre,chambre_base_type_nombre,quantite_chambre,date_debut,date_fin,prix_unitaire,prix_total,commande_id,ville_id,ile_id,prestataire_id|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
