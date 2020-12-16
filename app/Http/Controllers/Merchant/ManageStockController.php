<?php

namespace App\Http\Controllers\Merchant;

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

        $product = DB::table('products')
        ->where('belongToAdmin',Auth::user()->belongsToAdmin)
        ->get();

        return view(
            'merchant/restock',
            [
                'userId' => $id,
                'products' => $product,
            ]
        );
    }
    
}
