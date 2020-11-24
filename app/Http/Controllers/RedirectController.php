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
                case 'masteradmin':
                    $url = '/MasterDashboard';
                    break;
                case 'admin':
                    $url = '/dashboard';
                    break;
                case 'shogun':
                    $url = '/ShogunDashboard';
                    break;
                case 'damio':
                    $url = '/DamioDashboard';
                    break;
                case 'merchant':
                    $url = '/MerchantDashboard';
                    break;
                case 'dropship':
                    $url = '/DropshipDashboard';
                    break;
                default:
                    $url = '/login';
                    break;
            }

            return redirect($url);
        } else {
            return redirect('/login');
        }
    }
}
