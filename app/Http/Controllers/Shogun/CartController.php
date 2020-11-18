<?php

namespace App\Http\Controllers\Shogun;

use DB;
use Session;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function cart()
    {
        $customer = DB::table('customers')
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('shogun/cart')->with([
            'customers' => $customer
        ]);
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

    public function checkout(Request $req)
    {

        $validatedData = [
            'name' => 'required',
            'phone' => 'required',
            'address1' => 'required',
            'address2' => '',
            'address3' => '',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required'
        ];
        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before checkout', 'error');
            return redirect()->back();
        } else {
            $data = $req->input();

            $customerDetails = DB::table('customers')->insertGetId([
                'name' => $data['name'],
                'address' => $data['address1'],
                'address_two' => $data['address2'],
                'address_three' => $data['address3'],
                'phone' => $data['phone'],
                'state' => $data['state'],
                'city' => $data['city'],
                'postcode' => $data['postcode'],
                'user_id' => Auth::user()->id
            ]);

            date_default_timezone_set("Asia/Kuala_Lumpur");

            $orderID = date("Ymd") . date("hi") . Auth::user()->id;

            session()->put('customer', $customerDetails);

            $total = 0;

            foreach (session('cart') as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }
            $option = array(
                'userSecretKey' => 'ky1g673m-az9v-dwde-6nyk-24r0x9g83msb',
                'categoryCode' => 'g2lwd3s7',
                'billName' => 'Purchase for Stock',
                'billDescription' => 'Buy stock',
                'billPriceSetting' => 1,
                'billPayorInfo' => 1,
                'billAmount' => $total * 100,
                'billReturnUrl' => route('statusShogun'),
                'billCallbackUrl' => route('callbackShogun'),
                'billExternalReferenceNo' => $orderID,
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

            $url = 'https://dev.toyyibpay.com/index.php/api/createBill';

            $response = Http::asForm()->post($url, $option);
            $billCode = $response[0]['BillCode'];

            return redirect('https://dev.toyyibpay.com/' .  $billCode);
        }
    }
    public function paymentStatus(Request $request)
    {
        $custID = session('customer');
        $total = 0;
        foreach (session('cart') as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $response = request()->all(['status_id', 'billcode', 'order_id']);

        //if payment success
        if ($request->status_id == 1) {
            //insert orders
            DB::table('orders')->insert([
                [
                    'orders_id' => $request->order_id,
                    'bill_code' => $request->billcode,
                    'user_id' => Auth::user()->id,
                    'amount' => $total,
                    'created_at' => NOW(),
                    'customer_id' => $custID
                ],
            ]);

            //insert product orders
            foreach (session('cart') as $id => $details) {
                DB::table('orders_details')->insert([
                    [
                        'product_id' => $id,
                        'referenceNo' => $request->order_id,
                        'quantity' => $details['quantity'],
                    ],
                ]);
            }

            $totalCommission = 0;
            //update commision
            foreach (session('cart') as $id => $details) {
                $prod = DB::table('products')
                    ->where('id', $id)
                    ->get();
                foreach ($prod as $product) {
                    $commisionPerProduct = $product->product_price - $product->price_hq -$product->price_shogun;
                    $commisionPerProduct = $commisionPerProduct * $details['quantity'];
                    $totalCommission = $totalCommission + $commisionPerProduct;

                    //check downline
                    $status = true;
                    // $statusCheck = false;
                    $id = Auth::user()->downlineTo;
                    $commissionPoint = 0;

                    if (Auth::user()->downlineTo != '') {
                        while ($status) {
                            $check = DB::table('users')
                                ->where('id', $id)
                                ->get();
                            // dd($check);
                            foreach ($check as $checking) {
                                if ($checking->id != '') {
                                    $id = $checking->downlineTo;
                                    $role = $checking->role;
                                    // dd($product->price_shogun);
                                    switch ($role) {
                                        case 'shogun':
                                            $commissionPoint = ($product->price_shogun * $details['quantity']) + $checking->commissionPoint;
                                            break;
                                        case 'merchant':
                                            $commissionPoint = ($product->price_merchant * $details['quantity']) + $checking->commissionPoint;
                                            break;
                                        case 'damio':
                                            $commissionPoint = ($product->price_damio * $details['quantity']) + $checking->commissionPoint;
                                            break;
                                        case 'dropship':
                                            $commissionPoint = ($product->price_dropship * $details['quantity']) + $checking->commissionPoint;
                                            break;
                                        default:
                                            break;
                                    }
                                    DB::table('users')
                                        ->where('id', $checking->id)
                                        ->update([
                                            'commissionPoint' => $commissionPoint
                                        ]);

                                    if ($checking->downlineTo == null) {
                                        $status = false;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            //addToCommision
            $userCommission = DB::table('users')->where('id', Auth::user()->id)->get();

            foreach ($userCommission as $user) {
                $commissionPoint = $user->commissionPoint;
                if ($commissionPoint == null) {
                    DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->update([
                            'commissionPoint' => $totalCommission
                        ]);
                } else {
                    $totalCommission += $commissionPoint;
                    DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->update([
                            'commissionPoint' => $totalCommission
                        ]);
                }
            }

            $request->session()->forget('cart');
            toast('Payment Successful', 'success');
            return redirect('purchase-history-shogun');
        } else { //if payment unsuccessful
            toast('Payment Unsuccessful', 'error');
            return redirect('purchase-history-shogun');
        }
    }

    public function callback()
    {
        $response = request()->all(['refno', 'status', 'billcode', 'order_id', 'amount']);
        Log::info($response);
    }
}
