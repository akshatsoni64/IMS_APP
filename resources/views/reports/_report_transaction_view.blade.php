@if(count($transaction_data)<=0)
    <table class="table table-bordered" border=1 align="center" style="width:100%; text-align: center;">
        <thead>
        <tr>
            <td colspan=6>
                <h1 style="color:red">
                    <b>No Data Found</b>
                </h1>
            </td>
        </tr>
        </thead>
    </table>
@else
    <table class="table table-bordered" border=1 align="center" style="width:100%; text-align: center;">
        <thead>
            <tr>
                <th class="text-center" colspan=6>
                    <h2 style="padding:0px">
                        {{ (Auth::check()) ? Auth::user()->name : 'Report - Header' }}
                    </h2>
                    <h4>
                        Address: {{ (Auth::check()) ? Auth::user()->address : 'Address - Here' }}
                    </h4>
                </th>
            </tr>   
            <tr>
                <td colspan=6> <b>Date:</b> {{ date("d-m-Y") }} </td>            
            </tr>
            <tr class="text-center">
                <th>Date</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Vehicle No.</th>
                <th>Issued</th>
                <th>Received</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction_data as $row)
                <tr class="text-center">
                    <td> {{ date_format(date_create($row->t_date),"d-m-Y") }} </td>
                    <td> {{ $row->cname }} </td>
                    <td> {{ $row->pname }} </td>
                    <td> {{ $row->vehicle_number }} </td>
                    <td> {{ $row->issue }} </td>
                    <td> {{ $row->receive }} </td>
                </tr>                        
            @endforeach
        </tbody>
    </table>
@endif