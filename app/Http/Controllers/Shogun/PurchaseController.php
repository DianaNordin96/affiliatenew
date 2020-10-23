<?php

namespace App\Http\Controllers\Shogun;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
       $orders_detail= DB::table('orders')->where('user_id','=', Auth::user()->id)->get();
       
        return view('shogun/purchaseHistory',[
            'orders_detail' => $orders_detail
        ]);
    }

    public function viewPurchase ($id){

        $product = DB::table('orders_details')
        -> JOIN('products','orders_details.product_id','=','products.id')
        -> select('products.*', 'orders_details.quantity')
        ->get();

        return view('shogun/purchaseItem',[
            'products' => $product
        ]);

    }
}