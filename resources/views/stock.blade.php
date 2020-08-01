@extends('layouts.app')
@extends('sections.navbar')

@section('content')
@php($route=Request::route()->getName())
@php( $value=explode('.',$route) ) 
<div class="col">
    <div class="px-3">
        <!-- <h4 align="center">        
            {{ Str::title($value[0]) }}
            Page
        </h4> -->
        
        @if($value[1] == "edit")
            <form id="{{$value[0]}}-form-div" action="{{ route('stock.update', $id) }}" method="POST" class="p-4 border">
                @method('PUT')
        @else
            <form id="load-stock-div" style='display:block' action="{{ route('stock.index') }}" class="p-4 border">
                @csrf
                <div class="form-row">
                    <div class="col-xl-1 text-right">
                        <label>Customer*</label>
                    </div>
                    <div class="col">
                        <select name="load_cid" class="custom-select" value="" required autofocus>
                            <option disabled value="">Customer Name</option>
                            <option selected value="all">All</option>
                            @foreach($load_cust_data as $row)                                
                                <option {{ ($form_cust_data == $row->id) ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->name." - ".$row->mobile }}</option>
                            @endforeach
                       </select>
                    </div>
                    <div class="col-xl-1 text-right">
                        <label>Product*</label>
                    </div>
                    <div class="col">
                        <select name="load_pid" class="custom-select" value="" required>
                            <!-- <option selected disabled value="">-- Please Select Customer First --</option> -->
                            <option disabled value="">Product Code</option>
                            <option selected value="all">All</option>
                            @foreach($prod_data as $row)
                                <option {{ ($form_prod_data == $row->id) ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col text-center">
                        <input class="btn btn-outline-primary" type="submit" value="OK">
                    </div>
                </div>
            </form>
            <form id="{{$value[0]}}-form-div" style='display:none' action="{{ route('stock.store') }}" method="POST" class="p-4 border">
        @endif
            @csrf
            <div class="form-row">
                <div class="col-xl-1 text-right">
                    <label>Customer*</label>
                </div>
                <div class="col">
                    <select name="cid" id="stock-customer" class="custom-select" required autofocus>
                        @if($value[1] == "edit")
                            <option disabled value="">Customer Name</option>
                            @foreach($cust_data as $row)
                                <option {{ ($row->id == $formdata->cid) ? "selected" : "" }} value="{{ $row->id }}">{{ $row->name." - ".$row->mobile }}</option>
                            @endforeach
                        @else
                            <option selected disabled value="">Customer Name</option>
                            @foreach($cust_data as $row)                                
                                <option value="{{ $row->id }}">{{ $row->name." - ".$row->mobile }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-xl-1 text-right">
                    <label>Product*</label>
                </div>
                <div class="col">
                    <select name="pid" id="stock-products" class="custom-select" required>
                        @if($value[1] == "edit")
                            <option disabled value="">Product Code</option>
                            @foreach($prod_data as $row)
                                <option {{ ($row->id == $formdata->pid) ? "selected" : "" }} value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        @else
                            <option selected disabled value="">-- Please Select Customer First --</option>
                            <!-- <option selected disabled value="">Product Code</option>
                            @foreach($prod_data as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach -->
                        @endif
                    </select>
                </div>
                <div class="col-xl-1 text-right">
                    <label>Opening*</label>
                </div>
                <div class="col">
                    <input class="form-control" value="{{ $formdata->quantity ?? '0' }}" name="quantity" type="number" placeholder="Quantity" min=0 max=999 required>
                </div>
                <div class="col">
                    <input 
                        class="btn btn-block {{ ($value[1] == 'edit') ? 'btn-outline-primary' : 'btn-outline-success' }}" 
                        type="submit" 
                        value="{{ ($value[1] == 'edit') ? 'Update' : 'Submit' }}"
                    >
                </div>
                <div class="col">
                    <a class="btn btn-block btn-outline-danger" type="button" href="{{ route($value[0].'.index') }}">Cancel</a>
                </div> 
            </div>
        </form>
        @include('partials._datatable')
    </div>
</div>
@endsection