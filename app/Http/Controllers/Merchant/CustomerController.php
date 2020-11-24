<?php

namespace App\Http\Controllers\Merchant;
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
        ->where('user_id',Auth::user()->id)
        ->get();
        
        return view('merchant/customers')->with([
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
            return redirect('customers-merchant');
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
                return redirect('customers-merchant');
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
            'addressEdit' => 'required',
        ];

        $validator = Validator::make($req->all(), $validatedData);
        if ($validator->fails()) {
            toast('Please fill in all the box before updating customer', 'error');
            return redirect('customers-merchant');
        } else {
            $data = $req->input();
            try {

                DB::table('customers')
                    ->where('id', $data['customerID'])
                    ->update([
                        'name' => $data['nameEdit'],
                        'address' => $data['addressEdit'],
                        'phone' => $data['phoneEdit']
                    ]);


                toast('Customer has been updated', 'success');
                return redirect('customers-merchant');
            } catch (Exception $e) {
                return redirect('insert')->with('failed', "operation failed");
            }
        }
    }

    public function delete($id)
    {
        DB::table('customers')
        ->where('id',$id)
        ->delete();

        toast('Customer has been removed', 'success');
        return redirect('customers-merchant');
    }
}
