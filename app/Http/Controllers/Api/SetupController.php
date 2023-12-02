<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessCategoryResource;
use App\Http\Resources\BusinessPackageResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\OfficialCardResource;
use App\Models\BusinessCategory;
use App\Models\BusinessTypeCategory;
use App\Models\BusinnessType;
use App\Models\BussinessPackage;
use App\Models\City;
use App\Models\DayList;
use Illuminate\Http\Request;

/**
 * @group Setup
 *
 */
class SetupController extends Controller
{
    /**
     * GET api/setup
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * Kayıt Ekranı Tüm Bilgiler Apisi
     *
     *
     */
    public function get(Request $request)
    {
        $business_types = BusinnessType::select('id', 'name')->get();
        $dayList = DayList::orderBy('id', 'asc')->select('id', 'name')->get();
        $monthlyPackages = BussinessPackage::where('type', 0)->get();
        $yearlyPackages = BussinessPackage::where('type', 1)->get();
        $business = $request->user();

        return response()->json([
            'cities' => CityResource::collection(City::take(20)->get()),
            'dayList' => $dayList,
            'businessTypes' => $business_types,
            'monthlyPackages' => BusinessPackageResource::collection($monthlyPackages),
            'yearlyPackages' => BusinessPackageResource::collection($yearlyPackages),
            'business' => BusinessResource::make($business),

        ]);
    }

    /**
     * POST api/setup/update
     *
     *
     * <ul>
     * <li>Bearer Token | required | İşletme Kategorisi</li>
     * <li>name | string | required | İşletme Adı</li>
     * <li>type_id | string | required | Hizmet Türü businessTypes değişkeninden alabilirsiniz </li>
     * <li>city_id  | string | required | Şehir</li>
     * <li>off_day_id  | string | required | Kapalı Olduğu Gün</li>
     * <li>phone | string | required | Kullanıcı Telefon Numarası</li>
     * <li>about_content | string | required| İşletme Hakkında Yazısı</li>
     * <li>start_time | string | required| İşletme Açılış Saati Örneğin (12:08)</li>
     * <li>end_time | string | required| İşletme Kapanış Saati Örneğin (18:08)</li>
     * </ul>
     * Kayıt Ekranı Tüm Bilgiler güncelleme Apisi
     *
     *
     */
    public function update(Request $request)
    {
        $business = $request->user();
        $business->name = $request->input('name');
        $business->type_id = $request->input('business_type');
        $business->phone = $request->input('phone');
        $business->city = $request->input('city_id');
        $business->off_day = $request->input('off_day_id');
        $business->about = $request->input('about_content');
        $business->start_time = $request->input('start_time');
        $business->end_time = $request->input('end_time');
        $business->save();

        return response()->json([
            'status' => "success",
            'message' => "Ihre Benutzerinformationen wurden aktualisiert.",
        ]);
    }

    /**
     * GET api/business/categories
     *
     *
     * Tüm kategoriler apisi
     *
     *
     */
    public function categories(Request $request)
    {
        $business = $request->user();
        $categories = BusinessCategory::all();
        return response()->json([
            'categories' => CategoryResource::collection($categories),
            'businessCategories' => BusinessCategoryResource::collection($business->categories),
        ]);
    }

    /**
     * POST api/business/categories/add
     *
     *<ul>
     *     <li>Berarer token | required | longtext</li>
     *     <li>categories |required | array| kategori id leri</li>
     *</ul>
     * İşletme kategori güncelleme apisi
     *
     *
     */
    public function addCategories(Request $request)
    {
        $business = $request->user();

        if (count($request->input('categories')) > 0) {
            if ($business->categories->count() > 0) {
                foreach ($business->categories as $category) {
                    $category->delete();
                }
            }
            foreach ($request->input('categories') as $category) {
                $businessCategory = new BusinessTypeCategory();
                $businessCategory->category_id = $category;
                $businessCategory->business_id = $business->id;
                $businessCategory->save();
            }
            return response()->json([
                'status' => "success",
                'message' => "Ihre Benutzerinformationen wurden aktualisiert.",
            ]);
        } else {
            return response()->json([
                'status' => "warning",
                'message' => "Auswahl einer Kategorie erforderlich.",
            ]);
        }

    }

    /**
     * POST api/business/setup/step/map
     *
     *<ul>
     *     <li>Berarer token | required | longtext</li>
     *     <li>latitude |required | array| lat</li>
     *     <li>longitude |required | array| lat</li>
     *</ul>
     * İşletme kategori güncelleme apisi
     *
     *
     */
    public function mapUpdate(Request $request)
    {
        $business = $request->user();
        $business->lat = $request->input('latitude');
        $business->longitude = $request->input('longitude');

        $business->save();
        return response()->json([
            'status' => "success",
            'message' => "Ihre Benutzerinformationen wurden aktualisiert.",
        ]);
    }
}
