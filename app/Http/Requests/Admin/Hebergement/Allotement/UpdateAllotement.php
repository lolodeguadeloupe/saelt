<?php

namespace App\Http\Requests\Admin\Hebergement\Allotement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAllotement extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.allotement.edit', $this->allotement);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'titre' => ['sometimes', 'string'],
            'quantite' => ['sometimes', 'integer'],
            'date_depart' => ['sometimes', 'date', 'after_or_equal:now'],
            'date_arrive' => ['sometimes', 'date', 'after_or_equal:date_depart'],
            'heure_depart' => ['sometimes', 'string'],
            'heure_arrive' => ['sometimes', 'string'],
            'date_acquisition' => ['sometimes', 'date', 'before_or_equal:date_depart'],
            'date_limite' => ['nullable', 'date', 'after:date_acquisition'],
            'compagnie_transport_id' => ['sometimes', 'string'],
            'lieu_depart_id' => ['sometimes', 'string'],
            'lieu_arrive_id' => ['sometimes', 'string', Rule::notIn([$this->lieu_depart_id])],
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
