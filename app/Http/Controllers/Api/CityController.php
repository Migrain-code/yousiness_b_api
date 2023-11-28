<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Models\Page;
use Illuminate\Http\Request;

/**
 *
 * @group City
 * */
class CityController extends Controller
{
    /**
     * POST api/city/search
     *
     * Şehir arama apisi sadeece city_name göndermeniz yeterli
     *
     *
     */
    public function search(Request $request)
    {
        $cities = City::where('name', 'like', '%' . $request->city_name . '%')
            ->orWhere('post_code', 'like', '%' . $request->city_name . '%')
            ->take(50)
            ->get();

        return response()->json([
            'cities' => CityResource::collection($cities),
        ]);
    }

    /**
     * POST api/city/list
     *
     * Şehir listesi
     *
     *
     */
    public function list()
    {
        return response()->json([
            'cities' => CityResource::collection(City::take(20)->get()),
        ]);
    }

    public function setting()
    {
        return response()->json([
            'pages' => Page::whereIn('id', [2, 3])->get(),
            'menu' =>  Page::whereIn('id', [1, 2, 3])->get(),
        ]);
    }

    public function pageDetail(Request $request)
    {
        return response()->json([
            'page' => Page::whereIn('id', $request->id)->first(),
        ]);
    }
}
