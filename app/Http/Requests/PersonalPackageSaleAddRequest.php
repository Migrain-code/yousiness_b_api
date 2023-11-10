<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonalPackageSaleAddRequest extends FormRequest
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
            'customer_id'=> "required",
            'service_id' => "required",
            'amount' => "required",
            'total' => "required",
            'package_type' => "required",
            'seller_date' => "required",
        ];
    }

    public function attributes()
    {
        return [
            'customer_id'=> "Kunde",
            'service_id' => "Dienstleistung",
            'amount' => "Fiyat",
            'total' => "Betrag",
            'package_type' => "Paket Türü",
            'seller_date' => "Satış Tarihi",
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
