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

    public function viewAgentProfile($id){

        $getUser = DB::table('users')->where('id',$id)->get();

        return view('masteradmin/viewAgent')->with([
            'users' => $getUser,
            'name' => $getUser[0]->name
        ]);
    }

    public static function countDownline($userID){
        $allDownline = array();
        $statusLoop = true;
        $id = $userID;
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

        $numDownline = count($allDownline);
        return $numDownline;
    }

    public static function getDownline($userID){
        $allDownline = array();
        $statusLoop = true;
        $id = $userID;
        $downlineList = array($id);
        $statusForLoop = array();
        $downlineListAll = array();

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

        foreach($allDownline as $value){
            $dl = DB::table('users')->where('id',$value)->get();

            array_push($downlineListAll,$dl);
        }
        // dd($downlineListAll);

        return $downlineListAll;
    }

}
