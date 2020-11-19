<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ManageOrderController extends Controller
{
    public function index()
    {
        $order_details_pending = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.belongsToAdmin', Auth::user()->id)
            ->where('orders.tracking_number', '=', NULL)
            ->select('orders.orders_id', 'orders.created_at', 'users.name', 'orders.amount', 'orders.tracking_number', 'orders.courier_code')
            ->get();

        $order_details_complete = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.belongsToAdmin', Auth::user()->id)
            ->where('orders.tracking_number', '<>', NULL)
            ->select('orders.orders_id', 'orders.created_at', 'users.name', 'orders.amount', 'orders.tracking_number', 'orders.courier_code')
            ->get();

        return view('admin/view-order', [
            'orders_details_pending' => $order_details_pending,
            'orders_details_complete' => $order_details_complete,
        ]);
    }

    public function viewItem($id)
    {
        session()->forget('parcelCart');
        session()->forget('refNo');
        session()->forget('weight');

        $courierList = $this->getCourierList();
        // dd($courierList);
        $customerDetails = DB::table('orders')
            ->JOIN('customers', 'orders.customer_id', '=', 'customers.id')
            ->WHERE('orders.orders_id', $id)
            ->get();

        $product = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->where('referenceNo', $id)
            ->select('products.*', 'orders_details.quantity')
            ->get();

        return view('admin/view-order-item', [
            'products' => $product,
            'customerDetails' => $customerDetails,
            'referenceNo' => $id,
            'courierList' => $courierList
        ]);
    }

    public function getCourierList()
    {
        $url = 'https://api.tracktry.com/v1/carriers';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Tracktry-Api-Key' => '3cbee946-e06e-4315-bcda-ae18ed79be07',
        ])->get($url);
        $result = json_decode($response);
        // dd($response);
        return $result;
    }
}
