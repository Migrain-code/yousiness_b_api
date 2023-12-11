<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DetailSetupRequestStep1 extends FormRequest
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
            'officialName' => 'required|string|max:255',
            'businessName' => 'required|string|max:255',
            'appointmentRange' => 'required|numeric',
            'phone' => 'required|string',
            'email' => 'required|string',
            'year' => 'required|date',
            'address' => 'required|string',
            'aboutText' => 'required|string',
            //'personalCount' => 'required|numeric',
            //'businessType' => 'required|numeric',
            //'cityId' => 'required|numeric',
            //'districtId' => 'required|numeric',
            //'commission' => 'required|numeric',
            //'offDay' => 'required|numeric',
            //'startTime' => 'required|string',
            //'endTime' => 'required|string',
        ];
    }

    public function attributes()
    {

        return [
            'officialName' => "Inhaber/in Name Nachname",
            'businessName' => "Salonname",
            'appointmentRange' => "Randevu aralığı",
            'phone' => "Salon mobilnummer",
            'email' => "Salon E-mail",
            'year' => "Gründungsjahr",
            'address' => "Adresse",
            'aboutText' => "über uns",
            //'personalCount' => "Personel Sayısı",
            //'cityId' => "Şehir",
            //'districtId' => "İlçe",
            //'commission' => "Personel Komisyonu",
            //'offDay' => "Kapalı Olduğu Gün",
            //'businessType' => "İşletme türü",
            //'startTime' => "İşletme Açılış Saati",
            //'endTime' => "İşletme Kapanış Saati",
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
