<?php

namespace App\Http\Requests\Admin\Hebergement\SupplementPension;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateSupplementPension extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.supplement-pension.edit', $this->supplementPension);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'hebergement_id'=>['sometimes','string'],
            'titre' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'regle_tarif' => ['sometimes', 'string'],
            'icon' => ['nullable', 'string'],
            'prestataire_id'=>['nullable','string'],
            //
            'type_personne_id' => ['nullable', 'array'],
            'type_personne_id.*' => ['required', 'string'],
            //
            'prix_vente' => ['nullable', 'array'],
            'prix_achat' => ['nullable', 'array'],
            'marge' => ['nullable', 'array'],
            //
            'prix_vente.*' => ['required', 'string'],
            'prix_achat.*' => ['required', 'string'],
            'marge.*' => ['required', 'string'],
            
        ];
    }

    public function getValidatorInstance() {

        $isTrue = true;
        $i = 0;
        $array_type_personnne_id = [];
        $array_prix_achat = [];
        $array_prix_vente = [];
        $array_marge = [];

        while ($isTrue) {

            if (!isset($this->{'type_personne_id_' . $i})) {
                $isTrue = false;
            } else {
                $array_type_personnne_id[] = $this->{'type_personne_id_' . $i};
                $array_marge[] = $this->{'marge_' . $i};
                $array_prix_achat[] = $this->{'prix_achat_' . $i};
                $array_prix_vente[] = $this->{'prix_vente_' . $i};
            }

            $i++;
        }
        $all_merge = [
            'type_personne_id' => $array_type_personnne_id,
            'prix_achat' => $array_prix_achat,
            'prix_vente' => $array_prix_vente,
            'marge' => $array_marge
        ];

        if (isset($this->icon)) {
            $all_merge['icon'] = RequestUploadImage::upload($this->icon, 'supplement');
        }

        $this->merge($all_merge);
        return parent::getValidatorInstance();
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
