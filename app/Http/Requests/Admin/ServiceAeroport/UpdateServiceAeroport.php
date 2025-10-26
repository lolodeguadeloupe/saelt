<?php

namespace App\Http\Requests\Admin\ServiceAeroport;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateServiceAeroport extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.service-aeroport.edit', $this->serviceAeroport);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'code_service' => ['nullable', Rule::unique('service_aeroport', 'code_service')->ignore($this->serviceAeroport->getKey(), $this->serviceAeroport->getKeyName()), 'string'],
            'name' => ['sometimes', 'string'],
            'adresse' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'string'],
            'logo' => ['nullable', 'string'],
            'ville_id' => ['sometimes', 'string'],
            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        if (isset($this->logo)) {
            $_images['logo'] = RequestUploadImage::upload($this->logo,'service-aeroport');
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

        return $this->getInArray($sanitized, [
                    'code_service',
                    'name',
                    'adresse',
                    'phone',
                    'email',
                    'logo',
                    'ville_id']);
    }

    public function getCalendar(): array {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized, ['calendar']);
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
