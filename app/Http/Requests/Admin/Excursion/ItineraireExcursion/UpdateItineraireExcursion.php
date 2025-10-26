<?php

namespace App\Http\Requests\Admin\Excursion\ItineraireExcursion;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateItineraireExcursion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.itineraire-excursion.edit', $this->itineraireExcursion);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'rang' => ['sometimes', 'integer'],
            'excursion_id' => ['sometimes', 'string'],
            'titre' => ['sometimes', 'string'],
            'image' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->image)) {
            $_images['image'] = RequestUploadImage::upload($this->image, 'itineraire');
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
