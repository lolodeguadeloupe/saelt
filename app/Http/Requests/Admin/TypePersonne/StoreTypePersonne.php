<?php

namespace App\Http\Requests\Admin\TypePersonne;

use App\Models\Excursion\Excursion;
use App\Models\Hebergement\Hebergement;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTypePersonne extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.type-personne.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::unique('type_personne')->where('type', $this->type)->where(function ($query) {
                if (isset($this->heb)) {
                    $query->where('model', Hebergement::class)
                        ->where('model_id', $this->heb);
                } else if ($this->excursion) {
                    $query->where('model', Excursion::class)
                        ->where('model_id', $this->excursion);
                } else if ($this->transfert) {
                    $query->where('model', TypeTransfertVoyage::class)
                        ->where('model_id', $this->transfert);
                } else {
                    $query->whereNull('model')
                        ->whereNull('model_id');
                }
            })],
            'age' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'original_id' => ['nullable', 'string'],
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
