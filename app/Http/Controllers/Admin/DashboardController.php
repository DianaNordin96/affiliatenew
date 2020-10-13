<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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
        return view('admin/dashboard')->with('userId',$id);
    }
}
