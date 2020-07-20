<?php

namespace App\Http\Controllers;

use App\{Stock, Customer, User, Product, Transaction};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
        $data = Transaction::select('transactions.id','customers.name as CustomerName','products.name as ProductName','transactions.t_date as TransactionDate','transactions.issue as Issue','transactions.receive as Receive')
        ->join('customers','transactions.cid','=','customers.id')
        ->join('products','transactions.pid','=','products.id')
        ->orderBy('transactions.id','desc')
        ->orderBy('transactions.t_date','desc')
        ->get();
        $cust_data = Customer::select('id','mobile','name')->where('active','1')->get();
        $prod_data = Product::select('id','name')->where('active','1')->get();
        return view('transaction', ["data" => $data, "cust_data" => $cust_data, 'prod_data' => $prod_data]);
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
        // return $request;
        unset($request['_token']);
        $res = Transaction::create($request->all());
        error_log($res);
        
        return \Redirect::route('transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transaction::select('transactions.id','customers.name as CustomerName','products.name as ProductName','transactions.t_date as TransactionDate' ,'transactions.issue as Issue','transactions.receive as Receive')
        ->join('customers','transactions.cid','=','customers.id')
        ->join('products','transactions.pid','=','products.id')
        ->orderBy('transactions.id','desc')
        ->orderBy('transactions.t_date','desc')
        ->get();
        $cust_data = Customer::select('id','mobile','name')->where('active','1')->get();
        $prod_data = Product::select('id','name')->where('active','1')->get();
        $formdata = Transaction::find($id);
        return view('transaction', ["id" => $id,"data" => $data, "cust_data" => $cust_data, 'prod_data' => $prod_data, "formdata" => $formdata]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        unset($request['_token']);
        unset($request['_method']);
        $res = Transaction::find($id)->update($request->all());
        error_log($res);

        return \Redirect::route('transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Transaction::find($id)->delete();
        error_log(response()->json($res));
        
        // return \Redirect::route('transaction.index');

    }
}
