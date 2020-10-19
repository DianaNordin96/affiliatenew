<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Product;
use Illuminate\Support\Facades\Http;

class ToyyibpayController extends Controller
{
    public function createBill(Request $req)
    {

        $option = array(
            'userSecretKey' => '7jjvcrsb-h3ro-1zsh-wrrs-7j47nubg36v2',
            'categoryCode' => 'p5cfhstp',
            'billName' => 'Car Rental WXX123',
            'billDescription' => 'Car Rental WXX123 On Sunday',
            'billPriceSetting' => 0,
            'billPayorInfo' => 1,
            'billAmount' => 100,
            'billReturnUrl' => route('toyyibpay-status'),
            'billCallbackUrl' => route('toyyibpay-callback'),
            'billExternalReferenceNo' => 'AFR341DFI',
            'billTo' => 'John Doe',
            'billEmail' => 'jd@gmail.com',
            'billPhone' => '0194342411',
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billMultiPayment' => 1,
            'billPaymentChannel' => 0,
            'billDisplayMerchant' => 1,
            'billContentEmail' => 'Email content'
        );

    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_POST, 1);
    //     curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $option);

    //     $result = curl_exec($curl);
    //     $info = curl_getinfo($curl);
    //     curl_close($curl);
    //     $obj = json_decode($result);
    //    echo $obj[0]->BillCode;

        // foreach ($obj['items'] as $value){
        //     echo $value;
        // };

        
        // from the guide

        $url = 'https://dev.toyyibpay.com/index.php/api/createBill';

        $response = Http::asForm()->post($url, $option);
        // foreach ($response as $res) {
        //     dd($res);
        // }
        $billCode = $response[0]['BillCode'];
        // return redirect('https://dev-toyyibpay.com/' .  $obj[0]->BillCode);
        return redirect('https://dev.toyyibpay.com/' .  $billCode);
    }

    public function paymentStatus()
    {
        $response = request()->all(['status_id','billcode','order_id']);
        return $response;
    }

    public function callback()
    {
        $response = request()->all(['refno','status','billcode','order_id','amount']);
        Log::info($response);
    }
}
