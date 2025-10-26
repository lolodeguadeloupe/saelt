<?php

namespace App\Http\Requests\Admin\TransfertVoyage\TrajetTransfertVoyage;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTrajetTransfertVoyage extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.trajet-transfert-voyage.edit', $this->trajetTransfertVoyage);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'titre' => ['sometimes', 'string'],
            'point_depart' => ['sometimes', 'string',Rule::unique('trajet_transfert_voyage', 'point_depart')->where('point_arrive', $this->point_arrive)->ignore($this->trajetTransfertVoyage->getKey(), $this->trajetTransfertVoyage->getKeyName())],
            'point_arrive' => ['sometimes', 'string', Rule::notIn([$this->point_depart])],
            'description' => ['nullable', 'string'],
            'card' => ['nullable', 'string'],
        ];
    }
    
    public function getValidatorInstance() {
        $merge = [];
        if (isset($this->card)) {
            $merge['card'] = RequestUploadImage::upload($this->card, 'trajet-transfert');
        }
        $merge['titre'] = isset($this->titre) && $this->titre != '' ? $this->titre : $this->point_depart_titre . ' - ' . $this->point_arrive_titre;
        $this->merge($merge);
        return parent::getValidatorInstance();
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
