<?php

namespace App\Http\Controllers;

use App\{Stock, Customer, User, Product, Transaction};
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Stock::select('stocks.id','customers.name as CustomerName','products.name as ProductName','stocks.quantity as Quantity')
        ->join('customers','stocks.cid','=','customers.id')
        ->join('products','stocks.pid','=','products.id')
        ->orderBy('id','desc')
        ->get();
        // dd($data);
        $cust_data = Customer::select('id','mobile','name')->where('active','1')->get();
        $prod_data = Product::select('id','name')->where('active','1')->get();
        return view('stock', ["data" => $data, "cust_data" => $cust_data, 'prod_data' => $prod_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        unset($request['_token']);
        $res = Stock::create($request->all());
        error_log($res);
        
        return \Redirect::route('stock.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Stock::select('stocks.id','customers.name as CustomerName','products.name as ProductName','stocks.quantity as Quantity')
        ->join('customers','stocks.cid','=','customers.id')
        ->join('products','stocks.pid','=','products.id')
        ->orderBy('id','desc')
        ->get();
        $cust_data = Customer::select('id','mobile','name')->where('active','1')->get();
        $prod_data = Product::select('id','name')->where('active','1')->get();
        $formdata = Stock::find($id);
        return view('stock', ["id" => $id,"data" => $data, "cust_data" => $cust_data, 'prod_data' => $prod_data, "formdata" => $formdata]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        unset($request['_token']);
        unset($request['_method']);
        $res = Stock::find($id)->update($request->all());
        error_log($res);

        return \Redirect::route('stock.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Stock::find($id)->delete();
        error_log(response()->json($res));
        
        // return \Redirect::route('stock.index');
    }
}
