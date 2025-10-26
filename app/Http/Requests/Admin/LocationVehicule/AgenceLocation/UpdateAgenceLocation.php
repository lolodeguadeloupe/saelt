<?php

namespace App\Http\Requests\Admin\LocationVehicule\AgenceLocation;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAgenceLocation extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.agence-location.edit', $this->agenceLocation);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code_agence' => ['nullable', 'string'],
            'name' => ['sometimes', 'string', Rule::unique('agence_location', 'name')->ignore($this->agenceLocation->getKey(), $this->agenceLocation->getKeyName())],
            'adresse' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'string'],
            'logo' => ['nullable', 'string'],
            'ville_id' => ['sometimes', 'string'],
            'heure_ouverture' => ['nullable', 'date_format:H:i'],
            'heure_fermeture' => ['nullable', 'date_format:H:i'],
            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
        ];
    }

    public function getValidatorInstance()
    {
        $_merge = [];
        if (isset($this->logo)) {
            $_merge['logo'] = RequestUploadImage::upload($this->logo,'agent-location');
        }
        if (!isset($this->code_agence)) {
            $_merge['code_agence'] = '';
        }
        $this->merge($_merge);
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

        return $this->getInArray($sanitized, [
            'code_agence',
            'name',
            'adresse',
            'phone',
            'email',
            'logo',
            'heure_ouverture',
            'heure_fermeture',
            'ville_id'
        ]);
    }

    public function getCalendar(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized, ['calendar']);
    }

    private function getInArray($array = [], $key = [])
    {
        $new_array = [];
        for ($index = 0; $index < count($key); $index++) {
            if (isset($array[$key[$index]])) {
                $new_array[$key[$index]] = $array[$key[$index]];
            }
        }
        return $new_array;
    }
}
