<?php

namespace App\Http\Controllers\MasterAdmin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ManageCommissionController extends Controller
{
    public function index()
    {
        $commissionList = DB::table('commission')
            ->where('status', '=', 'pending')
            ->get();

        return view('masteradmin/commission')->with([
            'commissionList' => $commissionList
        ]);
    }

    public function approve($id)
    {
        $users = DB::table('commission')
            ->join('users', 'commission.user_id', '=', 'users.id')
            ->where('commission.id', $id)
            ->select('users.commissionPoint', 'commission.user_id', 'commission.amountRequest')
            ->get();

        foreach ($users as $user) {

            $beforeDeduct = $user->commissionPoint;
            $afterDeduct = $user->commissionPoint - $user->amountRequest;

            DB::table('commission')
                ->where('id', '=', $id)
                ->update([
                    'status' => 'approve',
                    'before' => $beforeDeduct,
                    'after' => $afterDeduct
                ]);

            DB::table('users')
                ->where('id', '=', $user->user_id)
                ->update([
                    'commissionPoint' => $afterDeduct
                ]);
        }

        return redirect('master-commission')->with('success','User request has been approved');
    }

    public function decline($id)
    {
        DB::table('commission')
            ->where('id', '=', $id)
            ->update([
                'status' => 'decline'
            ]);

            return redirect('master-commission')->with('success','User request has been declined');
    }
}
