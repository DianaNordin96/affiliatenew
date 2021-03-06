<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
            ->where(function ($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline', '!=', 'decline');
            })
            ->where(function ($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline', '!=', 'pending');
            })
            ->where(function ($query) {
                $query->where('role', '<>', 'admin')
                    ->where('role', '<>', 'masteradmin');
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
            'image' => 'image|mimes:jpeg,png,jpg'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            $notification = array(
                'message' => 'Please ensure all fields were filled and file uploaded is image files.',
                'alert-type' => 'error'
            );

            return redirect('/manageAgent')->with($notification);
        } else {
            $data = $req->input();
            try {

                //check IC and email exist 
                $icStatus = DB::table('users')
                    ->where('icnumber', $data['ic'])
                    ->orWhere('email', $data['email'])
                    ->get();

                $countIC = count($icStatus);
                if ($countIC == 0) {
                    if ($req->file('image') != null) {

                        $image = $req->file('image');
                        $newFileName = $image->getClientOriginalName();
                        $filename = pathinfo($newFileName, PATHINFO_FILENAME);
                        $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                        if (file_exists(base_path('../../public_html/imageUploaded/profile/' . $image->getClientOriginalName() . ''))) {
                            $newFileName = $filename . '1' . '.' . $extension;
                            $image->move(base_path('../../public_html/imageUploaded/profile'), $newFileName);
                        } else {
                            $image->move(base_path('../../public_html/imageUploaded/profile'), $image->getClientOriginalName());
                        }

                        $user = new User;
                        $user->name = $data['name'];
                        $user->email = $data['email'];
                        $user->phone = $data['phone'];
                        $user->address = $data['address'];
                        $user->password = Hash::make('12345678');
                        $user->image = $newFileName;
                        $user->icnumber = $data['ic'];
                        $user->dob = $data['dob'];
                        $user->downlineTo = null;
                        $user->commissionPoint = 0;
                        $user->belongsToAdmin = Auth::user()->admin_category;
                        $user->role = 'shogun';
                        $user->save();

                        $notification = array(
                            'message' => 'Agent has been created',
                            'alert-type' => 'success'
                        );

                        return redirect('/manageAgent')->with($notification);
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

                        $notification = array(
                            'message' => 'Agent has been created',
                            'alert-type' => 'success'
                        );

                        return redirect('/manageAgent')->with($notification);
                    }
                } else {

                    $notification = array(
                        'message' => 'User with the same IC number/email has existed in the system',
                        'alert-type' => 'error'
                    );

                    return redirect('/manageAgent')->with($notification);
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
            'imageEdit' => 'image|mimes:jpeg,png,jpg'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {

            $notification = array(
                'message' => 'Please ensure all fields were filled and file uploaded is image files.',
                'alert-type' => 'error'
            );

            return redirect('/manageAgent')->with($notification);
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

                    $notification = array(
                        'message' => 'Agent has been updated',
                        'alert-type' => 'success'
                    );

                    return redirect('/manageAgent')->with($notification);
                } else if ($req->file('imageEdit') != null) {

                    $image = $req->file('imageEdit');
                    $newFileName = $image->getClientOriginalName();
                    $filename = pathinfo($newFileName, PATHINFO_FILENAME);
                    $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                    if (file_exists(base_path('../public_html/imageUploaded/profile/' . $image->getClientOriginalName() . ''))) {
                        $newFileName = $filename . '1' . '.' . $extension;
                        $image->move(base_path('../public_html/imageUploaded/profile'), $newFileName);
                    } else {
                        $image->move(base_path('../public_html/imageUploaded/profile'), $image->getClientOriginalName());
                    }

                    DB::table('users')
                        ->where('id', $data['userID'])
                        ->update([
                            'name' => $data['nameEdit'],
                            'email' => $data['emailEdit'],
                            'phone' => $data['phoneEdit'],
                            'address' => $data['addressEdit'],
                            'image' => $newFileName,
                            'dob' => $data['dobEdit'],
                            'icnumber' => $data['icEdit']
                        ]);

                    $notification = array(
                        'message' => 'Agent has been updated',
                        'alert-type' => 'success'
                    );

                    return redirect('/manageAgent')->with($notification);
                }
            } catch (Exception $e) {
                $notification = array(
                    'message' => 'Something went wrong.',
                    'alert-type' => 'error'
                );
                return redirect('/manageAgent')->with($notification);
            }
        }
    }

    public function changeRole($roles, $id)
    {
        $getRole = DB::table('users')->where('id', $id)->select('role')->get();

        if ($getRole[0]->role == 'shogun') {
            switch ($roles) {
                case 'damio':
                    return redirect('/manageAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                case 'merchant':
                    return redirect('/manageAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                case 'dropship':
                    return redirect('/manageAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                default:
                    break;
            }
        }

        if ($getRole[0]->role == 'damio') {
            switch ($roles) {
                case 'shogun':
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'role' => $roles,
                            'downlineTo' => null
                        ]);
                    return redirect('/manageAgent')->with('success', 'Agent role has been changed.');
                    break;
                case 'merchant':
                    return redirect('/manageAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                case 'dropship':
                    return redirect('/manageAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                default:
                    break;
            }
        }

        if ($getRole[0]->role == 'merchant') {

            $higherLevelID = 0;

            switch ($roles) {
                case 'shogun':
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'role' => $roles,
                            'downlineTo' => null
                        ]);
                    return redirect('/manageAgent')->with('success', 'Agent role has been changed.');
                    break;
                case 'damio':
                    $status = true;
                    // $statusCheck = false;
                    $ids = $id;

                    while ($status) {
                        $check = DB::table('users')
                            ->where('id', $ids)
                            ->get();
                        // dd($check);
                        foreach ($check as $checking) {
                            if ($checking->id != '') {
                                $ids = $checking->downlineTo;
                                $role = $checking->role;

                                if ($role == 'shogun') {
                                    $higherLevelID = $checking->id;
                                }

                                if ($checking->downlineTo == null) {
                                    $status = false;
                                }
                            }
                        }
                    }
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'role' => $roles,
                            'downlineTo' => $higherLevelID
                        ]);
                    return redirect('/manageAgent')->with('success', 'Agent role has been changed.');
                    break;
                case 'dropship':
                    return redirect('/manageAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;

                default:
                    break;
            }
        }


        if ($getRole[0]->role == 'dropship') {
            $higherLevelID = 0;

            switch ($roles) {
                case 'shogun':
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'role' => $roles,
                            'downlineTo' => null
                        ]);
                    return redirect('/manageAgent')->with('success', 'Agent role has been changed.');
                    break;
                case 'damio':
                    $status = true;
                    // $statusCheck = false;
                    $ids = $id;

                    while ($status) {
                        $check = DB::table('users')
                            ->where('id', $ids)
                            ->get();
                        // dd($check);
                        foreach ($check as $checking) {
                            if ($checking->id != '') {
                                $ids = $checking->downlineTo;
                                $role = $checking->role;

                                if ($role == 'shogun') {
                                    $higherLevelID = $checking->id;
                                }

                                if ($checking->downlineTo == null) {
                                    $status = false;
                                }
                            }
                        }
                    }
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'role' => $roles,
                            'downlineTo' => $higherLevelID
                        ]);
                    return redirect('/manageAgent')->with('success', 'Agent role has been changed.');
                    break;
                case 'merchant':
                    $status = true;
                    // $statusCheck = false;
                    $ids = $id;

                    while ($status) {
                        $check = DB::table('users')
                            ->where('id', $ids)
                            ->get();
                        // dd($check);
                        foreach ($check as $checking) {
                            if ($checking->id != '') {
                                $ids = $checking->downlineTo;
                                $role = $checking->role;

                                if ($role == 'shogun') {
                                    $higherLevelID = $checking->id;
                                }

                                if ($checking->downlineTo == null) {
                                    $status = false;
                                }
                            }
                        }
                    }
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'role' => $roles,
                            'downlineTo' => $higherLevelID
                        ]);
                    return redirect('/manageAgent')->with('success', 'Agent role has been changed.');
                    break;

                default:
                    break;
            }
        }

        if ($getRole[0]->role == '') {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'role' => $roles
                ]);
            return redirect('/manageAgent')->with('success', 'Agent role has been set.');
        }
    }

    public function delete($id)
    {
        DB::table('users')
            ->delete($id);


        $notification = array(
            'message' => 'Agent has been removed!',
            'alert-type' => 'success'
        );

        return redirect('/manageAgent')->with($notification);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
