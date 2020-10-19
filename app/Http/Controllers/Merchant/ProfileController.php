<?php

namespace App\Http\Controllers\Merchant;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public function index()
    {
       
        return view('merchant/profile');
    }

    public function update(Request $req)
    {

        $validatedData = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please dont leave any boxes empty', 'error');
            return redirect('/profileMerchant');
        } else {
            $data = $req->input();
            try {
                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'address' => $data['address'],
                    ]);

                toast('User has been updated', 'success');
                return redirect('/profileMerchant');
            } catch (Exception $e) {
                toast('Something went wrong', 'error');
                return redirect('/profileMerchant');
            }
        }
    }
}
