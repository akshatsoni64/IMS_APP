@extends('layouts.app')
@extends('sections.navbar')

@section('content')
@php($route=Request::route()->getName())
@php( $value=explode('.',$route) ) 
<div class="col">
    <div class="px-2">
        <!-- <h4 align="center">        
            {{ Str::title($value[0]) }}
            Page
        </h4> -->
        
        <form action="{{ route('report') }}" method="" class="p-4 border mb-4" id="report-form" style="display:block">
            @csrf
            <div class="form-row mt-2">
                <!-- <div class="col-xl-1">
                </div> -->
                <div class="col-xl-3">
                    <label class="font-weight-bold">From: </label>
                    <input value="{{ $from_date ?? date('Y-m-d') }}" type="date" name="ft_date" class="form-control" max="{{ date('Y-m-d') }}" required autofocus>
                </div>              
                <!-- <div class="col-xl-1 text-center">
                </div> -->
                <div class="col-xl-3">
                    <label class="font-weight-bold">To: </label>
                    <input value="{{ $to_date ?? date('Y-m-d') }}" type="date" name="tt_date" class="form-control" max="{{ date('Y-m-d') }}" required>
                </div>              
                <div class="col">
                    <label class="font-weight-bold">Customer Name: </label>
                    <select title="Customer Name" id="cust_data" name="cust_id" class="custom-select" required>                       
                        <option disabled value="">Customer Name</option>
                        <option selected value="all">All</option>                    
                        @foreach($form_cust_data as $row)                                
                            <option {{ ($cust_id == $row->id) ? "selected" : "" }} value="{{ $row->id }}">{{ $row->name." - ".$row->mobile }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="font-weight-bold">Product Name: </label>
                    <select title="Products Name" name="p_name" class="custom-select" id="product-list" required>
                        <!-- <option value="">-- Please Select Customer First --</option> -->
                        <option disabled value="">Product Name</option>
                        <option selected value="all">All</option>                    
                        @foreach($form_prod_data as $row)                                
                            <option {{ ($pcode == $row->id) ? "selected" : "" }} value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="export-btn">
                <div class="d-flex justify-content-around mt-3">
                    <div>
                        <input type="submit" value="OK" class="mt-3 btn btn-outline-primary">
                    </div>
                </div>
            </div>
        </form>

        <h4 align="center" class="font-weight-bold">Report Preview</h4>
        <!-- Include Report View Here -->
        @include('reports._report_view')
    </div>
</div>
@endsection