<?php

namespace App\Http\Controllers;

use App\Http\services\FatoorahService;
use Illuminate\Http\Request;

class FatoorahController extends Controller
{

    /**
     * FatoorahController constructor.
     */
    private $fatoorahServices;

    public function __construct(FatoorahService $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }

    public function payOrder(Request $request)
    {
        $data = [
            "CustomerName" => "amr",
            "NotificationOption" => "Lnk",
            "MobileCountryCode" => "965",
            "CustomerMobile" => "01018970251",
            "CustomerEmail" => "amr@amr.com",
            "InvoiceValue" => 100,
            "DisplayCurrencyIso" => "kwd",
            "CallBackUrl" => env("success_url"),
            "ErrorUrl" => env("error_url"),
            "Language" => "en",
        ];


        return  response()->json($this->fatoorahServices->sendPayment($data));
    }

    public function callBack(Request $request)
    {
        return  response()->json("Payment Successfull");
        // search where invoice id = $paymentData['Data]['InvoiceId];

    }
    public function error(Request $request)
    {
        return  response()->json("Payment failed");
        // search where invoice id = $paymentData['Data]['InvoiceId];

    }
}