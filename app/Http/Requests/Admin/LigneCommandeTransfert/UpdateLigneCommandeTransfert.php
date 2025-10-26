<?php

namespace App\Http\Requests\Admin\LigneCommandeTransfert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateLigneCommandeTransfert extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ligne-commande-transfert.edit', $this->ligneCommandeTransfert);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['sometimes', 'string'],
            'date_depart' => ['nullable', 'date'],
            'date_retour' => ['nullable', 'date'],
            'image' => ['nullable', 'string'],
            'quantite' => ['sometimes', 'integer'],
            'lieu_depart_id' => ['sometimes', 'string'],
            'lieu_depart_name' => ['sometimes', 'string'],
            'lieu_arrive_id' => ['sometimes', 'string'],
            'lieu_arrive_name' => ['sometimes', 'string'],
            'parcours' => ['sometimes', 'integer'],
            'heure_depart' => ['nullable', 'string'],
            'heure_retour' => ['nullable', 'string'],
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
