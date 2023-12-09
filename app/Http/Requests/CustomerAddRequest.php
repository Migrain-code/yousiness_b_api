<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>"required|string|min:3",
            'phone'=>"required|string|min:10|unique:customers",
            'email'=>"required|string|min:8",
            'password'=>"required|string|min:8",
            'gender'=>"required|string"
        ];
    }

    public function attributes()
    {
        return [
            'name'=>"Name und Nachname ",
            'phone'=>"Mobilenummer",
            'email'=>"E-mail",
            'password'=>"Password",
            'gender'=>"Geschlecht"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Doğrulama hatası',
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
