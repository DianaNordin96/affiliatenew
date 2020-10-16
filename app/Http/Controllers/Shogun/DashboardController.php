<?php

namespace App\Http\Controllers\Shogun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Auth::user()->id;
        $email = Auth::user()->email;
        $pass = Auth::user()->password;
        // dd($id,$email,$pass);
        // return view('dashboard',[
        //     'user' => $id,
        // ]);
        return view('shogun/dashboardShogun')->with('userId',$id);
    }
}
