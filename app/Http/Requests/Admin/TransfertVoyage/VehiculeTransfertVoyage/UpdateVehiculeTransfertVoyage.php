<?php

namespace App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateVehiculeTransfertVoyage extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.vehicule-transfert-voyage.edit', $this->vehiculeTransfertVoyage);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['nullable', 'string'],
            'immatriculation' => ['sometimes'/*, Rule::unique('vehicule_location', 'immatriculation')->ignore($this->vehiculeLocation->getKey(), $this->vehiculeLocation->getKeyName())*/, 'string'],
            'marque_vehicule_id' => ['sometimes', 'string'],
            'modele_vehicule_id' => ['sometimes', 'string'],
            'status' => ['sometimes', 'integer'],
            'description' => ['nullable', 'string'],
            'duration_min' => ['sometimes', 'integer'],
            'prestataire_id' => ['sometimes', 'string'],
            'categorie_vehicule_id' => ['sometimes', 'string'],
            //
            'image' => ['nullable', 'array'],
            'image.*' => ['required', 'string'],
            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
            //type transfert
            'type_transfert_voyage_id' => ['required', 'string'],
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getValidatorInstance()
    {

        $images = [];
        if (isset($this->image)) {
            foreach ($this->image as $value) {
                $images[] = RequestUploadImage::upload($value, 'vehicule-transfert');
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
    public function getSanitized(): array
    {
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
        ]);
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

    public function getTypeTransfert(): array
    {

        $sanitized = $this->validated();
        return $this->getInArray($sanitized, ['type_transfert_voyage_id']);
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
