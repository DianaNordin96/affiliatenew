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
            ->where(function($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline','!=', 'decline');
            })
            ->where(function($query) {
                $query->whereNull('statusDownline')
                    ->orWhere('statusDownline','!=', 'pending');
            })
            ->get();

        return view('masteradmin/agents')->with([
            'agentList' => $agentList
        ]);
    }
}
