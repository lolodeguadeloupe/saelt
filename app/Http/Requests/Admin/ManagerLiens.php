<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ManagerLiens extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    public function getValidatorInstance() {
        if (isset($this->parent_name)) {
            $this->merge(['parent_name' => $this->parent_name]);
        }

        if (isset($this->name)) {
            $this->merge(['name' => $this->name]);
        }

        if (isset($this->liens)) {
            $this->merge(['liens' => $this->liens]);
        }
        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'is_parent' => ['nullable'],
            'parent_name' => ['nullable'],
            'href' => ['nullable'],
            'name' => ['nullable'],
            'liens' => ['nullable'],
            'range' => ['nullable']
        ];
    }

}
