<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BulkParcelController extends Controller
{
    public function index(){
        return view('admin/bulkParcel');
    }

    
    public function getExcelToArray(Request $req){
        // $array = Excel::import(new BulkImport,  $req->file('excelFile'));
        // $array = (new BulkImport)->toArray($req->file('excelFile'));

        $array = $req->input('orders');
        dd($array);
    }
}
