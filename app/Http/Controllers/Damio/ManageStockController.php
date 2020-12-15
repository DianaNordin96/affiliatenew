<?php

namespace App\Http\Controllers\Damio;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;

class ManageStockController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $email = Auth::user()->email;
        $pass = Auth::user()->password;

        $getProdGrp = DB::table('users')
        ->where('id',Auth::user()->belongsToAdmin)
        ->select('admin_category')
        ->get();

        $product = DB::table('products')
        ->where('belongToAdmin',$getProdGrp[0]->admin_category)
        ->get();

        return view(
            'damio/restock',
            [
                'userId' => $id,
                'products' => $product,
            ]
        );
    }
    
}
