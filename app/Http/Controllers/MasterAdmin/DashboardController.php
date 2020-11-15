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
        $totalSale = DB::table('orders')
            ->select('amount')
            ->sum('amount');

        return view('masteradmin/dashboard')->with([
            'totalSales' => $totalSale
        ]);
    }
}
