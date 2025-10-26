<?php

namespace App\Http\Requests\Admin\Hebergement\HebergementVol;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateHebergementVol extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.hebergement-vol.edit', $this->hebergementVol);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        $min_nuit = $this->nombre_jour;
        return [
            'depart' => ['sometimes', 'date', 'after:now'],
            'arrive' => ['sometimes', 'date', 'after_or_equal:depart'],
            'nombre_jour' => ['sometimes', 'numeric', 'min:1'],
            'nombre_nuit' => ['sometimes', 'integer'],
            'heure_depart' => ['sometimes', 'string'],
            'heure_arrive' => ['sometimes', 'string'],
            'tarif_id' => ['sometimes', 'string'],
            'allotement_id' => ['sometimes', 'string'],
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
