<?php

namespace App\Http\Requests\Admin\Prestataire;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePrestataire extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.prestataire.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'name' => ['required', 'string', 'unique:prestataire,name'],
            'adresse' => ['required', 'string'],
            'phone' => ['nullable', 'regex:/^[+0-9\s]*$/'],
            'email' => ['nullable', 'email', 'string'],
            'second_email' => ['nullable', 'email', 'string'],
            'ville_id' => ['required', 'string'],
            'logo' => ['nullable', 'string'],
            'heure_ouverture' => ['nullable', 'date_format:H:i'],
            'heure_fermeture' => ['nullable', 'date_format:H:i'],
            
        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->logo)) {
            $_images['logo'] = RequestUploadImage::upload($this->logo,'prestataire');
        }
        $this->merge($_images);
        return parent::getValidatorInstance();
    }
    
    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }

}
