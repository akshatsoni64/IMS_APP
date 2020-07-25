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
        
        @if($value[1]=="edit")
            <form action="{{ route('stock.update', $id) }}" method="POST" class="p-4 border">
                @method('PUT')
        @else
            <form id="form-div" style='display:none' action="{{ route('stock.store') }}" method="POST" class="p-4 border">
        @endif
            @csrf
            <div class="form-row">
                <div class="col">
                    <label>Customer Name*</label>
                    <select name="cid" id="stock-customer" class="custom-select" value="" required autofocus>
                        @if($value[1] == "edit")
                            <option disabled value="">Customer Name</option>
                            @foreach($cust_data as $row)
                                <option {{ ($row->id == $formdata->cid) ? "selected" : "" }} value="{{ $row->cid }}">{{ $row->name." - ".$row->mobile }}</option>
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
                    <select name="pid" id="stock-products" class="custom-select" value="" required>
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
                <div class="col">
                    <label>Opening Stock*</label>
                    <input class="form-control" value="{{ $formdata->quantity ?? '' }}" name="quantity" type="number" placeholder="Quantity" min=0 max=999 required>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col">
                    <input class="btn btn-block {{ ($value[1] == 'edit') ? 'btn-outline-primary' : 'btn-outline-success' }}" type="submit" value="{{ ($value[1] == 'edit') ? 'Update' : 'Submit' }}">
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