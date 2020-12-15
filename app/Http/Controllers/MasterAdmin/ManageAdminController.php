<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ManageAdminController extends Controller
{
    public function index(){
        return view('masteradmin/admins')->with([
            "allTypeAdmin" => $this->getAllAdminType(),
            "allAdmin" => $this->getAllAdminList(),
        ]);
    }

    public static function getAllAdminType(){
        $getType = DB::table('admin')->get();
        return $getType;
    }

    public static function getAllAdminList(){
        $getAdmin = DB::table('users')->where('role','admin')->get();
        return $getAdmin;
    }

    public function changeCategory($id,$categoryID){
        DB::table('users')->where('id',$id)
        ->update([
            'admin_category' => $categoryID
        ]);

        return redirect('master-manageAdmin')->with('success', "Successfully changed");
    }

}
