<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UnauthorizedController extends Controller
{
    public function index()
    {
        // User role
        $role = Auth::user()->role;

        // Check user role
        // switch ($role) {
        //     case 'admin':
        //         return redirect('/dashboard');
        //         break;
        //     case 'shogun':
        //         return redirect('/ShogunDashboard');
        //         break;
        //     case 'damio':
        //         return redirect('/DamioDashboard');
        //         break;
        //     case 'merchant':
        //         return redirect('/MerchantDashboard');
        //         break;
        //     case 'dropship':
        //         return redirect('/DropshipDashboard');
        //         break;
        //     default:
        //         return redirect('/login');
        //         break;
        // }
    }
}
