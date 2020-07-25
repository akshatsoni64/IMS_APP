@extends('layouts.app')
@extends('sections.navbar')

@section('content')
@php($route=Request::route()->getName())
@php( $value=explode('.',$route) ) 
<div class="col">
    <div class="px-5">
        <!-- <h1 align="center">        
            {{ Str::title($value[0]) }}
            Page
        </h1> -->
        
        <form action="{{ route('report') }}" method="" class="p-4 border" id="report-form">
            @csrf
            <div class="form-row mt-2">
                <div class="col-xl-1">
                    <label class="font-weight-bold">From: </label>
                </div>
                <div class="col-xl-5">
                    <input value="{{ $from_date ?? date('Y-m-d') }}" type="date" name="ft_date" class="form-control" required autofocus>
                </div>              
                <div class="col-xl-1 text-center">
                    <label class="font-weight-bold">To: </label>
                </div>
                <div class="col-xl-5">
                    <input value="{{ $to_date ?? date('Y-m-d') }}" type="date" name="tt_date" class="form-control" required>
                </div>              
            </div>
            <div class="form-row mt-2">
                <!-- <label class="font-weight-bold pt-2 pl-1 pr-2">Opening Stock</label> -->
                <div class="col">
                    <select title="Customer Name" id="cust_data" name="cust_id" class="custom-select" required>                       
                        <option disabled value="">Customer Name</option>
                        <option selected value="all">All</option>                    
                        @foreach($form_cust_data as $row)                                
                            <option value="{{ $row->id }}">{{ $row->name." - ".$row->mobile }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select title="Products Name" name="p_name" class="custom-select" id="product-list" required>
                        <!-- <option value="">-- Please Select Customer First --</option> -->
                        <option disabled value="">Product Name</option>
                        <option selected value="all">All</option>                    
                        @foreach($form_prod_data as $row)                                
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- <div class="form-row mt-4">
                <div class="col">
                    <input class="btn btn-block btn-primary" type="submit" value="Generate Report">
                </div>
                <div class="col">
                    <input class="btn btn-block btn-danger" type="reset" value="Reset">
                </div>                
            </div> -->
        <!-- <div id="export-btn" style="display:none"> -->
        <div id="export-btn">
            <div class="d-flex justify-content-around mt-3">
                <!-- <div>
                    <input value="Export to Excel" type="submit" class="btn btn-success text-white">
                </div> -->
                <div>
                    <input type="submit" value="Preview" class="mt-3 btn btn-primary text-white">
                </div>
            </div>
        </div>
        </form>
        <br><br>
        <!-- Include Report View Here -->
        @include('reports._report_view')
    </div>
</div>
@endsection