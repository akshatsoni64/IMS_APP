@if(count($transaction_data)<=0)
    <table class="table table-bordered" border=1 align="center" style="width:100%; text-align: center;">
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
            <td colspan=5>
                <h1 style="color:red">
                    <b>No Data Found</b>
                </h1>
            </td>
        </tr>
        </thead>
    </table>
@else
    @php( $condition = false )
    @foreach($cust_data as $cust)
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
                <td colspan=2><b>Customer Name:</b> {{ $cust->name }} </td>
                <td colspan=3><b>Date:</b> {{ date("d-m-Y") }} </td>
            </tr>
            <tr class="text-center">
                <th>Date</th>
                <th>Product</th>
                <th>Mode</th>
                <th>Vehicle No.</th>
                <th>Stock Count</th>
            </tr>
        </thead>
        @foreach($prod_data as $prod)
            @if($prod->cid == $cust->id)
                <tbody>
                    <!-- Total Variable Initialization -->
                    @php($sum = 0)

                    <!-- Display Opening Stock -->
                    @foreach($opening_data as $row)
                        @if($cust->id === $row->cid && $prod->pid === $row->pid)
                            <tr class="text-center">
                                <td> {{ date_format(date_create($from_date),"d-m-Y") }} </td>
                                <td> {{ $prod->pname }} </td>
                                <td> Opening </td>
                                <td> - </td>
                                @php($sum += $row->opening)
                                <td> {{ $row->opening }} </td>                       
                            </tr>
                        @endif
                    @endforeach

                    <!-- Display Transaction/Stock Details -->
                    @foreach($transaction_data as $row)
                        @if($cust->id === (int)$row->cid && $prod->pid === (int)$row->pid)
                            <tr style="background-color:cyan">
                                <td> {{ date_format(date_create($row->t_date),"d-m-Y") }} </td>
                                <td> {{ $prod->pname }} </td>
                                <td> Issue </td>
                                <td> {{ $row->vehicle_number }} </td>
                                @php($sum += $row->issue)
                                <td> {{ $row->issue }} </td>
                            </tr> 
                            <tr style="background-color:yellow">
                                <td> {{ date_format(date_create($row->t_date),"d-m-Y") }} </td>
                                <td> {{ $prod->pname }} </td>
                                <td> Receive </td>
                                <td> {{ $row->vehicle_number }} </td>
                                @php($sum -= $row->receive)
                                <td> {{ $row->receive }} </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr class="text-center">
                        <td colspan=4>
                            <b> Grand Total: </b>
                        </td>               
                        <td> 
                            <b> {{ $sum }} </b> 
                        </td>
                    </tr>
                </tbody>
            @endif
        @endforeach
        </table>
    @endforeach
@endif