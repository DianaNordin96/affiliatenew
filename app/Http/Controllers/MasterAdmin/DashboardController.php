<?php

namespace App\Http\Controllers\MasterAdmin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        //totalSales this month
        $totalSales = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereDate('orders.created_at', '>=', $year . '-' . $month . '-01')
            ->whereDate('orders.created_at', '<=', $year . '-' . $month . '-31')
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $shogun = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereDate('orders.created_at', '>=', $year . '-' . $month . '-01')
            ->whereDate('orders.created_at', '<=', $year . '-' . $month . '-31')
            ->where('users.role', 'shogun')
            ->select('amount')
            ->sum('amount');


        //total sales downline today
        $damio = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereDate('orders.created_at', '>=', $year . '-' . $month . '-01')
            ->whereDate('orders.created_at', '<=', $year . '-' . $month . '-31')
            ->where('users.role', 'damio')
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $merchant = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereDate('orders.created_at', '>=', $year . '-' . $month . '-01')
            ->whereDate('orders.created_at', '<=', $year . '-' . $month . '-31')
            ->where('users.role', 'merchant')
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $dropship = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereDate('orders.created_at', '>=', $year . '-' . $month . '-01')
            ->whereDate('orders.created_at', '<=', $year . '-' . $month . '-31')
            ->where('users.role', 'dropship')
            ->select('amount')
            ->sum('amount');

        $totalAgent = DB::table('users')
            ->where('id', '<>', Auth::user()->id)
            ->where(function ($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline', '!=', 'decline');
            })
            ->where(function ($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline', '!=', 'pending');
            })
            ->where(function ($query) {
                $query->where('role', '<>', 'admin')
                    ->where('role', '<>', 'masteradmin');
            })
            ->get();

        return view('masteradmin/dashboard')->with([
            'shogunSales' => $shogun,
            'damioSales' => $damio,
            'merchantSales' => $merchant,
            'dropshipSales' => $dropship,
            'totalSales' => $totalSales,
            'totalAgent' => count($totalAgent)
        ]);
    }
}
