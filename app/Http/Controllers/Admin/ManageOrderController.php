<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ManageOrderController extends Controller
{
    public function index($status)
    {
        if ($status == 'pending') {
            $order_details_pending = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->join('orders_details', 'orders.orders_id', '=', 'orders_details.referenceNo')
                ->join('products', 'orders_details.product_id', '=', 'products.id')
                ->leftJoin('consignment', 'orders.orders_id', '=', 'consignment.refNo')
                ->where('products.belongToAdmin', Auth::user()->admin_category)
                ->where('awb', '=', NULL)
                ->select('customers.name AS cust_name', 'customers.*', 'orders.orders_id', 'orders.user_id', 'orders.created_at AS order_created', 'users.name', 'orders.amount')
                ->groupBy('orders.orders_id')
                ->get();

            return view('admin/view-order-pending', [
                'orders_details_pending' => $order_details_pending,
            ]);
        } else if ($status == 'completed') {
            $order_details_complete = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->join('orders_details', 'orders.orders_id', '=', 'orders_details.referenceNo')
                ->join('products', 'orders_details.product_id', '=', 'products.id')
                ->leftJoin('consignment', 'orders.orders_id', '=', 'consignment.refNo')
                ->where('products.belongToAdmin', Auth::user()->admin_category)
                ->where('awb', '<>', NULL)
                ->select('customers.name AS cust_name', 'customers.*', 'orders.orders_id', 'orders.user_id', 'orders.created_at AS order_created', 'users.name', 'orders.amount')
                ->groupBy('orders.orders_id')
                ->get();

            return view('admin/view-order-completed', [
                'orders_details_complete' => $order_details_complete,
            ]);
        }
    }

    public function viewItem($id)
    {
        if (session()->get('parcelCart')) {
            session()->forget('parcelCart');
        }

        if (session()->get('parcelDetails')) {
            session()->forget('parcelDetails');
        }

        if (session()->get('rateList')) {
            session()->forget('rateList');
        }

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

    public static function checkOrderExistConsignment($refNo)
    {
        $parcel = DB::table('consignment')
            ->where('refNo', $refNo)
            ->get();

        return $parcel;
    }

    public function updateOrderPage()
    {
        $getAllPendingOrders = DB::table('orders')
            ->leftJoin('consignment', 'orders.orders_id', '=', 'consignment.refNo')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.belongsToAdmin', Auth::user()->admin_category)
            ->where('awb', '=', NULL)
            ->get();

        // dd($getAllPendingOrders);
        return view('admin/updateOrder')->with([
            'pendingOrders' => $getAllPendingOrders
        ]);
    }

    public function updateOrder(Request $req)
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');

        DB::table('consignment')
            ->insert([
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
                'price' => $req->input('price'),
                'awb' => $req->input('trackingNo'),
                'refNo' => $req->input('refNo'),
                'courier' => $req->input('courier'),
                'order_number' => $req->input('orderno'),
                'status' => 'Success'
            ]);

        toast('Order has been updated.', 'success');
        return redirect('update-order');
    }
}
