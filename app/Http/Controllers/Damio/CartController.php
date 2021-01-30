<?php

namespace App\Http\Controllers\Damio;

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

        return view('damio/cart')->with([
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
                    "price" => $product->damio_cost,
                    "photo" => $product->product_image,
                    "cat_id" => $product->belongToAdmin
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
            "price" => $product->damio_cost,
            "photo" => $product->product_image,
            "cat_id" => $product->belongToAdmin
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
        $cart = session()->get('cartPayment');

        date_default_timezone_set("Asia/Kuala_Lumpur");

        $orderID = date("Ymd") . date("hi") . Auth::user()->id;

        $total = 0;

        foreach ($cart as $key => $value) {
            foreach ($cart[$key][0] as $details) {
                $total += $details['price'] * $details['quantity'];
            }
        }

        $option = array(
            'userSecretKey' => 'ky1g673m-az9v-dwde-6nyk-24r0x9g83msb',
            'categoryCode' => 'g2lwd3s7',
            'billName' => 'Purchase for Stock',
            'billDescription' => 'Buy stock',
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $total * 100,
            'billReturnUrl' => url('statusDamio'),
            'billCallbackUrl' => url('callbackDamio'),
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

    public function group_by($key, $data)
    {
        $result = array();

        foreach ($data as $keyVal => $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][$keyVal] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }

    public function paymentStatus(Request $request)
    {
        $cart = session()->get('cartPayment');

        date_default_timezone_set("Asia/Kuala_Lumpur");

        $response = request()->all(['status_id', 'billcode', 'order_id']);


        //if payment success
        if ($request->status_id == 1) {
            //insert orders
            foreach ($cart as $key => $value) {

                $orderID = date("Ymd") . date("hi") . Auth::user()->id . $key;

                // dd($cart[$key][0]);
                $byGroup = $this->group_by("cat_id", $cart[$key][0]);

                // Dump result


                foreach ($byGroup as $keyGrp => $group) {
                    // dd($byGroup[$keyGrp]);
                    $total = 0;
                    foreach ($byGroup[$keyGrp] as $details) {
                        $total += $details['price'] * $details['quantity'];
                    }

                    $orderID = $orderID . $keyGrp;

                    DB::table('orders')->insert([
                        [
                            'orders_id' => $orderID,
                            'bill_code' => $request->billcode,
                            'user_id' => Auth::user()->id,
                            'amount' => $total,
                            'created_at' => NOW(),
                            'customer_id' => $key,
                            'belongToAdmin' => $keyGrp
                        ],
                    ]);

                    //insert product orders
                    foreach ($byGroup[$keyGrp] as $id => $details) {

                        DB::table('orders_details')->insert([
                            [
                                'product_id' => $id,
                                'referenceNo' => $orderID,
                                'quantity' => $details['quantity'],
                            ],
                        ]);
                    }
                }
                $totalCommission = 0;
                //update commision
                foreach ($cart[$key][0] as $id => $details) {
                    $prod = DB::table('products')
                        ->where('id', $id)
                        ->get();
                    foreach ($prod as $product) {
                        //check upperLevel role
                        $checkRole = DB::table('users')->where('id', Auth::user()->downlineTo)->get();
                        // dd($checkRole);
                        switch ($checkRole[0]->role) {
                            case 'shogun':
                                $this->addCommission($checkRole[0]->id, ($product->price_shogun) * $details['quantity']);
                                break;

                            case 'damio':
                                $this->addCommission($checkRole[0]->id, ($product->price_damio) * $details['quantity']);
                                //getShogun
                                $getShogun = DB::table('users')->where('id', $checkRole[0]->downlineTo)->get();

                                if ($getShogun[0]->role == 'shogun') {
                                    $this->addCommission($getShogun[0]->id, ($product->price_shogun) * $details['quantity']);
                                }
                                break;

                            case 'merchant':
                                // $tempID = $checkRole[0]->id;
                                // $status = true;
                                $this->addCommission($checkRole[0]->id, ($product->price_merchant) * $details['quantity']);

                                //getUpperLevelRole
                                $getUpperLvl = DB::table('users')->where('id', $checkRole[0]->downlineTo)->get();

                                if ($getUpperLvl[0]->role == 'damio') {
                                    $this->addCommission($checkRole[0]->id, ($product->price_damio) * $details['quantity']);
                                    //addToShogun
                                    $this->addCommission($checkRole[0]->downlineTo, ($product->price_shogun) * $details['quantity']);
                                } else if ($getUpperLvl[0]->role == 'shogun') {
                                    $this->addCommission($getUpperLvl[0]->id, ($product->price_shogun + $product->price_damio) * $details['quantity']);
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
            $request->session()->forget('cartPayment');
            return redirect('purchase-history-damio')->with('success', 'Payment Successful');
        } else { //if payment unsuccessful
            return redirect('purchase-history-damio')->with('error', 'Payment Unsuccessful');
        }
    }

    public function addCommission($id, $amount)
    {
        $getLatestAmount = DB::table('users')->where('id', $id)->get();

        DB::table('users')
            ->where('id', $id)
            ->update([
                'commissionPoint' => $getLatestAmount[0]->commissionPoint + $amount
            ]);
    }

    public function callback()
    {
        $response = request()->all(['refno', 'status', 'billcode', 'order_id', 'amount']);
        Log::info($response);
    }

    public function removeFromCartPayment(Request $request)
    {

        DB::table('customers')->where('id', $request->id)->delete();

        if ($request->id) {
            $cart = session()->get('cartPayment');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cartPayment', $cart);
            }
            session()->flash('success', 'Customer order has been removed successfully');
        }
    }

    public function addToPaymentCart(Request $req)
    {
        $validatedData = [
            'name' => 'required',
            'phone' => 'required',
            'address1' => 'required',
            'address2' => '',
            'address3' => '',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'notes' => ''
        ];
        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please fill in all the box before submit page');
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
                'user_id' => Auth::user()->id,
                'notes' => $data['notes']
            ]);

            $cart = session()->get('cart');
            $cartPayment = session()->get('cartPayment');

            if (!$cartPayment) {
                $cartPayment = [
                    $customerDetails => [$cart]
                ];
                session()->put('cartPayment', $cartPayment);
                $req->session()->forget('cart');
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cartPayment[$customerDetails] = [$cart];
            session()->put('cartPayment', $cartPayment);
            $req->session()->forget('cart');
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
    }
}
