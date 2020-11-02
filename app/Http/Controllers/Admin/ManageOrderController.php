<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageOrderController extends Controller
{
    public function index()
    {
        $order_details = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.belongsToAdmin', Auth::user()->id)
            ->select('orders.orders_id', 'orders.created_at', 'users.name')
            ->get();

        return view('admin/view-order', [
            'orders_details' => $order_details,
        ]);
    }

    public function viewItem($id)
    {
        $customerDetails = DB::table('orders')
        ->JOIN('customers','orders.customer_id','=','customers.id')
        ->WHERE('orders.orders_id',$id)
        ->get();

        $product = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->where('referenceNo', $id)
            ->select('products.*', 'orders_details.quantity')
            ->get();

        return view('admin/view-order-item', [
            'products' => $product,
            'customerDetails' => $customerDetails,
            'referenceNo' => $id
        ]);
    }
}
