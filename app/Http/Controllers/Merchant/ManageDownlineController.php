<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Support\Facades\Hash;
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

        $user = DB::table('users')
        ->where('id','<>',Auth::user()->id)
        ->where('downlineTo',Auth::user()->id)
        ->where('statusDownline','approve')
        ->get();

        $pendingUser = DB::table('users')
            ->where('statusDownline', 'pending')
            ->where('downlineTo', Auth::user()->id)
            ->get();

        return view(
            'merchant/manageDownline',
            [
                'userId' => $id,
                'users' => $user,
                'pendingUser' => $pendingUser,
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
        return redirect('/downline-merchant');
    }

    public function approve($id){

        DB::table('users')
        ->where('id',$id)
        ->update([
            'statusDownline' => 'approve',
            'password' => Hash::make('12345678'),
            'belongsToAdmin' => Auth::user()->belongsToAdmin
        ]);

        toast('Agent has been approved', 'success');
        return redirect('/downline-merchant');
    }

    public function decline($id){
        DB::table('users')
        ->where('id',$id)
        ->update([
            'statusDownline' => 'decline',
        ]);

        toast('Agent has been declined', 'success');
        return redirect('/downline-merchant');
    }
}
