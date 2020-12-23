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
            $notification = array(
                'message' => 'Please choose agent from list.',
                'alert-type' => 'error'
            );

            return redirect('blastMessage')->with($notification);
        }

        if($req->input('messageAgent') == ''){
            $notification = array(
                'message' => 'Please enter your message.',
                'alert-type' => 'error'
            );

            return redirect('blastMessage')->with($notification);
        }
       
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

        $notification = array();
        
        switch ($msgCode) {
            case 'E00001':
                $notification = array(
                    'message' => 'Message has been sent.',
                    'alert-type' => 'success'
                );
                break;
            case 'E00242':
                $notification = array(
                    'message' => 'Invalid recipient(s).',
                    'alert-type' => 'error'
                );
                break;
            case 'E00250':
                $notification = array(
                    'message' => 'Insufficient balance.',
                    'alert-type' => 'error'
                );
                break;
            case 'BE00128':
                $notification = array(
                    'message' => 'Completed successfully(low balance).',
                    'alert-type' => 'success'
                );
                break;
            case 'E00359':
                $notification = array(
                    'message' => 'Invalid API Key.',
                    'alert-type' => 'error'
                );
                break;
            default:
                break;
        }
        return redirect('blastMessage')->with($notification);
    }

    public function bulkSMScustomer(Request $req)
    {
        if($req->input('messageCustomer') == ''){
            $notification = array(
                'message' => 'Please enter your message.',
                'alert-type' => 'error'
            );

            return redirect('blastMessage')->with($notification);
        }

        if($req->input('customers') == ''){
            $notification = array(
                'message' => 'Please choose customer from list.',
                'alert-type' => 'error'
            );
            return redirect('blastMessage')->with($notification);
        }

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
        $notification = array();
        
        switch ($msgCode) {
            case 'E00001':
                $notification = array(
                    'message' => 'Message has been sent.',
                    'alert-type' => 'success'
                );
                break;
            case 'E00242':
                $notification = array(
                    'message' => 'Invalid recipient(s).',
                    'alert-type' => 'error'
                );
                break;
            case 'E00250':
                $notification = array(
                    'message' => 'Insufficient balance.',
                    'alert-type' => 'error'
                );
                break;
            case 'BE00128':
                $notification = array(
                    'message' => 'Completed successfully(low balance).',
                    'alert-type' => 'success'
                );
                break;
            case 'E00359':
                $notification = array(
                    'message' => 'Invalid API Key.',
                    'alert-type' => 'error'
                );
                break;
            default:
                break;
        }
        return redirect('blastMessage')->with($notification);
    }

    public function singleSMS(Request $req)
    {
        if($req->input('phoneSingle') == '' || $req->input('messageSingle') == ''){
            $notification = array(
                'message' => 'Please fill all the details before submit your page.',
                'alert-type' => 'error'
            );

            return redirect('blastMessage')->with($notification);
        }

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

        $notification = array();
        
        switch ($msgCode) {
            case 'E00001':
                $notification = array(
                    'message' => 'Message has been sent.',
                    'alert-type' => 'success'
                );
                break;
            case 'E00242':
                $notification = array(
                    'message' => 'Invalid recipient(s).',
                    'alert-type' => 'error'
                );
                break;
            case 'E00250':
                $notification = array(
                    'message' => 'Insufficient balance.',
                    'alert-type' => 'error'
                );
                break;
            case 'BE00128':
                $notification = array(
                    'message' => 'Completed successfully(low balance).',
                    'alert-type' => 'success'
                );
                break;
            case 'E00359':
                $notification = array(
                    'message' => 'Invalid API Key.',
                    'alert-type' => 'error'
                );
                break;
            default:
                break;
        }
        return redirect('blastMessage')->with($notification);
    }
}
