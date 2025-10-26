<?php

namespace App\Http\Requests\Admin\TransfertVoyage\TranchePersonneTransfertVoyage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyTranchePersonneTransfertVoyage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tranche-personne-transfert-voyage.delete', $this->tranchePersonneTransfertVoyage);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
