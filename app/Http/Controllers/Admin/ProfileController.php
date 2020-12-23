<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin/profile');
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
            $notification = array(
                'message' => 'Please dont leave any boxes empty',
                'alert-type' => 'error'
            );
            return redirect('/profile-admin')->with($notification);
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

                $notification = array(
                    'message' => 'User has been updated',
                    'alert-type' => 'success'
                );
                return redirect('/profile-admin')->with($notification);
            } catch (Exception $e) {
                $notification = array(
                    'message' => 'Something went wrong',
                    'alert-type' => 'error'
                );
                return redirect('/profile-admin')->with($notification);
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
            $notification = array(
                'message' => 'Please check your password again',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $data = $req->input();
            try {
                if ($req->password1 == $req->password2) {
                    DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->update([
                            'password' => Hash::make($req->password1),
                        ]);

                    $notification = array(
                        'message' => 'Your password has been updated',
                        'alert-type' => 'success'
                    );
                    return redirect('/profile-admin') > with($notification);
                } else {
                    $notification = array(
                        'message' => 'Your created password do not match. Please enter again.',
                        'alert-type' => 'error'
                    );
                    return redirect()->back() > with($notification);
                }
            } catch (Exception $e) {
                $notification = array(
                    'message' => 'Something went wrong',
                    'alert-type' => 'error'
                );
                return redirect('/profile-admin') > with($notification);
            }
        }
    }
}
