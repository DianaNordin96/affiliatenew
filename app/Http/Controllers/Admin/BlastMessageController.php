<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlastMessageController extends Controller
{
    public function index()
    {

        $option = array(
            'apiKey' => '9e8611e27e899012d28f215859462bdf',
            'email' => 'diananana1996@gmail.com'
        );

        $url = 'https://www.sms123.net/api/getBalance.php';

        $response = Http::asForm()->get($url, $option);
        // dd(json_decode($response));
        $creditBalance = $response['balance'];


        return view('admin/blastmessage')->with([
            'creditBalance' => $creditBalance
        ]);
    }

    public function bulkSMS()
    {
    }

    public function singleSMS(Request $req)
    {

        $todayDate = date("Y-m-d h:i:sa");
        $option = array(
            'apiKey' => '9e8611e27e899012d28f215859462bdf',
            'recipients' => '+60123456789',
            'messageContent' => '+60123456789',
            'referenceID' => $todayDate
        );

        $url = 'https://www.sms123.net/api/send.php';

        $response = Http::asForm()->POST($url, $option);
        // dd(json_decode($response));
        $status = $response['status'];
        $msgCode = $response['msgCode'];

        switch ($msgCode) {
            case 'E00001':
                toast('Completed successfully.', 'success');
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
