<?php

namespace App\Http\Requests\Admin\CompagnieTransport;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCompagnieTransport extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.compagnie-transport.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'nom' => ['required', 'string'],
            'email' => ['nullable', 'email', 'string'],
            'phone' => ['nullable', 'string'],
            'adresse' => ['required', 'string'],
            'type_transport' => ['required', 'string'],
            'ville_id' => ['required', 'string'],
            'logo' => ['nullable', 'string'],
            'heure_ouverture' => ['nullable'],
            'heure_fermeture' => ['nullable'],
        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->logo)) {
            $_images['logo'] = RequestUploadImage::upload($this->logo,'compagnie-transport');
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
