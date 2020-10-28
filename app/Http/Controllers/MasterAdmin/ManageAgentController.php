<?php

namespace App\Http\Controllers\MasterAdmin;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageAgentController extends Controller
{
    public function index()
    {
        $agentList = DB::table('users')
            ->where('id', '<>', Auth::user()->id)
            ->get();

        return redirect('masteradmin/agent')->with([
            'agentList' => $agentList
        ]);
    }
}
