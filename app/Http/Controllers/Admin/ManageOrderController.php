<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageOrderController extends Controller
{
    public function index()
    {
        $order_details = DB::table('orders_details')
            ->join('products', 'orders_details.product_id', '=', 'products.id')
            ->join('orders', 'orders_details.order_id', '=', 'orders.orders_id')
            ->join('users', 'orders.user_id', '=', 'users.name')
            ->select('products.*', 'orders_details.order_id','orders_details.created_at','users.name')
            ->get();

        return view('admin/view-order', [
            'orders_details' => $order_details,
        ]);
    }
}
