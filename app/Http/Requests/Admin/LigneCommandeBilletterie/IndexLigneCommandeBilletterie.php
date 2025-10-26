<?php

namespace App\Http\Requests\Admin\LigneCommandeBilletterie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexLigneCommandeBilletterie extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-billetterie.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,titre,date_depart,date_retour,quantite,compagnie_transport_id,compagnie_transport_name,lieu_depart_id,lieu_depart_name,lieu_arrive_id,lieu_arrive_name,parcours,heure_aller,heure_retour,prix_unitaire,prix_total,commande_id|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
