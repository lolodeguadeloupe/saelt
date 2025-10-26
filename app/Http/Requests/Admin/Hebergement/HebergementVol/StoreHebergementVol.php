<?php

namespace App\Http\Requests\Admin\Hebergement\HebergementVol;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreHebergementVol extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return Gate::allows('admin.hebergement-vol.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {

        $startTime = \Carbon\Carbon::parse($this->depart);
        $endTime = \Carbon\Carbon::parse($this->arrive);
        $min_nuit = $this->nombre_jour;
        /*
          $jour = $endTime->diffInDays($startTime);
          $jour = intval($jour) <= 0 ? 0 : intval($jour);
          $nuit = implode(',', [$jour > 0 ? $jour - 1 : 0, $jour]);
         */

        /*
         * return [
          'depart' => ['required', 'date', 'after:now'],
          'arrive' => ['required', 'date', 'after:depart'],
          'nombre_jour' => ['required', 'numeric', 'min:' . $jour, 'max:' . $jour],
          'nombre_nuit' => ['required', 'integer', 'in:' . $nuit],
          'lien_depart' => ['required', 'string'],
          'lien_arrive' => ['required', 'string'],
          'tarif_id' => ['required', 'string'],
          ];
         */
        return [
            'depart' => ['required', 'date', 'after:now'],
            'arrive' => ['required', 'date', 'after_or_equal:depart'],
            'nombre_jour' => ['required', 'numeric', 'min:1'],
            'nombre_nuit' => ['required', 'integer'],
            'heure_depart' => ['required', 'string'],
            'heure_arrive' => ['required', 'string'],
            'tarif_id' => ['required', 'string'],
            'allotement_id' => ['required', 'string'],
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
