<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{
    public function index()
    {
        $domain = "http://demo.connect.easyparcel.my/?ac=";

        $action = "EPSubmitOrderBulk";
        $postparam = array(
            'api'    => 'EP-Ro51LDZu9',
            'bulk'    => array(
                array(
                    'weight'    => '3',
                    'width'    => '1',
                    'length'    => '1',
                    'height'    => '1',
                    'content'    => 'book',
                    'value'    => '10',
                    'service_id'    => 'EP-CS0W',
                    'pick_point'    => '',
                    'pick_name'    => 'Yong Tat',
                    'pick_company'    => 'Yong Tat Sdn Bhd',
                    'pick_contact'    => '0123456789',
                    'pick_mobile'    => '0123456789',
                    'pick_addr1'    => 'ppppp46/7 adfa',
                    'pick_addr2'    => 'test',
                    'pick_addr3'    => '',
                    'pick_addr4'    => '',
                    'pick_city'    => 'city',
                    'pick_state'    => 'png',
                    'pick_code'    => '48000',
                    'pick_country'    => 'MY',
                    'send_point'    => '',
                    'send_name'    => 'sam',
                    'send_company'    => '',
                    'send_contact'    => '0122134567',
                    'send_mobile'    => '0122134567',
                    'send_addr1'    => 'ssssadsasdst test',
                    'send_addr2'    => 'test test',
                    'send_addr3'    => '',
                    'send_addr4'    => '',
                    'send_city'    => 'send city',
                    'send_state'    => 'png',
                    'send_code'    => '11950',
                    'send_country'    => 'MY',
                    'collect_date'    => '2020-02-20',
                    'sms'    => '0',
                    'send_email'    => 'xxxxxx@hotmail.com',
                    'hs_code'    => 'yshs_code',
                    'REQ_ID'    => 'shipping # 1',
                    'reference'    => 'order12321',
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
}
