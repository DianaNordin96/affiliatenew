<?php

namespace App\Http\Controllers\Merchant;

use DB;
use Session;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function cart()
    {
        return view('merchant/cart');
    }
    public function addToCart($id)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->product_name,
                    "quantity" => 1,
                    "price" => $product->product_price,
                    "photo" => $product->product_image
                ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->product_name,
            "quantity" => 1,
            "price" => $product->product_price,
            "photo" => $product->product_image
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if ($request->id and $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function checkout()
    {

        $total = 0;
        foreach (session('cart') as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }
        $option = array(
            'userSecretKey' => '7jjvcrsb-h3ro-1zsh-wrrs-7j47nubg36v2',
            'categoryCode' => 'p5cfhstp',
            'billName' => 'Purchase for Stock',
            'billDescription' => 'Buy stock',
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $total * 100,
            'billReturnUrl' => route('statusMerchant'),
            'billCallbackUrl' => route('callbackMerchant'),
            'billExternalReferenceNo' => 'AFR341DFI',
            'billTo' => Auth::user()->name,
            'billEmail' => Auth::user()->email,
            'billPhone' => Auth::user()->phone,
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billMultiPayment' => 1,
            'billPaymentChannel' => 0,
            'billDisplayMerchant' => 1,
            'billContentEmail' => 'Email content'
        );

        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_POST, 1);
        // curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $option);

        // $result = curl_exec($curl);
        // $info = curl_getinfo($curl);
        // curl_close($curl);
        // $obj = json_decode($result);
        // echo $obj[0]->BillCode;

        // return redirect('https://toyyibpay.com/' .  $obj[0]->BillCode);
        // foreach ($obj['items'] as $value){
        //     echo $value;
        // };


        // from the guide

        $url = 'https://dev.toyyibpay.com/index.php/api/createBill';

        $response = Http::asForm()->post($url, $option);
        $billCode = $response[0]['BillCode'];

        return redirect('https://dev.toyyibpay.com/' .  $billCode);
    }

    public function paymentStatus(Request $request)
    {

        $total=0;
        foreach (session('cart') as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $response = request()->all(['status_id', 'billcode', 'order_id']);
        DB::table('orders')->insert([
            [
                'orders_id' => $request->order_id,
                'bill_code' => $request->billcode,
                'user_id' => Auth::user()->id,
                'amount' => $total,
                'created_at' => NOW()
            ],
        ]);


        foreach (session('cart') as $id => $details) {
            DB::table('orders_details')->insert([
                [
                    'product_id' => $id,
                    'order_id' => $request->order_id,
                    'quantity' => $details['quantity'],
                ],
            ]);
        }

        $request->session()->forget('cart');
        toast('Payment Successful', 'success');
        return redirect('purchase-historyMerchant');
    }

    public function callback()
    {
        $response = request()->all(['refno', 'status', 'billcode', 'order_id', 'amount']);
        Log::info($response);
    }
}
