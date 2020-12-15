<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

// Use Alert;

class ManageAgentController extends Controller
{

    public function index()
    {
        $users = DB::table('users')
            ->where('id', '<>', Auth::user()->id)
            ->where('belongsToAdmin', Auth::user()->admin_category)
            ->where(function ($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline', '!=', 'decline');
            })
            ->where(function ($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline', '!=', 'pending');
            })
            ->get();

        $id = Auth::user()->id;
        $email = Auth::user()->email;
        $pass = Auth::user()->password;
        // dd($id,$email,$pass);
        // return view('dashboard',
        //     'user' => $id,
        // ]);

        return view(
            'admin/manageAgent',
            [
                'userId' => $id,
                'users' => $users
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return \App\User
     */
    public function create(Request $req)
    {
        $validatedData = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'ic' => 'required',
            'image' => '',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new user', 'error');
            return redirect('/manageAgent');
        } else {
            $data = $req->input();
            try {

                //check IC exist
                $icStatus = DB::table('users')->where('icnumber', $data['ic'])->get();

                $countIC = count($icStatus);
                if ($countIC == 0){
                    if ($req->file('image') != null) {
                        $user = new User;
                        $user->name = $data['name'];
                        $user->email = $data['email'];
                        $user->phone = $data['phone'];
                        $user->address = $data['address'];
                        $user->password = Hash::make('12345678');
                        $user->image = $req->file('image')->getClientOriginalName();
                        $user->icnumber = $data['ic'];
                        $user->dob = $data['dob'];
                        $user->downlineTo = null;
                        $user->commissionPoint = 0;
                        $user->belongsToAdmin = Auth::user()->admin_category;
                        $user->role = 'shogun';
                        $user->save();

                        $image = $req->file('image');

                        $image->move(base_path('../public_html/imageUploaded/profile'), $image->getClientOriginalName());

                        toast('User has been created', 'success');
                        return redirect('/manageAgent');
                    } else {
                        $user = new User;
                        $user->name = $data['name'];
                        $user->email = $data['email'];
                        $user->phone = $data['phone'];
                        $user->address = $data['address'];
                        $user->password = Hash::make('12345678');
                        $user->image = null;
                        $user->icnumber = $data['ic'];
                        $user->dob = $data['dob'];
                        $user->downlineTo = null;
                        $user->belongsToAdmin = Auth::user()->admin_category;
                        $user->role = 'shogun';
                        $user->save();

                        toast('User has been created', 'success');
                        return redirect('/manageAgent');
                    }
                }
                else {
                    toast('User with the same IC number has existed in the system.', 'error');
                    return redirect('/manageAgent');
                }
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function update(Request $req)
    {
        $validatedData = [
            'userID' => '',
            'nameEdit' => 'required',
            'emailEdit' => 'required|email',
            'addressEdit' => 'required',
            'phoneEdit' => 'required',
            'icEdit' => 'required',
            'dobEdit' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please dont leave any boxes empty', 'error');
            return redirect('/manageAgent');
        } else {
            $data = $req->input();
            try {
                if ($req->file('imageEdit') == null) {
                    DB::table('users')
                        ->where('id', $data['userID'])
                        ->update([
                            'name' => $data['nameEdit'],
                            'email' => $data['emailEdit'],
                            'phone' => $data['phoneEdit'],
                            'address' => $data['addressEdit'],
                            'dob' => $data['dobEdit'],
                            'icnumber' => $data['icEdit']
                        ]);

                    toast('Agent has been updated', 'success');
                    return redirect('/manageAgent');
                } else if ($req->file('imageEdit') != null) {
                    DB::table('users')
                        ->where('id', $data['userID'])
                        ->update([
                            'name' => $data['nameEdit'],
                            'email' => $data['emailEdit'],
                            'phone' => $data['phoneEdit'],
                            'address' => $data['addressEdit'],
                            'image' => $req->file('imageEdit')->getClientOriginalName(),
                            'dob' => $data['dobEdit'],
                            'icnumber' => $data['icEdit']
                        ]);

                    $image = $req->file('imageEdit');

                    $image->move(base_path('../public_html/imageUploaded/profile'), $image->getClientOriginalName());

                    toast('Agent has been updated', 'success');
                    return redirect('/manageAgent');
                }
            } catch (Exception $e) {
                toast('Something went wrong', 'error');
                return redirect('/manageAgent');
            }
        }
    }

    public function changeRole($role, $id)
    {

        DB::table('users')
            ->where('id', $id)
            ->update([
                'role' => $role
            ]);

        toast('User role has been changed', 'success');
        return redirect('/manageAgent');
    }

    public function delete($id)
    {
        DB::table('users')
            ->delete($id);

        toast('Agent has been removed', 'success');
        return redirect('/manageAgent');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
