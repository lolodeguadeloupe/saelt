<?php

namespace App\Http\Requests\Admin\Taxe;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTaxe extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.taxe.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', Rule::unique('taxe')->where(function ($query) {
                $query->where(DB::raw('lower(titre)'), '=', strtolower($this->titre))
                ->orWhere(function($query){
                    $query->where('sigle','!=','autres')
                    ->where('sigle',$this->sigle);
                });
            })],
            'sigle' => ['required', 'string'],
            'valeur_pourcent' => ['required', 'numeric'],
            'valeur_devises' => ['required', 'numeric'],
            'descciption' => ['nullable', 'string'],
            'taxe_appliquer' => ['required', 'string'],
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
