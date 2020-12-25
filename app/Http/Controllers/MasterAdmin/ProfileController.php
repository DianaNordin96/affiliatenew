<?php

namespace App\Http\Controllers\MasterAdmin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('masteradmin/profile');
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
            return redirect('/profile-masteradmin')->with('error','Please dont leave any boxes empty');
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
                return redirect('/profile-masteradmin')->with('success','User has been updated');
            } catch (Exception $e) {
                toast('Something went wrong', 'error');
                return redirect('/profile-masteradmin');
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
            return redirect('/profile-masteradmin')->with('error','Please check your password again');
        } else {
            $data = $req->input();
            try {
                if ($req->password1 == $req->password2) {
                    DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->update([
                            'password' => Hash::make($req->password1),
                        ]);

                    return redirect('/profile-masteradmin')->with('success','Your password has been updated');
                } else {
                    
                    return redirect()->back()->with( 'error','Your created password do not match. Please enter again.');
                }
            } catch (Exception $e) {
                return redirect('/profile-masteradmin');
            }
        }
    }
}
