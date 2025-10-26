<?php

namespace App\Http\Requests\Admin\Excursion\Excursion;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreExcursion extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.excursion.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'title' => ['required', 'string', 'unique:excursions,title'],
            'availability' => ['required', 'string'],
            'heure_depart' => ['required', 'date_format:H:i'],
            'heure_arrive' => ['nullable', 'date_format:H:i'],
            'duration' => ['required', 'string'],
            'participant_min' => ['required', 'numeric'],
            'card' => ['nullable', 'string'],
            'lunch' => ['required', 'numeric'],
            'lunch_prestataire_id'=>['nullable','string'],
            'ticket' => ['required', 'numeric'],
            'ticket_billeterie_id'=>['nullable','string'],
            'status' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'ville_id' => ['nullable', 'string'],
            'adresse_depart' => ['nullable', 'string'],
            'adresse_arrive' => ['nullable', 'string',Rule::notIn([$this->adresse_depart])],
            'lieu_depart_id' => ['nullable', 'string'],
            'lieu_arrive_id' => ['nullable', 'string', Rule::notIn([$this->lieu_depart_id])],
            'prestataire_id' => ['required', 'string'],
            'image' => ['nullable', 'array'],
            'image.*' => ['required', 'string'],
            'taxes' => ['nullable', 'array'],
            'taxes.*' => ['required', 'string'],
            'ile_id' => ['required', 'string'],
            'fond_image' => ['nullable', 'string'],
            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getValidatorInstance() {

        $images = [];
        foreach ($this->image as $value) {
            $images[] = RequestUploadImage::upload($value,'excursion');
        }
        $_all_merge = ['image' => $images];
        if (isset($this->fond_image)) {
            $_all_merge['fond_image'] = RequestUploadImage::upload($this->fond_image,'excursion');
        }

        $this->merge($_all_merge);
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
                    'title', 'availability', 'duration', 'heure_depart','heure_arrive', 'lieu_depart_id', 'lieu_arrive_id',
                    'participant_min', 'card',
                    'lunch', 'ticket','lunch_prestataire_id','ticket_billeterie_id',
                    'status', 'description',
                    'ville_id', 'prestataire_id',
                    'taxes','ile_id','adresse_depart','adresse_arrive','fond_image'
        ]);
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
