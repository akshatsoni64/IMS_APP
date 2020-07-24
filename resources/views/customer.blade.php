@extends('layouts.app')
@extends('sections.navbar')

@section('content')
@php( $route=Request::route()->getName() )
@php( $value=explode('.',$route) ) 
<div class="col">
    <div class="px-3">
        <!-- <h1 align="center">        
            {{ Str::title($value[0]) }}
            Page
        </h1> -->
        @if($value[1] == "edit")
            <form action="{{ route('customer.update', $id) }}" method="POST" class="p-4 border" id="real-form">
            @method('PUT')            
        @else  
            <div id="form-div" style="display:none">      
                <form action="#" id="name-form">
                    <label for="">Customer Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="name_name" placeholder="Customer Name" required autofocus>
                        <div class="input-group-addon">
                            <button type="submit" class="btn btn-outline-primary">&#10133;</button>
                        </div>
                    </div>
                </form>
            </div>
            <form action="{{ route('customer.store') }}" method="POST" class="p-4 border" id="real-form" style="display:none">
        @endif
            @csrf
            <div class="form-row">
                <div class="col-xl-2">
                    <label for="id">Customer ID*</label>
                    <input class="form-control" value="{{ $formdata->id ?? '' }}" id="cust_id" min=0 name="id" type="number" placeholder="Customer ID" required>
                </div>
                <div class="col-xl-4">
                    <label for="name">Customer Name*</label>
                    <input class="form-control" value="{{ $formdata->name ?? '' }}" name="name" id="real_name" type="text" placeholder="Customer Name" required>
                </div>
                <div class="col-xl-6">
                    <label for="org_name">Organization Name</label>
                    <input class="form-control" value="{{ $formdata->org_name ?? '' }}" name="org_name" type="text" placeholder="Organization Name">
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col-xl-6">
                <label for="email">Email</label>
                    <input class="form-control" value="{{ $formdata->email ?? '' }}"  name="email"  type="email" placeholder="Email">
                </div>
                <div class="col-xl-4">
                    <label for="mobile">Mobile Number*</label>
                    <input class="form-control" value="{{ $formdata->mobile ?? '' }}" name="mobile" type="number" placeholder="Mobile Number" min="1111111111" max="9999999999" required>
                </div>
                <div class="col-xl-2">
                    <label class="" for="active">Service Status</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                        <label class="custom-control-label" for="active"></label>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col">
                <label for="address">Customer Address</label>
                    <input class="form-control" value="{{ $formdata->address ?? '' }}"  name="address"  type="text" placeholder="Address">
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col">
                    <label class="" for="created_at">Registration Date*</label>
                    <input class="form-control" value="{{ $formdata->created_at ?? date('Y-m-d') }}" name="created_at" type="date" title="Registration Date" required>
                </div>
                <div class="col" id="end_date-input" style="display:none">
                    <label class="" for="end_date">Termination Date</label>
                    <input class="form-control" value="{{ $formdata->end_date ?? '' }}" name="end_date" type="date" title="Termination Date">
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col">
                    <input class="btn btn-block {{ ($value[1] == 'edit') ? 'btn-warning' : 'btn-success' }}" type="submit" value="{{ ($value[1] == 'edit') ? 'Update' : 'Submit' }}">
                </div>
                <div class="col">
                    <a class="btn btn-block btn-danger" type="button" href="{{ route($value[0].'.index') }}">Cancel</a>
                </div>                
            </div>
        </form>
        @include('partials._datatable')
    </div>
</div>
@endsection