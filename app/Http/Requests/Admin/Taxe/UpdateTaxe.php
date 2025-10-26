<?php

namespace App\Http\Requests\Admin\Taxe;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTaxe extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.taxe.edit', $this->taxe);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['sometimes', 'string', Rule::unique('taxe')->ignore($this->taxe->getKey(), $this->taxe->getKeyName())->where(function ($query) {
                $query->where(DB::raw('lower(titre)'), '=', strtolower($this->titre))
                    ->orWhere(function ($query) {
                        $query->where('sigle', '!=', 'autres')
                            ->where('sigle', $this->sigle);
                    });
            })],
            'sigle' => ['sometimes', 'string'],
            'valeur_pourcent' => ['sometimes', 'numeric'],
            'valeur_devises' => ['sometimes', 'numeric'],
            'descciption' => ['nullable', 'string'],
            'taxe_appliquer' => ['sometimes', 'string'],
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
