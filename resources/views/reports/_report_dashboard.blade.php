@if(count($dashboard_data)<=0)
    <table class="table table-bordered" border=1 align="center" style="width:100%; text-align: center;">
        <thead>
        <tr>
            <td colspan=5>
                <h4 style="color:red">
                    <b>No Data Found</b>
                </h4>
            </td>
        </tr>
        </thead>
    </table>
@else
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
            <td colspan=5><b>Report Date:</b> {{ date("d-m-Y") }} </td>
        </tr>
        <tr class="text-center">
            <th>Product Name</th>
            <th>Opening Stock</th>
            <th>Issue</th>
            <th>Receive</th>
            <th>Closing Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dashboard_data as $row)
        <tr>
            <td>{{ $row->name }}</td>
            <td>{{ $row->opening_stock }}</td>
            <td>{{ $row->s_issue ?? 0 }}</td>
            <td>{{ $row->s_receive ?? 0 }}</td>
            <td>{{ $row->opening_stock - $row->s_issue + $row->s_receive }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
@endif