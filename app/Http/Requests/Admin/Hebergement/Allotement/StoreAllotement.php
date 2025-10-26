<?php

namespace App\Http\Requests\Admin\Hebergement\Allotement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAllotement extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.allotement.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'titre' => ['required', 'string'],
            'quantite' => ['required', 'integer'],
            'date_depart' => ['required', 'date', 'after_or_equal:now'],
            'date_arrive' => ['required', 'date', 'after_or_equal:date_depart'],
            'heure_depart' => ['required', 'string'],
            'heure_arrive' => ['required', 'string'],
            'date_acquisition' => ['required', 'date', 'before_or_equal:date_depart'],
            'date_limite' => ['nullable', 'date', 'after:date_acquisition'],
            'compagnie_transport_id' => ['required', 'string'],
            'lieu_depart_id' => ['required', 'string'],
            'lieu_arrive_id' => ['required', 'string', Rule::notIn([$this->lieu_depart_id])],
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
