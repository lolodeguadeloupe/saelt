<?php

namespace App\Http\Requests\Admin\LocationVehicule\TrancheSaison;

use App\Models\LocationVehicule\VehiculeLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTrancheSaison extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tranche-saison.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['required', 'string'/*, Rule::unique('tranche_saison')->where(function ($query) {
                $query->where(['model' => VehiculeLocation::class, 'model_id' => $this->location, 'titre' => $this->titre]);
            })*/],
            'nombre_min' => ['required', 'integer'],
            'nombre_max' => ['required', 'integer'],
        ];
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
