<?php

namespace App\Http\Controllers\Merchant;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
       $orders_detail= DB::table('orders')->where('user_id','=', Auth::user()->id)->get();
       
        return view('merchant/purchaseHistory',[
            'orders_detail' => $orders_detail
        ]);
    }

    public function viewPurchase ($id){

        $customerDetails = DB::table('orders')
        ->JOIN('customers','orders.customer_id','=','customers.id')
        ->WHERE('orders.orders_id',$id)
        ->get();

        $product = DB::table('orders_details')
        -> JOIN('products','orders_details.product_id','=','products.id')
        ->where('referenceNo',$id)
        -> select('products.*', 'orders_details.quantity')
        ->get();

        return view('merchant/purchaseItem',[
            'products' => $product,
            'customerDetails' => $customerDetails
        ]);

    }
}
