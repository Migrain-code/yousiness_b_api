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
        $customer->birthday = Carbon::parse($request->input('date'))->format('d.m.Y');
        $customer->note = $request->input('note');
        $customer->status = 1;
        if ($customer->save()) {
            $businessCustomer = new BusinessCustomer();
            $businessCustomer->business_id = $request->user()->id;
            $businessCustomer->customer_id = $customer->id;
            $businessCustomer->save();
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Eklendi. Artık bu müşteri için işlem yapabilirsiniz."
            ]);
        }
    }

    public function edit(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        if (!$customer) {
            return response()->json([
                'status' => "warning",
                'message' => "Müşteri bilgisi bulunamadı"
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
                    'message'=>"Müşteri Bilgileri Güncellendi"
                ]);
            }
        }
        else{
            $findCustomer = Customer::where('email', $request->phone)->first();
            if ($findCustomer){
                return response()->json([
                    'status'=>"danger",
                    'message'=>"Bu telefon numarası ile kayıtlı kullanıcı bulunmakta lütfen başka bir telefon numarası deneyin."
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
                        'message'=>"Müşteri Bilgileri Güncellendi"
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
                'messsage' => "Müşteri Bulunamadı"
            ]);
        }
        BusinessCustomer::where('customer_id', $customer->id)->where('business_id', $request->user()->id)->delete();
        if ($customer->delete()){
            return \response()->json([
                'status' => "success",
                'messsage' => "Müşteri Silindi"
            ]);
        }
    }
}
