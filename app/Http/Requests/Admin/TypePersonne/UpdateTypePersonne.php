<?php

namespace App\Http\Requests\Admin\TypePersonne;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTypePersonne extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.type-personne.edit', $this->typePersonne);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'type' => ['sometimes', 'string', Rule::unique('type_personne')->ignore($this->typePersonne->getKey(), $this->typePersonne->getKeyName())->where('type', $this->type)->where(function ($query) {
                if (isset($this->typePersonne->model)) {
                    $query->where('model', $this->typePersonne->model)
                        ->where('model_id', $this->typePersonne->model_id);
                } else {
                    $query->whereNull('model')
                        ->whereNull('model_id');
                }
            })],
            'age' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'original_id'=> ['nullable', 'string'],
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
