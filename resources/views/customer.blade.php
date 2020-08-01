@extends('layouts.app')
@extends('sections.navbar')

@section('content')
@php( $route=Request::route()->getName() )
@php( $value=explode('.',$route) ) 
<div class="col">
    <div class="px-3">
        <!-- <h4 align="center">        
            {{ Str::title($value[0]) }}
            Page
        </h4> -->

        @if($value[1] == "edit")
            <form id="{{$value[0]}}-form-div" action="{{ route('customer.update', $id) }}" method="POST" class="p-4 border" id="real-form">
            @method('PUT')
            <div id="warn-div" style="display:none">
                <div class="alert alert-warning alert-dismissible fade show">
                    <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
                    <strong>Warning:</strong> {{ Str::title($value[0]) }} will be deleted only if no transactions exists for this!
                </div>
            </div>         
        @else 
            <form id="{{$value[0]}}-form-div" style="display:none" action="{{ route('customer.store') }}" method="POST" class="p-4 border" id="real-form" style="display:none">
        @endif
            @csrf
            <div class="form-row">
                <div class="col-xl-2">
                    <label for="id">Customer ID*</label>
                    <input class="form-control" value="{{ $formdata->id ?? '' }}" id="cust_id" min=0 name="id" type="number" placeholder="Customer ID" required>
                </div>
                <div class="col-xl-4">
                    <label for="name">Customer Name*</label>
                    <input class="form-control" value="{{ $formdata->name ?? '' }}" name="name" id="c_name" type="text" placeholder="Customer Name" required>
                </div>
                <div class="col-xl-6">
                    <label for="org_name">Organization Name</label>
                    <input class="form-control" value="{{ $formdata->org_name ?? '' }}" name="org_name" type="text" placeholder="Organization Name">
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="col">
                    <label for="email">Email</label>
                    <input class="form-control" value="{{ $formdata->email ?? '' }}"  name="email"  type="email" placeholder="Email">
                </div>
                <div class="col">
                    <label for="mobile">Mobile Number*</label>
                    <input id="c_mobile" class="form-control" value="{{ $formdata->mobile ?? '' }}" name="mobile" type="number" placeholder="Mobile Number" min="1111111111" max="9999999999" required>
                </div>
                <div class="col">
                    <label for="created_at">Registration Date*</label>
                    <input class="form-control" value="{{ $formdata->created_at ?? date('Y-m-d') }}" name="created_at" type="date" title="Registration Date" max="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col" id="end_date-input" style="display:none">
                    <label for="end_date">Termination Date*</label>
                    <input class="form-control" value="{{ $formdata->end_date ?? date('Y-m-d') }}" name="end_date" id="end_date" type="date" title="Termination Date" max="{{ date('Y-m-d') }}">
                </div>
                @if($value[1] == "edit")
                <div class="col-xl-2">
                    <label for="active">Service Status</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                        <label class="custom-control-label" for="active"></label>
                    </div>
                </div>
                @endif
            </div>
            <div class="form-row mt-2">
                <div class="col">
                <label for="address">Customer Address</label>
                    <input class="form-control" value="{{ $formdata->address ?? '' }}"  name="address"  type="text" placeholder="Address">
                </div>
            </div>
            <!-- <div class="form-row mt-2">
            </div> -->
            <div class="form-row mt-4">
                <div class="col">
                    <input id="submit-customer" class="btn btn-block {{ ($value[1] == 'edit') ? 'btn-outline-primary' : 'btn-outline-success' }}" type="submit" value="{{ ($value[1] == 'edit') ? 'Update' : 'Submit' }}">
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