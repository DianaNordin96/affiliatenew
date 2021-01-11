<?php

namespace App\Http\Controllers\Shogun;

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

        $prodCat = $this->getProdCategory();

        return view(
            'shogun/productCategory',
            [
                'userId' => $id,
                'catID' => 0,
                'productsCategory' => $prodCat,
            ]
        );
    }

    public function getProdCategory()
    {
        $allProdCat = DB::table('products_category')->get();
        return $allProdCat;
    }

    public function getProductsBy($catName, $prodCat)
    {

        if ($prodCat == 0) {
            $allProd = DB::table('products')
                ->get();

            return view(
                'shogun/restock',
                [
                    'catID' => $prodCat,
                    'products' => $allProd
                ]
            );
        } else {
            $allProd = DB::table('products')
                ->where('product_cat', $prodCat)
                ->get();

            return view(
                'shogun/restock',
                [
                    'catID' => $prodCat,
                    'products' => $allProd
                ]
            );
        }
    }
}
