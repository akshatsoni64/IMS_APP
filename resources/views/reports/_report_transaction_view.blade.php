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
@foreach($prod_data as $prod)
    @if($loop->last)
        <table class="table table-bordered" border=1 align="center" style="width:100%; text-align: center;page-break-after: avoid;">    
    @else
        <table class="table table-bordered" border=1 align="center" style="width:100%; text-align: center;page-break-after: always;">
    @endif
    <thead>
        <tr>
            <th class="text-center" colspan=5>
                <h2 style="padding:0px">
                    {{ (Auth::check()) ? Auth::user()->name : 'Report - Header' }}
                </h2>
                <h4>
                    Address: {{ (Auth::check()) ? Auth::user()->address : 'Address - Here' }}
                </h4>
            </th>
        </tr>   
        <tr>
            <td colspan=2> <b>Product:</b> {{ $prod->name }} </td>
            <td colspan=3> <b>Date:</b> {{ date("d-m-Y") }} </td>
            
        </tr>
        <tr class="text-center">
            <th>Date</th>
            <th>Customer</th>
            <th>Vehicle No.</th>
            <th>Issued</th>
            <th>Received</th>
            <!-- <th>Remarks</th> -->
        </tr>
    </thead>
    <tbody>
        @php($sum_stock = 0)
        @foreach($transaction_data as $row)
            <!-- @php(error_log($row)) -->
            @if($row->pid == $prod->id)
                <tr class="text-center">
                    <td> {{ date_format(date_create($row->t_date),"d-m-Y") }} </td>
                    <td> {{ $row->name }} </td>
                    <td> {{ $row->vehicle_number }} </td>
                    <td> {{ $row->issue }} </td>
                    <td> {{ $row->receive }} </td>
                    @php( $sum_stock += ($row->receive - $row->issue) )
                </tr>                        
            @endif
        @endforeach
        <tr class="text-center">
            <td colspan=3> Grand Total: </td>
            <td colspan=2> {{$sum_stock}} </td>
        </tr>
    </tbody>
</table>
@endforeach
@endif