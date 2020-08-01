<?php

namespace App\Http\Controllers;

use App\{Stock, Customer, User, Product, Transaction};
use Illuminate\Http\Request;
use DB;

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
    public function index(Request $request)
    {
        $request->load_cid = ($request->load_cid == "") ? "all" : $request->load_cid;
        $request->load_pid = ($request->load_pid == "") ? "all" : $request->load_pid;
        
        $cid = $request->load_cid;
        $pid = $request->load_pid;
        
        error_log($cid." - Stock Page - ".$pid);

        $data = Stock::select('stocks.id','customers.name as Customer Name','products.name as Product Name','stocks.quantity as Opening Stock');
        $data = $data->join('customers','stocks.cid','=','customers.id');
        $data = $data->join('products','stocks.pid','=','products.id');
        $data = $data->where('customers.active','1');
        $data = $data->where('products.active','1');
        if($cid != "all"){
            $data = $data->where('customers.id',$cid);
        }
        if($pid != "all"){
            $data = $data->where('products.id',$pid);
        }
        $data = $data->orderBy('id','desc');
        $data = $data->get();
        // dd($data);
        
        $cust_data = DB::select('SELECT 
            customers.id, customers.name, customers.mobile            
        FROM stocks RIGHT OUTER JOIN customers 
        ON customers.id = stocks.cid 
        WHERE customers.active = 1
        GROUP BY customers.id 
        HAVING COUNT(pid) != (
            SELECT 
            COUNT(*) 
            FROM products
        )');

        
        $load_cust_data = Customer::select('id','mobile','name')
        ->where('active','1')
        ->orderBy('id','desc')
        ->get();
        $prod_data = Product::select('id','name')->where('active','1')->get();
        return view('stock', ["data" => $data, "form_cust_data" => $cid, 'form_prod_data' => $pid, 'load_cust_data' => $load_cust_data, "cust_data" => $cust_data, 'prod_data' => $prod_data]);
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
        // error_log($res);
        
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
        $data = Stock::select('stocks.id','customers.name as Customer Name','products.name as Product Name','stocks.quantity as Opening Stock')
        ->join('customers','stocks.cid','=','customers.id')
        ->join('products','stocks.pid','=','products.id')
        ->where('customers.active','1')
        ->where('products.active','1')
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
        // error_log($res);

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
        // error_log(response()->json($res));
        
        // return \Redirect::route('stock.index');
    }
}
