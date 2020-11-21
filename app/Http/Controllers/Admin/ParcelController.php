<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ParcelController extends Controller
{
    public function index()
    {
        $balance = $this->checkBalance();
        $parcelList = DB::table('consignment')
            ->join('orders', 'consignment.refNo', '=', 'orders.orders_id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('messagenow', '=', null)
            ->get();
        // dd($parcelList);
        return view('admin/parcel')->with([
            'balance' => $balance,
            'consignment' => $parcelList
        ]);
    }

    public function consignmentPage()
    {
        return view('admin/consignmentCustDetails');
    }

    public function checkRate($weight, $referenceNo, $senderPostcode, $state)
    {
        $cust = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.orders_id', $referenceNo)
            ->select('customers.*')
            ->get();
        $custDetails = json_decode($cust, true);
        // dd(json_decode($custDetails));

        $option = array(
            'api'    => 'EP-Ro51LDZu9',
            'bulk'    => array(
                array(
                    'pick_code'    => $senderPostcode,
                    'pick_state'    => $state,
                    'pick_country'    => 'MY',
                    'send_code'    => $custDetails[0]['postcode'],
                    'send_state'    => $custDetails[0]['state'],
                    'send_country'    => 'MY',
                    'weight'    => $weight,
                    'width'    => '0',
                    'length'    => '0',
                    'height'    => '0',
                    'date_coll'    => '',
                )
            ),
            'exclude_fields'    => array(
                'rates.*.pickup_point',
            )
        );

        $url = "http://connect.easyparcel.my/?ac=EPRateCheckingBulk";
        $response = Http::asForm()->post($url, $option);
        $result = json_decode($response);
        // dd(json_decode($response));
        // $price = $result['result'][0]['rates']['0']['price'];

        session()->put('rateList', $result);
        return $result;
    }

    public static function checkBalance()
    {
        $option = array(
            'api'    => 'EP-Ro51LDZu9',
        );

        $url = "http://connect.easyparcel.my/?ac=EPCheckCreditBalance";
        $response = Http::asForm()->post($url, $option);
        $result = json_decode($response, true);
        $balance = $result['result'];

        return $balance;
    }

    public function expressOrder()
    {
        $domain = "http://demo.connect.easyparcel.my/?ac=";

        $action = "EPSubmitOrderBulkV3";
        $postparam = array(
            'api'    => 'EP-Ro51LDZu9',
            'courier'    => array('Poslaju'),
            'dropoff'    => '0',
            'bulk'    => array(
                array(
                    'referrence'    => 'item1',
                    'weight'    => '1',
                    'content'    => '2017-09-14 - book',
                    'value'    => '20',
                    'pick_name'    => 'Yong Tat',
                    'pick_company'    => 'Yong Tat Sdn Bhd',
                    'pick_contact'    => '+6012-1234-5678',
                    'pick_mobile'    => '+6017-1234-5678',
                    'pick_addr1'    => 'ppppp46/7 adfa',
                    'pick_addr2'    => 'test',
                    'pick_addr3'    => 'test',
                    'pick_addr4'    => '',
                    'pick_city'    => 'png',
                    'pick_state'    => 'png',
                    'pick_code'    => '14300',
                    'pick_country'    => 'MY',
                    'send_name'    => 'Sam',
                    'send_contact'    => '+6012-2134567',
                    'send_mobile'    => '+6017-1234-5678',
                    'send_addr1'    => 'ssssadsasdst test',
                    'send_addr2'    => 'test test',
                    'send_addr3'    => 'test',
                    'send_addr4'    => '',
                    'send_city'    => 'png',
                    'send_state'    => 'png',
                    'send_code'    => '11950',
                    'send_country'    => 'MY',
                    'collect_date'    => '2020-11-19',
                    'send_email'    => 'xxxxxx@hotmail.com',
                    'sms'    => '0',
                ),
            ),
        );

        $url = $domain . $action;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postparam));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        ob_start();
        $return = curl_exec($ch);
        ob_end_clean();
        curl_close($ch);

        $json = json_decode($return);
        dd($json);
    }

    public function create(Request $req)
    {
        session()->put('senderDetails', ([
            'postcode' => $req->input('senderPostcode'),
            'state' => $req->input('state')
        ]));

        $parcelDetails = [
            'refNo' => $req->input('refNo'),
            'weight' => $req->input('weight')
        ];

        session()->put('parcelDetails', $parcelDetails);

        $ratesList = $this->checkRate($req->input('weight'), $req->input('refNo'), $req->input('senderPostcode'), $req->input('state'));
        // dd($ratesList);
        $result = $ratesList->result[0]->rates;
        // dd($result);
        // dd($ratesList['result'][0]['rates']);
        return view('admin/consignment')->with([
            'ratesList' => $result,
            'refNo' => $req->input('refNo')
        ]);
    }

    public function addToCartParcel($desc, $serv_id, $price)
    {
        $parcelCart = session()->get('parcelCart');

        // if cart is empty then this the first product
        if (!$parcelCart) {
            $parcelCart = [
                'shipping' => [
                    "desc" => $desc,
                    "serv_id" => $serv_id,
                    "price" => $price,
                ]
            ];
            session()->put('parcelCart', $parcelCart);
            // dd(session()->get('parcelCart'));
            return redirect('/consignment-details');
        } else {

            if ($parcelCart[$desc]) {
                toast('Shipping Cost already in cart', 'error');
                return redirect('/consignment-details');
            } else {
                $desc = [
                    "desc" => $desc,
                    "serv_id" => $serv_id,
                    "price" => $price,
                ];
                session()->put('parcelCart', $parcelCart);
                return redirect('/consignment-details');
            }
        }
    }

    public function updateParcelCart()
    {
        $parcelCart = session()->get('parcelCart');
        $parcelCart['sms'] = [
            "desc" => 'SMS Tracking',
            "serv_id" => '',
            "price" => number_format(0.20, 2)
        ];
        session()->put('parcelCart', $parcelCart);
        session()->flash('success', 'Added RM 0.20 to parcel bill.');
    }

    public function removeParcelCart()
    {
        $parcelCart = session()->get('parcelCart');
        unset($parcelCart['sms']);
        session()->put('parcelCart', $parcelCart);
        session()->flash('success', 'Remove RM 0.20');
    }

    public function checkout(Request $req)
    {
        $parcelDetails = session()->get('parcelDetails');
        $parcelCart = session()->get('parcelCart');
        $orderItem = DB::table('orders')
            ->where('orders_id', $parcelDetails['refNo'])
            ->get();
        $sms = 0;
        $dropoff = '';

        //checkSMS subscribed or not
        if (isset($parcelCart['sms'])) {
            $sms = 1;
        } else {
            $sms = 0;
        }

        if ($req->input('dropoff_point') != '') {
            $dropoff = $req->input('dropoff_point');
        } else {
            $dropoff = '';
        }

        $postparam = array(
            'api'    => 'EP-Ro51LDZu9',
            'bulk'    => array(
                array(
                    'weight'    => $parcelDetails['weight'],
                    'width'    => '',
                    'length'    => '',
                    'height'    => '',
                    'content'    => 'Stuff',
                    'value'    => $orderItem[0]->amount,
                    'service_id'    => $parcelCart['shipping']['serv_id'],
                    'pick_point'    => $dropoff,
                    'pick_name'    => $req->input('sender_name'),
                    'pick_company'    => 'Yong Tat Sdn Bhd',
                    'pick_contact'    => $req->input('sender_phone'),
                    'pick_mobile'    => $req->input('sender_phone'),
                    'pick_addr1'    => $req->input('sender_address1'),
                    'pick_addr2'    => $req->input('sender_address2'),
                    'pick_addr3'    => $req->input('sender_address3'),
                    'pick_addr4'    => '',
                    'pick_city'    => $req->input('sender_city'),
                    'pick_state'    => $req->input('sender_state'),
                    'pick_code'    => $req->input('sender_postcode'),
                    'pick_country'    => 'MY',
                    'send_point'    => '',
                    'send_name'    => $req->input('receiver_name'),
                    'send_company'    => '',
                    'send_contact'    => $req->input('receiver_phone'),
                    'send_mobile'    => $req->input('receiver_phone'),
                    'send_addr1'    => $req->input('receiver_address1'),
                    'send_addr2'    => $req->input('receiver_address2'),
                    'send_addr3'    => $req->input('receiver_address3'),
                    'send_addr4'    => '',
                    'send_city'    => $req->input('receiver_city'),
                    'send_state'    => $req->input('receiver_state'),
                    'send_code'    => $req->input('receiver_postcode'),
                    'send_country'    => 'MY',
                    'collect_date'    => date("Y-m-d"),
                    'sms'    => $sms,
                    'send_email'    => 'diananana1996@gmail.com',
                    'hs_code'    => '',
                    'REQ_ID'    => $parcelDetails['refNo'],
                    'reference'    => $parcelDetails['refNo'],
                ),
            ),
        );

        $url = "http://connect.easyparcel.my/?ac=EPSubmitOrderBulk";
        $response = Http::asForm()->post($url, $postparam);
        $result = json_decode($response, true);
        // dd($result['result'][0]);

        foreach ($result['result'] as $value) {
            DB::table('consignment')
                ->insert([
                    'refNo' => $value['REQ_ID'],
                    'REQ_ID' => $value['REQ_ID'],
                    'parcel_number' => $value['parcel_number'],
                    'order_number' => $value['order_number'],
                    'price' => $value['price'],
                    'status' => $value['status'],
                    'remarks' => $value['remarks'],
                    'courier' => $value['courier'],
                    'collect_date' => $value['collect_date'],
                    'created_at' => now()
                ]);
        }
        return redirect('/parcel');
    }
}
