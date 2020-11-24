<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlastMessageController extends Controller
{
    public function index()
    {
        $getAllAgents = DB::table('users')
        ->get();

        $getAllCustomers = DB::table('customers')
        ->get();

        $option = array(
            'apiKey' => '9e8611e27e899012d28f215859462bdf',
            'email' => 'diananana1996@gmail.com'
        );

        $url = 'https://www.sms123.net/api/getBalance.php';

        $response = Http::asForm()->get($url, $option);
        // dd(json_decode($response));
        $creditBalance = $response['balance'];

        //rateChecking
        
        return view('admin/blastmessage')->with([
            'creditBalance' => $creditBalance,
            'customerList' => $getAllCustomers,
            'agentList' => $getAllAgents
        ]);
    }

    public function bulkSMSagent(Request $req)
    {
        if($req->input('agents') == ''){
            toast('Please choose agent from list.', 'error');
            return redirect('blastMessage');

        }
        // $agentPhoneList = DB::table('users')
        // ->select('phone')
        // ->get();

        // $phoneList= array();
        // foreach($agentPhoneList as $value){
        //     array_push($phoneList,$value->phone);
        // }

        $phoneList = implode(';',$req->input('agents'));
        $todayDate = date("Y-m-d h:i:sa");

        $option = array(
            'apiKey' => '9e8611e27e899012d28f215859462bdf',
            'recipients' => $phoneList,
            'messageContent' => $req->input('messageAgent'),
            'referenceID' => $todayDate
        );

        $url = 'https://www.sms123.net/api/send.php';

        $response = Http::asForm()->get($url, $option);
        // dd(json_decode($response));
        $status = $response['status'];
        $msgCode = $response['msgCode'];

        switch ($msgCode) {
            case 'E00001':
                toast('Message has been sent.', 'success');
                break;
            case 'E00242':
                toast('Invalid recipient(s).', 'error');
                break;
            case 'E00250':
                toast('Insufficient balance.', 'error');
                break;
            case 'BE00128':
                toast('Completed successfully(low balance).', 'success');
                break;
            case 'E00359':
                toast('Invalid API Key.', 'error');
                break;
            default:
                break;
        }
        return redirect('blastMessage');
    }

    public function bulkSMScustomer(Request $req)
    {
        if($req->input('customers') == ''){
            toast('Please choose customer from list.', 'error');
            return redirect('blastMessage');

        }
        
        // $customerPhoneList = DB::table('customers')
        // ->select('phone')
        // ->get();
        // $phoneList= array();
        // foreach($customerPhoneList as $value){
        //     array_push($phoneList,$value->phone);
        // }

        $phoneList = implode(';',$req->input('customers'));
        $todayDate = date("Y-m-d h:i:sa");

        $option = array(
            'apiKey' => '9e8611e27e899012d28f215859462bdf',
            'recipients' => $phoneList,
            'messageContent' => $req->input('messageCustomer'),
            'referenceID' => $todayDate
        );

        $url = 'https://www.sms123.net/api/send.php';

        $response = Http::asForm()->GET($url, $option);
        // dd(json_decode($response));
        $status = $response['status'];
        $msgCode = $response['msgCode'];

        switch ($msgCode) {
            case 'E00001':
                toast('Message has been sent.', 'success');
                break;
            case 'E00242':
                toast('Invalid recipient(s).', 'error');
                break;
            case 'E00250':
                toast('Insufficient balance.', 'error');
                break;
            case 'BE00128':
                toast('Completed successfully(low balance).', 'success');
                break;
            case 'E00359':
                toast('Invalid API Key.', 'error');
                break;
            default:
                break;
        }
        return redirect('blastMessage');
    }

    public function singleSMS(Request $req)
    {
       
        $todayDate = date("Y-m-d h:i:sa");
        $option = array(
            'apiKey' => '9e8611e27e899012d28f215859462bdf',
            'recipients' => $req->input('phoneSingle'),
            'messageContent' => $req->input('messageSingle'),
            'referenceID' => $todayDate
        );

        $url = 'https://www.sms123.net/api/send.php';

        $response = Http::asForm()->GET($url, $option);
        // dd(json_decode($response));
        $status = $response['status'];
        $msgCode = $response['msgCode'];

        switch ($msgCode) {
            case 'E00001':
                toast('Message has been sent.', 'success');
                break;
            case 'E00242':
                toast('Invalid recipient(s).', 'error');
                break;
            case 'E00250':
                toast('Insufficient balance.', 'error');
                break;
            case 'BE00128':
                toast('Completed successfully(low balance).', 'success');
                break;
            case 'E00359':
                toast('Invalid API Key.', 'error');
                break;
            default:
                break;
        }
        return redirect('blastMessage');
    }
}
