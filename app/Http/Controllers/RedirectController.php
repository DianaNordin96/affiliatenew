<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirect()
    {
        if (isset(Auth::user()->role)) {
            // Check user role
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect('/dashboard');
                    break;
                case 'shogun':
                    return redirect('/ShogunDashboard');
                    break;
                case 'damio':
                    return redirect('/DamioDashboard');
                    break;
                case 'merchant':
                    return redirect('/MerchantDashboard');
                    break;
                case 'dropship':
                    return redirect('/DropshipDashboard');
                    break;
                default:
                    return redirect('/login');
                    break;
            }
        } else {
            return redirect('/login');
        }
    }
}
