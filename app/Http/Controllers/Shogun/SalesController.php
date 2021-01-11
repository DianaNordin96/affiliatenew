<?php

namespace App\Http\Controllers\Shogun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;


class SalesController extends Controller
{
    public function getDownline()
    {
        //getAllDownline
        $allDownline = array();
        $statusLoop = true;
        $id = Auth::user()->id;
        $downlineList = array($id);
        $statusForLoop = array();

        // dd($allDownline);

        //get downline 
        while ($statusLoop) {
            $statusForLoop = array();
            foreach ($downlineList as $value) {

                $userDownlineL1 = DB::table('users')
                    ->where('downlineTo', $value)
                    ->where(function ($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline', '!=', 'decline');
                    })
                    ->where(function ($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline', '!=', 'pending');
                    })
                    ->select('id')
                    ->get();

                foreach ($userDownlineL1 as $valueL2) {
                    array_push($downlineList, $valueL2->id);
                    array_push($allDownline, $valueL2->id);

                    if ($valueL2->id != '') {
                        array_push($statusForLoop, 'true');
                    } else {
                        array_push($statusForLoop, 'false');
                    }
                }
                $key = array_search($value, $downlineList);
                unset($downlineList[$key]);
            }

            if (in_array('true', $statusForLoop, true)) {
                $statusLoop = true;
            } else {
                $statusLoop = false;
            }
        }

        return $allDownline;
    }

    public function getTotalPurchase()
    {
        //get the date
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        $total = 0;
        $allDownline = $this->getDownline();

        //totalPurchase all agent
        foreach ($allDownline as $dl) {
            $getRole = DB::table('users')
                ->where('id', $dl)
                ->get();

            // dd($sales);
            foreach ($getRole as $user) {
                switch ($user->role) {
                    case 'damio':
                        $getTotalPurchase = DB::table('orders_details')
                            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                            ->selectRaw('orders_details.quantity * (products.product_price-(products.product_price-(products.price_hq + products.price_shogun))) AS total_purchase')
                            ->where('orders.created_at', '>=', $year . $month . '01')
                            ->where('orders.created_at', '<=', $year . $month . '31')
                            ->where('orders.user_id', $user->id)
                            ->get();

                        foreach ($getTotalPurchase as $value) {
                            $total += $value->total_purchase;
                        }
                        break;
                    case 'merchant':
                        $getTotalPurchase = DB::table('orders_details')
                            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                            ->selectRaw('orders_details.quantity * (products.product_price-(products.product_price-(products.price_hq + products.price_shogun + products.price_damio))) AS total_purchase')
                            ->where('orders.created_at', '>=', $year . $month . '01')
                            ->where('orders.created_at', '<=', $year . $month . '31')
                            ->where('orders.user_id', $user->id)
                            ->get();

                        foreach ($getTotalPurchase as $value) {
                            $total += $value->total_purchase;
                        }
                        break;
                    case 'dropship':
                        $getTotalPurchase = DB::table('orders_details')
                            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                            ->selectRaw('orders_details.quantity * (products.product_price-(products.product_price-(products.price_hq + products.price_shogun + products.price_damio + products.price_merchant ))) AS total_purchase')
                            ->where('orders.created_at', '>=', $year . $month . '01')
                            ->where('orders.created_at', '<=', $year . $month . '31')
                            ->where('orders.user_id', $user->id)
                            ->get();

                        foreach ($getTotalPurchase as $value) {
                            $total += $value->total_purchase;
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        //totalPurchase own
        $getTotalPurchase = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
            ->selectRaw('orders_details.quantity * (products.price_hq) AS total_purchase')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('orders.user_id', Auth::user()->id)
            ->get();

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

        $total = 0;
        $allDownline = $this->getDownline();

        //totalPurchase all agent
        foreach ($allDownline as $dl) {
            $getRole = DB::table('users')
                ->where('id', $dl)
                ->get();

            // dd($sales);
            foreach ($getRole as $user) {
                $getTotalSales = DB::table('orders_details')
                    ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                    ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                    ->selectRaw('orders_details.quantity * products.product_price AS total_sales')
                    ->where('orders.created_at', '>=', $year . $month . '01')
                    ->where('orders.created_at', '<=', $year . $month . '31')
                    ->where('orders.user_id', $user->id)
                    ->get();

                foreach ($getTotalSales as $value) {
                    $total += $value->total_sales;
                }
            }
        }

        $getTotalSales = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
            ->selectRaw('orders_details.quantity * products.product_price AS total_sales')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('orders.user_id', Auth::user()->id)
            ->get();

        
        foreach ($getTotalSales as $value) {
            $total += $value->total_sales;
        }

        return $total;
    }

    public function getOwnTotalPurchase()
    {
        //get the date
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        $total = 0;
       
        //totalPurchase own
        $getTotalPurchase = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
            ->selectRaw('orders_details.quantity * (products.price_hq) AS total_purchase')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('orders.user_id', Auth::user()->id)
            ->get();

        foreach ($getTotalPurchase as $value) {
            $total += $value->total_purchase;
        }

        return $total;
    }

    public function getOwnTotalSales()
    {
        //get the date
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        $total = 0;

        $getTotalSales = DB::table('orders_details')
            ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
            ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
            ->selectRaw('orders_details.quantity * products.product_price AS total_sales')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('orders.user_id', Auth::user()->id)
            ->get();

        
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
        $allDownline = $this->getDownline();

        foreach ($month as $mth) {

            $total = 0;
            //totalPurchase all agent
            foreach ($allDownline as $dl) {
                $getRole = DB::table('users')
                    ->where('id', $dl)
                    ->get();
                
                // dd($sales);
                foreach ($getRole as $user) {
                    $getTotalSales = DB::table('orders_details')
                        ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                        ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                        ->selectRaw('orders_details.quantity * products.product_price AS total_sales')
                        ->where('orders.created_at', '>=', $year . $mth . '01')
                        ->where('orders.created_at', '<=', $year . $mth . '31')
                        ->where('orders.user_id', $user->id)
                        ->get();
                        
                    
                    foreach ($getTotalSales as $value) {
                        $total += $value->total_sales;
                    }
                }
            }
            
            $getTotalSales = DB::table('orders_details')
                ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                ->selectRaw('orders_details.quantity * products.product_price AS total_sales')
                ->where('orders.created_at', '>=', $year . $mth . '01')
                ->where('orders.created_at', '<=', $year . $mth . '31')
                ->where('orders.user_id', Auth::user()->id)
                ->get();

            
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
        $allDownline = $this->getDownline();

        foreach ($month as $mth) {
            $total = 0;
            foreach ($allDownline as $dl) {
                $getRole = DB::table('users')
                    ->where('id', $dl)
                    ->get();

                // dd($sales);
                foreach ($getRole as $user) {
                    switch ($user->role) {
                        case 'damio':
                            $getTotalPurchase = DB::table('orders_details')
                                ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                                ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                                ->selectRaw('orders_details.quantity * (products.product_price-(products.product_price-(products.price_hq + products.price_shogun))) AS total_purchase')
                                ->where('orders.created_at', '>=', $year . $mth . '01')
                                ->where('orders.created_at', '<=', $year . $mth . '31')
                                ->where('orders.user_id', $user->id)
                                ->get();

                            foreach ($getTotalPurchase as $value) {
                                $total += $value->total_purchase;
                            }
                            break;
                        case 'merchant':
                            $getTotalPurchase = DB::table('orders_details')
                                ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                                ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                                ->selectRaw('orders_details.quantity * (products.product_price-(products.product_price-(products.price_hq + products.price_shogun + products.price_damio))) AS total_purchase')
                                ->where('orders.created_at', '>=', $year . $mth . '01')
                                ->where('orders.created_at', '<=', $year . $mth . '31')
                                ->where('orders.user_id', $user->id)
                                ->get();

                            foreach ($getTotalPurchase as $value) {
                                $total += $value->total_purchase;
                            }
                            break;
                        case 'dropship':
                            $getTotalPurchase = DB::table('orders_details')
                                ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                                ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                                ->selectRaw('orders_details.quantity * (products.product_price-(products.product_price-(products.price_hq + products.price_shogun + products.price_damio + products.price_merchant ))) AS total_purchase')
                                ->where('orders.created_at', '>=', $year . $mth . '01')
                                ->where('orders.created_at', '<=', $year . $mth . '31')
                                ->where('orders.user_id', $user->id)
                                ->get();

                            foreach ($getTotalPurchase as $value) {
                                $total += $value->total_purchase;
                            }
                            break;
                        default:
                            break;
                    }
                }
            }

            //totalPurchase own
            $getTotalPurchase = DB::table('orders_details')
                ->JOIN('products', 'orders_details.product_id', '=', 'products.id')
                ->JOIN('orders', 'orders_details.referenceNo', '=', 'orders.orders_id')
                ->selectRaw('orders_details.quantity * (products.price_hq) AS total_purchase')
                ->where('orders.created_at', '>=', $year . $mth . '01')
                ->where('orders.created_at', '<=', $year . $mth . '31')
                ->where('orders.user_id', Auth::user()->id)
                ->get();

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
