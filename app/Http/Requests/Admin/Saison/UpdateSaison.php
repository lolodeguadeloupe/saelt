<?php

namespace App\Http\Requests\Admin\Saison;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateSaison extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.saison.edit', $this->saison);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'debut_format' => ['sometimes', 'string'],
            'fin_format' => ['sometimes', 'string'],
            'debut' => ['sometimes', 'date'],
            'fin' => ['sometimes', 'date'],
            'titre' => ['sometimes', 'string', Rule::unique('saisons')->ignore($this->saison->getKey(), $this->saison->getKeyName())->where(function ($query) {
                $query->where(['model' => $this->saison->model, 'model_id' => $this->saison->model_id, 'titre' => $this->titre]);
            })],
            'model_saison' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
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
