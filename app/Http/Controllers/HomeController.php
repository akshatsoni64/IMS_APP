<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Stock, Customer, User, Product, Transaction};
use Illuminate\Support\Facades\Auth;
use \PDF;
use DB;
use Arr;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->user_address = (Auth::check()) ? User::select('address')->where('name',Auth::user())->get() : "";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function export_pdf(Request $request)
    {
        error_log('cust_id - '.$request->cust_id);
        error_log('p_name - '.$request->p_name);
        error_log('ft_date - '.$request->ft_date);
        error_log('tt_date - '.$request->tt_date);
        
        $cust_id = $request->cust_id;
        $pcode = $request->p_name;
        $from = $request->ft_date;
        $to = $request->tt_date;
        
        $cust_data = Customer::select('id','name')->where('active','1');
        if($cust_id !== "all"){
            $cust_data = $cust_data->where('id',$cust_id);
        }
        $cust_data = $cust_data->get();

        $prod_data = Product::select('id','name','quantity')->where('active','1');
        if($pcode !== "all"){
            $prod_data = $prod_data->where('id',$pcode);
        }
        $prod_data = $prod_data->get();
        
        
        if($cust_id === "all"){
            if($pcode === "all"){
                $tquery = 'SELECT 
                    cid, pid, issue, receive, t_date, vehicle_number 
                FROM transactions 
                WHERE t_date >= ? 
                AND t_date <= ? 
                ORDER BY id, pid';
                $tparam = [$from, $to];

                $oquery = 'SELECT 
                    customers.id as cid, 
                    products.id as pid, 
                    ( 
                        stocks.quantity 
                        + opening_stock.open_issue 
                        - opening_stock.open_receive 
                    ) AS opening 
                FROM customers, products, stocks, 
                ( 
                    SELECT 
                        cid, pid, 
                        SUM(issue) as open_issue, 
                        SUM(receive) as open_receive 
                    FROM transactions 
                    WHERE t_date < ? 
                    GROUP BY cid, pid 
                ) AS opening_stock 
                WHERE products.id = opening_stock.pid 
                AND customers.id = opening_stock.cid 
                AND stocks.cid = customers.id 
                AND stocks.pid = products.id';
                $oparam = [$from];
            }
            else{
                $tquery = 'SELECT 
                    cid, pid, issue, receive, t_date, vehicle_number 
                FROM transactions 
                WHERE t_date >= ? 
                AND t_date <= ? 
                AND pid = ? 
                ORDER BY id, pid';
                $tparam = [$from, $to, $pcode];

                $oquery = 'SELECT 
                    customers.id as cid, 
                    products.id as pid, 
                    ( 
                        stocks.quantity 
                        + opening_stock.open_issue 
                        - opening_stock.open_receive 
                    ) AS opening 
                FROM customers, products, stocks, 
                ( 
                    SELECT 
                        cid, pid, 
                        SUM(issue) as open_issue, 
                        SUM(receive) as open_receive 
                    FROM transactions 
                    WHERE t_date < ? 
                    GROUP BY cid, pid 
                ) AS opening_stock 
                WHERE products.id = opening_stock.pid 
                AND customers.id = opening_stock.cid 
                AND stocks.cid = customers.id 
                AND stocks.pid = products.id 
                AND opening_stock.pid = ?';
                $oparam = [$from, $pcode];
            }
        }
        else{
            if($pcode === "all"){
                $tquery = 'SELECT 
                    cid, pid, issue, receive, t_date, vehicle_number 
                FROM transactions 
                WHERE t_date >= ? 
                AND t_date <= ? 
                AND cid = ? 
                ORDER BY id, pid';
                $tparam = [$from, $to, $cust_id];
                
                $oquery = 'SELECT 
                    customers.id as cid, 
                    products.id as pid, 
                    ( 
                        stocks.quantity 
                        + opening_stock.open_issue 
                        - opening_stock.open_receive 
                    ) AS opening 
                FROM customers, products, stocks, 
                ( 
                    SELECT 
                        cid, pid, 
                        SUM(issue) as open_issue, 
                        SUM(receive) as open_receive 
                    FROM transactions 
                    WHERE t_date < ? 
                    GROUP BY cid, pid 
                ) AS opening_stock 
                WHERE products.id = opening_stock.pid 
                AND customers.id = opening_stock.cid 
                AND stocks.cid = customers.id 
                AND stocks.pid = products.id 
                AND opening_stock.cid = ?';
                $oparam = [$from, $cust_id];
            }
            else{   
                $tquery = 'SELECT 
                    cid, pid, issue, receive, t_date, vehicle_number 
                FROM transactions 
                WHERE t_date >= ? 
                AND t_date <= ? 
                AND pid = ? 
                AND cid = ? 
                ORDER BY id, pid';
                $tparam = [$from, $to, $pcode, $cust_id];
                
                $oquery = 'SELECT 
                    customers.id as cid, 
                    products.id as pid, 
                    ( 
                        stocks.quantity 
                        + opening_stock.open_issue 
                        - opening_stock.open_receive 
                    ) AS opening 
                FROM customers, products, stocks, 
                ( 
                    SELECT 
                        cid, pid, 
                        SUM(issue) as open_issue, 
                        SUM(receive) as open_receive 
                    FROM transactions 
                    WHERE t_date < ? 
                    GROUP BY cid, pid 
                ) AS opening_stock 
                WHERE products.id = opening_stock.pid 
                AND customers.id = opening_stock.cid 
                AND stocks.cid = customers.id 
                AND stocks.pid = products.id 
                AND opening_stock.cid = ? 
                AND opening_stock.pid = ?';
                $oparam = [$from, $cust_id, $pcode];
            }
        }

        $transaction_data = DB::select($tquery, $tparam);
        $opening_data = DB::select($oquery, $oparam);

        // dd($cust_data, $prod_data, $stock_data, $opening_data);
        // return $request;
       
        $data = ['from_date' => $from, 'to_date' => $to, 'cust_data' => $cust_data, 'prod_data' => $prod_data, 'transaction_data' => $transaction_data, 'opening_data' => $opening_data];
        $pdf = PDF::loadView('partials._report_view', $data);
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(500,810, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->download('report_pdf.pdf');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function report(Request $request)
    {
        $cust_data = Customer::select('id','mobile','name')->where('active','1')->get();
        return view('report', ["cust_data" => $cust_data, 'transaction_data' => Transaction::all()]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_prod($id)
    {
        error_log($id);        
        if($id !== "all"){
            $prod_data = Transaction::distinct()->select('customers.id','transactions.pid as id','products.name')
            ->join('products','products.id','=','transactions.pid')
            ->join('customers','customers.id','=','transactions.cid')
            ->where('customers.id',$id)
            ->get();
        }
        else{
            $prod_data = Transaction::distinct()->select('transactions.pid as id','products.name')
            ->join('products','products.id','=','transactions.pid')
            ->get();
        }
        error_log($prod_data);
        return json_encode($prod_data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transaction_data = DB::select('select products.name, ( (products.quantity + transaction.open_receive) - transaction.open_issue ) as opening_stock, transaction.s_issue, transaction.s_receive, ( ((products.quantity + transaction.open_receive) - transaction.open_issue) + transaction.s_receive - transaction.s_issue ) as closing_stock from products, ( select s_open.pid, s_open.open_issue, s_open.open_receive, s_close.s_issue, s_close.s_receive from ( select pid as pid, sum(issue) as open_issue, sum(receive) as open_receive from transactions where t_date < DATE_FORMAT(NOW(), "%Y-%m-%d") GROUP by pid ) as s_open LEFT JOIN ( select pid as pidd, sum(issue) as s_issue, sum(receive) as s_receive from transactions where t_date = DATE_FORMAT(NOW(), "%Y-%m-%d") GROUP by pid ) as s_close ON s_open.pid = s_close.pidd ) as transaction where products.id = transaction.pid');
        return view('home', ['transaction_data' => $transaction_data]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fetch_id()
    {
        $cust_data = Customer::count();
        $prod_data = Product::count();

        return json_encode(array('cust_id' => $cust_data+1, 'prod_id' => $prod_data+1));
    }
}
