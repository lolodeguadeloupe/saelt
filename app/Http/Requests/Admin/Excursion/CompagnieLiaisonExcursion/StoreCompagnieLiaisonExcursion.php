<?php

namespace App\Http\Requests\Admin\Excursion\CompagnieLiaisonExcursion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCompagnieLiaisonExcursion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.compagnie-liaison-excursion.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'excursion_id' => ['required', 'string'],
            'compagnie_id' => ['nullable', 'array'],
            'compagnie_id.*' => ['required', 'string'],
            'lieu_depart_id' => ['required', 'string'],
            'lieu_arrive_id' => ['required', 'string', Rule::notIn([$this->lieu_depart_id])],
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
