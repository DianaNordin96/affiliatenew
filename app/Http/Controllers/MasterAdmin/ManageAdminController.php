<?php

namespace App\Http\Controllers\MasterAdmin;

use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManageAdminController extends Controller
{
    public function index()
    {
        return view('masteradmin/admins')->with([
            "allTypeAdmin" => $this->getAllAdminType(),
            "allAdmin" => $this->getAllAdminList(),
        ]);
    }

    public static function getAllAdminType()
    {
        $getType = DB::table('admin')->get();
        return $getType;
    }

    public static function getAllAdminList()
    {
        $getAdmin = DB::table('users')->where('role', 'admin')->get();
        return $getAdmin;
    }

    public function changeCategory($id, $categoryID)
    {
        DB::table('users')->where('id', $id)
            ->update([
                'admin_category' => $categoryID
            ]);

        return redirect('master-manageAdmin')->with('success', "Successfully changed");
    }

    public function addAdmin(Request $req)
    {
        $validatedData = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'ic' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'category' => 'required'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new user', 'error');
            return redirect('/master-manageAdmin');
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
                    $user->password = Hash::make('12345678');
                    $user->image = $req->file('image')->getClientOriginalName();
                    $user->icnumber = $data['ic'];
                    $user->dob = $data['dob'];
                    $user->downlineTo = null;
                    $user->commissionPoint = 0;
                    $user->admin_category = $data['category'];
                    $user->role = 'admin';
                    $user->save();

                    $image = $req->file('image');

                    $image->move(base_path('../public_html/imageUploaded/profile'), $image->getClientOriginalName());

                    toast('User has been created', 'success');
                    return redirect('/master-manageAdmin');
                } else {
                    toast('User with the same IC number has existed in the system.', 'error');
                    return redirect('/master-manageAdmin');
                }
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function removeAdmin($id)
    {
        DB::table('users')
            ->delete($id);

        toast('Admin has been removed', 'success');
        return redirect('/master-manageAdmin');
    }

    public function addCategory(Request $req)
    {
        $validatedData = [
            'catName' => 'required',
            'desc' => 'required'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new category', 'error');
            return redirect('/master-manageAdmin');
        } else {
            $data = $req->input();
            try {

                DB::table('admin')->insert([
                    'category' => $data['catName'],
                    'desc' => $data['desc'],
                    'created_at' => NOW()
                ]);

                toast('User has been created', 'success');
                return redirect('/master-manageAdmin');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function updateCategory(Request $req)
    {
        $validatedData = [
            'catNameEdit' => 'required',
            'descEdit' => 'required'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before updating category', 'error');
            return redirect('/master-manageAdmin');
        } else {
            $data = $req->input();
            try {

                DB::table('admin')
                ->where('id',$data['idEdit'])
                ->update([
                    'category' => $data['catNameEdit'],
                    'desc' => $data['descEdit'],
                    'updated_at' => NOW()
                ]);

                toast('Category has been updated', 'success');
                return redirect('/master-manageAdmin');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }
}
