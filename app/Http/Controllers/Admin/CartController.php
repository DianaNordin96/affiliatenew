<?php

namespace App\Http\Controllers\Admin;

use DB;
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
        $cart = session()->get('cart');
        $cartArray = array();

        foreach($cart as $value){
            $array = array("order_no" => $value['orderNo']);
            array_push($cartArray,$array);
        }

        $postparam = array(
            'api'    => 'EP-Ro51LDZu9',
            'bulk'    => $cartArray
        );

        $url = "http://connect.easyparcel.my/?ac=EPPayOrderBulk";
        $response = Http::asForm()->post($url, $postparam);
        $result = json_decode($response,true);
        // dd($result);
        //get number of orders
        $numOfOrder = $result['result'];
        $arrayPaymentStatus = array();

        //get result of payment result
        foreach($numOfOrder as $value){
            array_push($arrayPaymentStatus,$value['messagenow']);
        }

        // dd($arrayPaymentStatus);

        if (!in_array('Fully Paid',$arrayPaymentStatus,TRUE)){
            toast('Insufficient Credit','error');
        }else{

            foreach($result['result'][0]['parcel'] as $value){
            DB::table('consignment')
            ->where('parcel_number',$value['parcelno'])
            ->update([
                'awb' => $value['awb'],
                'awb_id_link' => $value['awb_id_link'],
                'tracking_url' => $value['tracking_url']
            ]);
            
            toast('Payment Successful','success'); 
            return redirect('/parcel');
            // $array = Excel::toArray(new UsersImport, 'users.xlsx');
            }
        }
        return redirect('/parcel');
    }
}
