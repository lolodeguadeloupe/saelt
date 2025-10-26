<?php

namespace App\Http\Requests\Admin\Saison;

use App\Models\Excursion\Excursion;
use App\Models\Hebergement\Hebergement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StoreSaison extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.saison.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'debut_format' => ['required', 'string'],
            'fin_format' => ['required', 'string'],
            'debut' => ['required', 'date'],
            'fin' => ['required', 'date'],
            'titre' => ['required', 'string', Rule::unique('saisons')->where(function ($query) {
                if (isset($this->heb)) {
                    $query->where(['model' => Hebergement::class, 'model_id' => $this->heb, 'titre' => $this->titre]); //->ignore($this->user)
                } else if (isset($this->excursion)) {
                    $query->where(['model' => Excursion::class, 'model_id' => $this->excursion, 'titre' => $this->titre]); //->ignore($this->user)
                }
            })],
            'description' => ['nullable', 'string'],
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
