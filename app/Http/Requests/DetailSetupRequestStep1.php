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
            'businessType' => 'required|numeric',
            'phone' => 'required|string|min:11',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'email' => 'required|string',
            'year' => 'required|date',
            'address' => 'required|string',
            'cityId' => 'required|numeric',
            'districtId' => 'required|numeric',
            'commission' => 'required|numeric',
            'personalCount' => 'required|numeric',
            'offDay' => 'required|numeric',
            'aboutText' => 'required|string',
        ];
    }

    public function attributes()
    {

        return [
            'officialName' => "Salon Sahibinin adı",
            'businessName' => "Salon Adı",
            'appointmentRange' => "Randevu aralığı",
            'businessType' => "İşletme türü",
            'phone' => "İşletme Telefon Numarası",
            'startTime' => "İşletme Açılış Saati",
            'endTime' => "İşletme Kapanış Saati",
            'email' => "İşletme E-posta Adresi",
            'year' => "İşletme Kuruluş Tarihi",
            'address' => "İşletme Address Metni",
            'cityId' => "Şehir",
            'districtId' => "İlçe",
            'commission' => "Personel Komisyonu",
            'personalCount' => "Personel Sayısı",
            'offDay' => "Kapalı Olduğu Gün",
            'aboutText' => "İşletme Hakkında Yazısı",
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
