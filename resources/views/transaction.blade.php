@extends('layouts.app')
@extends('sections.navbar')

@section('content')
<div class="col-xl-10">
    <div class="px-5">
        <h1 align="center">
            @php($route=Request::route()->getName())
            @php( $value=explode('.',$route) ) 
            {{ Str::title($value[0]) }}
            Page
        </h1>
        @if($value[1]=="edit")
            <form action="{{ route('transaction.update', $id) }}" class="p-4 border" method="POST">
                @method('PUT')
        @else
            <form action="{{ route('transaction.store') }}" class="p-4 border" method="POST">
        @endif
            @csrf
            <div class="form-row mt-2">
                <div class="col">
                    <label>Customer Name*</label>
                    <select name="cid" class="custom-select" required autofocus>
                        @if($value[1] === "edit")
                            <option selected disabled value="">Customer Name</option>
                            @foreach($cust_data as $row)
                                <option {{ ($row->id === $formdata->id) ? "selected" : "" }} value="{{ $row->id }}">{{ $row->name." - ".$row->mobile }}</option>
                            @endforeach
                        @else
                            <option selected disabled value="">Customer Name</option>
                            @foreach($cust_data as $row)                                
                                <option value="{{ $row->id }}">{{ $row->name." - ".$row->mobile }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col">
                    <label>Product Code*</label>
                    <select name="pid" class="custom-select" required>
                        @if($value[1] === "edit")
                            <option selected disabled value="">Product Code</option>
                            @foreach($prod_data as $row)
                                <option {{ ($row->id === $formdata->id) ? "selected" : "" }} value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        @else
                            <option selected disabled value="">Product Code</option>
                            @foreach($prod_data as $row)
                                <option value="{{ $row->id }}">{{$row->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col">
                    <label>Issued Quantity*</label>
                    <input class="form-control" value="{{ $formdata->issue ?? '' }}" name="issue" type="number" placeholder="Issued Quantity" max=999>
                </div>
                <div class="col">
                    <label>Received Quantity*</label>
                    <input class="form-control" value="{{ $formdata->receive ?? '0' }}" name="receive" type="number" placeholder="Received Quantity" max=999>
                </div>
                <div class="col">
                    <label>Transaction Date*</label>
                    <input class="form-control" value="{{ $formdata->t_date ?? '' }}" name="t_date" type="date" title="Transaction Date" required>
                </div>
                <div class="col">
                    <label>Vehicle Number</label>
                    <input class="form-control" value="{{ $formdata->vehicle_number ?? '' }}" name="vehicle_number" type="text" placeholder="Vehicle Number">
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col">
                    <label>Remarks</label>
                    <input class="form-control" value="{{ $formdata->remarks ?? '' }}" name="remarks" type="text" placeholder="Remarks">
                </div>                
            </div>
            <div class="form-row mt-4">
                <div class="col">
                    <input class="btn btn-block btn-success" type="submit" value="Submit">
                </div>
                <div class="col">
                    <input class="btn btn-block btn-danger" type="reset" value="Reset">
                </div>                
            </div>
        </form>
        @include('partials._datatable')
    </div>
</div>
@endsection