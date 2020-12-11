<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //get the date
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        //total downline
        $numberDownline = DB::table('users')
            ->where('belongsToAdmin', '=', Auth::user()->id)
            ->where(function($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline','!=', 'decline');
            })
            ->where(function($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline','!=', 'pending');
            })
            ->get();
        $countDownline = count($numberDownline);

        //totalSales this month
        $totalSales = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $shogun = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', 'shogun')
            ->select('amount')
            ->sum('amount');


        //total sales downline today
        $damio = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', 'damio')
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $merchant = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', 'merchant')
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $dropship = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', 'dropship')
            ->select('amount')
            ->sum('amount');

        return view('admin/dashboard')->with([
            'downline' => $countDownline,
            'shogunSales' => $shogun,
            'damioSales' => $damio,
            'merchantSales' => $merchant,
            'dropshipSales' => $dropship,
            'totalSale' => $totalSales
        ]);
    }
}
