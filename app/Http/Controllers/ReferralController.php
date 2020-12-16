<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReferralController extends Controller
{
    public function index($id)
    {
        return view('referral/register')->with([
            'userID' => $id
        ]);
    }

    public function create(Request $req)
    {
        $validatedData = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'ic' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            return redirect()->back()->with('failed', "Please fill in all the box");
        } else {
            $data = $req->input();
            try {
                //check IC exist
                $icStatus = DB::table('users')->where('icnumber', $data['ic'])->get();

                $countIC = count($icStatus);
                if ($countIC == 0) {
                    $user = new User;
                    $user->name = $data['name'];
                    $user->email = $data['email'];
                    $user->phone = $data['phone'];
                    $user->address = $data['address'];
                    $user->image = $req->file('image')->getClientOriginalName();
                    $user->password = null;
                    $user->icnumber = $data['ic'];
                    $user->dob = $data['dob'];
                    $user->downlineTo = $data['id'];
                    $user->belongsToAdmin = null;
                    $user->role = null;
                    $user->statusDownline = 'pending';
                    $user->save();

                    $image = $req->file('image');

                    $image->move(base_path('../public_html/imageUploaded/profile'), $image->getClientOriginalName());
                    
                    return view('referral/info')->with([
                        'message' => "You have been successfully registered. The approval of your account will took 2-3 days of working days"
                    ]);
                } else {
                    return redirect()->back()->with('failed', "Your IC number has been registered to one of the agents.");
                }
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function info()
    {
    }
}
