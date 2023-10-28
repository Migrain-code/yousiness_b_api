<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OfficialCreatidCardUpdateRequest extends FormRequest
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
            'cart_id' => 'required|min:1',
            'name' => 'required|string|max:255',
            'number' => 'required|numeric|min:16',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric',
            'cvc' => 'required|string|regex:/^\d{3,4}$/',
            'name_on_the_card' => 'required|string|max:255',
            'is_default' => 'required|numeric|in:0,1'
        ];
    }

    public function attributes()
    {
        return [
            'cart_id' => 'Kullanıcı Kartı Benzersiz Kimliği',
            'name' => 'Kartınızın Adı',
            'number' => 'Kart Numarası',
            'month' => 'Ay Bilgisi',
            'year' => 'Yıl Bilgisi',
            'cvc' => 'CVC',
            'name_on_the_card' => 'Kart Üzerindeki İsim',
            'is_default' => 'Varsayılan Kart'
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
