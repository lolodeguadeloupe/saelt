<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutFacturationCommande extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'billeterie' => ['nullable', 'array'],
            'client_info' => ['required', 'array'],
            'excursion' => ['nullable', 'array'],
            'hebergement' => ['nullable', 'array'],
            'location' => ['nullable', 'array'],
            'payement_mode' => ['nullable'],
            'tarifTotal' => ['required'],
            'tarifTotalTaxe' => ['nullable'],
            'taxe_tva' => ['nullable'],
            'transfert' => ['nullable', 'array'],
            /** */
            'client_info.email'=>['required','email'/*,'email:rfc,dns'*/]
        ];
    }
}
