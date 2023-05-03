<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userType = $this->input('user_type');

        $rules = [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'bio' => 'required',
        ];

        if ($userType == 2) {
            $rules['certification_title'] = 'required';
            $rules['certification_file'] = 'required|file|mimes:jpg,png,jpeg, pdf|max:2048';
        } elseif ($userType == 3) {
            $rules['map_location'] = 'required';
            $rules['date_of_birth'] = 'required|date';
        }

        return $rules;
    }
}
