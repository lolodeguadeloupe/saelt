<?php

namespace App\Http\Requests\Admin\TransfertVoyage\VehiculeTransfertVoyage;

use App\Http\Requests\RequestUploadImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreVehiculeTransfertVoyagePrestataire extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.vehicule-transfert-voyage.store-prestataire');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'vehicule.titre' => ['nullable', 'string'],
            'vehicule.immatriculation' => ['required', /*Rule::unique('vehicule_location', 'immatriculation'),*/ 'string'],
            'vehicule.marque_vehicule_id' => ['required', 'string'],
            'vehicule.modele_vehicule_id' => ['required', 'string'],
            'vehicule.status' => ['required', 'integer'],
            'vehicule.description' => ['nullable', 'string'],
            'vehicule.duration_min' => ['required', 'integer'],
            'vehicule.prestataire_id' => ['nullable', 'string'],
            'vehicule.categorie_vehicule_id' => ['required', 'string'],
            //
            'vehicule.image' => ['nullable', 'array'],
            'vehicule.image.*' => ['required', 'string'],
            //prestataire
            'prest.name' => ['required', 'string'],
            'prest.adresse' => ['required', 'string'],
            'prest.phone' => ['nullable', 'regex:/^[+0-9\s]*$/'],
            'prest.email' => ['nullable', 'email', 'string'],
            'prest.second_email' => ['nullable', 'email', 'string'],
            'prest.ville_id' => ['required', 'string'],
            'prest.logo' => ['nullable', 'string'],
            'heure_ouverture' => ['nullable', 'date_format:H:i'],
            'heure_fermeture' => ['nullable', 'date_format:H:i'],
            //calendar
            'calendar' => ['nullable', 'array'],
            'calendar.*' => ['required'],
            //type transfert
            'type_transfert_voyage_id' => ['required', 'string'],
        ];
    }

    public function getValidatorInstance()
    {

        $images = [];
        $_all_merge = [
            'vehicule' => $this->vehicule,
            'prest' => $this->prest
        ];
        foreach ($this->vehicule['image'] as $value) {
            $images[] = RequestUploadImage::upload($value, 'vehicule-transfert');
        }
        $_all_merge['vehicule']['image'] =$images;
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
    public function getSanitizedVehicule(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized['vehicule'], [
            'titre',
            'immatriculation',
            'marque_vehicule_id',
            'modele_vehicule_id',
            'status',
            'description',
            'duration_min',
            'prestataire_id',
            'categorie_vehicule_id',
        ]);
    }

    public function getSanitizedPrestataire(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized['prest'], ['name', 'adresse', 'phone','second_email','logo', 'email', 'ville_id','heure_ouverture','heure_fermeture']);
    }

    public function getMediaImage(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized['vehicule'], ['image']);
    }

    public function getCalendar(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $this->getInArray($sanitized, ['calendar']);
    }

    public function getTypeTransfert(): array
    {

        $sanitized = $this->validated();
        return $this->getInArray($sanitized, ['type_transfert_voyage_id']);
    }

    private function getInArray($array = [], $key = [])
    {
        $new_array = [];
        for ($index = 0; $index < count($key); $index++) {
            if (isset($array[$key[$index]])) {
                $new_array[$key[$index]] = $array[$key[$index]];
            }
        }
        return $new_array;
    }
}
