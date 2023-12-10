<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DetailSetupRequestStep1;
use App\Http\Resources\BusinessOfficialResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BusinessServiceResource;
use App\Http\Resources\PersonelResource;
use App\Http\Resources\ServiceCategoryResource;
use App\Models\BusinessGallery;
use App\Models\BusinessService;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelService;
use App\Models\ServiceCategory;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @group DetailSetup
 *
 */
class DetailSetupController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $business_types = BusinnessType::select('id', 'name')->get();
        $appointmentRanges = [];
        for ($i = 5; $i <= 60; $i += 5) {
            $appointmentRanges[] = $i;
        }
        if ($user->is_setup == 0){
            $user->is_setup = 1;
        }
        return response()->json([
            'business' => BusinessResource::make($user),
            'dayList' => DayList::all(),
            'businessTypeList' => BusinnessType::all(),
            'appointmentRange' => $appointmentRanges,
            'businessTypes' => $business_types,
        ]);
    }

    /**
     * POST api/detail-setup/step-1/update
     *
     *
     * <ul>
     * <li>Bearer Token</li>
     * <li>officialName | string | required | Salon Sahibinin adı</li>
     * <li>businessName | string | required | Salon Adı</li>
     * <li>businessType | numeric | required | işletme türü id'si </li>
     * <li>phone | string | required | İşletme Telefon Numarası</li>
     * <li>email | string | required | İşletme E-posta Adresi</li>
     * <li>appointmentRange | string | required | Randevu aralığı | örneğin (10, 20, 30,40)</li>
     * <li>aboutText | string | required| İşletme Hakkında Yazısı</li>
     * <li>startTime | string | required| İşletme Açılış Saati Örneğin (12:08)</li>
     * <li>endTime | string | required| İşletme Kapanış Saati Örneğin (18:08)</li>
     * <li>year | date | required| Kuruluş Tarihi örneğin (2023-04-01)</li>
     * <li>address | text | required| Address Metni</li>
     * </ul>
     * Detaylı Kurulum Ekranı İşletme Bilgileri güncelleme Apisi
     *
     *
     */
    public function step1(DetailSetupRequestStep1 $request)
    {
        $business = $request->user();
        $business->owner = $request->input('officialName'); //Yetkili Ad Soyad
        $business->name = $request->input('businessName');// Salon Adı
        $business->appoinment_range = $request->input('appointmentRange');
        $business->phone = $request->input('phone');
        $business->business_email = $request->input('email');
        $business->year = Carbon::parse($request->input('year'))->format('Y-m-d'); //2023-04-01
        $business->address = $request->input('address');
        $business->about = $request->input('aboutText');
        //$business->type_id = $request->input('businessType');
        //$business->start_time = $request->input('startTime');
        //$business->end_time = $request->input('endTime');
        //$business->off_day = $request->input('offDay');
        //$business->city = $request->input('cityId');
        //$business->district = $request->input('districtId');
        //$business->commission = $request->input('commission');
        $business->save();

        return response()->json([
            'status' => "success",
            'message' => "Ihre Benutzerinformationen wurden aktualisiert"
        ]);
    }

    /**
     * POST api/detail-setup/update/logo
     *
     * Bu işletmenin profil fotoğrafını güncelleyecek endpoint
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> base_64_code|text| notes: base 64 codunun başındaki data:image/jpeg;base64 kodunun olmaması gerekiyor </li>
     * <li> mime_type|string|image/png, image/jpeg, image/jpg olarak gönderilebilir </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function updateLogo(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $mime = $request->mime_type;
            if ($mime === 'image/png' or $mime === 'image/jpeg' or $mime === 'image/jpg') {
                if ($request->base_64_code) {
                    $newProfile = "data:image/jpeg;base64," . $request->base_64_code;
                    $data = explode(',', $newProfile);
                    $image = base64_decode($data[1]);
                    if ($mime)
                        $path = 'new_images/profiles/' . Str::random(64) . ".jpeg";
                    Storage::put($path, $image);
                    $user->image = $path;
                    if ($user->save()) {
                        return response()->json([
                            'status' => "success",
                            'message' => "Ihr Profil wurde erfolgreich aktualisiert. "
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => "warning",
                        'message' => "Profilfoto nicht ausgewählt"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => "warning",
                    'message' => "Sie können nur Dateien in den Formaten png, jpeg und jpg hochladen."
                ]);
            }


        }
        return response()->json(['error' => 'Unauthorized'], 401);

    }

    public function uploadLogo(Request $request)
    {
        $user = $request->user();
        $response = UploadFile::uploadFile($request->file('logo'), 'business_logo');
        $user->logo = $response["image"];
        $user->save();

        return response()->json([
            'status' => "success",
            'message' => "Ihre Benutzerinformationen wurden aktualisiert",
            'link' => image($user->logo),
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $user = $request->user();

        BusinessGallery::where('business_id', $user->id)->delete();

        foreach ($request->file('images') as $file) {
            $gallery = new BusinessGallery();
            $gallery->business_id = $user->id;
            $response = UploadFile::uploadFile($file, 'businessGallery');
            $gallery->way = $response["image"];
            $gallery->byte = 45;
            $gallery->name = "businessGallery";
            $gallery->save();
        }

        return response()->json([
            'status' => "success",
            'message' => "Ihre Benutzerinformationen wurden aktualisiert.",
        ]);
    }
}
