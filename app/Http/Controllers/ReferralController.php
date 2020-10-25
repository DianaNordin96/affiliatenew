<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index($id){
        return view('referral/register')->with([
            'userID' => $id
        ]);
    }
}
