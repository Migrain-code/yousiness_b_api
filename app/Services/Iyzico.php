<?php

namespace App\Services;

use Iyzipay\Model\Locale;
use Iyzipay\Model\Payment;
use Iyzipay\Options;
use Iyzipay\Request\RetrievePaymentRequest;

class Iyzico
{
    // private static string $apiUrl = "https://sandbox-api.iyzipay.com";
    // const apikey = 'sandbox-rargNwJ6QlyOFaRfroy7zHLEDIMHnPLt';
    // const secretKey = 'sandbox-HPfMELibknquyPnk5ulROe23jS1RK2U5';

    private static string $apiUrl = "https://api.iyzipay.com";
    const apikey = 'SVoiBn1Q9WemfUkHxiPuDNHBXugGg0hm';
    const secretKey = '3e6tRIic5coLfPLsogmjh6cXE4L8Ml6s';

    public static function options()
    {
        $options = new Options();
        $options->setApiKey(self::apikey);
        $options->setSecretKey(self::secretKey);
        $options->setBaseUrl(self::$apiUrl);

        return $options;
    }

    public static function getPaymentDetails($paymentId)
    {
        $request = new RetrievePaymentRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId("123456789");
        $request->setPaymentId($paymentId);
        $request->setPaymentConversationId("123456789");

        $payment = Payment::retrieve($request, self::options());

        return $payment;
    }

    public function getRegisteredCards()
    {

    }
}
