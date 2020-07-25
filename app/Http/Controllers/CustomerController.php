<?php

namespace App\Http\Controllers;

use App\{Stock, Customer, User, Product, Transaction};
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::select('id','name as CustomerName','org_name as OrganizationName','mobile as MobileNumber')
        ->where('active','1')
        ->orderBy('id','desc')
        ->get();
        // error_log('Customer: '.$data);
        return view('customer', ["data" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        unset($request['_token']);
        ($request->active == "on") ? ($request['active']='1') : ($request['active']='0'); // Set active status by translating checbox value
        $res = Customer::create($request->all());
        // error_log($res);

        return \Redirect::route('customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        // error_log($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // error_log('Edit: '.$id);
        $data = Customer::select('id','name as CustomerName','org_name as OrganizationName','mobile as MobileNumber')
        ->where('active','1')
        ->orderBy('id','desc')
        ->get();
        $formdata = Customer::find($id);
        return view('customer', ["id" => $id, "data" => $data, "formdata" => $formdata]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        unset($request['_token']);
        unset($request['_method']);
        ($request->active == "on") ? ($request['active']='1') : ($request['active']='0'); // Set active status by translating checbox value
        $res = Customer::find($id)->update($request->all());
        // error_log($res);

        return \Redirect::route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Customer::where('id',$id)->update(['active' => '0']); //Update the active status
        $res = Customer::where('id',$id)->update(['end_date' => \DB::raw('now()')]); //Update the end_date
        // error_log('DELETE Customer'.$res);
        
        // return \Redirect::route('customer.index');
    }
}
