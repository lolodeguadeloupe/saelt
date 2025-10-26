<?php

namespace App\Http\Requests\Admin\Hebergement\TypeChambre;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTypeChambre extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.type-chambre.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('type_chambre')->where('name', $this->name)->where('hebergement_id', $this->hebergement_id)],
            'nombre_chambre' => ['required', 'integer'],
            'nombre_adulte_max' => ['nullable', 'integer'],
            'image' => ['nullable', 'array'],
            'image.*' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'hebergement_id' => ['required', 'string'],
            'capacite' => ['required', 'integer'],
            'status' => ['required', 'integer'],
            'formule'=>['nullable','integer'],
            'cout_supplementaire'=>['nullable','string'],
            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
        ];
    }

    public function getValidatorInstance()
    {
        $images = [];
        foreach ($this->image as $value) {
            $images[] = RequestUploadImage::upload($value, 'typeChambre');
        }
        $this->merge(['image' => $images]);
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

        return $this->getInArray($sanitized, ['name', 'description', 'capacite', 'nombre_chambre','nombre_adulte_max', 'hebergement_id', 'status','formule','cout_supplementaire']);
    }

    public function getMediaImage(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized, ['image']);
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
