<?php

namespace App\Http\Controllers\MasterAdmin;

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


class ManageAgentController extends Controller
{
    public function index()
    {
        $agentList = DB::table('users')
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

        return view('masteradmin/agents')->with([
            'agentList' => $agentList
        ]);
    }

    public function viewAgentProfile($id)
    {

        $getUser = DB::table('users')->where('id', $id)->get();

        return view('masteradmin/viewAgent')->with([
            'users' => $getUser,
            'name' => $getUser[0]->name
        ]);
    }

    public static function countDownline($userID)
    {
        $allDownline = array();
        $statusLoop = true;
        $id = $userID;
        $downlineList = array($id);
        $statusForLoop = array();

        while ($statusLoop) {
            $statusForLoop = array();
            foreach ($downlineList as $value) {

                $userDownlineL1 = DB::table('users')
                    ->where('downlineTo', $value)
                    ->where(function ($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline', '!=', 'decline');
                    })
                    ->where(function ($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline', '!=', 'pending');
                    })
                    ->select('id')
                    ->get();

                foreach ($userDownlineL1 as $valueL2) {
                    array_push($downlineList, $valueL2->id);
                    array_push($allDownline, $valueL2->id);

                    if ($valueL2->id != '') {
                        array_push($statusForLoop, 'true');
                    } else {
                        array_push($statusForLoop, 'false');
                    }
                }
                $key = array_search($value, $downlineList);
                unset($downlineList[$key]);
            }

            if (in_array('true', $statusForLoop, true)) {
                $statusLoop = true;
            } else {
                $statusLoop = false;
            }
        }

        $numDownline = count($allDownline);
        return $numDownline;
    }

    public static function getDownline($userID)
    {
        $allDownline = array();
        $statusLoop = true;
        $id = $userID;
        $downlineList = array($id);
        $statusForLoop = array();
        $downlineListAll = array();

        while ($statusLoop) {
            $statusForLoop = array();
            foreach ($downlineList as $value) {

                $userDownlineL1 = DB::table('users')
                    ->where('downlineTo', $value)
                    ->where(function ($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline', '!=', 'decline');
                    })
                    ->where(function ($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline', '!=', 'pending');
                    })
                    ->select('id')
                    ->get();

                foreach ($userDownlineL1 as $valueL2) {
                    array_push($downlineList, $valueL2->id);
                    array_push($allDownline, $valueL2->id);

                    if ($valueL2->id != '') {
                        array_push($statusForLoop, 'true');
                    } else {
                        array_push($statusForLoop, 'false');
                    }
                }
                $key = array_search($value, $downlineList);
                unset($downlineList[$key]);
            }

            if (in_array('true', $statusForLoop, true)) {
                $statusLoop = true;
            } else {
                $statusLoop = false;
            }
        }

        foreach ($allDownline as $value) {
            $dl = DB::table('users')->where('id', $value)->get();

            array_push($downlineListAll, $dl);
        }
        // dd($downlineListAll);

        return $downlineListAll;
    }

    public function update(Request $req)
    {
        $validatedData = [
            'userIDEdit' => '',
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

            return redirect('/master-viewAgent')->with($notification);
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

                    return redirect('/master-viewAgent')->with($notification);
                } else if ($req->file('imageEdit') != null) {

                    $image = $req->file('imageEdit');
                    $newFileName = $image->getClientOriginalName();
                    $filename = pathinfo($newFileName, PATHINFO_FILENAME);
                    $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                    if (File::exists(public_path('../public_html/imageUploaded/profile/' . $image->getClientOriginalName() . ''))) {
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

                    return redirect('/master-viewAgent')->with($notification);
                }
            } catch (Exception $e) {
                $notification = array(
                    'message' => 'Something went wrong.',
                    'alert-type' => 'error'
                );
                return redirect('/master-viewAgent')->with($notification);
            }
        }
    }

    public function changeRole($roles, $id)
    {
        $getRole = DB::table('users')->where('id', $id)->select('role')->get();

        if ($getRole[0]->role == 'shogun') {
            switch ($roles) {
                case 'damio':
                    return redirect('/master-viewAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                case 'merchant':
                    return redirect('/master-viewAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                case 'dropship':
                    return redirect('/master-viewAgent')->with('error', 'Agent can only be upgraded to upper level.');
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
                    return redirect('/master-viewAgent')->with('success', 'Agent role has been changed.');
                    break;
                case 'merchant':
                    return redirect('/master-viewAgent')->with('error', 'Agent can only be upgraded to upper level.');
                    break;
                case 'dropship':
                    return redirect('/master-viewAgent')->with('error', 'Agent can only be upgraded to upper level.');
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
                    return redirect('/master-viewAgent')->with('success', 'Agent role has been changed.');
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
                    return redirect('/master-viewAgent')->with('success', 'Agent role has been changed.');
                    break;
                case 'dropship':
                    return redirect('/master-viewAgent')->with('error', 'Agent can only be upgraded to upper level.');
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
                    return redirect('/master-viewAgent')->with('success', 'Agent role has been changed.');
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
                    return redirect('/master-viewAgent')->with('success', 'Agent role has been changed.');
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
                    return redirect('/master-viewAgent')->with('success', 'Agent role has been changed.');
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
            return redirect('/master-viewAgent')->with('success', 'Agent role has been set.');
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

        return redirect('/master-viewAgent')->with($notification);
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
            'image' => 'image|mimes:jpeg,png,jpg'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            $notification = array(
                'message' => 'Please ensure all fields were filled and file uploaded is image files.',
                'alert-type' => 'error'
            );

            return redirect('/master-viewAgent')->with($notification);
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

                        if (File::exists(public_path('../public_html/imageUploaded/profile/' . $image->getClientOriginalName() . ''))) {
                            $newFileName = $filename . '1' . '.' . $extension;
                            $image->move(base_path('../public_html/imageUploaded/profile'), $newFileName);
                        } else {
                            $image->move(base_path('../public_html/imageUploaded/profile'), $image->getClientOriginalName());
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

                        return redirect('/master-viewAgent')->with($notification);
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

                        return redirect('/master-viewAgent')->with($notification);
                    }
                } else {

                    $notification = array(
                        'message' => 'User with the same IC number/email has existed in the system',
                        'alert-type' => 'error'
                    );

                    return redirect('/master-viewAgent')->with($notification);
                }
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }
}
