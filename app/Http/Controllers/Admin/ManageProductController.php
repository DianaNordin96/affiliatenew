<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Billplz\Laravel\Billplz;
use DB;
use App\Purchase;
use App\Product;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

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
                    'product_image' => $req->file('image')->getClientOriginalName(),
                    'payment_link' => 'wtv',
                ]);

                $image = $req->file('image');

                $image->move(base_path('public\imageUploaded'), $image->getClientOriginalName());

                toast('Product has been created', 'success');
                return redirect('/manageProduct');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function store(Request $req)
    {

        $product = Product::find($req->product);

        $some_data = array(
            "collection_id" => "inbmmepb",
            "paid" => false,
            "state" => "due",
            "amount" => 200,
            "paid_amount" => 0,
            "due_at" => "2015-3-9",
            "email"  => "api@billplz.com",
            "mobile" => null,
            "name" => "Sara",
            "url" => "https://www.billplz.com/bills/8X0Iyzaw",
            "reference_1_label" => "Reference 1",
            "reference_1" => null,
            "reference_2_label" => "Reference 2",
            "reference_2" => null,
            "redirect_url" => null,
            "callback_url" => "http://example.com/webhook/",
            "description" => "Maecenas eu placerat ante."
        );
        // from the guide

        $url = 'https://www.billplz.com/api/v3/bills';

        $response = Http::asForm()->post($url, $some_data);


        // Store the bill into our purchases
        $purchase = new Purchase;
        $purchase->user_id = Auth::user()->id;
        $purchase->product_id = $product->id;
        $purchase->bill_id = '0';
        $purchase->save();
        $billcode = $response[0]['id'];


        return redirect('https://www.billplz.com/');
    }
}
