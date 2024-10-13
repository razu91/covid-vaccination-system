<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|min:5',
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'required|string|max:20|unique:users,phone',
            'nid'  => 'required|string|max:17|min:10|unique:users,nid',
            'vaccine_center' => 'required|exists:vaccine_centers,id',
        ];
    }

    /**
     * Get custom attribute names for validation error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'vaccine_center' => 'vaccine center',
            'nid' => 'National ID',
        ];
    }

}
