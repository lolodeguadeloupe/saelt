<?php

namespace App\Http\Requests\Admin\LocationVehicule\LocationVehiculeSaison;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateLocationVehiculeSaison extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.location-vehicule-saison.edit', $this->locationVehiculeSaison);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'debut' => ['sometimes', 'date'],
            'fin' => ['sometimes', 'date', 'after_or_equal:debut'],
            'titre' => ['required', 'string', Rule::unique('saisons')->ignore($this->saison->getKey(), $this->saison->getKeyName())->where(function($query){
                $query->where(['model'=> VehiculeLocation::class,'titre'=> $this->titre])->whereNull('model_id'); //->ignore($this->user)
            })],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }

}
