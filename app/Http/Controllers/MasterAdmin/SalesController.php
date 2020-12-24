<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SalesController extends Controller
{
    public function getTotalPurchase()
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
            ->get();

        $total = 0;
        foreach ($getTotalPurchase as $value) {
            $total += $value->total_purchase;
        }

        return $total;
    }

    public function getTotalSales()
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
            ->get();

        $total = 0;
        foreach ($getTotalSales as $value) {
            $total += $value->total_sales;
        }

        return $total;
    }

    public function getGraphSales()
    {

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $monthlySales = array();
        $year = date('Y');

        foreach ($month as $mth) {

            $getTotalSales = DB::table('orders_details')
                ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                ->selectRaw('orders_details.quantity * products.product_price AS total_sales')
                ->where('orders.created_at', '>=', $year . $mth . '01')
                ->where('orders.created_at', '<=', $year . $mth . '31')
                ->get();

            $total = 0;
            foreach ($getTotalSales as $value) {
                $total += $value->total_sales;
            }

            if ($total != 0) {
                array_push($monthlySales, $total);
            } else {
                array_push($monthlySales, 0);
            }
        }

        return $monthlySales;
    }

    public function getGraphPurchase()
    {

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $monthlyPurchase = array();
        $year = date('Y');

        foreach ($month as $mth) {

            $getTotalPurchase = DB::table('orders_details')
                ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                ->selectRaw('orders_details.quantity * products.price_hq AS total_purchase')
                ->where('orders.created_at', '>=', $year . $mth . '01')
                ->where('orders.created_at', '<=', $year . $mth . '31')
                ->get();

            $total = 0;
            foreach ($getTotalPurchase as $value) {
                $total += $value->total_purchase;
            }

            if ($total != 0) {
                array_push($monthlyPurchase, $total);
            } else {
                array_push($monthlyPurchase, 0);
            }
        }

        return $monthlyPurchase;
    }

    public function getGraphProfit()
    {
        $sales = $this->getGraphSales();
        $purchases = $this->getGraphPurchase();

        $profitMonthly = array();

        for ($i = 0; $i < 12; $i++) {
            $total = $sales[$i] - $purchases[$i];

            if ($total != 0) {
                array_push($profitMonthly, $total);
            } else {
                array_push($profitMonthly, 0);
            }
        }
        
        return $profitMonthly;
    }

}