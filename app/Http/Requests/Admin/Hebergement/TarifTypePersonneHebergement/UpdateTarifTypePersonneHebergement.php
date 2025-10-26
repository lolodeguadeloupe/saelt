<?php

namespace App\Http\Requests\Admin\Hebergement\TarifTypePersonneHebergement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTarifTypePersonneHebergement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-type-personne-hebergement.edit', $this->tarifTypePersonneHebergement);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'prix_achat' => ['sometimes', 'string'],
            'marge' => ['sometimes', 'numeric'],
            'prix_vente' => ['sometimes', 'string'],
            'type_personne_id' => ['sometimes', 'string'],
            'tarif_id' => ['sometimes', 'string'],
            
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
