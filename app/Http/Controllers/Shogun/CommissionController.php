<?php

namespace App\Http\Controllers\Shogun;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{
    public function index()
    {
        $commission = DB::table('users')
            ->where('id', Auth::user()->id)
            ->get();

        $commissionList = DB::table('commission')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('shogun/commission')->with([
            'commissionPoint' => $commission,
            'commissionList' => $commissionList
        ]);
    }

    public function withdraw(Request $req)
    {

        $validatedData = [
            'amount' => 'required',
            'bank' => 'required',
            'accountNo' => 'required'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            
            return redirect('/commission-shogun')->with('error','Please fill in all the box before submitting your page');
        } else {
            $data = $req->input();

            $checkBalance = DB::table('users')->select('commissionPoint')->where('id',Auth::user()->id)->get();
            $checkRequest = DB::table('commission')
                ->where('user_id', Auth::user()->id)
                ->where(function ($query) {
                    $query->where('status', '=', 'pending');
                })
                ->get();
            
            if ($checkBalance[0]->commissionPoint <= $data['amount']){
                return redirect('/commission-shogun')->with('error','The amount you requested is not accepted.');
            }

            if ($checkRequest = 0){
                return redirect('/commission-shogun')->with('error','You still have pending requests. Try again once your requests has been taken into actions. ');
            }


            DB::table('commission')
                ->insert([
                    'bank' => $data['bank'],
                    'accountNo' => $data['accountNo'],
                    'status' => 'pending',
                    'created_at' => NOW(),
                    'amountRequest' => $data['amount'],
                    'user_id' => Auth::user()->id
                ]);

            return redirect('/commission-shogun')->with('success','Your request has been submitted.');
        }
    }
}
