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
            <form action="{{ route('stock.update', $id) }}" method="POST" class="p-4 border">
                @method('PUT')
        @else
            <form action="{{ route('stock.store') }}" method="POST" class="p-4 border">
        @endif
            @csrf
            <div class="form-row mt-2">
                <div class="col">
                    <label>Customer Name*</label>
                    <select name="cid" class="custom-select" value="" required autofocus>
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
                    <select name="pid" class="custom-select" value="" required>
                        @if($value[1] === "edit")
                            <option selected disabled value="">Product Code</option>
                            @foreach($prod_data as $row)
                                <option {{ ($row->id === $formdata->id) ? "selected" : "" }} value="{{ $row->pcode }}">{{ $row->name }}</option>
                            @endforeach
                        @else
                            <option selected disabled value="">Product Code</option>
                            @foreach($prod_data as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col">
                    <label>Opening Stock*</label>
                    <input class="form-control" value="{{ $formdata->quantity ?? '' }}" name="quantity" type="number" placeholder="Quantity" min=0 max=999 required>
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