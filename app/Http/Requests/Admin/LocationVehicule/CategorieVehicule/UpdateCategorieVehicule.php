<?php

namespace App\Http\Requests\Admin\LocationVehicule\CategorieVehicule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCategorieVehicule extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.categorie-vehicule.edit', $this->categorieVehicule);
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
            'description' => ['nullable', 'string'],
            'famille_vehicule_id' => ['sometimes', 'string'],
            'franchise'=> ['sometimes','string'],
            'franchise_non_rachatable'=>['sometimes','string'],
            'caution'=> ['sometimes','string'],
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
