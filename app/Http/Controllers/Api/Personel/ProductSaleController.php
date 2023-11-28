<?php

namespace App\Http\Controllers\Api\Personel;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessCustomerResource;
use App\Http\Resources\PersonelResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSaleResource;
use App\Models\Product;
use App\Models\ProductSales;
use Illuminate\Http\Request;

/**
 * @group PersonalProductSale
 *
 *
 */
class ProductSaleController extends Controller
{
    /**
     * GET api/personal/product-sale
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
        $personal = $request->user();
        return response()->json([
            'product_sales' => ProductSaleResource::collection($personal->productSales),
        ]);
    }

    /**
     * GET api/personal/product-sale/get-info
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * İşletmenin ürün satışı ekleyeceği yerde kullanacağı bilgiler.
     *
     *
     *
     */
    public function createProduct(Request $request)
    {
        $personal = $request->user();

        $payment_types = [
            [
                'id' => 0,
                'name' => "Barzahlung",
            ],
            [
                'id' => 1,
                'name' => "Lastschrift/Kreditkarte",
            ],
            [
                'id' => 2,
                'name' => "EFT/Geldtransfer",
            ],
            [
                'id' => 3,
                'name' => "Andere",
            ],
        ];
        $personalCustomers = $personal->business->customers()->get();

        $customers = [];
        foreach ($personalCustomers as $customer) {
            $customers[] = $customer->customer;
        }
        return response()->json([
            'payment_types' => $payment_types,
            'customers' => BusinessCustomerResource::collection($customers),
            'products' => ProductResource::collection($personal->business->products),
        ]);
    }

    /**
     * POST api/personal/product-sale/create
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>customer_id | string | required | müşteri id</li>
     * <li>product_id | string | required | ürün id</li>
     * <li>personel_id | string | required | personel id</li>
     * <li>payment_type | string | required | ödeme türü</li>
     * <li>amount | string | required | adet</li>
     * <li>price | string | required | fiyat</li>
     *
     * </ul>
     * İşletmenin ürün satışı ekleyeceği yerde .
     *
     *
     *
     */
    public function store(Request $request)
    {
        $personal = $request->user();
        $productSale = new ProductSales();
        $productSale->business_id = $personal->business->id;
        $productSale->customer_id = $request->input('customer_id');
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $personal->id;
        $productSale->payment_type = $request->input('payment_type');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price')) * $request->input('amount');
        if ($productSale->save()) {
            $productFind = Product::find($request->input('product_id'));
            $productFind->piece = $productFind->piece - $productSale->piece;
            $productFind->save();
            return response()->json([
                'status' => "success",
                'message' => "Produktverkauf hinzugefügt"
            ]);
        }
    }

    /**
     * POST api/personal/product-sale/update
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>product_sale_id | numeric | required | ürün satışı id is</li>
     * <li>customer_id | string | required | müşteri id</li>
     * <li>product_id | string | required | ürün id</li>
     * <li>personel_id | string | required | personel id</li>
     * <li>payment_type | string | required | ödeme türü</li>
     * <li>amount | string | required | adet</li>
     * <li>price | string | required | fiyat</li>
     *
     * </ul>
     * İşletmenin ürün satışı ekleyeceği yerde .
     *
     *
     *
     */
    public function update(Request $request)
    {
        $personal = $request->user();
        $productSale = ProductSales::find($request->product_sale_id);
        $productSale->customer_id = $request->input('customer_id');
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $personal->id;
        $productSale->payment_type = $request->input('payment_type');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price') * $request->input('amount'));
        if ($productSale->save()) {
            $productFind = Product::find($request->input('product_id'));
            $oldPrice = $productSale->piece + $productFind->piece;
            $productFind->piece = $oldPrice - $productSale->piece;
            $productFind->save();
            return response()->json([
                'status' => "success",
                'message' => "Produktverkauf aktualisiert"
            ]);
        }
    }

    /**
     * POST api/personal/product-sale/delete
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>product_sale_id | numeric | required | ürün satışı id is</li>
     * </ul>
     * İşletmenin ürün satışı ekleyeceği yerde .
     *
     *
     *
     */
    public function destroy(Request $request)
    {
        $productSale = ProductSales::find($request->product_sale_id);
        if ($productSale) {
            $productSale->delete();
            return response()->json([
                'status' => "success",
                'message' => "Produktverkauf gelöscht"
            ]);
        }
        return response()->json([
            'status' => "warning",
            'message' => "Produktverkauf nicht gefunden"
        ]);
    }

    function sayiDuzenle($sayi)
    {
        $sayi = str_replace('.', '', $sayi);
        $sayi = str_replace(',', '.', $sayi);
        $sonuc = floatval($sayi);
        return $sonuc;
    }

}
