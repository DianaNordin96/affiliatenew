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
        $users = DB::table('users')->get();

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
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new user', 'error');
            return redirect('/manageAgent');
        } else {
            $data = $req->input();
            try {
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->phone = $data['phone'];
                $user->address = $data['address'];
                $user->password = Hash::make('12345678');
                $user->role = 'shogun';
                $user->save();
                toast('User has been created', 'success');
                return redirect('/manageAgent');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function update(Request $req)
    {
        $validatedData = [
            'idEdit' => '',
            'nameEdit' => 'required',
            'emailEdit' => 'required|email',
            'addressEdit' => 'required',
            'phoneEdit' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please dont leave any boxes empty', 'error');
            return redirect('/manageAgent');
        } else {
            $data = $req->input();
            try {
                DB::table('users')
                    ->where('id', $data['idEdit'])
                    ->update([
                        'name' => $data['nameEdit'],
                        'email' => $data['emailEdit'],
                        'phone' => $data['phoneEdit'],
                        'address' => $data['addressEdit'],
                    ]);

                toast('User has been updated', 'success');
                return redirect('/manageAgent');
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

    public function __construct()
    {
        $this->middleware('auth');
    }
}
