<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\BusinessNotificationPermission;
use App\Models\Device;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @group Authentication
 */

class AuthController extends Controller
{

    /**
     * POST api/auth/login
     *
     * Status Codes
     * <ul>
     * <li>phone</li>
     * <li>password</li>
     * <li> 401 Unauthorized Hatası </li>
     * </ul>
     * Login apisi
     *
     *
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = Business::where('email', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => "error",
                'message' => 'Ihre Mobilnummer oder Ihr Passwort ist falsch. '
            ], 401);
        }

        $token = $user->createToken('Access Token')->accessToken;
        if ($request->has('device_token')){
            $deviceToken = $request->device_token;
            /*$this->saveDevice($user, $deviceToken);
            $deviceToken = $user->device->token;*/
            $title = $user->name;
            $body = 'Herzlich willkommen!';
            $notification = new \App\Services\Notification();
            $notification->sendPushNotification($deviceToken, $title, $body);
        }
        return response()->json([
            'token' => $token,
            'user' => BusinessResource::make($user),
        ]);
    }

    /**
     * POST api/auth/logout
     *
     *
     * <ul>
     * <li>Token Göndermeniz Yeterli</li>
     * </ul>
     * Logout apisi
     *
     * @header Bearer {token}
     *
     */
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Vom System abgemeldet']);
    }
    /**
     * GET api/auth/user
     *
     *
     * <ul>
     * <li>Token Göndermeniz Yeterli</li>
     * </ul>
     * Logout apisi
     *
     * @header Bearer {token}
     *
     */
    public function user(Request $request)
    {
        return response()->json(BusinessResource::make($request->user()));
    }
    /**
     * POST api/auth/check-phone
     *
     *
     * <ul>
     * <li>phone | string | required</li>
     * </ul>
     * telefon numarası kontrol apisi
     *
     *
     */
    public function register(Request $request)
    {
        if ($this->existPhone(clearPhone($request->phone))) {
            return response()->json([
                'status' => "warning",
                'message' => "Es ist bereits ein Benutzer mit dieser Mobilnummer registriert."
            ]);
        } else {

            $this->createVerifyCode(clearPhone($request->phone));

            return response()->json([
                'status' => "success",
                'message' => "Wir haben einen Code an Ihre Mobilnummer gesendet. Bitte überprüfen Sie Ihre Mobilnummer."
            ]);
        }
    }
    /**
     * POST api/auth/verify
     *
     *
     * <ul>
     * <li>code | string | required | Doğrulama Kodu</li>
     * <li>phone | string | required | Kullanıcı Telefon Numarası</li>
     * <li>name | string | required | Kullanıcı Adı</li>
     * <li>business_name | string | required | İşletme Adı</li>
     * <li>phone | string | required</li>
     * </ul>
     * Kod doğrulama ve kullanıcı kayıt apisi
     *
     *
     */
    public function verify(Request $request)
    {

        $code = SmsConfirmation::where("code", $request->code)->where('action','BUSINESS-REGISTER')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->createVerifyCode($code->phone);

                return response()->json([
                    'status' => "warning",
                    'message' => "Verifizierungscode ist nicht mehr gültig. "
                ]);

            }
            else{

                if ($code->phone == $request->phone){
                    $generatePassword = rand(100000, 999999);

                    $business = new Business();
                    $business->email = $request->phone;
                    $business->name = $request->business_name;
                    $business->slug = Str::slug($request->business_name);
                    $business->owner = $request->name;
                    $business->password = Hash::make($generatePassword);
                    $business->package_id = 1;
                    $business->verify_phone = 1;
                    $business->save();

                    $this->addPermission($business->id);

                    Sms::send(clearPhone($request->input('phone')), "Ihr Passwort für die Anmeldung bei ".config('settings.appy_site_title')." lautet ".$generatePassword);
                    return response()->json([
                        'status' => "success",
                        'message' => "Ihre Mobilnummer Überprüfung war erfolgreich. Für die Anmeldung in das System wurde Ihnen Ihr Passwort zugesendet. "
                    ]);
                }
                else{
                    return response()->json([
                        'status' => "danger",
                        'message' => "Verifizierungscode ist fehlerhaft."
                    ]);
                }
            }


        } else {
            return response()->json([
                'status' => "danger",
                'message' => "Verifizierungscode ist fehlerhaft."
            ]);
        }

    }

    public function resetPassword(Request $request)
    {
        $user = Business::where('email', $request->phone)->first();
        if ($user){
            $generatePassword = rand(100000, 999999);
            $user->password = Hash::make($generatePassword);
            $user->save();
            Sms::send(clearPhone($request->input('phone')), "Ihr Passwort für die Anmeldung bei ".config('settings.appy_site_title')." lautet ".$generatePassword);
            return response()->json([
                'status' => "success",
                'message' => "Ihre Mobilnummer Überprüfung war erfolgreich. Für die Anmeldung in das System wurde Ihnen Ihr Passwort zugesendet. "
            ]);
        }
    }

    public function existPhone($phone)
    {
        $existPhone = Business::where('email', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function addPermission($id){
        $businessPermission = new BusinessNotificationPermission();
        $businessPermission->business_id = $id;
        $businessPermission->save();
        return true;
    }

    /*function setAdmin($business,$user){
        $business->admin_id = $user->id;
        $business->save();
    }*/

    function createVerifyCode($phone){
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = $phone;
        $smsConfirmation->action = "BUSINESS-REGISTER";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send(clearPhone($phone), "Für die Registrierung bei ".setting('appy_site_title')." ist der Verifizierungscode anzugeben " . $generateCode);

        return $generateCode;
    }

    function saveDevice($user, $deviceToken){
        $device = Device::where('customer_id', $user->id)->first();
        if ($device){
            $device->token = $deviceToken;
            $device->save();
        }
        else{
            $device = new Device();
            $device->customer_id = $user->id;
            $device->token = $deviceToken;
            $device->type = 1;
            $device->user_type = 1;
            $device->save();
        }
    }
}
