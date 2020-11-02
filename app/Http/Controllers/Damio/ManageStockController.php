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

        $product = DB::table('products')->get();

        return view(
            'damio/restock',
            [
                'userId' => $id,
                'products' => $product,
            ]
        );
    }
    
}
