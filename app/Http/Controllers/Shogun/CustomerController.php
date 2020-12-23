<?php

namespace App\Http\Controllers\Shogun;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('shogun/customers')->with([
            'customers' => $customers
        ]);
    }

    public function create(Request $req)
    {
        $validatedData = [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before creating new customer', 'error');
            return redirect('customers-shogun');
        } else {
            $data = $req->input();
            try {

                DB::table('customers')
                    ->insert([
                        'name' => $data['name'],
                        'address' => $data['address'],
                        'phone' => $data['phone'],
                        'user_id' => Auth::user()->id
                    ]);

                toast('Customer has been created', 'success');
                return redirect('customers-shogun')->with('success', 'ok');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function update(Request $req)
    {
        $validatedData = [
            'nameEdit' => 'required',
            'phoneEdit' => 'required',
            'address1Edit' => 'required',
            'address2Edit' => '',
            'address3Edit' => '',
            'stateEdit' => 'required',
            'postcodeEdit' => 'required',
            'emailEdit' => 'required',
            'cityEdit' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            $notification = array(
                'message' => 'Make sure all details has been filled properly',
                'alert-type' => 'error'
            );
            return redirect('customers-shogun')->with($notification);
        } else {
            $data = $req->input();
            try {

                DB::table('customers')
                    ->where('id', $data['customerID'])
                    ->update([
                        'name' => $data['nameEdit'],
                        'address' => $data['address1Edit'],
                        'phone' => $data['phoneEdit']
                    ]);

                    return redirect('customers-shogun')->with('success','Customer has been updated');
            } catch (Exception $e) {
                $notification = array(
                    'message' => 'Something went wrong',
                    'alert-type' => 'error'
                );
                return redirect('customers-shogun')->with($notification);
            }
        }
    }

    public function delete($id)
    {
        DB::table('customers')
            ->where('id', $id)
            ->delete();

        toast('Customer has been removed', 'success');
        return redirect('customers-shogun');
    }

    public static function getCustomer($id)
    {
        $customer = DB::table('customers')
            ->where('id', $id)
            ->get();

        return $customer;
    }
}
