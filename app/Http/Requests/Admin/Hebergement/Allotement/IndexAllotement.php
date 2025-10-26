<?php

namespace App\Http\Requests\Admin\Hebergement\Allotement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexAllotement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.allotement.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,titre,quantite,date_depart,date_arrive,heure_depart,heure_arrive,date_acquisition,date_limite,service_aeroport.name,lieu_arrive_id,compagnie_transport_id,compagnie_transport.nom,lieu_depart_id,lieu_arrive_id,service_port.name|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
