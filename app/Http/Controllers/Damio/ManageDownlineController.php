<?php

namespace App\Http\Controllers\Damio;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageDownlineController extends Controller
{
    public function index()
    {
    
        $allDownline = array();
        $statusLoop = true;
        $id = Auth::user()->id;
        $downlineList = array($id);
        $statusForLoop = array();

        while ($statusLoop) {
            $statusForLoop = array();
            foreach ($downlineList as $value) {

                $userDownlineL1 = DB::table('users')
                    ->where('downlineTo', $value)
                    ->where(function($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline','!=', 'decline');
                    })
                    ->where(function($query) {
                        $query->whereNull('statusDownline')
                            ->orWhere('statusDownline','!=', 'pending');
                    })
                    ->select('id')
                    ->get();

                foreach ($userDownlineL1 as $valueL2) {
                    array_push($downlineList, $valueL2->id);
                    array_push($allDownline, $valueL2->id);

                    if ($valueL2->id != '') {
                        array_push($statusForLoop, 'true');
                    } else {
                        array_push($statusForLoop, 'false');
                    }
                }
                $key = array_search($value, $downlineList);
                unset($downlineList[$key]);
            }

            if (in_array('true', $statusForLoop, true)) {
                $statusLoop = true;
            } else {
                $statusLoop = false;
            }
        }

        $users = array();
        
        for($i=0;$i<count($allDownline);$i++){
            $getUser= DB::table('users')
            ->where('id',$allDownline[$i])
            ->get();

            array_push($users,$getUser);
        }

        $pendingUser = DB::table('users')
            ->where('statusDownline', 'pending')
            ->where('downlineTo', Auth::user()->id)
            ->get();

        return view(
            'damio/manageDownline',
            [
                'users' => $users,
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

        
        return redirect('/downline-damio')->with('success','User role has been changed');
    }

    public function approve($id){

        DB::table('users')
        ->where('id',$id)
        ->update([
            'statusDownline' => 'approve',
            'password' => Hash::make('12345678'),
            'belongsToAdmin' => Auth::user()->belongsToAdmin
        ]);

        
        return redirect('/downline-damio')->with('success','Agent has been approved');
    }

    public function decline($id){
        DB::table('users')
        ->where('id',$id)
        ->update([
            'statusDownline' => 'decline',
        ]);

        
        return redirect('/downline-damio')->with('success','Agent has been declined');
    }
}
