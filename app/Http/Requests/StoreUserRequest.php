<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'              => 'required|max:511',
            'email'             => 'required|max:511',
            'phone'             => 'required|max:511',
            'nid'               => 'required|max:511',
            'vaccine_center'    => 'required',
            'password'          => 'required'
        ];
    }
}
