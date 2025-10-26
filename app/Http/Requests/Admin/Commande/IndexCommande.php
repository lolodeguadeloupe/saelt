<?php

namespace App\Http\Requests\Admin\Commande;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexCommande extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.commande.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,commande.id,mode_payement.titre,commande.date,commande.status,commande.prix,commande.tva,commande.prix_total,facturation_commande.nom,facturation_commande.prenom,facturation_commande.adresse,facturation_commande.ville,facturation_commande.code_postal|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
