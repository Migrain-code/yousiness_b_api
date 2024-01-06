<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerAddRequest;
use App\Http\Resources\BusinessCustomerResource;
use App\Models\BusinessCustomer;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @group Customer
 *
 */
class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->user();
        $businessCustomers = $business->customers()->get();
        $customers = [];
        foreach ($businessCustomers as $customer) {
            $customers[] = $customer->customer;
        }
        $bCustomers = $business->appointments()->with('customer')->get()->pluck('customer');
        foreach ($bCustomers as $customer){
            $customers[] = $customer;
        }
        return response()->json([
            'customers' => BusinessCustomerResource::collection($customers),
        ]);
    }

    public function create(CustomerAddRequest $request)
    {
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->email = $request->input('phone');
        $customer->phone = $request->input('phone');
        $customer->custom_email = $request->input('email');
        $customer->password = Hash::make($request->input('password'));
        $customer->gender = $request->input('gender');
        $customer->birthday = Carbon::parse(str_replace('/', '-', $request->input('date')))->format('Y-m-d');
        $customer->note = $request->input('note');
        $customer->status = 1;
        if ($customer->save()) {
            $businessCustomer = new BusinessCustomer();
            $businessCustomer->business_id = $request->user()->id;
            $businessCustomer->customer_id = $customer->id;
            $businessCustomer->save();
            return response()->json([
                'status' => "success",
                'message' => "Kunde hinzugefügt. Sie können nun Transaktionen für diesen Kunden durchführen."
            ]);
        }
    }

    public function edit(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        if (!$customer) {
            return response()->json([
                'status' => "warning",
                'message' => "Keine Kundeninformationen gefunden"
            ]);
        }
        else{
            return response()->json([
               'customer' => BusinessCustomerResource::make($customer)
            ]);
        }
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        if ($request->phone == $customer->email){
            $customer->name=$request->input('name');
            $customer->email=$request->input('phone');
            $customer->phone=$request->input('phone');
            $customer->custom_email=$request->input('email');
            if ($request->has('password'))
            {
                $customer->password= Hash::make($request->input('password'));
            }
            $customer->gender=$request->input('gender');
            $customer->status=1;
            if ($customer->save()){
                return response()->json([
                    'status'=>"success",
                    'message'=>"Kundeninformationen aktualisiert"
                ]);
            }
        }
        else{
            $findCustomer = Customer::where('email', $request->phone)->first();
            if ($findCustomer){
                return response()->json([
                    'status'=>"danger",
                    'message'=>"Es ist bereits ein Benutzer mit dieser Mobilnummer registriert."
                ]);
            }
            else{
                $customer->name=$request->input('name');
                $customer->email=$request->input('phone');
                $customer->phone=$request->input('phone');
                $customer->custom_email=$request->input('email');
                if ($request->has('password'))
                {
                    $customer->password= Hash::make($request->input('password'));
                }
                $customer->gender=$request->input('gender');
                $customer->status=1;
                if ($customer->save()){
                    return response()->json([
                        'status'=>"success",
                        'message'=>"Kundeninformationen aktualisiert"
                    ]);
                }
            }
        }
    }

    public function destroy(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        if (!$customer){
            return \response()->json([
                'status' => "warning",
                'messsage' => "Keine Kunden gefunden"
            ]);
        }
        $businessCustomer = BusinessCustomer::where('customer_id', $customer->id)->where('business_id', $request->user()->id)->delete();
        if ($businessCustomer->delete()){
            return \response()->json([
                'status' => "success",
                'messsage' => "Kunde gelöscht"
            ]);
        }
    }
}
