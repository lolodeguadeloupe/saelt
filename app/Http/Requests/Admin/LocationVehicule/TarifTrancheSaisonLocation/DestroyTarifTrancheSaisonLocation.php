<?php

namespace App\Http\Requests\Admin\LocationVehicule\TarifTrancheSaisonLocation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyTarifTrancheSaisonLocation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.tarif-tranche-saison-location.delete', $this->tarifTrancheSaisonLocation);
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
