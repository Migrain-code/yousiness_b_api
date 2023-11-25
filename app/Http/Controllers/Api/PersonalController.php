<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessPackageResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BusinessServiceResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\PersonelResource;
use App\Models\BusinessService;
use App\Models\BusinnessType;
use App\Models\BussinessPackage;
use App\Models\City;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
/**
 * @group Personal
 *
 */
class PersonalController extends Controller
{
    /**
     * GET api/personal
     *
     * Personel listesini döndürecek size
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3Get(Request $request)
    {
        $business = $request->user();
        return response()->json([
            'personals' => PersonelResource::collection($business->personel),
        ]);
    }
    /**
     * POST api/personal/add
     *
     * Personel Ekleme pointi
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> name |required | string | </li>
     * <li> image |required | string | </li>
     * <li> email |required | string | </li>
     * <li> phone |required | string | </li>
     * <li> password |required | string | </li>
     * <li> approveType |required | numeric | örneğin 1 veya 0</li>
     * <li> restDay |required | numeric | haftanın günlerinden herhangi bir günün id si</li>
     * <li> startTime |required | string | örneğin 10:43 </li>
     * <li> endTime |required | string | örneğin 10:43</li>
     * <li> foodStart |required | string | örneğin 10:43</li>
     * <li> foodEnd |required | string | örneğin 10:43</li>
     * <li> gender |required | numeric | 1 => kadın,2 => erkek,3 => Unisex herhangi biri</li>
     * <li> rate |required | numeric | 10 personel yüzdesi 10 = %10</li>
     * <li> appointmentRange |required | numeric | randevu aralığı örneğin "15" dk bazında</li>
     * <li> description |required | string</li>
     * <li> services | required | array | eğer tümü seçeneği seçilirse "all" olarak gönderebilirsiniz dizi içerisinde</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3AddPersonal(Request $request)
    {
        $business = $request->user();
        $personel = Personel::where('phone', clearPhone($request->input('phone')))->first();
        if ($personel){
            return response()->json([
                'status'=>"warning",
                'message'=>"Die von Ihnen eingegebene Mobilnummer ist nicht im System registriert.",
            ]);
        }
        $personel= new Personel();
        $personel->business_id=$business->id;
        $personel->name= $request->input('name');
        $personel->image="business/team.png";
        $personel->email=$request->email;
        $personel->password=Hash::make($request->password);
        $personel->phone=$request->phone;
        $personel->accept=$request->accept;
        $personel->rest_day=$request->restDay;
        $personel->start_time=$request->startTime;
        $personel->end_time=$request->endTime;
        $personel->food_start=$request->foodStart;
        $personel->food_end=$request->foodEnd;
        $personel->gender=$request->gender;
        $personel->rate=$request->rate;
        $personel->range=$request->appointmentRange;
        $personel->description=$request->description;
        if ($request->hasFile('logo')){
            $personel->image = image($request->file('logo')->store('personalImage'));
        }
        $services = explode(',', $request->services);
        if ($personel->save()){
            if (in_array('all', $services)){
                foreach ($business->services as $service){
                    $personelService=new PersonelService();
                    $personelService->service_id=$service->id;
                    $personelService->personel_id=$personel->id;
                    $personelService->save();
                }
            }
            else{
                foreach ($services as $service){
                    $personelService=new PersonelService();
                    $personelService->service_id=$service;
                    $personelService->personel_id=$personel->id;
                    $personelService->save();
                }
            }
            return response()->json([
                'status'=>"success",
                'message'=>"Personal hinzugefügt",
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Beim Hinzufügen von Personal ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut",
        ]);
    }

    /**
     * POST api/personal/update
     *
     * Personel Güncelleme pointi
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> personal_id | required | numeric</li>
     * <li> name |required | string | personal adı</li>
     * <li> image |required | string | personel görseli</li>
     * <li> email |required | string | mail adresi</li>
     * <li> phone |required | string | telefon numarası</li>
     * <li> password |required | string | şifre</li>
     * <li> approveType |required | numeric | örneğin 1 veya 0</li>
     * <li> restDay |required | numeric | haftanın günlerinden herhangi bir günün id si</li>
     * <li> startTime |required | string | örneğin 10:43 </li>
     * <li> endTime |required | string | örneğin 10:43</li>
     * <li> foodStart |required | string | örneğin 10:43</li>
     * <li> foodEnd |required | string | örneğin 10:43</li>
     * <li> gender |required | numeric | 1 => kadın,2 => erkek,3 => Unisex herhangi biri</li>
     * <li> rate |required | numeric | 10 personel yüzdesi 10 = %10</li>
     * <li> appointmentRange |required | numeric | randevu aralığı örneğin "15" dk bazında</li>
     * <li> description |required | string</li>
     * <li> services | required | array | eğer tümü seçeneği seçilirse "all" olarak gönderebilirsiniz dizi içerisinde</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3UpdatePersonal(Request $request)
    {
        $business = $request->user();

        $personel= Personel::find($request->personal_id);
        if ($personel){
            $personel->business_id=$business->id;
            $personel->name= $request->input('name');
            $personel->image="business/team.png";
            $personel->email=$request->email;
            $personel->password=Hash::make($request->password);
            if ($personel->phone != $request->phone){
                $personelFind = Personel::where('phone', $request->phone)->first();
                if ($personelFind){
                    return response()->json([
                       'status' => "warning",
                       'message' => "Unter dieser Telefonnummer sind Mitarbeiter registriert."
                    ]);
                }
                else{
                    $personel->phone=$request->phone;
                }
            }
            $personel->accept=$request->accept;
            $personel->rest_day=$request->restDay;
            $personel->start_time=$request->startTime;
            $personel->end_time=$request->endTime;
            $personel->food_start=$request->foodStart;
            $personel->food_end=$request->foodEnd;
            $personel->gender=$request->gender;
            $personel->rate=$request->rate;
            $personel->range=$request->appointmentRange;
            $personel->description=$request->description;
            if ($personel->save()){
                if (in_array('all', $request->services)){
                    foreach ($business->services as $service){
                        $personelService=new PersonelService();
                        $personelService->service_id=$service->id;
                        $personelService->personel_id=$personel->id;
                        $personelService->save();
                    }
                }
                else{
                    foreach ($request->services as $service){
                        $personelService=new PersonelService();
                        $personelService->service_id=$service;
                        $personelService->personel_id=$personel->id;
                        $personelService->save();
                    }
                }
                return response()->json([
                    'status'=>"success",
                    'message'=>"Mitarbeiter aktualisiert",
                ]);
            }
        }
        else{
            return response()->json([
                'status'=>"danger",
                'message'=>"Mitarbeiter nicht gefunden",
            ]);
        }


    }

    /**
     * POST api/personal/get
     *
     * id si gönderilen personelin getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>personalId | required | güncellenecek personel id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3GetPersonal(Request $request)
    {
        $business = $request->user();
        $personel = Personel::find($request->personalId);
        if ($personel) {
            return response()->json([
                'status' => "success",
                'personal' => PersonelResource::make($personel),
                'services' => BusinessServiceResource::collection($business->service),
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Mitarbeiter nicht gefunden",
            ]);
        }
    }

    /**
     * POST api/personal/get
     *
     * id si gönderilen personeli silecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>personalId | required | silinecek personel id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3DeletePersonal(Request $request)
    {
        $personel = Personel::find($request->personalId);
        if ($personel) {
            $personel->delete();
            return response()->json([
                'status' => "success",
                'message' => "Mitarbeiter gelöscht",
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Mitarbeiter nicht gefunden",
            ]);
        }
    }
    /**
     * POST api/business/personal/add/get
     *
     * id si gönderilen personeli silecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>personalId | required | silinecek personel id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3AddGetPersonal(Request $request)
    {
        $business_types = BusinnessType::select('id', 'name')->get();
        $dayList = DayList::orderBy('id', 'asc')->select('id', 'name')->get();

        $business = $request->user();
        $appointmentRanges =[];
        for ($i = 5; $i <= 60; $i+= 5){
            $appointmentRanges[]=$i;
        }
        $acceptedType = [
            [
                'id' => 0,
                'name' => "NEIN"
            ],
            [
                'id' => 1,
                'name' => "Ja"
            ]

        ];
        $rates = [
            0,
            10,
            20
        ];
        return response()->json([
            'acceptType' =>$acceptedType,
            'rates' => $rates,
            'dayList' => $dayList,
            'businessTypes' => $business_types,
            'business' => BusinessResource::make($business),
            'appointmentRange' => $appointmentRanges,
            'services' => BusinessServiceResource::collection($business->services)
        ]);
    }
}
