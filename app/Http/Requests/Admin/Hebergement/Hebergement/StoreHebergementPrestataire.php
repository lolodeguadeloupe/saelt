<?php

namespace App\Http\Requests\Admin\Hebergement\Hebergement;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreHebergementPrestataire extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.hebergement.create-prestataire');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'heb.name' => ['required', 'string', 'unique:hebergements,name'],
            'heb.image' => ['nullable', 'array'],
            //'heb.duration_min' => ['required','integer'],
            'heb.image.*' => ['required', 'string'],
            'heb.adresse' => ['required', 'string'],
            'heb.ville_id' => ['required', 'string'],
            'heb.description' => ['nullable', 'string'],
            'heb.type_hebergement_id' => ['required', 'integer'],
            'heb.prestataire_id' => ['nullable', 'string'],
            'heb.status' => ['required', 'integer'],
            'beh.taxes' => ['nullable', 'array'],
            'heb.taxes.*' => ['required', 'string'],
            'heb.caution' => ['nullable', 'string'],
            'heb.ile_id' => ['required', 'string'],
            'heb.etoil' => ['nullable', 'integer'],
            'heb.fond_image' => ['nullable', 'string'],
            //prestataire
            'prest.name' => ['required', 'string'],
            'prest.adresse' => ['required', 'string'],
            'prest.phone' => ['nullable', 'regex:/^[+0-9\s]*$/'],
            'prest.email' => ['nullable', 'email', 'string'],
            'prest.second_email' => ['nullable', 'email', 'string'],
            'prest.ville_id' => ['required', 'string'],
            'prest.logo' => ['nullable', 'string'],
            'prest.heure_ouverture' => ['nullable', 'date_format:H:i'],
            'prest.heure_fermeture' => ['nullable', 'date_format:H:i'],

            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
        ];
    }

    public function getValidatorInstance()
    {
        $_images_prest = [];
        $_images_heb = [];
        $images = [];
        foreach ($this->heb['image'] as $value) {
            $images[] = RequestUploadImage::upload($value, 'hebergement');
        }
        $_images_heb['image'] = $images;
        if (isset($this->heb['fond_image'])) {
            $_images_heb['fond_image'] = RequestUploadImage::upload($this->heb['fond_image'], 'hebergement');
        }
        if (isset($this->prest['logo'])) {
            $_images_prest['logo'] = RequestUploadImage::upload($this->prest['logo'], 'prestataire');
        }
        $heb = $this->heb;
        $prest = $this->prest;
        $this->merge(['heb' => collect($heb)->merge($_images_heb), 'prest' => collect($prest)->merge($_images_prest)]);
        return parent::getValidatorInstance();
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitizedHebergement(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized['heb'], ['name'/*,'duration_min'*/, 'adresse', 'ville_id', 'description', 'type_hebergement_id', 'prestataire_id', 'status', 'taxes', 'caution', 'ile_id', 'etoil', 'fond_image']);
    }

    public function getSanitizedPrestataire(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized['prest'], ['name', 'adresse', 'phone', 'email','second_email', 'ville_id', 'logo', 'heure_ouverture', 'heure_fermeture']);
    }

    public function getMediaImage(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized['heb'], ['image']);
    }

    public function getCalendar(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized, ['calendar']);
    }

    private function getInArray($array = [], $key = [])
    {
        $new_array = [];
        for ($index = 0; $index < count($key); $index++) {
            if (isset($array[$key[$index]])) {
                $new_array[$key[$index]] = $array[$key[$index]];
            } else if ($key[$index] != '') {
                $new_array[$key[$index]] = null;
            }
        }
        return $new_array;
    }
}
