<?php

namespace App\Http\Controllers\Damio;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        //get this month and year
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        //count number downline
        $numberDownline = DB::table('users')
            ->where('downlineTo', '=', Auth::user()->id)
            ->get();
        $countDownline = count($numberDownline);

        //totalSale all agent
        $totalSale = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('orders.user_id', Auth::user()->id)
            ->orWhere('users.downlineTo', '=', Auth::user()->id)
            ->select('amount')
            ->sum('amount');

        //own sale
        $own =  DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('orders.user_id', Auth::user()->id)
            ->select('amount')
            ->sum('amount');


        //totalSale all agent
        $damio = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.role', 'damio')
            ->where('users.downlineTo', '=', Auth::user()->id)
            ->select('amount')
            ->sum('amount');

        $merchant = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.role', 'merchant')
            ->where('users.downlineTo', '=', Auth::user()->id)
            ->select('amount')
            ->sum('amount');

        $dropship = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('users.role', 'dropship')
            ->where('users.downlineTo', '=', Auth::user()->id)
            ->select('amount')
            ->sum('amount');

        return view('damio/dashboard')->with([
            'totalSale' => $totalSale,
            'downline' => $countDownline,
            'damio' => $damio,
            'merchant' => $merchant,
            'dropship' => $dropship,
            'own' => $own
        ]);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
