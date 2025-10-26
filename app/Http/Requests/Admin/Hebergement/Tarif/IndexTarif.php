<?php

namespace App\Http\Requests\Admin\Hebergement\Tarif;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexTarif extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif.index') || Gate::allows('admin.tarif.detail');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,marge,marge_appliquer,prix_vente,montant,description,type_personne.type,saisons.titre,allotements.titre,compagnie_transport.nom,hebergememnt_vol.lien_depart,hebergement_vo.lien_arrive,hebergement_vol.depart,hebergement_vol.arrive,type_chambre.name,base_type.titre|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
