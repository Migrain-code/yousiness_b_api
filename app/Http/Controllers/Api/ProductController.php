<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Business;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @group Product
 *
 * */
class ProductController extends Controller
{
    /**
     * GET api/business/product
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * İşletmenin ürün listesi sadece bu apiden dönen verileri listede göstermeniz yeterlidir.
     *
     *
     *
     */
    public function index(Request $request)
    {
        $business = $request->user();
        return response()->json([
           'products' => ProductResource::collection($business->products),
        ]);
    }
    /**
     * POST api/business/product/create
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>name | string | required | Ürün adı</li>
     * <li>amount | numeric | required | Ürün sayısı</li>
     * <li>price | numeric | required | tek bir ürünün fiyatı</li>
     *
     * </ul>
     * ürün ekleme apisi
     *
     */
    public function create(Request $request)
    {
        $business = $request->user();
        $product = new Product();
        $product->business_id = $business->id;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->piece = $request->input('amount');
        $product->barcode = $request->input('barcode');

        if ($product->save()){
            return response()->json([
                'status' => "success",
                'message' => "Ürün Eklendi"
            ]);
        }
    }
    /**
     * POST api/business/product/update
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>product_id | numeric | required | Ürün id si</li>
     * <li>name | string | required | Ürün adı</li>
     * <li>amount | numeric | required | Ürün sayısı</li>
     * <li>price | numeric | required | tek bir ürünün fiyatı</li>
     *
     * </ul>
     * ürün ekleme apisi
     *
     */
    public function update(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->piece = $request->input('amount');
        if ($product->save()){
            return response()->json([
                'status' => "success",
                'message' => "Ürün Güncellendi"
            ]);
        }
    }
    /**
     * POST api/business/product/delete
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>product_id | numeric | required | Ürün id si</li>
     *
     * </ul>
     * ürün silme apisi
     *
     */
    public function destroy(Request $request)
    {
        $product = Product::find($request->input('product_id'));

        if ($product->save()){
            return response()->json([
                'status' => "success",
                'message' => "Ürün Silindi"
            ]);
        }
    }
}
