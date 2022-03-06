<?php

namespace App\Http\Controllers;

use App\Http\Services\FatoorahService;
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
            "CustomerName" => $request->CustomerName,
            "NotificationOption" => "Lnk",
            "MobileCountryCode" => "965",
            "CustomerMobile" => "12345678",
            "CustomerEmail" => "mail@company.com",
            "InvoiceValue" => 100,
            "DisplayCurrencyIso" => "kwd",
            "CallBackUrl" => env('success_url'),
            "ErrorUrl" => env('error_url'),
            "Language" => "en",
        ];

        return $this->fatoorahServices->sendPayment($data);
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