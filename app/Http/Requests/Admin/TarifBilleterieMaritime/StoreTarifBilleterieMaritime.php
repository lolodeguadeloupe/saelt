<?php

namespace App\Http\Requests\Admin\TarifBilleterieMaritime;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTarifBilleterieMaritime extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-billeterie-maritime.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'billeterie_maritime_id' => ['required', 'string'],
            'type_personne_id' => ['required', 'string'],
            'marge_aller' => ['required', 'string'],
            'marge_aller_retour' => ['required', 'string'],
            'prix_achat_aller' => ['required', 'string'],
            'prix_achat_aller_retour' => ['required', 'string'],
            'prix_vente_aller' => ['required', 'string'],
            'prix_vente_aller_retour' => ['required', 'string'],
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
