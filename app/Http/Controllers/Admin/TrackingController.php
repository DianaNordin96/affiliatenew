<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class TrackingController extends Controller
{
    public static function getTrackingStatus($trackingNum,$courierCode)
    {
        $option = array(
            'carrier_code' => $courierCode,
            'tracking_number' => $trackingNum 
        );

        $url = 'https://api.tracktry.com/v1/trackings';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Tracktry-Api-Key' => '3cbee946-e06e-4315-bcda-ae18ed79be07',
        ])->get($url,$option);
        $result = json_decode($response);
        // dd($result);
        // $result = $result['data'][0]['status'];
        return $result;
    }

    public static function getTrackingStatusSingle($trackingNum,$courierCode)
    {
        $option = array(
            'carrier_code' => $courierCode,
            'tracking_number' => $trackingNum 
        );

        $url = 'https://api.tracktry.com/v1/trackings';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Tracktry-Api-Key' => '3cbee946-e06e-4315-bcda-ae18ed79be07',
        ])->get($url,$option);
        $result = json_decode($response,true);
        // dd($result);
        $result = $result['data'][0]['lastEvent'];
        return $result;
    }

    public function createTracking(Request $req){
        DB::table('orders')
        ->where('orders_id',$req->input('order_id'))
        ->update([
            'tracking_number' => $req->input('tracking_number'),
            'courier_code' => $req->input('courier')
        ]);

        toast('Tracking created', 'success');
        return redirect()->back();

    }
}
