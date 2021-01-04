<?php

namespace App\Http\Controllers\Damio;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function index()
    {
        $orders_detail = DB::table('orders')
        ->join('customers','orders.customer_id','=','customers.id')
        ->select('orders.*','customers.name','customers.phone')
        ->where('orders.user_id', '=', Auth::user()->id)->get();

        return view('damio/purchaseHistory', [
            'orders_detail' => $orders_detail
        ]);
    }

    public function viewPurchase($id)
    {

        $customerDetails = DB::table('orders')
            ->JOIN('customers', 'orders.customer_id', '=', 'customers.id')
            ->WHERE('orders.orders_id', $id)
            ->get();

        $product = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->where('referenceNo', $id)
            ->select('products.*', 'orders_details.quantity')
            ->get();

        return view('damio/purchaseItem', [
            'products' => $product,
            'customerDetails' => $customerDetails,
            'referenceNo' => $id
        ]);
    }

    public static function getTrackingStatus($awb)
    {
        $postparam = array(
            'api'    => 'EP-Ro51LDZu9',
            'bulk'    => array(
                array(
                    'awb_no'    => $awb,
                ),
            ),
        );

        $url = 'http://demo.connect.easyparcel.my/?ac=EPTrackingBulk';
        $response = Http::asForm()->post($url, $postparam);
        $result = json_decode($response);
        // $result = $result['result']['latest_status'];
        return $result;
    }

    public static function checkOrderExistConsignment($refNo)
    {
        $parcel = DB::table('consignment')
            ->where('refNo', $refNo)
            ->get();

        return $parcel;
    }

    public static function getTrackingDetails($awb)
    {
        $getDetails= DB::table('consignment')->where('awb',$awb)->get();

        return $getDetails;
    }

    public function getProducts($refNo){

        $product = DB::table('orders_details')
        ->join('products','orders_details.product_id','=','products.id')
        ->where('orders_details.referenceNo',$refNo)
        ->select('products.*')
        ->get();

        return $product;
    }
}

