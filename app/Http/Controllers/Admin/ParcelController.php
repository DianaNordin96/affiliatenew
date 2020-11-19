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
        // $checkRate = $this->checkRate();
        $expressOrder = $this->expressOrder();
        return view('admin/parcel')->with([
            'balance' => $balance,
            // 'rate' => $checkRate
        ]);
    }

    public function consignmentPage(){
        return view('admin/consignmentCustDetails');
    }

    public function checkRate($weight, $referenceNo, $senderPostcode,$state)
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

    public function checkBalance()
    {

        $option = array(
            'api'    => 'EP-Ro51LDZu9',
        );

        $url = "http://demo.connect.easyparcel.my/?ac=EPCheckCreditBalance";
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
        session()->put('senderDetails',([
            'postcode' => $req->input('senderPostcode'),
            'state' => $req->input('state')
        ]));
        session()->put('refNo', $req->input('refNo'));
        session()->put('weight', $req->input('weight'));

        $ratesList = $this->checkRate($req->input('weight'), $req->input('refNo'),$req->input('senderPostcode'),$req->input('state'));
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
                $desc => [
                    "desc" => $desc,
                    "serv_id" => $serv_id,
                    "price" => $price,
                ]
            ];
            session()->put('parcelCart', $parcelCart);
            // dd(session()->get('parcelCart'));
            return redirect('/consignment-details');
        } else {

            if ($parcelCart[$desc]){
                toast('Shipping Cost already in cart', 'error');
                return redirect('/consignment-details');
            }else{
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
                "price" => number_format(0.20,2)
        ];
        session()->put('parcelCart', $parcelCart);
        session()->flash('success', 'Added RM 0.20 to parcel bill.');
    }

    public function removeParcelCart(){
        $parcelCart = session()->get('parcelCart');
        unset($parcelCart['sms']);
        session()->put('parcelCart', $parcelCart);
        session()->flash('success', 'Remove RM 0.20');
    }
}