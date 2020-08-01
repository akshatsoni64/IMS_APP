<?php

namespace App\Http\Controllers;

use App\{Stock, Customer, User, Product, Transaction};
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

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
        $data = Customer::select('id','name as Customer Name','org_name as Organization Name','mobile as Mobile Number')
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
        // ($request->active == "on") ? ($request['active']='1') : ($request['active']='0'); // Set active status by translating checbox value
        $res = Customer::create($request->all());
        $prod = Product::select('id')->get();
        foreach($prod as $row){
            Stock::create(['cid' => $request->id, 'pid' => $row->id, 'quantity' => 0]);
        }
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
        $data = Customer::select('id','name as Customer Name','org_name as Organization Name','mobile as Mobile Number')
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
        // ($request->active == "on") ? ($request['active']='1') : ($request['active']='0'); // Set active status by translating checbox value
        if($request->active == "on"){
            $count = DB::select('SELECT COUNT(*) AS count FROM transactions WHERE cid = ?',[$id]);
            if($count[0]->count > 0){
                echo "Failed";
                $request['active']='1';
            }
            else{
                $res = Customer::where('id',$id)->update(['active' => '0']); //Update the active status
                $res = Customer::where('id',$id)->update(['end_date' => \DB::raw('now()')]); //Update the end_date
                $request['active']='0';
            }
        }
        else{
            $request['active']='1';
        }
        $res = Customer::find($id)->update($request->all());

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
        $count = DB::select('SELECT COUNT(*) AS count FROM transactions WHERE cid = ?',[$id]);
        error_log($count[0]->count);
        if($count[0]->count > 0){
            return "Failed";
        }
        else{
            $res = Customer::where('id',$id)->update(['active' => '0']); //Update the active status
            $res = Customer::where('id',$id)->update(['end_date' => \DB::raw('now()')]); //Update the end_date
        }
        // error_log('DELETE Customer'.$res);
        
        // return \Redirect::route('customer.index');
    }
}
