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

        $validator = Validator::make($req->all(),$validatedData);
		if ($validator->fails()) {
            toast('Please fill in all the box before creating new user','error');
			return redirect('/manageAgent');
			}else{
            $data = $req->input();
            try{
				$user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
				$user->phone = $data['phone'];
                $user->address = $data['address'];
                $user->password = Hash::make('12345678');
                $user->role = 'shogun';
                $user->save();
                toast('User has been created','success');
				return redirect('/manageAgent');
			}
			catch(Exception $e){
				return redirect('insert')->with('failed',"operation failed");
            }
        }
    }

}
//         if ($validatedData) {
//             $name = $req->input('name');
//             $email = $req->input('email');
//             $address = $req->input('address');
//             $phone = $req->input('phone');

//             return User::create([
//                 'name' => $name,
//                 'email' => $email,
//                 'password' => Hash::make('12345678'),
//                 'address' => $address,
//                 'phone' => $phone,
//                 'role' => 'admin'
//             ]);

//             $user = new User();

//             $user -> $name;
//             $

//             Alert::success('Success Title', 'Success Message');
//             return redirect('/manageAgent')->with('success', 'Data inserted');
//         } else {
            
//             Alert::success('Success Title', 'Success Message');
//             return view('admin/manageAgent');
//         }
//     }

//     public function edit()
//     {
//     }

//     public function __construct()
//     {
//         $this->middleware('auth');
//     }
// }
