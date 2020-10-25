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
        //total downline
        $numberDownline = DB::table('users')
            ->where('belongsToAdmin', '=', Auth::user()->id)
            ->get();
        $countDownline = count($numberDownline);

        //total sales downline today
        $allSales = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            // ->where('orders.created_at', 'LIKE', '%' . date("Y-m-d") . '%')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $shogun = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', 'LIKE', '%' . date("Y-m-d") . '%')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', '=', 'shogun')
            ->select('amount')
            ->sum('amount');


        //total sales downline today
        $damio = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', 'LIKE', '%' . date("Y-m-d") . '%')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', '=', 'damio')
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $merchant = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', 'LIKE', '%' . date("Y-m-d") . '%')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', '=', 'merchant')
            ->select('amount')
            ->sum('amount');

        //total sales downline today
        $dropship = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', 'LIKE', '%' . date("Y-m-d") . '%')
            ->where('users.belongsToAdmin', '=', Auth::user()->id)
            ->where('users.role', '=', 'dropship')
            ->select('amount')
            ->sum('amount');

        return view('admin/dashboard')->with([
            'downline' => $countDownline,
            'shogunSales' => $shogun,
            'damioSales' => $damio,
            'merchantSales' => $merchant,
            'dropshipSales' => $dropship,
            'allSales' => $allSales
        ]);
    }
}
