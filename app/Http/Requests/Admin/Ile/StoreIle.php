<?php

namespace App\Http\Requests\Admin\Ile;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreIle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.ile.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'card' => ['nullable', 'string'],
            'background_image' => ['nullable', 'string'],
            'pays_id' => ['required', 'string'],
        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->card)) {
            $_images['card'] = RequestUploadImage::upload($this->card,'ile');
        }
        if (isset($this->background_image)) {
            $_images['background_image'] = RequestUploadImage::upload($this->background_image,'ile');
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
