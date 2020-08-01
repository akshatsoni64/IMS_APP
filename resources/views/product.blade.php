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
        
        @if($value[1]=="edit")
        <form id="{{$value[0]}}-form-div" action="{{ route('product.update', $id) }}" method="POST" class="p-4 border">
            @method('PUT')     
            <div id="warn-div" style="display:none">
                <div class="alert alert-warning alert-dismissible fade show">
                    <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
                    <strong>Warning:</strong> {{ Str::title($value[0]) }} will be deleted only if no transactions exists for this!
                </div>
            </div>
        @else
            <form id="{{$value[0]}}-form-div" style="display:none" action="{{ route('product.store') }}" method="POST" class="p-4 border" style="display:none">
        @endif
            @csrf
            <div class="form-row">
                <div class="col">
                    <label>Product Code*</label>
                    <input class="form-control" value="{{ $formdata->id ?? '' }}" id="prod_id" name="id" type="number" placeholder="Product ID" min=0 disabled required>
                </div>
                <div class="col">
                    <label>Product Name*</label>
                    <input class="form-control" value="{{ $formdata->name ?? '' }}" name="name" id="p_name" type="text" placeholder="Product Name" required>
                </div>
                <div class="col-xl-2">
                    <label>Opening Stock*</label>
                    <input class="form-control" value="{{ $formdata->quantity ?? '' }}" name="quantity" type="number" placeholder="Quantity" max=999 min=0 required>
                </div>
            <!-- </div> -->
            <!-- <div class="form-row mt-2"> -->
                <div class="col">
                    <label class="" for="">Registration Date*</label>
                    <input class="form-control" value="{{ $formdata->created_at ?? date('Y-m-d') }}" name="created_at" type="date" title="Registration Date" max="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col" id="end_date-input" style="display:none">
                    <label class="" for="">Termination Date*</label>
                    <input class="form-control" value="{{ $formdata->end_date ?? date('Y-m-d') }}" name="end_date" id="end_date" type="date" title="Termination Date" max="{{ date('Y-m-d') }}">
                </div>
                @if($value[1] == "edit")
                <div class="col">
                    <label class="" for="active">Service Status</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                        <label class="custom-control-label" for="active"></label>
                    </div>
                </div>
                @endif
                <!-- <div class="form-row mt-2">
                    <div class="col-xl-6">
                        <input class="form-control" name="rate" type="number" placeholder="Rate">
                    </div>
                    <div class="col-xl-6">
                        <input class="form-control" name="measure_unit" type="number" placeholder="Unit of Measurement">
                    </div>
                </div> -->
            </div>
            <div class="form-row mt-4">
                <div class="col">
                    <input id="submit-product" class="btn btn-block {{ ($value[1] == 'edit') ? 'btn-outline-primary' : 'btn-outline-success' }}" type="submit" value="{{ ($value[1] == 'edit') ? 'Update' : 'Submit' }}">
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