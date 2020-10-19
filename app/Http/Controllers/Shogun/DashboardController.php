<?php

namespace App\Http\Controllers\Shogun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  

    public function index()
    {
        return view('shogun/dashboardShogun');
    }  
    
    public function __construct()
    {
        $this->middleware('auth');
    }
}
