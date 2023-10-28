<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficialCreatidCardAddRequest;
use App\Http\Requests\OfficialCreatidCardUpdateRequest;
use App\Http\Resources\OfficialCardResource;
use App\Models\OfficialCreatidCard;
use Illuminate\Http\Request;
/**
 * @group Credit Cart
 *
 * */

class OfficialCreditCardController extends Controller
{

    /**
     * GET api/cart
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * Kullanıcının Tüm Kartları Apisi
     *
     *
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'cards' => OfficialCardResource::collection($user->cards),
        ]);
    }
    /**
     * POST api/cart/get
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>cart_id | numeric | required | Kredi kartı id si </li>
     * </ul>
     * Kullanıcının Tüm Kartları Apisi
     *
     *
     */
    public function get(Request $request)
    {
        $card = OfficialCreatidCard::find($request->cart_id);
        if ($card){
            return response()->json([
                'cart' => OfficialCardResource::make($card),
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Kart Bilgisi Bulunamadı",
            ]);
        }

    }
    /**
     * POST api/cart/delete
     * @headers BearerToken
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>cart_id | numeric | required | Kredi kartı id si </li>
     * </ul>
     * Kullanıcının Tüm Kartları Apisi
     *
     *
     */
    public function delete(Request $request)
    {
        $card = OfficialCreatidCard::find($request->cart_id);
        if ($card){
            $card->delete();
            return response()->json([
                'status' => "success",
                'message' => "Kart Bilgileri Silindi",
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Kart Bilgisi Bulunamadı",
            ]);
        }

    }
    /**
     * POST api/cart/save
     *
     *
     * <ul>
     * <li>Bearer Token | required | Kullanıcı Tokeni</li>
     * <li>name | string | required | Kartınızın Adı</li>
     * <li>cvc | number | required | CVC kodu</li>
     * <li>number | string | required | Kart Numarası </li>
     * <li>month  | string | required | Ay Bilgisi</li>
     * <li>year  | string | required | Yıl Bilgisi</li>
     * <li>name_on_the_card  | string | required | Kart Üzerindeki isim</li>
     * <li>is_default  | numeric | required | Varsayılan Kart seçimi is_default == 0 "seçili değil" is_default == 1 "seçili" </li>
     * </ul>
     * Kullanıcı kart kayıt Apisi
     *
     *
     */
    public function store(OfficialCreatidCardAddRequest $request)
    {
        $user = $request->user();
        $card = new OfficialCreatidCard();
        $this->setCard($user, $card, $request);
        return response()->json([
            'status' => "success",
            'message' => "Kartınız Kayıt Edildi",
        ]);
    }
    /**
     * POST api/cart/update
     *
     *
     * <ul>
     * <li>Bearer Token | required | Kullanıcı Tokeni</li>
     * <li>cart_id | required | Kullanıcı Tokeni</li>
     * <li>name | string | required | Kartınızın Adı</li>
     * <li>cvc | number | required | CVC kodu</li>
     * <li>number | string | required | Kart Numarası </li>
     * <li>month  | string | required | Ay Bilgisi</li>
     * <li>year  | string | required | Yıl Bilgisi</li>
     * <li>name_on_the_card  | string | required | Kart Üzerindeki isim</li>
     * <li>is_default  | numeric | required | Varsayılan Kart seçimi is_default == 0 "seçili değil" is_default == 1 "seçili" </li>
     * </ul>
     * Kullanıcı kart güncelleme Apisi
     *
     *
     */
    public function update(OfficialCreatidCardUpdateRequest $request)
    {
        $user = $request->user();
        $card = OfficialCreatidCard::find($request->card_id);
        if ($card->name != $request->name){
            if($user->cards->where('id', '!=', $card->id)->where('name', '==', $request->name)->count() > 0){
                return response()->json([
                    'status' => "error",
                    'message' => "Aynı isimde başka bir kartınız bulunmakta kart isimlendirmenizi değiştirin",
                ]);
            }
        }
        if ($card->number == $request->number) {

            $this->setCard($user, $card, $request);
            return response()->json([
                'status' => "success",
                'message' => "Kart Bilgileriniz Güncellendi",
            ]);
        } else {
            $searchCard = OfficialCreatidCard::where('number', $request->number)->first();
            if ($searchCard) {
                return response()->json([
                    'status' => "error",
                    'message' => "Kart numarası daha önce kayıt edilmiş",
                ]);
            } else {
                $this->setCard($user, $card, $request);
                return response()->json([
                    'status' => "success",
                    'message' => "Kart Bilgileriniz Güncellendi",
                ]);
            }
        }

    }

    public function setCard($user, $card, $request)
    {
        $card->official_id = $user->id;
        if ($request->is_default == 1){
            $this->setDefaultCard($user, $card);
        }
        $card->name = $request->name;
        $card->cvc = $request->input('cvc');
        $card->number = $request->input('number');
        $card->month = $request->input('month');
        $card->year = $request->input('year');
        $card->name_on_the_card = $request->input('name_on_the_card');
        if ($card->save()) {
            return $card;
        }
    }

    public function setDefaultCard($user, $card)
    {
        foreach ($user->cards as $cardOld) {
            $cardOld->update(['is_default' => 0]);
        }
        $card->update(['is_default' => 1]);
        return $card;
    }
}
