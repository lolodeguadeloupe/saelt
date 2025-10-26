<?php

namespace App\Http\Requests\Admin\Hebergement\Hebergement;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateHebergement extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.hebergement.edit', $this->hebergement);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'name' => ['sometimes', 'string'],
            /* 'duration_min'=> ['sometimes','integer'], */
            'image' => ['nullable', 'array'],
            'image.*' => ['required', 'string'],
            'adresse' => ['sometimes', 'string'],
            'ville_id' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'type_hebergement_id' => ['sometimes', 'integer'],
            'prestataire_id' => ['sometimes', 'string'],
            'status' => ['sometimes', 'integer'],
            'heure_ouverture' => ['nullable', 'string'],
            'heure_fermeture' => ['nullable', 'string'],
            'taxes' => ['nullable', 'array'],
            'taxes.*' => ['required', 'string'],
            'caution' => ['nullable', 'string'],
            'ile_id' => ['required', 'string'],
            'etoil' => ['nullable', 'integer'],
            'fond_image'=>['nullable','string'],
            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
        ];
    }

    public function getValidatorInstance()
    {
        $_images = [];
        $images = [];
        foreach ($this->image as $value) {
            $images[] = RequestUploadImage::upload($value, 'hebergement');
        }
        $_images['image'] = $images;
        if (isset($this->fond_image)) {
            $_images['fond_image'] = RequestUploadImage::upload($this->fond_image, 'hebergement');
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

        return $this->getInArray($sanitized, ['name', /* 'duration_min', */ 'adresse', 'ville_id', 'description', 'type_hebergement_id', 'prestataire_id', 'status', 'heure_ouverture', 'heure_fermeture', 'taxes', 'caution','ile_id','etoil','fond_image']);
    }

    public function getMediaImage(): array {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized, ['image']);
    }

    public function getCalendar(): array {
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
            }else if($key[$index] != ''){
                $new_array[$key[$index]] = null;
            }
        }
        return $new_array;
    }

}
