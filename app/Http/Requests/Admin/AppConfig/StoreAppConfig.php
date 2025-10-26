<?php

namespace App\Http\Requests\Admin\AppConfig;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAppConfig extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.app-config.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email', 'string'],
            'nom' => ['required', 'string'],
            'adresse' => ['nullable', 'string'],
            'site_web' => ['nullable', 'string'],
            'telephone' => ['nullable', 'regex:/^(\+?)((\d{3}|\d{2}|\d{1})?)(\s?)\d{2}(\s?)\d{2}(\s?)\d{3}(\s?)\d{2}/'],
            'ville_id' => ['nullable', 'string'],
            'logo' => ['nullable', 'string']

        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->logo)) {
            $_images['logo'] = RequestUploadImage::upload($this->logo,'app-config');
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
