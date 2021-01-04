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
        ->get();

        return view(
            'merchant/restock',
            [
                'userId' => $id,
                'products' => $product,
            ]
        );
    }
    
    public function getProdCategory(){
        $allProdCat = DB::table('products_category')->get();
        return $allProdCat;
    }

    public function getProductsBy($catName,$prodCat){

        $allProd = DB::table('products')
        ->where('product_cat',$prodCat)
        ->get();

        return view(
            'merchant/restock',
            [
                'catID' => $prodCat,
                'products' => $allProd
            ]
        );
    }
}
