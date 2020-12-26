<?php

namespace App\Http\Controllers\Damio;

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

        return view('damio/commission')->with([
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
            toast('Please fill in all the box before submitting your page', 'error');
            return redirect('/commission-damio');
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
                return redirect('/commission-damio')->with('error','The amount you requested is not accepted.');
            }

            if ($checkRequest = 0){
                return redirect('/commission-damio')->with('error','You still have pending requests. Try again once your requests has been taken into actions. ');
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

            toast('Your request has been submitted.', 'success');
            return redirect('/commission-damio');
        }
    }
}
