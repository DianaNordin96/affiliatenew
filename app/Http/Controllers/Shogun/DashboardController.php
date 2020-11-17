<?php

namespace App\Http\Controllers\Shogun;

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

        //getAllDownline
        $allDownline = array();
        $statusLoop = true;
        $id = Auth::user()->id;
        $downlineList = array(2,10);
        $statusForLoop = array();

        // dd($allDownline);

        //get downline 

        while ($statusLoop) {
            $statusForLoop = array();
            foreach ($downlineList as $value) {

                $userDownlineL1 = DB::table('users')
                    ->where('downlineTo', $value)
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
                $key = array_search($value,$downlineList);
                unset($downlineList[$key]);
            }

            if (in_array('true',$statusForLoop,true)){
                $statusLoop =true;
            }else{
                $statusLoop =false;
            }
            
        }
        // dd($allDownline);


        return view('shogun/dashboardShogun')->with([
            'totalSale' => $totalSale,
            'downline' => count($allDownline),
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
