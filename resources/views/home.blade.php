@extends('layouts.app')
@extends('sections.navbar')
@section('content')
    <div class="col-xl-10">
        <div class="px-5">
            @if(count($transaction_data)>0)
                <table class="mt-3 table table-bordered table-striped">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>Product Name</th>
                            <th>Opening Stock</th>
                            <th>[-] Issue</th>
                            <th>[+] Receive</th>
                            <th>Closing Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction_data as $row)
                            <tr class="text-center">
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->opening_stock }}</td>
                                <td>{{ $row->s_issue }}</td>
                                <td>{{ $row->s_receive }}</td>
                                <td>{{ $row->closing_stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="display-1 mt-5 font-weight-bold text-center">Dashboard</p>
            @endif
        </div>
    </div>
@endsection
