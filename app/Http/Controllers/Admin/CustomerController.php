<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')->get();
        return view('admin/customers')->with([
            'customers' => $customers
        ]);
    }

    public static function getCustomer($refNo){

        $customer = DB::table('orders')
        ->join('customers','orders.customer_id','=','customers.id')
        ->where('orders.orders_id',$refNo)
        ->select('customers.*')
        ->get();

        return $customer;

    }
}
