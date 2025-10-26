<?php

namespace App\Http\Requests\Admin\TarifBilleterieMaritime;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexTarifBilleterieMaritime extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-billeterie-maritime.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,billeterie_maritime_id,type_personne_id,marge_aller,marge_aller_retour,prix_achat_aller,prix_achat_aller_retour,prix_vente_aller,prix_vente_aller_retour|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
