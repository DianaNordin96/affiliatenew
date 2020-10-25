<?php

namespace App\Http\Controllers\SuperAdmin;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageAgent extends Controller
{
    public function index()
    {
        $agentList = DB::table('users')
            ->where('id', '<>', Auth::user()->id)
            ->get();

        return redirect('superadmin/agent')->with([
            'agentList' => $agentList
        ]);
    }
}
