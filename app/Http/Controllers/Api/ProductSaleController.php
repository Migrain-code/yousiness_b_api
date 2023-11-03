<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessCustomerResource;
use App\Http\Resources\PersonelResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductSales;
use Illuminate\Http\Request;

/**
 * @group ProductSale
 *
 *
 */
class ProductSaleController extends Controller
{
    /**
     * GET api/business/product-sale
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * İşletmenin ürün satış listesi sadece bu apiden dönen verileri listede göstermeniz yeterlidir.
     *
     *
     *
     */
    public function index(Request $request)
    {
        $business = $request->user();
        return response()->json([
            'product_sales' => $business->sales,
        ]);
    }
    /**
     * GET api/business/product/get-info
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * İşletmenin ürün satışı ekleyeceği yerde .
     *
     *
     *
     */
    public function createProduct(Request $request)
    {
        $business = $request->user();

        $payment_types = [
            [
                'id' => 0,
                'name' => "Nakit Ödeme",
            ],
            [
                'id' => 1,
                'name' => "Banka/Kredi Kartı",
            ],
            [
                'id' => 2,
                'name' => "EFT/Havale",
            ],
            [
                'id' => 3,
                'name' => "Diğer",
            ],
        ];
        $businessCustomers = $business->customers()->get();

        $customers = [];
        foreach ($businessCustomers as $customer) {
            $customers[] = $customer->customer;
        }
        return response()->json([
            'payment_types' => $payment_types,
            'customers' => BusinessCustomerResource::collection($customers),
            'personels' => PersonelResource::collection($business->personel),
            'products' => ProductResource::collection($business->products),
        ]);
    }

    public function store(Request $request)
    {
        $business = $request->user();
        $productSale = new ProductSales();
        $productSale->business_id = $business->id;
        $productSale->customer_id = $request->input('customer_id');
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price')) * $request->input('amount');
        if ($productSale->save()) {
            $productFind = Product::find($request->input('product_id'));
            $productFind->piece = $productFind->piece - $productSale->piece;
            $productFind->save();
            return response()->json([
                'status' => "success",
                'message' => "Satış Yapma İşlemi Tamamlandı"
            ]);
        }
    }

    function sayiDuzenle($sayi)
    {
        $sayi = str_replace('.', '', $sayi);
        $sayi = str_replace(',', '.', $sayi);
        $sonuc = floatval($sayi);
        return $sonuc;
    }

    public function update(Request $request)
    {
        $productSale = ProductSales::find($request->product_sale_id);
        $productSale->customer_id = $request->input('customer_id');
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type');
        $productSale->piece = $request->input('amount');
        $productSale->total = $request->input('price') * $request->input('amount');
        if ($productSale->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Satış Yapma İşlemi Güncellendi"
            ]);
        }
    }

    public function destroy(ProductSales $productSale)
    {
        if ($productSale->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Satış İşlemi Silindi"
            ]);
        }
    }


}
