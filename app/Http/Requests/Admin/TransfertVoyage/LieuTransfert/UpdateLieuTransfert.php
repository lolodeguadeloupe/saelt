<?php

namespace App\Http\Requests\Admin\TransfertVoyage\LieuTransfert;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateLieuTransfert extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.lieu-transfert.edit', $this->lieuTransfert);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'titre' => ['sometimes', 'string', Rule::unique('lieu_transfert')->ignore($this->lieuTransfert->getKey(), $this->lieuTransfert->getKeyName())->where(function($query) {
                            $query->where(['titre' => $this->titre, 'ville_id' => $this->ville_id]);
                        })],
            'adresse' => ['nullable', 'string'],
            'ville_id' => ['nullable', 'string'],
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
