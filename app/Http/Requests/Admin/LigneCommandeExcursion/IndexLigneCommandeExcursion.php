<?php

namespace App\Http\Requests\Admin\LigneCommandeExcursion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexLigneCommandeExcursion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-excursion.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,excursion_id,title,participant_min,lunch,ticket,adresse_arrive,adresse_depart,ville_id,ile_id,prestataire_id,lieu_depart_id,lieu_arrive_id,date_excursion,prix_unitaire,prix_total,commande_id|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
