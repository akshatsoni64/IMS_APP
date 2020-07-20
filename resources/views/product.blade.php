@extends('layouts.app')
@extends('sections.navbar')

@section('content')
<div class="col-xl-10">
    <div class="px-5">
        <h1 align="center">
            @php( $route=Request::route()->getName() )
            @php( $value=explode('.',$route) ) 
            {{ Str::title($value[0]) }}
            Page
        </h1>

        @if($value[1]=="edit")
            <form action="{{ route('product.update', $id) }}" method="POST" class="p-4 border" id="real-form">
            @method('PUT')            
        @else
            <form action="#" id="name-form">
                <label>Product Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="name_name" placeholder="Product Name" required autofocus>
                    <div class="input-group-addon">
                        <button type="submit" class="btn btn-outline-primary">&#10133;</button>
                    </div>
                </div>
            </form>
            <form action="{{ route('product.store') }}" method="POST" class="p-4 border" id="real-form" style="display:none">
        @endif
            @csrf
            <div class="form-row mt-2">
                <div class="col">
                    <label>Product Code*</label>
                    <input class="form-control" value="{{ $formdata->id ?? '' }}" id="prod_id" name="id" type="number" placeholder="Product ID" min=0 required>
                </div>
                <div class="col">
                    <label>Product Name*</label>
                    <input class="form-control" value="{{ $formdata->name ?? '' }}" name="name" id="real_name" type="text" placeholder="Product Name" required>
                </div>
                <div class="col">
                    <label>Opening Stock*</label>
                    <input class="form-control" value="{{ $formdata->quantity ?? '' }}" name="quantity" type="number" placeholder="Quantity" max=999 min=0 required>
                </div>
            </div>
            <!-- <div class="form-row mt-2">
                <div class="col-xl-6">
                    <input class="form-control" name="rate" type="number" placeholder="Rate">
                </div>
                <div class="col-xl-6">
                    <input class="form-control" name="measure_unit" type="number" placeholder="Unit of Measurement">
                </div>
            </div> -->
            <div class="form-row mt-2">
                <div class="col-xl-6">
                    <label class="" for="">Registration Date*</label>
                    <input class="form-control" value="{{ $formdata->created_at ?? '' }}" name="created_at" type="date" title="Registration Date" required>
                </div>
                <div class="col-xl-6">
                    <label class="" for="">Termination Date</label>
                    <input class="form-control" value="{{ $formdata->end_date ?? '' }}" name="end_date" type="date" title="Termination Date">
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