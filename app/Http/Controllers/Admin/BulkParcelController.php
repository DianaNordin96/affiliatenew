<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\BulkImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
