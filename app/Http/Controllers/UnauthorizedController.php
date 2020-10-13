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
        switch ($role) {
            case 'admin':
                return redirect('/dashboard');
                break;
            case 'emp':
                return redirect('/projects');
                break;
            default:
            return redirect('/login');
                break;
        }
    }
}
