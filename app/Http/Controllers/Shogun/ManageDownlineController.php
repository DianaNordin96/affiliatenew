<?php

namespace App\Http\Controllers\Shogun;

use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageDownlineController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $email = Auth::user()->email;
        $pass = Auth::user()->password;

        $user = DB::table('users')->where('role','<>','admin')->get();

        return view(
            'shogun/manageDownline',
            [
                'userId' => $id,
                'users' => $user,
            ]
        );
    }

    public function changeRole($role, $id)
    {

        DB::table('users')
            ->where('id', $id)
            ->update([
                'role' => $role
            ]);

        toast('User role has been changed', 'success');
        return redirect('/manageDownlineShogun');
    }

}
