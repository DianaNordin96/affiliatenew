<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/profile';

    public function redirectTo()
    {

        // User role
        $role = Auth::user()->role;

        // Check user role
        switch ($role) {
            case 'admin':
                return '/dashboard';
                break;
            case 'shogun':
                return '/ShogunDashboard';
                break;
            case 'damio':
                return '/DamioDashboard';
                break;
            case 'merchant':
                return '/MerchantDashboard';
                break;
            case 'dropship':
                return '/DropshipDashboard';
                break;
            default:
                return '/login';
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
