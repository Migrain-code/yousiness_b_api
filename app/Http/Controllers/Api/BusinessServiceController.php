<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessServiceResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ServiceCategoryResource;
use App\Http\Resources\ServiceSubCategoryResource;
use App\Models\BusinessService;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;

/**
 * @group BusinessService
 *
 */
class BusinessServiceController extends Controller
{
    /**
     * GET api/business-service
     *
     * Hizmetlerin listesini döndürecek size buradaki hizmet listesinden seçilen hizmetlerden seçilen hizmet eklenecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2Get(Request $request)
    {
        $user = $request->user();
        $services = ServiceCategory::all();

        return response()->json([
            'services' => ServiceCategoryResource::collection($services),
            'businessServices' => BusinessServiceResource::collection($user->service),
        ]);
    }
    /**
     * GET api/business/business-service/list
     *
     * Hizmetlerin listesini döndürecek size buradaki hizmet listesinden seçilen hizmetlerden seçilen hizmet eklenecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function serviceList(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'businessServices' => BusinessServiceResource::collection($user->service),
        ]);
    }
    /**
     * POST api/business-service/add
     *
     * Hizmetlerin listesini döndürecek size buradaki hizmet listesinden seçilen hizmetlerden seçilen hizmet eklenecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> type_id |required | cinsiyet id si gelecek buradan  </li>
     * <li> sub_category |required | hizmetin sub_category id si gelecek buradan  </li>
     * <li> time |required | hizmetin süresi gelecek buradan  </li>
     * <li> price |required | hizmetin fiyatı gelecek buradan  </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2AddService(Request $request)
    {
        $business = $request->user();

        if ($request->type_id == "all"){
            $serviceSubCategory = ServiceSubCategory::find($request->input('sub_category'));
            $businessService = new BusinessService();
            $businessService->business_id = $business->id;
            $businessService->type = $serviceSubCategory->category->type_id;
            $businessService->category = $serviceSubCategory->category_id;
            $businessService->sub_category = $serviceSubCategory->id;
            $businessService->time = $request->input('time');
            $businessService->price = $this->sayiDuzenle($request->input('price'));
            $businessService->save();

            $serviceSubCategorys2 = ServiceSubCategory::where('slug', $serviceSubCategory->slug."-m")->first();
            $businessService = new BusinessService();
            $businessService->business_id = $business->id;
            $businessService->type = $serviceSubCategorys2->category->type_id;
            $businessService->category = $serviceSubCategorys2->category_id;
            $businessService->sub_category = $serviceSubCategorys2->id;
            $businessService->time = $request->input('time');
            $businessService->price = $this->sayiDuzenle($request->input('price'));
            $businessService->save();

            $services = [
                "id"=> $businessService->id,
                "type"=> 'Kadın-Erkek',
                "category"=> $businessService->categorys->name,
                "sub_category"=> $businessService->subCategory->name,
                "price"=> $businessService->price,
                'time' => $businessService->time,
            ];
            return response()->json([
                'status' => "success",
                'message' => "Yeni Hizmet Eklendi",
                'businessServices' => $services,
            ]);

        }
        else{
            $serviceSubCategory = ServiceSubCategory::find($request->input('sub_category'));

            $businessService = new BusinessService();
            $businessService->business_id = $business->id;
            $businessService->type = $serviceSubCategory->category->type_id;
            $businessService->category = $serviceSubCategory->category_id;
            $businessService->sub_category = $request->input('sub_category');
            $businessService->time = $request->input('time');
            $businessService->price = $this->sayiDuzenle($request->input('price'));

            if ($businessService->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Yeni Hizmet Eklendi",
                    'businessServices' => BusinessServiceResource::make($businessService),
                ]);
            }
        }


    }

    /**
     * POST api/business-service/update
     *
     * id si gönderilen işletme hizmetinin bilgilerini güncelleyek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>businessServiceId | required | güncellenecek hizmetin idsi</li>
     * <li> typeId |required | cinsiyet id si gelecek buradan  </li>
     * <li> categoryId |required | hizmetin category id si gelecek buradan  </li>
     * <li> subCategoryId |required | hizmetin sub_category id si gelecek buradan  </li>
     * <li> time |required | hizmetin süresi gelecek buradan  </li>
     * <li> price |required | hizmetin fiyatı gelecek buradan  </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2UpdateService(Request $request)
    {
        $business = $request->user();

        $businessService = BusinessService::find($request->input('businessServiceId'));

        if ($businessService) {
            $serviceSubCategory = ServiceSubCategory::find($request->input('sub_category'));

            $businessService = new BusinessService();
            $businessService->business_id = $business->id;
            $businessService->type = $serviceSubCategory->category->type_id;
            $businessService->category = $serviceSubCategory->category_id;
            $businessService->sub_category = $request->input('sub_category');
            $businessService->time = $request->input('time');
            $businessService->price = $this->sayiDuzenle($request->input('price'));

            if ($businessService->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Hizmet Güncellendi",
                    'businessServices' => BusinessServiceResource::make($businessService),
                ]);
            }
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hizmet Bulunamadı",
            ]);
        }

    }

    /**
     * POST api/business-service/get
     *
     * id si gönderilen işletme hizmetinin bilgilerini getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>businessServiceId | required | güncellenecek hizmetin idsi</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2GetService(Request $request)
    {
        $businessService = BusinessService::find($request->input('businessServiceId'));
        if ($businessService) {
            return response()->json([
                'status' => "success",
                'businessService' => BusinessServiceResource::make($businessService),
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hizmet Bulunamadı",
            ]);
        }
    }

    /**
     * POST api/business-service/delete
     *
     * id si gönderilen işletme hizmetinin bilgilerini getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>businessServiceId | required | güncellenecek hizmetin idsi</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2DeleteService(Request $request)
    {
        $businessService = BusinessService::find($request->input('businessServiceId'));
        if ($businessService) {
            $businessService->delete();
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Silindi",
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hizmet Bulunamadı",
            ]);
        }
    }
    /**
     * POST api/business/business-service/category/get
     *
     * id si gönderilen işletme hizmetinin bilgilerini getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>category_id | required | getirilecek cinsiyet türü id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function category(Request $request)
    {
        $sub_category = ServiceSubCategory::where('category_id', $request->category_id)->get();
        return response()->json([
           'sub_categories' => ServiceSubCategoryResource::collection($sub_category)
        ]);
    }
    /**
     * POST api/business/business-service/gender/get
     *
     * id si gönderilen işletme hizmetinin bilgilerini getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>gender | required | getirilecek cinsiyet türü id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function gender(Request $request)
    {
        if ($request->gender == "all") {
            $category = ServiceCategory::with('type')->where('type_id', 1)->get();
        } else {
            $category = ServiceCategory::where('type_id', $request->gender)->get();
        }
        //dd($category);
        return response()->json([
            'category' => CategoryResource::collection($category)
        ]);
    }

    function sayiDuzenle($sayi){
        $sayi = str_replace('.','',$sayi);
        $sayi = str_replace(',','.',$sayi);
        $sonuc = floatval($sayi);
        return $sonuc;
    }

}
