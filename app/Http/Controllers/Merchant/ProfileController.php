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
            return redirect('/profile-merchant');
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
                return redirect('/profile-merchant');
            } catch (Exception $e) {
                toast('Something went wrong', 'error');
                return redirect('/profile-merchant');
            }
        }
    }

    public function changePassword(Request $req)
    {
        $validatedData = [
            'password1' => 'required|min:8',
            'password2' => 'required|min:8',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please check your password again', 'error');
            return redirect()->back();
        } else {
            $data = $req->input();
            try {
                if ($req->password1 == $req->password2) {
                    DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->update([
                            'password' => Hash::make($req->password1),
                        ]);

                    toast('Your password has been updated', 'success');
                    return redirect('/profile-merchant');
                } else {
                    toast('Your created password do not match. Please enter again.', 'error');
                    return redirect()->back();
                }
            } catch (Exception $e) {
                toast('Something went wrong', 'error');
                return redirect('/profile-merchant');
            }
        }
    }

}
