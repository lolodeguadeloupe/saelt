<?php

namespace App\Http\Requests\Admin\LocationVehicule\VehiculeLocation;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreVehiculeLocation extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.vehicule-location.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'titre' => ['nullable', 'string'],
            'immatriculation' => ['required',/* Rule::unique('vehicule_location', 'immatriculation'),*/ 'string'],
            'marque_vehicule_id' => ['required', 'string'],
            'modele_vehicule_id' => ['required', 'string'],
            'status' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'duration_min' => ['required', 'integer'],
            'prestataire_id' => ['required', 'string'],
            'categorie_vehicule_id' => ['required', 'string'],
            //
            'franchise'=> ['required','string'],
            'franchise_non_rachatable'=>['required','string'],
            'caution'=> ['required','string'],
            //
            'image' => ['nullable', 'array'],
            'image.*' => ['required', 'string'],
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
        if(isset($this->image)){
            foreach ($this->image as $value) {
                $images[] = RequestUploadImage::upload($value,'location-vehicule');
            }
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

        return $this->getInArray($sanitized, [
                    'titre',
                    'immatriculation',
                    'marque_vehicule_id',
                    'modele_vehicule_id',
                    'status',
                    'description',
                    'duration_min',
                    'prestataire_id',
                    'categorie_vehicule_id',
                    'franchise',
                    'franchise_non_rachatable',
                    'caution'
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
