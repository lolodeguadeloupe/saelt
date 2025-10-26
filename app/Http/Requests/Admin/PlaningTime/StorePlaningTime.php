<?php

namespace App\Http\Requests\Admin\PlaningTime;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePlaningTime extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.planing-time.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_model' => ['required', 'string'],
            'debut' => [isset($this->fin) ? 'nullable' : 'required', 'string', Rule::unique('planing_time')->where(function ($query) {
                $query->where(['debut' => $this->debut, 'id_model' => $this->id_model]);
            })],
            'fin' => [isset($this->debut) ? 'nullable' : 'required', 'string'],
            'availability' => ['nullable', 'string']

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
