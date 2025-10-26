<?php

namespace App\Http\Requests\Admin\Hebergement\HebergementMarqueBlanche;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateHebergementMarqueBlanche extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.hebergement-marque-blanche.edit', $this->hebergementMarqueBlanche);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'liens' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'array'],
            'image.*' => ['required', 'string'],
            'type_hebergement_id' => ['sometimes', 'string'],
        ];
    }

    public function getValidatorInstance() {
        $images = [];
        foreach ($this->image as $value) {
            $images[] = RequestUploadImage::upload($value,'hebergement-marque');
        }
        $this->merge(['image' => $images]);
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

        return $this->getInArray($sanitized, ['liens', 'description', 'type_hebergement_id']);
    }

    public function getMediaImage(): array {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized, ['image']);
    }

    private function getInArray($array = [], $key = []) {
        $new_array = [];
        for ($index = 0; $index < count($key); $index++) {
            if (isset($array[$key[$index]])) {
                $new_array[$key[$index]] = $array[$key[$index]];
            }
        }
        return $new_array;
    }

}
