<?php

namespace App\Http\Controllers\SuperAdmin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageCommission extends Controller
{
    public function index(){
        $commissionList = DB::table('commission')
        ->where('approveStatus','=','pending')
        ->get();

        return redirect('superadmin/commission')->with([
            'commissionList' => $commissionList
        ]);
    }

    public function approve($id){
        DB::table('commission')
        -> where('id','=',$id)
        -> update('approveStatus','=','paid');

        return redirect('superadmin/commission');
    }

    public function decline($id){
        DB::table('commission')
        -> where('id','=',$id)
        -> update('approveStatus','=','decline');

        return redirect('superadmin/commission');
    }
}
