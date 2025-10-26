<?php

namespace App\Http\Requests\Admin\BilleterieMaritime;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreBilleterieMaritime extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.billeterie-maritime.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    /*
     * 'titre',
      'lieu_depart',
      'lieu_arrive',
      'date_depart',
      'date_arrive',
      'iamge',
     */
    public function rules(): array
    {
        return [
            'parcours' => ['required', 'string'],
            'availability' => ['nullable', 'string'],
            'titre' => ['required', 'string', 'unique:billeterie_maritime,titre'],
            'lieu_depart_id' => ['required', 'string'],
            'lieu_arrive_id' => ['required', 'string', Rule::notIn([$this->lieu_depart_id])],
            'date_depart' => ['nullable', 'date', 'after_or_equal:now'],
            'date_arrive' => ['nullable', 'date', 'after_or_equal:now'],
            'date_acquisition' => ['required', 'date', 'before:now'],
            'date_limite' => ['nullable', 'date', 'after:date_acquisition'],
            'image' => ['nullable', 'string'],
            'quantite' => ['required', 'integer'],
            'compagnie_transport_id' => ['required', 'string'],
            'type_personne_original_id' => ['required', 'array'],
            'type_personne_type' => ['required', 'array'],
            'type_personne_age' => ['required', 'array'],
            'type_personne_description' => ['required', 'array'],
            'type_personne_reference_prix' => ['required', 'array'],
            'type_personne_id' => ['required', 'array'],
            'type_personne_type.*' => ['required', 'string'],
            'type_personne_age.*' => ['required', 'string'],
            'type_personne_description.*' => ['nullable', 'string'],
            'type_personne_reference_prix.*' => ['required', 'string'],
            'type_personne_id.*' => ['required', 'integer'],
            'type_personne_original_id.*' => ['required', 'integer'],
            //
            'prix_vente_aller' => ['required', 'array'],
            'prix_achat_aller' => ['required', 'array'],
            'marge_aller' => ['required', 'array'],
            'prix_vente_aller_retour' => ['nullable', 'array'],
            'prix_achat_aller_retour' => ['nullable', 'array'],
            'marge_aller_retour' => ['nullable', 'array'],
            //
            'prix_vente_aller.*' => ['required', 'string'],
            'prix_achat_aller.*' => ['required', 'string'],
            'marge_aller.*' => ['required', 'string'],
            'prix_vente_aller_retour.*' => ['required', 'string'],
            'prix_achat_aller_retour.*' => ['required', 'string'],
            'marge_aller_retour.*' => ['required', 'string'],
            //
            'debut' => ['nullable', 'date_format:H:i'],
            'fin' => ['nullable', 'date_format:H:i'],
            'duree_trajet' => ['nullable', 'string'],
        ];
    }

    public function getValidatorInstance()
    {

        $isTrue = true;
        $i = 0;
        $array_type_personne_original_id = [];
        $array_type_personnne_type = [];
        $array_type_personnne_age = [];
        $array_type_personnne_description = [];
        $array_type_personnne_reference_prix = [];
        $array_type_personnne_id = [];
        $array_prix_achat_aller = [];
        $array_prix_achat_aller_retour = [];
        $array_prix_vente_aller = [];
        $array_prix_vente_aller_retour = [];
        $array_marge_aller = [];
        $array_marge_aller_retour = [];

        while ($isTrue) {

            if (!isset($this->{'type_personne_type_' . $i})) { 
                $isTrue = false;
            } else {
                $array_type_personnne_type[] = $this->{'type_personne_type_' . $i};
                $array_type_personne_original_id[] = $this->{'type_personne_original_id_' . $i};
                $array_type_personnne_age[] = $this->{'type_personne_age_' . $i};
                $array_type_personnne_description[] = isset($this->{'type_personne_description_' . $i}) ? $this->{'type_personne_description_' . $i} : null;
                $array_type_personnne_reference_prix[] = $this->{'type_personne_reference_prix_' . $i};
                $array_type_personnne_id[] = $this->{'type_personne_id_' . $i};
                $array_marge_aller[] = $this->{'marge_aller_' . $i};
                $array_prix_achat_aller[] = $this->{'prix_achat_aller_' . $i};
                $array_prix_vente_aller[] = $this->{'prix_vente_aller_' . $i};
                if ($this->parcours == 2) {
                    $array_marge_aller_retour[] = $this->{'marge_aller_retour_' . $i};
                    $array_prix_achat_aller_retour[] = $this->{'prix_achat_aller_retour_' . $i};
                    $array_prix_vente_aller_retour[] = $this->{'prix_vente_aller_retour_' . $i};
                }
            }

            $i++;
        }

        $_all_merge = [
            'type_personne_original_id'=> $array_type_personne_original_id,
            'type_personne_type' => $array_type_personnne_type,
            'type_personne_age' => $array_type_personnne_age,
            'type_personne_description' => $array_type_personnne_description,
            'type_personne_reference_prix' => $array_type_personnne_reference_prix,
            'type_personne_id' => $array_type_personnne_id,
            'prix_achat_aller' => $array_prix_achat_aller,
            'prix_achat_aller_retour' => count($array_prix_achat_aller_retour) ? $array_prix_achat_aller_retour : null,
            'prix_vente_aller' => $array_prix_vente_aller,
            'prix_vente_aller_retour' => count($array_prix_vente_aller_retour) ? $array_prix_vente_aller_retour : null,
            'marge_aller' => $array_marge_aller,
            'marge_aller_retour' => count($array_marge_aller_retour) ? $array_marge_aller_retour : null
        ];

        if (isset($this->image)) {
            $_all_merge['image'] = RequestUploadImage::upload($this->image, 'billeterie');
        }
        $this->merge($_all_merge);
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
