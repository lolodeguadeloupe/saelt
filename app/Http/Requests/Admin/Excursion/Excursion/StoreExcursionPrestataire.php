<?php

namespace App\Http\Requests\Admin\Excursion\Excursion;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreExcursionPrestataire extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.excursion.create-prestataire');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'excursion.title' => ['required', 'string', 'unique:excursions,title'],
            'excursion.availability' => ['required', 'string'],
            'excursion.heure_depart' => ['required', 'date_format:H:i'],
            'excursion.heure_arrive' => ['nullable', 'date_format:H:i'],
            'excursion.duration' => ['required', 'string'],
            'excursion.participant_min' => ['required', 'numeric'],
            'excursion.card' => ['nullable', 'string'],
            'excursion.lunch' => ['required', 'numeric'],
            'excursion.lunch_prestataire_id'=>['nullable','string'],
            'excursion.ticket' => ['required', 'numeric'],
            'excursion.ticket_billeterie_id'=>['nullable','string'],
            'excursion.status' => ['required', 'numeric'],
            'excursion.description' => ['nullable', 'string'],
            'excursion.ville_id' => ['nullable', 'string'],
            'excursion.adresse_depart' => ['nullable', 'string'],
            'excursion.adresse_arrive' => ['nullable', 'string', Rule::notIn([$this->excursion['adresse_depart']])],
            'excursion.lieu_depart_id' => ['nullable', 'string'],
            'excursion.lieu_arrive_id' => ['nullable', 'string', Rule::notIn([isset($this->excursion['lieu_depart_id']) ? $this->excursion['lieu_depart_id'] : ''])],
            'excursion.prestataire_id' => ['nullable', 'string'],
            'excursion.image' => ['nullable', 'array'],
            'excursion.image.*' => ['required', 'string'],
            'excursion.taxes' => ['nullable', 'array'],
            'excursion.taxes.*' => ['required', 'string'],
            'excursion.ile_id' => ['required', 'string'],
            'excursion.fond_image' => ['nullable', 'string'],
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
        $images = [];
        $_all_merge = [
            'excursion' => $this->excursion,
            'prest' => $this->prest
        ];
        foreach ($this->excursion['image'] as $value) {
            $images[] = RequestUploadImage::upload($value, 'excursion');
        }
        $_all_merge['excursion']['image'] = $images;
        if (isset($this->excursion['fond_image'])) {
            $_all_merge['excursion']['fond_image'] = RequestUploadImage::upload($this->excursion['fond_image'], 'excursion');
        }

        if (isset($this->prest['logo'])) {
            $_all_merge['prest']['logo'] = RequestUploadImage::upload($this->prest['logo'], 'prestataire');
        }

        $this->merge($_all_merge);
        return parent::getValidatorInstance();
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitizedExcursion(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized['excursion'], [
            'title', 'availability', 'duration', 'heure_depart','heure_arrive', 'lieu_depart_id', 'lieu_arrive_id',
            'participant_min', 'card',
            'lunch', 'ticket','lunch_prestataire_id','ticket_billeterie_id',
            'status', 'description',
            'ville_id', 'prestataire_id',
            'taxes', 'ile_id', 'adresse_depart', 'adresse_arrive', 'fond_image'
        ]);
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

        return $this->getInArray($sanitized['excursion'], ['image']);
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
