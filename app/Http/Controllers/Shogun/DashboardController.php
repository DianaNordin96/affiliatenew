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
                    ->where(function($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline','!=', 'decline');
                    })
                    ->where(function($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline','!=', 'pending');
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

        //get this month and year
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $month = date('m');
        $year = date('Y');

        
        $damio = 0;
        $merchant = 0;
        $dropship = 0;

        //totalSale all agent
        foreach ($allDownline as $dl) {
            $sales = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('orders.created_at', '>=', $year . $month . '01')
                ->where('orders.created_at', '<=', $year . $month . '31')
                ->where('orders.user_id', '=', $dl)
                ->get();
            // dd($sales);
            foreach ($sales as $sale) {
                switch ($sale->role) {
                    case 'damio':
                        $damio = $damio + $sale->amount;
                        break;
                    case 'merchant':
                        $merchant = $merchant + $sale->amount;
                        break;
                    case 'dropship':
                        $dropship = $dropship + $sale->amount;
                        break;
                    default:
                        break;
                }
            }
        }

        //own sale
        $own =  DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $year . $month . '01')
            ->where('orders.created_at', '<=', $year . $month . '31')
            ->where('orders.user_id', Auth::user()->id)
            ->select('amount')
            ->sum('amount');
        
        $totalSale = $own + $damio + $merchant + $dropship;


        //totalSale all agent
        // $damio = DB::table('orders')
        //     ->join('users', 'orders.user_id', '=', 'users.id')
        //     ->where('orders.created_at', '>=', $year . $month . '01')
        //     ->where('orders.created_at', '<=', $year . $month . '31')
        //     ->where('users.role', 'damio')
        //     ->where('users.downlineTo', '=', Auth::user()->id)
        //     ->select('amount')
        //     ->sum('amount');

        // $merchant = DB::table('orders')
        //     ->join('users', 'orders.user_id', '=', 'users.id')
        //     ->where('orders.created_at', '>=', $year . $month . '01')
        //     ->where('orders.created_at', '<=', $year . $month . '31')
        //     ->where('users.role', 'merchant')
        //     ->where('users.downlineTo', '=', Auth::user()->id)
        //     ->select('amount')
        //     ->sum('amount');

        // $dropship = DB::table('orders')
        //     ->join('users', 'orders.user_id', '=', 'users.id')
        //     ->where('orders.created_at', '>=', $year . $month . '01')
        //     ->where('orders.created_at', '<=', $year . $month . '31')
        //     ->where('users.role', 'dropship')
        //     ->where('users.downlineTo', '=', Auth::user()->id)
        //     ->select('amount')
        //     ->sum('amount');

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
