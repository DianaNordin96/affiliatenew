<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ManageProductController extends Controller
{
    public function index()
    {

        $products = DB::table('products')->get();

        return view(
            'admin/manageProduct',
            [
                'product' => $products
            ]
        );
    }

    public function create(Request $req)
    {
        $validatedData = [
            'productName' => 'required',
            'productPrice' => 'required',
            'productDesc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new products', 'error');
            return redirect('/manageProduct');
        } else {
            $data = $req->input();
            try {
                DB::table('products')->insert([
                    'product_name' => $data['productName'],
                    'product_price' => $data['productPrice'],
                    'product_description' => $data['productDesc'],
                    'product_image' => $req->file('image')-> getClientOriginalName(),
                ]);

                $image = $req->file('image');

               $image->move(base_path('public\imageUploaded'),$image -> getClientOriginalName());

                toast('Product has been created', 'success');
                return redirect('/manageProduct');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
       
    }
}
