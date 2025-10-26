<?php

namespace App\Http\Requests\Admin\Excursion\ItineraireExcursion;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreItineraireExcursion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.itineraire-excursion.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'rang' => ['nullable', 'integer'],
            'excursion_id' => ['required', 'string'],
            'titre' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->image)) {
            $_images['image'] = RequestUploadImage::upload($this->image,'itineraire');
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
