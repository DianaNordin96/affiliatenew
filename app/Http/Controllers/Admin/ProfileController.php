<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
       
        return view('admin/profile');
    }

    public function update(Request $req)
    {

        $validatedData = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
            'ic' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
           
            return redirect('/profile-admin')->with('error','Please dont leave any boxes empty');
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
                        'icnumber' => $data['ic'],
                    ]);
                
                return redirect('/profile-admin')->with('success','User has been updated');
            } catch (Exception $e) {
                
                return redirect('/profile-admin')->with('error','Something went wrong');
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
            
            return redirect()->back()->with('error','Please check your password again');
        } else {
            $data = $req->input();
            try {
                if ($req->password1 == $req->password2) {
                    DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->update([
                            'password' => Hash::make($req->password1),
                        ]);

                    return redirect('/profile-admin')->with('error','Your password has been updated');
                } else {
                    return redirect()->back()->with('error','Your created password do not match. Please enter again.');
                }
            } catch (Exception $e) {
                return redirect('/profile-admin')->with('error','Something went wrong');
            }
        }
    }

}
