<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SalesController extends Controller
{
    public static function getTotalPurchase()
    {
        //get the date
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        $getTotalPurchase = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
            ->JOIN('users', 'orders.user_id', '=', 'users.id')
            ->selectRaw('orders_details.quantity * products.price_hq AS total_purchase')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.belongsToAdmin', '=', Auth::user()->admin_category)
            ->get();

        $total = 0;
        foreach ($getTotalPurchase as $value) {
            $total += $value->total_purchase;
        }

        return $total;
    }

    public static function getTotalSales()
    {
        //get the date
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        $getTotalSales = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
            ->JOIN('users', 'orders.user_id', '=', 'users.id')
            ->selectRaw('orders_details.quantity * products.product_price AS total_sales')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.belongsToAdmin', '=', Auth::user()->admin_category)
            ->get();

        $total = 0;
        foreach ($getTotalSales as $value) {
            $total += $value->total_sales;
        }

        return $total;
    }
}
