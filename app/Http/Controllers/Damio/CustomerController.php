<?php

namespace App\Http\Controllers\Damio;

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

        return view('damio/customers')->with([
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
            return redirect('customers-damio')->with('error', 'Please fill in all the box before creating new customer');
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

                return redirect('customers-damio')->with('success', 'Customer has been created');
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
            'notesEdit' => '',
            'cityEdit' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            $notification = array(
                'message' => 'Make sure all details has been filled properly',
                'alert-type' => 'error'
            );
            return redirect('customers-damio')->with($notification);
        } else {
            $data = $req->input();
            try {

                DB::table('customers')
                    ->where('id', $data['customerID'])
                    ->update([
                        'name' => $data['nameEdit'],
                        'address' => $data['address1Edit'],
                        'phone' => $data['phoneEdit'],
                        'address_two' => $data['address2Edit'],
                        'address_three' => $data['address3Edit'],
                        'state' => $data['stateEdit'],
                        'notes' => $data['notesEdit'],
                        'city' => $data['cityEdit'],
                        'postcode' => $data['postcodeEdit']
                    ]);

                    return redirect('customers-damio')->with('success','Customer has been updated');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function delete($id)
    {
        DB::table('customers')
            ->where('id', $id)
            ->delete();


        return redirect('customers-damio')->with('success', 'Customer has been removed');
    }

    public static function getCustomer($id)
    {
        $customer = DB::table('customers')
            ->where('id', $id)
            ->get();

        return $customer;
    }
}
