<?php

namespace App\Http\Requests\Admin\Hebergement\SupplementVue;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateSupplementVue extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.supplement-vue.edit', $this->supplementVue);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'hebergement_id' => ['nullable', 'string'],
            'titre' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string'],
            'prestataire_id' => ['nullable', 'string'],
            'regle_tarif' => ['sometimes', 'string'],
            'prix_vente' => ['sometimes', 'string'],
            'prix_achat' => ['sometimes', 'string'],
            'marge' => ['sometimes', 'string'],
            'chambre' => ['nullable', 'array'],
            'chambre.*' => ['nullable', 'integer']

        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->icon)) {
            $_images['icon'] = RequestUploadImage::upload($this->icon, 'supplement');
        }
        $this->merge($_images);
        return parent::getValidatorInstance();
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
