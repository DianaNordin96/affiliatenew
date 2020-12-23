<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Admin\ParcelController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    public function addToCart($orderNo, $price)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            $cart = [
                $orderNo => [
                    "orderNo" => $orderNo,
                    "price" => $price
                ]
            ];
            session()->put('cart', $cart);
            // dd(session()->get('parcelCart'));
            return redirect('/parcel');
        } else {
            $cart[$orderNo] = [
                "orderNo" => $orderNo,
                "price" => $price
            ];
            session()->put('cart', $cart);
            // dd(session()->get('parcelCart'));
            return redirect('/parcel');
        }
    }

    public function removeFromCart($orderNo)
    {
        $cart = session()->get('cart');
        unset($cart[$orderNo]);
        session()->put('cart', $cart);
        return redirect('/parcel');
    }

    public function checkout()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $cart = session()->get('cart');
        $cartArray = array();
        $creditBalance = ParcelController::checkBalance();
        $total = 0;

        foreach ($cart as $value) {
            $array = array("order_no" => $value['orderNo']);
            array_push($cartArray, $array);
            $total += $value['price'];
        }

        if ($total <= $creditBalance) {
            $postparam = array(
                'api'    => 'EP-Ro51LDZu9',
                'bulk'    => $cartArray
            );

            $url = "http://connect.easyparcel.my/?ac=EPPayOrderBulk";
            $response = Http::asForm()->post($url, $postparam);
            $result = json_decode($response, true);
            // dd($result['result']);
            //get number of orders
            // $numOfOrder = $result['result'];
            // $arrayPaymentStatus = array();

            // //get result of payment result
            // foreach ($numOfOrder as $value) {
            //     array_push($arrayPaymentStatus, $value['messagenow']);
            // }

            // // dd($arrayPaymentStatus);

            // dd($result['result'][0]['messagenow']);

            if ($result['result'][0]['messagenow'] != 'Invalid order number') {
                foreach ($result['result'] as $key => $value) {
                    DB::table('consignment')
                        ->where('parcel_number', $value['parcel'][0]['parcelno'])
                        ->update([
                            'awb' => $value['parcel'][0]['awb'],
                            'awb_id_link' => $value['parcel'][0]['awb_id_link'],
                            'tracking_url' => $value['parcel'][0]['tracking_url'],
                            'updated_at' => date("Y-m-d H:i:s")
                        ]);
                }

                $notification = array(
                    'message' => $result['result'][0]['messagenow'],
                    'alert-type' => 'success'
                );

                session()->forget('cart');
                // $array = Excel::toArray(new UsersImport, 'users.xlsx');
                return redirect('/parcel')->with($notification);
            }else{
                $notification = array(
                    'message' => $result['result'][0]['messagenow'],
                    'alert-type' => 'error'
                );
                // $array = Excel::toArray(new UsersImport, 'users.xlsx');
                return redirect('/parcel')->with($notification);
            }

            
        } else {
            $notification = array(
                'message' => 'Insufficient Credit.',
                'alert-type' => 'error'
            );
            return redirect('/parcel')->with($notification);
        }
    }
}
