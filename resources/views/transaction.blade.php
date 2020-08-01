@extends('layouts.app')
@extends('sections.navbar')

@section('content')
<div class="col">
    <div class="px-3">

        <!-- <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error:</strong> Invalid Operation
        </div> -->
        
        @php($route=Request::route()->getName())
        @php( $value=explode('.',$route) ) 
        <!-- <h4 align="center">
            {{ Str::title($value[0]) }}
            Page
        </h4> -->
        
        <!-- <div id="form-div" style='display:none'> -->
            @if($value[1] != "edit")
            @endif
            @if($value[1] == "edit")
                <form id="{{$value[0]}}-form-div" action="{{ route('transaction.update', $id) }}" class="p-4 border" method="POST">
                    @method('PUT')
            @else
                <form id="date-form-div" style='display:block' action="{{ route('transaction.index') }}" class="p-4 border" method="GET">
                <!-- @csrf -->
                    <div class="form-row">
                        <div class="col-xl-1 text-right">
                            <label class="mt-1">From*</label>
                        </div>
                        <div class="col-xl-3">
                            <input class="form-control" value="{{ $from_date ?? date('Y-m-d') }}" name="from_date" type="date" title="From Date" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-xl-1 text-right">
                            <label class="mt-1">To*</label>
                        </div>
                        <div class="col-xl-3">
                            <input class="form-control" value="{{ $to_date ?? date('Y-m-d') }}" name="to_date" type="date" title="To Date" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col">
                            <!-- <div class="d-flex justify-content-center"> -->
                                <button class="btn btn-outline-primary" value="Load" type="submit">
                                    OK
                                    <!-- <i class="fa fa-refresh"></i> -->
                                </button>
                                <!-- <button class="ml-5 btn btn-outline-primary" value="Print" formaction="{{ route('get_transactions_report') }}" type="submit">
                                    <i class="fa fa-print"></i>
                                </button> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </form>
                <form id="{{$value[0]}}-form-div" style='display:none' action="{{ route('transaction.store') }}" class="p-4 border" method="POST">
            @endif
                @csrf
                <div class="form-row">
                    <div class="col">
                        <label>Transaction Date*</label>
                        <input class="form-control" value="{{ $formdata->t_date ?? date('Y-m-d') }}" name="t_date" type="date" title="Transaction Date" max="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col">
                        <label>Customer Name*</label>
                        <select name="cid" class="custom-select" required autofocus>
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
                    <div class="col">
                        <label>Vehicle Number</label>
                        <input class="form-control" value="{{ $formdata->vehicle_number ?? '' }}" name="vehicle_number" type="text" placeholder="Vehicle Number">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col">
                        <label>Product Code*</label>
                        <select name="pid" class="custom-select" required>
                            @if($value[1] == "edit")
                                <option disabled value="">Product Code</option>
                                @foreach($prod_data as $row)
                                    <option {{ ($row->id == $formdata->pid) ? "selected" : "" }} value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            @else
                                <option selected disabled value="">Product Name</option>
                                @foreach($prod_data as $row)
                                    <option value="{{ $row->id }}">{{$row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col">
                        <label>Issued Quantity*</label>
                        <input class="form-control" value="{{ $formdata->issue ?? '0' }}" name="issue" id="t_issue" type="number" placeholder="Issued Quantity" max=999 required>
                    </div>
                    <div class="col">
                        <label>Received Quantity*</label>
                        <input class="form-control" value="{{ $formdata->receive ?? '0' }}" name="receive" id="t_receive" type="number" placeholder="Received Quantity" max=999 required>
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
                        <input class="btn btn-block {{ ($value[1] == 'edit') ? 'btn-outline-primary' : 'btn-outline-success' }}" type="submit" value="{{ ($value[1] == 'edit') ? 'Update' : 'Submit' }}">
                    </div>
                    <div class="col">
                        <a class="btn btn-block btn-outline-danger" type="button" href="{{ route($value[0].'.index') }}">Cancel</a>
                    </div>                
                </div>
            </form>
        <!-- </div> -->
        @include('partials._datatable')        
    </div>
</div>
<div class="modal fade" id="report-field-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Transactions Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">                
                <form id="date-form-div" style='display:block' action="{{ route('get_transactions_report') }}" class="p-4 border" method="GET" target="_blank">
                    <!-- @csrf -->
                    <div class="form-row">
                        <div class="col-xl-4">
                            <select name="pid" class="custom-select" required>
                                <option disabled value="">Product Name</option>
                                <option selected value="all">All</option>
                                @foreach($prod_data as $row)
                                    <option value="{{ $row->id }}">{{$row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-1 text-right">
                            <label class="mt-1">From*</label>
                        </div>
                        <div class="col-xl-3">
                            <input class="form-control" value="{{ $from_date ?? date('Y-m-d') }}" name="from_date" type="date" title="From Date" required>
                        </div>
                        <div class="col-xl-1 text-right">
                            <label class="mt-1">To*</label>
                        </div>
                        <div class="col-xl-3">
                            <input class="form-control" value="{{ $to_date ?? date('Y-m-d') }}" name="to_date" type="date" title="To Date" required>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <button class="btn btn-outline-primary" value="Load" type="submit">
                            Print
                        </button>
                        <button class="ml-5 btn btn-outline-danger" data-dismiss="modal" type="button">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection