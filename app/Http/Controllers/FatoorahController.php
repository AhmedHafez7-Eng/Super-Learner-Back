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
            "CustomerName" => $request['fname'],
            "NotificationOption" => "Lnk",
            "MobileCountryCode" => "965",
            "CustomerMobile" => $request['phone'],
            "CustomerEmail" => $request['email'],
            "InvoiceValue" => 100,
            "DisplayCurrencyIso" => "kwd",
            "CallBackUrl" => env("success.url"),
            "ErrorUrl" => env("error.url"),
            "Language" => "en",
        ];


        return  response()->json($this->fatoorahServices->sendPayment($data));
    }

    public function callBack(Request $request)
    {
       
        $data = [];
        $data['Key'] = $request->payementId;
        $data['KeyType'] = 'paymentId';
        
        return  $paymentData = $this->fatoorahServices->getPaymentStatus($data);
        // search where invoice id = $paymentData['Data]['InvoiceId];

    }
}