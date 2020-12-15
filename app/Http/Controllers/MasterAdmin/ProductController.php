<?php

namespace App\Http\Controllers\MasterAdmin;

use DB;
use App\Purchase;
use App\Product;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index()
    {

        $products = DB::table('products')->get();

        return view(
            'masteradmin/products',
            [
                'product' => $products
            ]
        );
    }

    public function update(Request $req)
    {

        $validatedData = [
            'productNameEdit' => 'required',
            'productPriceEdit' => 'required',
            'productDescEdit' => 'required',
            'hqPriceEdit' => 'required',
            'shogunPriceEdit' => 'required',
            'dropshipPriceEdit' => 'required',
            'damioPriceEdit' => 'required',
            'merchantPriceEdit' => 'required',
            'productLinkEdit' => '',
            'categoryEdit' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new products', 'error');
            return redirect('/master-manageProduct');
        } else {
            $data = $req->input();
            try {
                DB::table('products')
                    ->where('id', $data['productIDEdit'])
                    ->update([
                        'product_name' => $data['productNameEdit'],
                        'product_price' => $data['productPriceEdit'],
                        'product_description' => $data['productDescEdit'],
                        'price_shogun' => $data['shogunPriceEdit'],
                        'price_damio' => $data['damioPriceEdit'],
                        'price_merchant' => $data['merchantPriceEdit'],
                        'price_dropship' => $data['dropshipPriceEdit'],
                        'price_hq' => $data['hqPriceEdit'],
                        'product_link' => $data['productLinkEdit'],
                        'belongToAdmin' => $data['categoryEdit'],
                    ]);

                toast('Product has been updated', 'success');
                return redirect('/master-manageProduct');
            } catch (Exception $e) {
                return redirect('/master-manageProduct')->with('error', "Data cannot be updated");
            }
        }
    }

    public function create(Request $req)
    {
        $validatedData = [
            'productName' => 'required',
            'productPrice' => 'required',
            'productDesc' => 'required',
            'shogunPrice' => 'required',
            'dropshipPrice' => 'required',
            'damioPrice' => 'required',
            'merchantPrice' => 'required',
            'hqPrice' => 'required',
            'productLink' => '',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'categoryEdit' => '',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new products', 'error');
            return redirect('/master-manageProduct');
        } else {
            $data = $req->input();
            try {
                DB::table('products')->insert([
                    'product_name' => $data['productName'],
                    'product_price' => $data['productPrice'],
                    'product_description' => $data['productDesc'],
                    'price_hq' => $data['hqPrice'],
                    'product_image' => $req->file('image')->getClientOriginalName(),
                    'price_shogun' => $data['shogunPrice'],
                    'price_damio' => $data['damioPrice'],
                    'price_merchant' => $data['merchantPrice'],
                    'price_dropship' => $data['dropshipPrice'],
                    'product_link' => $data['productLink'],
                    'belongToAdmin' => $data['category'],
                ]);

                $image = $req->file('image');

                $image->move(base_path('../public_html/imageUploaded/products'), $image->getClientOriginalName());

                toast('Product has been created', 'success');
                return redirect('/master-manageProduct');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function delete($id)
    {
        DB::table('products')
            ->delete($id);

        toast('Product has been removed', 'success');
        return redirect('/master-manageProduct');
    }
}
