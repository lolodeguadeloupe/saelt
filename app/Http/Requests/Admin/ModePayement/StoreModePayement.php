<?php

namespace App\Http\Requests\Admin\ModePayement;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreModePayement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.mode-payement.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', Rule::unique('mode_payement')->where(function ($query) {
                $query->where(DB::raw('lower(titre)'), '=', strtolower($this->titre));
            })],
            'key_test'=>['nullable','string'],
            'key_prod'=>['nullable','string'],
            'base_url_test'=>['required','string'],
            'base_url_prod'=>['required','string'],
            'api_version'=>['nullable','string'],
            'mode'=>['required','string'],
            'icon' => ['nullable', 'string']

        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->icon)) {
            $_images['icon'] = RequestUploadImage::upload($this->icon,'mode-payement');
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
