<?php $title = 'Edit Client RFQ'; ?>
@extends('layouts.app')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
fieldset{
    border: 1px dashed #28c76f !important;
    padding: 2.5% !important;
    width: 96.6% !important;
    margin-left: 1.5% !important;
    margin-right: 1% !important;
    margin-bottom: 2% !important;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

legend {
 font-size: 18px !important;
 color:#000 !important;
 font-weight: 600;
}

label {
    color: #000;
}

#floatingInputContainer {
    width: 100%;
    z-index: 1000; /* Adjust the z-index based on your layout */
}

.floating {
    position: fixed;
    width: 39% !important;
    top: 0;
    /*box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: #fff;  Adjust background color if needed */
}

#floatingButtonContainer {
    width: 100%;
    z-index: 1000; /* Adjust the z-index based on your layout */
}

.floating-button {
    position: fixed;
    width: 100%;
    bottom: 0;
    right: 40;
    text-align: right; /* Adjust as needed */
    padding: 10px; /* Adjust as needed */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
}
</style>
<script>
    $(document).ready(function () {
        var floatingInputContainer = $("#floatingInputContainer");
        var originalPosition = floatingInputContainer.offset().top + 380;

        $(window).scroll(function () {
            var scrollPosition = $(window).scrollTop();

            if (scrollPosition > originalPosition) {
                floatingInputContainer.addClass("floating");
            } else {
                floatingInputContainer.removeClass("floating");
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        var floatingButtonContainer = $("#floatingButtonContainer");
        var originalButtonPosition = floatingButtonContainer.offset().top + floatingButtonContainer.height() + 10;

        $(window).scroll(function () {
            var scrollPosition = $(window).scrollTop();

            if (scrollPosition + $(window).height() < originalButtonPosition) {
                floatingButtonContainer.addClass("floating-button");
            } else {
                floatingButtonContainer.removeClass("floating-button");
            }
        });
    });
</script>
@section('content')
    <div class="main-container">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item active"><a href="{{ route('rfq.edit', $details->refrence_no) }}">Edit RFQ </a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('line.create',$details->rfq_id) }}">Create Line Item</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rfq.create',$clienting->client_id) }}">Create RFQ</a></li>
                @endif
                <li class="breadcrumb-item "><a href="{{ route('rfq.price', $details->refrence_no) }}"> Price Quotation</a></li>
                <li class="breadcrumb-item "><a href="{{ route('rfq.details', $details->refrence_no) }}"> RFQ Details</a></li>
                <li class="breadcrumb-item "><a href="{{ route('rfq.index') }}">View RFQ</a></li>

                <li class="breadcrumb-item "><a href="{{ route('client.index') }}"> Clients List</a></li>
                <li class="breadcrumb-item">Editing RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="card">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" align="left">
                                    <a  href="{{ route('line.preview', $details->rfq_id) }}" class="btn btn-primary" >  View Line Items </a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" align="left">
                                    
                                    <a  href="{{ route('print.Quote', $details->refrence_no) }}" target="_blank" class="btn btn-info" >  View PDF</a>
                                   
                                </div>
                                @if(count(po($details->rfq_id)) > 0)
                                    @php $data = poSee($details->rfq_id); @endphp
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" align="right">
                                        <a  href="{{ route('po.edit',[$data->po_id]) }}" class="btn btn-primary" >  View The PO </a>
                                    </div>
                                @endif
                            </div>
                            <br>

                            <form action="{{ route('rfq.update',$details->refrence_no) }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row gutters">

                                    <input type="hidden" name="company_id" value="{{ $details->company_id}}" >
                                    <input type="hidden" name="client_id" value="{{ $details->client_id}}" >

                                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">

                                        <div class="row gutters">
                                            <fieldset class="row" style="background: #F7F6CF;">
                                                <legend> <i class="icon-user mt-6" style="color:#000"></i> Primary Information </legend>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Status</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                        </div>

                                                        <select class="form-control selectpicker" data-live-search="true" id="status" required name="status">
                                                            <option data-tokens="{{ $details->status }}" value="{{ $details->status }}"> {{ $details->status }}</option>
                                                            <option value=""> </option>
                                                            @foreach ($status as $item)

                                                                <option data-tokens="{{ $item->name }}" value="{{ $item->name }}"> {{ $item->name }}</option>


                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    @if ($errors->has('status'))
                                                        <div class="" style="color:red">{{ $errors->first('status') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">Company Name</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-user" style="color:#28a745"></i></span>
                                                        </div>

                                                        <input type="text" class="form-control" name="company_name" readonly value="{{ $details->company->company_name ?? ' ' }}" placeholder="Company Name">
                                                    </div>
                                                    @if ($errors->has('company_name'))
                                                        <div class="" style="color:red">{{ $errors->first('company_name') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">RFQ Date</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                        </div>

                                                        <input type="datetime-local" class="form-control datepicker-datetime-format2" name="rfq_date" value="{{ $details->rfq_date }}" placeholder="RFQ Date">
                                                    </div>
                                                    @if ($errors->has('rfq_date'))
                                                        <div class="" style="color:red">{{ $errors->first('rfq_date') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="text">Submission Due Date </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input type="datetime-local" class="form-control datepicker-datetime-format2" name="delivery_due_date" value="{{ $details->delivery_due_date ?? old('delivery_due_date')}}"
                                                        placeholder="Sub Due Date" required>
                                                    </div>

                                                    @if ($errors->has('delivery_due_date'))
                                                        <div class="" style="color:red">{{ $errors->first('delivery_due_date') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone_number">Assigned To</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-user" style="color:#28a745"></i></span>
                                                        </div>
                                                        @if(count($employer) < 1)
                                                            <input class="form-control" name="" readonly placeholder="" type="text"
                                                            aria-describedby="basic-addon6" value="Add Employee for this company">
                                                        @else
                                                            <select class="form-control selectpicker" data-live-search="true" required name="employee_id">
                                                                <option data-tokens="{{ $details->employee->full_name ?? '' }}" value="{{  $details->employee_id  }}"> {{  $details->employee->full_name ?? ''  }}</option>
                                                                <option value=""> </option>
                                                                @foreach ($employer as $employers)
                                                                    <option data-tokens="{{ $employers->full_name }}" value="{{ $employers->employee_id }}"> {{ $employers->full_name }}</option>
                                                                @endforeach

                                                            </select>
                                                        @endif

                                                    </div>

                                                    @if ($errors->has('employer_id'))
                                                        <div class="" style="color:red">{{ $errors->first('employer_id') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">Buyer</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon4"><i class="icon-user" style="color:#28a745"></i></span>
                                                        </div>
                                                        @if(count($contact) < 1)
                                                            <input class="form-control" name="" readonly type="text"
                                                            aria-describedby="basic-addon6" value="Client Contact is Empty">
                                                        @else
                                                            <select class="form-control selectpicker" data-live-search="true" required name="contact_id">

                                                                @foreach (buyers($details->contact_id) as $items)

                                                                    <option data-tokens="{{ $items->first_name . ' '. $items->last_name ?? 'N/A' }}"
                                                                        value="{{  $details->contact_id  }}">
                                                                        {{ $items->first_name . ' '. $items->last_name ?? 'N/A' }}
                                                                    </option>
                                                                @endforeach
                                                                <option value=""> </option>
                                                                @foreach ($contact as $list)

                                                                    <option data-tokens="{{ $list->first_name . " ". $list->last_name }}" value="{{ $list->contact_id }}">
                                                                        {{ $list->first_name . " ". $list->last_name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        @endif
                                                    </div>

                                                    @if ($errors->has('contact_id'))
                                                        <div class="" style="color:red">{{ $errors->first('contact_id') }}</div>
                                                    @endif

                                                </div>
                                            </div>


                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Reference Number</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon6"><i class="icon-layers" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="refrence_number" readonly placeholder="Enter Refrence Number" type="text"
                                                        aria-describedby="basic-addon6" value="{{ $details->refrence_no}}">
                                                    </div>
                                                    @if ($errors->has('refrence_number'))
                                                        <div class="" style="color:red">{{ $errors->first('refrence_number') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Client RFQ No</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-book" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="rfq_number" id="inputName" required value="{{ $details->rfq_number ?? 'N/A' }}" placeholder="Enter RFQ Nos" type="text"
                                                    aria-describedby="basic-addon1">
                                                    </div>

                                                    @if ($errors->has('rfq_number'))
                                                        <div class="" style="color:red">{{ $errors->first('rfq_number') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="end_user">End User</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-select-arrows" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="end_user" id="end_user" value="{{ $details->end_user ?? '' }}" placeholder="Enter End User" type="text"
                                                        aria-describedby="basic-addon3" >
                                                    </div>

                                                    @if ($errors->has('end_user'))
                                                        <div class="" style="color:red">{{ $errors->first('end_user') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            </fieldset> <br/>

                                            <fieldset class="row" style="background: #B6D8F2;">
                                                <legend> <i class="icon-box mt-6" style="color:#000"></i> Product / Supplier Information </legend>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="lastName">Product</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-documents" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="product" value="{{ $details->product}}" id="lastName" required placeholder="Enter Product" type="text"
                                                                aria-describedby="basic-addon2">
                                                            </div>
                                                            @if ($errors->has('product'))
                                                                <div class="" style="color:red">{{ $errors->first('product') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                        <div class="for5m-group">
                                                            <label for="company_name">Supplier Name</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <select class="form-control selectpicker" data-live-search="true" required name="vendor_id" required>
                                                                    <option value="{{ $details->vendor_id }}">{{ $details->vendor->vendor_name }}</option>
                                                                    <option value=""> </option>
                                                                    @foreach ($vendor as $vendors)
                                                                        <option data-tokens="{{ $vendors->vendor_name }}" value="{{ $vendors->vendor_id }}">
                                                                            {{ $vendors->vendor_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @if ($errors->has('vendor_id'))
                                                                <div class="" style="color:red">{{ $errors->first('vendor_id') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                $(document).ready(function () {
                                                    // Add click event handler for the "Add" button
                                                    $(".add-supplier").click(function () {
                                                        // Clone the entire row (including form elements)
                                                        var clonedRow = $(this).closest(".row").clone();
                                                        
                                                        // Clear input values in the cloned row
                                                        clonedRow.find('input[type="text"]').val('');
                                                        
                                                        // Hide the "Add" button and show the "Remove" button for the new clone
                                                        clonedRow.find(".add-supplier").hide();
                                                        clonedRow.find(".remove-supplier").show();
                                                        
                                                        // Append the clone to the parent container (e.g., a form or a div)
                                                        $(this).closest(".row").after(clonedRow);
                                                    });

                                                    // Add click event handler for the "Remove" button
                                                    $(document).on("click", ".remove-supplier", function () {
                                                        // Remove the entire row when the "Remove" button is clicked
                                                        $(this).closest(".row").remove();
                                                    });
                                                });
                                            </script>

                                            
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-folder" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="description" id="description" minlength="9"
                                                        maxlength="" value="{{ $details->description}}" required placeholder="Enter Description" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('description'))
                                                        <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="clearing_agent">Clearing Agent</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-select-arrows" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="clearing_agent" id="clearing_agent" value="{{ $details->clearing_agent ?? '' }}" placeholder="Enter Clearing Agent" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('clearing_agent'))
                                                        <div class="" style="color:red">{{ $errors->first('clearing_agent') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                </fieldset>

                                        <div class="row gutters">
                                        <fieldset class="row" style="background: #F4CFDF;">
                                                <legend> <i class="icon-truck mt-6" style="color:#000"></i> Logistics Information </legend>
                                            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12">

                                                <div class="form-group">
                                                    <label for="net_percentage">Shipping Company</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-database" style="color:#28a745"></i></span>
                                                        </div>

                                                        <select class="form-control selectpicker" data-live-search="true" required name="shipper_id">
                                                            <option data-tokens="{{ $details->shipper->shipper_name ?? '' }}" value="{{ $details->shipper_id  ?? '' }}">
                                                                {{ $details->shipper->shipper_name ?? $details->shipper_id }}
                                                            </option>
                                                            <option value=""></option>
                                                            @foreach ($shipper as $shippers)
                                                                <option data-tokens="{{ $shippers->shipper_name }}" value="{{ $shippers->shipper_id }}">
                                                                        {{ $shippers->shipper_name }}
                                                                </option>

                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    @if ($errors->has('shipper_id'))
                                                        <div class="" style="color:red">{{ $errors->first('shipper_id') }}</div>
                                                    @endif

                                                </div>
                                            </div>



                                            @if(count(getRRQShipQuote($details->rfq_id, 'get')) > 0)
                                                @php 
                                                    $shi = getRRQShipQuote($details->rfq_id, 'first');
                                                    $shipCurrency = $shi->currency;
                                                    $soncap = $shi->soncap_charges;
                                                    $trucking = $shi->trucking_cost;
                                                    $customs = $shi->customs_duty;
                                                    $clearing = $shi->clearing_and_documentation;
                                                    $loc = $soncap + $trucking + $customs + $clearing;

                                                @endphp
                                            @else 
                                                @php 

                                                    $shipCurrency = 'NGN'; $clearing = 0;
                                                    $soncap = 0; $trucking = 0; $customs = 0;
                                                    $loc = $soncap + $trucking + $customs + $clearing;
                                                @endphp
                                            @endif
                                            @if($details->is_lumpsum == 1)
                                                @php
                                                    $loc = $details->lumpsum;
                                                @endphp
                                            @endif
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">Shipper Currency</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                        </div>
                                                        @php $mode = array('NGN', 'USD', 'EUR'); @endphp
                                                        <select class="form-control" name="shipper_currency" required>
                                                            <option value="{{ $shipCurrency }}"> {{ $shipCurrency ?? old('shipper_currency') }} </option>
                                                            <option value=""> </option>
                                                            @foreach ($mode as $modes)
                                                                <option value="{{$modes}}"> {{ $modes }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('shipper_currency'))
                                                        <div class="" style="color:red">{{ $errors->first('shipper_currency') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lumpSumCheckbox">Lump Sum?</label>
                                                    <div class="input-group">
                                                        <input name="lumpsum_checkbox" value="1" type="checkbox" id="lumpSumCheckbox" @if($details->is_lumpsum == 1) checked @endif>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="soncapFields" class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">Soncap Charges</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                        </div>
        
                                                        <input type="text" id="soncap" required class="form-control" name="soncap_charges" value="{{round($soncap,2) ?? 0}}" placeholder="Soncap Charges">
                                                    </div>
                                                    @if ($errors->has('soncap_charges'))
                                                        <div class="" style="color:red">{{ $errors->first('soncap_charges') }}</div>
                                                    @endif
        
                                                </div>
                                            </div>
                                            <div id="customFields" class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">Customs Duty</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                        </div>
        
                                                        <input type="text" id="customs" class="form-control" required name="customs_duty" value="{{round($customs,2) ?? 0}}" placeholder="Customs Duty">
                                                    </div>
                                                    @if ($errors->has('customs_duty'))
                                                        <div class="" style="color:red">{{ $errors->first('customs_duty') }}</div>
                                                    @endif
        
                                                </div>
                                            </div>
                                            <div id="clearingFields" class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">Clearing And Documentation</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                        </div>
        
                                                        <input type="text" id="clearing" class="form-control" required name="clearing_and_documentation" value="{{round($clearing,2) ?? 0}}" placeholder="Clearing And Documentation">
                                                    </div>
                                                    @if ($errors->has('clearing_and_documentation'))
                                                        <div class="" style="color:red">{{ $errors->first('clearing_and_documentation') }}</div>
                                                    @endif
        
                                                </div>
                                            </div>

                                            <div id="truckingFields" class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">Trucking Cost</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                        </div>
        
                                                        <input type="text" id="trucking" class="form-control" required name="trucking_cost" value="{{round($trucking,2) ?? 0}}" placeholder="Trucking Cost">
                                                    </div>
                                                    @if ($errors->has('trucking_cost'))
                                                        <div class="" style="color:red">{{ $errors->first('trucking_cost') }}</div>
                                                    @endif
        
                                                </div>
                                            </div>
                                            
                                            <div id="lumpSumField" class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" style="display: none;">
                                                <div class="form-group">
                                                    <label for="lastName">Lump Sum</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input type="text" id="lumpsum" class="form-control" required name="lumpsum" value="{{ round($details->lumpsum,2) ?? 0 }}" placeholder="Lump Sum">
                                                    </div>
                                                    @if ($errors->has('lumpsum'))
                                                        <div class="" style="color:red">{{ $errors->first('lumpsum') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="local_delivery">Local Delivery</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-address" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="local_delivery" id="local_delivery" value="{{ round($loc,2) ?? '0'}}" readonly placeholder="Enter Local Delivery" type="text"
                                                        aria-describedby="basic-addon3" step="">
                                                    </div>

                                                    @if ($errors->has('local_delivery'))
                                                        <div class="" style="color:red">{{ $errors->first('local_delivery') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <script>
                                                const checkbox = document.getElementById('lumpSumCheckbox');
                                                const lumpSumCheckbox = document.getElementById('lumpSumCheckbox');
                                                const soncapFields = document.getElementById('soncapFields');
                                                const lumpSumField = document.getElementById('lumpSumField');
                                                const customFields = document.getElementById('customFields');
                                                const clearingFields = document.getElementById('clearingFields');
                                                const truckingFields = document.getElementById('truckingFields');
                                                const localDeliveryField = document.getElementById('local_delivery');

                                                if (checkbox.checked) {
                                                    soncapFields.style.display = 'none';
                                                    customFields.style.display = 'none';
                                                    clearingFields.style.display = 'none';
                                                    truckingFields.style.display = 'none';
                                                    lumpSumField.style.display = 'block'; // Show fields
                                                } else {
                                                    soncapFields.style.display = 'block';
                                                    customFields.style.display = 'block';
                                                    clearingFields.style.display = 'block';
                                                    truckingFields.style.display = 'block';
                                                    lumpSumField.style.display = 'none';  // Hide fields
                                                }


                                                lumpSumCheckbox.addEventListener('change', function() {
                                                    if (this.checked) {
                                                        soncapFields.style.display = 'none';
                                                        customFields.style.display = 'none';
                                                        clearingFields.style.display = 'none';
                                                        truckingFields.style.display = 'none';
                                                        lumpSumField.style.display = 'block';
                                                    } else {
                                                        soncapFields.style.display = 'block';
                                                        customFields.style.display = 'block';
                                                        clearingFields.style.display = 'block';
                                                        truckingFields.style.display = 'block';
                                                        lumpSumField.style.display = 'none';
                                                    }
                                                });

                                                function updateLocalDelivery() {
                                                    const lumpSumValue = parseFloat(lumpSumField.querySelector('input').value) || 0;
                                                    const soncapValue = parseFloat(soncapFields.querySelector('input').value) || 0;
                                                    const customValue = parseFloat(customFields.querySelector('input').value) || 0;
                                                    const clearingValue = parseFloat(clearingFields.querySelector('input').value) || 0;
                                                    const truckingValue = parseFloat(truckingFields.querySelector('input').value) || 0;

                                                    if (lumpSumCheckbox.checked) {
                                                        localDeliveryField.value = lumpSumValue.toFixed(2);
                                                    } else {
                                                        const loc = soncapValue + customValue + clearingValue + truckingValue;
                                                        localDeliveryField.value = loc.toFixed(2);
                                                    }
                                                }

                                                checkbox.addEventListener('change', updateLocalDelivery);
                                                lumpSumField.querySelector('input').addEventListener('input', updateLocalDelivery);
                                                soncapFields.querySelector('input').addEventListener('input', updateLocalDelivery);
                                                customFields.querySelector('input').addEventListener('input', updateLocalDelivery);
                                                clearingFields.querySelector('input').addEventListener('input', updateLocalDelivery);
                                                truckingFields.querySelector('input').addEventListener('input', updateLocalDelivery);

                                                // Initial update
                                                updateLocalDelivery();
                                            </script>
                                            
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

                                                <div class="form-group">
                                                    <label for="net_percentage">Shipper Submission Date</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input type="date" class="form-control" name="shipper_submission_date"
                                                        value="{{ $details->shipper_submission_date ?? old('shipper_submission_date')}}" placeholder="Shipper Sub Date">

                                                    </div>

                                                    @if ($errors->has('shipper_submission_date'))
                                                        <div class="" style="color:red">{{ $errors->first('shipper_submission_date') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Oversized</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                        </div>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="oversized">
                                                            <option value="{{ $details->oversized ?? old('oversized')  }}">{{ $details->oversized ?? old('oversized') }} </option>
                                                            <option value="YES" >Yes </option>
                                                            <option value="NO">No</option>
                                                        </select>
                                                    </div>

                                                    @if ($errors->has('oversized'))
                                                        <div class="" style="color:red">{{ $errors->first('oversized') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            </fieldset>

                                            <fieldset class="row" style="background: #F5F3E7;">
                                                <legend> <i class="icon-history mt-6" style="color:#000"></i> Cost / Interest Information </legend>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row gutters" id="formSet">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="intrest_percent">Percent (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control percentage" name="intrest_percent" value="{{ $details->percent_supplier ?? '0'}}" id="intrest_percent" max="100" required placeholder="Enter Percent of Supplier Cost" type="number" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_percent'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_percent') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="intrest_rate">Interest Rate (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="intrest_rate" id="intrest_rate" value="{{ $details->intrest_rate ?? '0'}}" maxlength="11" required placeholder="Enter Interest Rate Supplier" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_rate'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_rate') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 form-group">
                                                    <label for="duration">Duration (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="duration" id="duration" value="{{ $details->duration ?? '0'}}" required placeholder="Enter Duration Supplier" type="number" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('duration'))
                                                        <div class="" style="color:red">{{ $errors->first('duration') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                            <button type="button" class="btn btn-primary" id="addForm">+</button>
                                                        </div>
                                                </div>
                                            </div>

                                        @if ($details->percent_supplier_1 > 0)
                                            <div class="row gutters" id="formSet">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="intrest_percent_1">Percent (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control percentage cloned_supplier_percent" name="intrest_percent_1" value="{{ $details->percent_supplier_1 ?? '0'}}" id="intrest_percent_1" max="100" required placeholder="Enter Percent of Supplier Cost" type="number" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_percent_1'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_percent_1') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="intrest_rate_1">Interest Rate (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="intrest_rate_1" id="intrest_rate_1" value="{{ $details->intrest_rate_1 ?? '0'}}" maxlength="11" required placeholder="Enter Interest Rate Supplier" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_rate'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_rate') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 form-group">
                                                    <label for="duration_1">Duration (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="duration_1" id="duration_1" value="{{ $details->duration_1 ?? '0'}}" required placeholder="Enter Duration Supplier" type="number" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('duration'))
                                                        <div class="" style="color:red">{{ $errors->first('duration') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                            <button type="button" class="btn btn-danger remove-form">-</button>
                                                        </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if ($details->percent_supplier_2 > 0)
                                            <div class="row gutters" id="formSet">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="intrest_percent_2">Percent (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control percentage cloned_supplier_percent" name="intrest_percent_2" value="{{ $details->percent_supplier_2 ?? '0'}}" id="intrest_percent_2" max="100" required placeholder="Enter Percent of Supplier Cost" type="number" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_percent_2'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_percent_2') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="intrest_rate_2">Interest Rate (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="intrest_rate_2" id="intrest_rate_2" value="{{ $details->intrest_rate_2 ?? '0'}}" maxlength="11" required placeholder="Enter Interest Rate Supplier" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_rate_2'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_rate_2') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 form-group">
                                                    <label for="duration_2">Duration (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="duration_2" id="duration_2" value="{{ $details->duration_2 ?? '0'}}" required placeholder="Enter Duration Supplier" type="number" aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('duration_2'))
                                                        <div class="" style="color:red">{{ $errors->first('duration_2') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration_2">.</label>
                                                    <div class="input-group">
                                                            <button type="button" class="btn btn-danger remove-form">-</button>
                                                        </div>
                                                </div>
                                            </div>
                                        @endif
                                            
                                            </div>
                                            
                                            <script>
                                            $(document).ready(function() {
                                                 // Initialize the clone count
                                                
                                                $("#addForm").click(function() {
                                                    var elementsPS = document.querySelectorAll('[id^="intrest_percent_"]');
                                                    var countPS = elementsPS.length;
                                                    console.log('the count of COuntPS is: '+ countPS);  
                                                    var supplierCloneCount = 0;
                                                    var clonedsupplier = document.getElementsByClassName("form-control cloned_supplier_percent");
                                                    var length = countPS + 1;
                                                    var supplierCloneCount = length;
                                                    var clonedsupplier = document.getElementsByClassName("form-control cloned_supplier_percent");
                                                    var clonedForm = $("#formSet").clone();
                                                    clonedForm.find('input').val('');
                                                    clonedForm.find('input').removeAttr('required');
                                                    
                                                    
                                                    // Increment the clone count and append it to class names
                                                    clonedForm.find("[id^='intrest_percent']").attr('id', 'intrest_percent_' + supplierCloneCount);
                                                    clonedForm.find("[id^='intrest_percent']").attr('name', 'intrest_percent_' + supplierCloneCount);
                                                    clonedForm.find("[id^='intrest_rate']").attr('id', 'intrest_rate_' + supplierCloneCount);
                                                    clonedForm.find("[id^='intrest_rate']").attr('name', 'intrest_rate_' + supplierCloneCount);
                                                    clonedForm.find("[id^='duration']").attr('id','duration_' + supplierCloneCount);
                                                    clonedForm.find("[id^='duration']").attr('name','duration_' + supplierCloneCount);

                                                    clonedForm.find("[id^='intrest_percent']").addClass('cloned_supplier_percent');
                                                    
                                                    clonedForm.find('.btn-primary').replaceWith('<button class="btn btn-danger remove-form" type="button">-</button>');
                                                    $("#formSet").after(clonedForm);
                                                });

                                                $(document).on('click', '.remove-form', function() {
                                                    $(this).closest('.row').remove();
                                                });
                                            });

                                            // Get all input elements with id "intrest_percent"
                                            const interestPercentInputs = document.querySelectorAll("#intrest_percent");

                                            // Initialize a variable to store the sum
                                            let sum = 0;

                                            // Iterate through each input and add its value to the sum
                                            interestPercentInputs.forEach(function(input) {
                                                sum += parseFloat(input.value) || 0;
                                            });

                                            if(sum>100){
                                                alert("Supplier ")
                                            }
                                            </script>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row gutters" id="formSet2">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                <div class="form-group">
                                                    <label for="intrest_rate">Percent (Logistics)</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control percentage" name="percent_logistics" id="percent_logistics"
                                                        maxlength="11" value="{{ $details->percent_logistics ?? '0'}}" required max="100" type="number" placeholder="Enter Percent of Logistics Cost"
                                                        aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_logistics'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_logistics') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                <div class="form-group">
                                                    <label for="intrest_rate">Interest Rate (Logistics)</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="intrest_logistics" id="intrest_logistics"
                                                        maxlength="11" value="{{ $details->intrest_logistics ?? '0'}}" required placeholder="Enter Intrest Rate Logistics" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_logistics'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_logistics') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 form-group">
                                                <div class="form-group">
                                                    <label for="freight_charges">Duration (Logistics) </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="duration_logistics" id="duration_logistics" value="{{ $details->duration_logistics ?? '0'}}" placeholder="Enter Duration Logistics"
                                                        type="number" required aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('duration_logistics'))
                                                        <div class="" style="color:red">{{ $errors->first('duration_logistics') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                            <button type="button" class="btn btn-primary" id="addForm2">+</button>
                                                        </div>
                                                </div>
                                            </div>
                                @if ($details->percent_logistics_1 > 0)

                                <div class="row gutters" id="formSet2">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                <div class="form-group">
                                                    <label for="percent_logistics_1">Percent (Logistics)</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control cloned_logistics_percent" name="percent_logistics_1" id="percent_logistics_1"
                                                        maxlength="11" value="{{ $details->percent_logistics_1 ?? '0'}}" required max="100" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('percent_logistics_1'))
                                                        <div class="" style="color:red">{{ $errors->first('percent_logistics_1') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                <div class="form-group">
                                                    <label for="intrest_logistics_1">Interest Rate (Logistics)</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="intrest_logistics_1" id="intrest_logistics_1"
                                                        maxlength="11" value="{{ $details->intrest_logistics_1 ?? '0'}}" required placeholder="Enter Intrest Rate Logistics" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_logistics_1'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_logistics_1') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 form-group">
                                                <div class="form-group">
                                                    <label for="duration_logistics_1">Duration (Logistics) </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="duration_logistics_1" id="duration_logistics_1" value="{{ $details->duration_logistics_1 ?? '0'}}" placeholder="Enter Duration Logistics"
                                                        type="number" required aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('duration_logistics_1'))
                                                        <div class="" style="color:red">{{ $errors->first('duration_logistics_1') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group">
                                                    <label for="percent_add">.</label>
                                                    <div class="input-group">
                                                            <button type="button" class="btn btn-danger remove-form" style="display: block;">-</button>
                                                        </div>
                                                </div>
                                            </div>
                                        @endif

                                    @if ($details->percent_logistics_2 > 0)

                                    <div class="row gutters" id="formSet2">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <div class="form-group">
                                                        <label for="percent_logistics_2">Percent (Logistics)</label><div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control cloned_logistics_percent" name="percent_logistics_2" id="percent_logistics_2"
                                                            maxlength="11" value="{{ $details->percent_logistics_2 ?? '0'}}" required max="100" type="number"
                                                            aria-describedby="basic-addon3">
                                                        </div>
                                                        @if ($errors->has('percent_logistics_2'))
                                                            <div class="" style="color:red">{{ $errors->first('percent_logistics_2') }}</div>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <div class="form-group">
                                                        <label for="intrest_logistics_2">Interest Rate (Logistics)</label><div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control" name="intrest_logistics_2" id="intrest_logistics_2"
                                                            maxlength="11" value="{{ $details->intrest_logistics_2 ?? '0'}}" required placeholder="Enter Intrest Rate Logistics" type="text"
                                                            aria-describedby="basic-addon3">
                                                        </div>
                                                        @if ($errors->has('intrest_logistics_2'))
                                                            <div class="" style="color:red">{{ $errors->first('intrest_logistics_2') }}</div>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 form-group">
                                                    <div class="form-group">
                                                        <label for="duration_logistics_2">Duration (Logistics) </label><div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control" name="duration_logistics_2" id="duration_logistics_2" value="{{ $details->duration_logistics_2 ?? '0'}}" placeholder="Enter Duration Logistics"
                                                            type="number" required aria-describedby="basic-addon3">
                                                        </div>
                                                        @if ($errors->has('duration_logistics_2'))
                                                            <div class="" style="color:red">{{ $errors->first('duration_logistics_2') }}</div>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group">
                                                        <label for="percent_add">.</label>
                                                        <div class="input-group">
                                                                <button type="button" class="btn btn-danger remove-form" style="display: block;">-</button>
                                                            </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <script>
                                        $(document).ready(function() {

                                            $("#addForm2").click(function() {
                                            // Initialize the clone count
                                            var elementsPL = document.querySelectorAll('[id^="percent_logistics_"]');
                                            var countPL = elementsPL.length;
                                                var logisticsCloneCount = 0;
                                                var clonedLogistics = document.getElementsByClassName("form-control cloned_logistics_percent");
                                                var length2 = countPL + 1;
                                                var logisticsCloneCount = length2;

                                                var clonedForm = $("#formSet2").clone();
                                                clonedForm.find('input').val('');
                                                clonedForm.find('input').removeAttr('required');
                                                
                                                // Increment the clone count and append it to class names
                                                logisticsCloneCount++;
                                                clonedForm.find("[id^='percent_logistics']").attr('id','percent_logistics_' + length2);
                                                clonedForm.find("[id^='intrest_logistics']").attr('id','intrest_logistics_' + length2);
                                                clonedForm.find("[id^='duration_logistics']").attr('id','duration_logistics_' + length2);
                                                
                                                clonedForm.find("[id^='percent_logistics']").addClass('cloned_logistics_percent');

                                                clonedForm.find('.btn-primary').replaceWith('<button class="btn btn-danger remove-form" type="button">-</button>');
                                                $("#formSet2").after(clonedForm);
                                            });

                                            $(document).on('click', '.remove-form', function() {
                                                $(this).closest('.row').remove();
                                            });
                                        });
                                        </script>
                                        </fieldset>

                                        <fieldset class="row" style="background: #E5DBD9;">
                                                <legend> <i class="icon-sound-mix mt-6" style="color:#000"></i> Miscellanous Cost Information </legend>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            
                                            @php
                                            $supplierData = json_decode($details->misc_cost_supplier, true) ?? [];
                                            @endphp
                                            @php
                                                $counters = 1 ;
                                            @endphp
                                            @if (!empty($supplierData))
                                            @foreach ($supplierData as $index => $supplier)
                                            <div class="row gutters" id="formSet3">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="misc_cost_supplier_{{ $counters }}">Misc Cost (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="misc_cost_supplier[]" value="{{ $supplier['desc'] ?? '' }}" id="misc_cost_supplier_{{ $counters }}" placeholder="Enter Misc Cost (Supplier)" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="misc_amount_supplier_{{ $counters }}">Misc Amount (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control misc_amount_supplier" name="misc_amount_supplier[]" value="{{ $supplier['amount'] ?? '' }}" id="misc_amount_supplier_{{ $counters }}" placeholder="Enter Misc Amount (Supplier)" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                </div>

                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                        @if ($index === 0)
                                                            <button type="button" class="btn btn-primary" id="addForm3">+</button>
                                                        @else
                                                            <button type="button" class="btn btn-danger remove-form3">-</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-primary" id="addForm3">+</button>
                                                        <button type="button" class="btn btn-danger remove-form3" style="display: none;">-</button>
                                                    </div>
                                                </div> -->
                                            </div>
                                            @php
                                                $counters++;
                                            @endphp
                                            @endforeach
                                            @else
                                            <div class="row gutters" id="formSet3">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="misc_cost_supplier_{{ $counters }}">Misc Cost (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="misc_cost_supplier[]" value="" id="misc_cost_supplier_1" placeholder="Enter Misc Cost (Supplier)" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="misc_amount_supplier_{{ $counters }}">Misc Amount (Supplier)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control misc_amount_supplier" name="misc_amount_supplier[]" value="" id="misc_amount_supplier_1" placeholder="Enter Misc Amount (Supplier)" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                </div>
                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-primary" id="addForm3">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                // Initialize the clone cou

                                                $("#addForm3").click(function() {
                                                    var miscSupplier = document.getElementsByClassName("form-control misc_amount_supplier");

                                                    var supplierCloneCount = miscSupplier.length;
                                                    supplierCloneCount++;

                                                    var clonedForm = $("#formSet3").clone();
                                                    clonedForm.find('input').val('');
                                                    clonedForm.find('input').removeAttr('required');

                                                    // Append the clone count to input names and ids
                                                    //clonedForm.find("[name^='misc_cost_supplier']").attr('name', 'misc_cost_supplier[' + supplierCloneCount + ']');
                                                    clonedForm.find("[id^='misc_cost_supplier']").attr('id', 'misc_cost_supplier_' + supplierCloneCount);

                                                    //clonedForm.find("[name^='misc_amount_supplier']").attr('name', 'misc_amount_supplier[' + supplierCloneCount + ']');
                                                    clonedForm.find("[id^='misc_amount_supplier']").attr('id', 'misc_amount_supplier_' + supplierCloneCount);

                                                    clonedForm.find('.btn-primary').replaceWith('<button class="btn btn-danger remove-form3" type="button">-</button>');
                                                    $("#formSet3").after(clonedForm);
                                                });

                                                $(document).on('click', '.remove-form3', function() {
                                                    $(this).closest('.row').remove();
                                                });
                                            });
                                        </script>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> 
                                                @php
                                                // Decode the JSON data into an array
                                                $logisticsData = json_decode($details->misc_cost_logistics, true) ?? [];
                                                @endphp
                                                @php
                                                $counter = 1;
                                                @endphp
                                                @if (!empty($logisticsData))
                                                @foreach ($logisticsData as $index => $logistics)
                                                <div class="row gutters" id="formSet4">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                        <label for="misc_cost_logistics_{{ $counter }}">Misc Cost (Logistics)</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control" name="misc_cost_logistics[]" value="{{ $logistics['desc'] ?? '' }}" id="misc_cost_logistics_{{ $counter }}" placeholder="Enter Misc Cost (Logistics)" type="text" aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                        <label for="misc_amount_logistics_{{ $counter }}">Misc Amount (Logistics)</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control misc_amount_logistics" name="misc_amount_logistics[]" value="{{ $logistics['amount'] ?? '' }}" id="misc_amount_logistics_{{ $counter }}" placeholder="Enter Misc Amount (Logistics)" type="text" aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>
                                                

                                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                            <button type="button" class="btn btn-primary" id="addForm4">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $counter++;
                                            @endphp
                                            @endforeach
                                            @else
                                            <div class="row gutters" id="formSet4">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                        <label for="misc_cost_logistics_{{ $counter }}">Misc Cost (Logistics)</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control misc_cost_logistics" name="misc_cost_logistics[]" value="" id="misc_cost_logistics_1" placeholder="Enter Misc Cost (Logistics)" type="text" aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 form-group">
                                                        <label for="misc_amount_logistics_{{ $counter }}">Misc Amount (Logistics)</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control misc_amount_logistics" name="misc_amount_logistics[]" value="" id="misc_amount_logistics_1" placeholder="Enter Misc Amount (Logistics)" type="text" aria-describedby="basic-addon3">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-primary" id="addForm4">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <script>
                                        $(document).ready(function() {
                                            // Initialize the clone count
                                            var logisticsCloneCount = {{ $counter }};

                                            console.log("Initial logisticsCloneCount: " + logisticsCloneCount);

                                            $("#addForm4").click(function() {
                                                var miscLogistics = document.getElementsByClassName("form-control misc_amount_logistics");

                                                console.log("Adding new form. Updated logisticsCloneCount Length: " + miscLogistics.length);

                                                logisticsCloneCount = miscLogistics.length;
                                                logisticsCloneCount++;

                                                console.log("Adding new form. Updated logisticsCloneCount: " + logisticsCloneCount);

                                                var clonedFormL = $("#formSet4").clone();
                                                clonedFormL.find('input').val('');
                                                clonedFormL.find('input').removeAttr('required');

                                                // Append the clone count to input names and ids
                                                //clonedForm.find("[name='misc_cost_logistics']").attr('name', 'misc_cost_logistics_' + logisticsCloneCount);
                                                clonedFormL.find("[id^='misc_cost_logistics']").attr('id', 'misc_cost_logistics_' + logisticsCloneCount);
                                                
                                                //clonedForm.find("[name='misc_amount_logistics']").attr('name', 'misc_amount_logistics_' + logisticsCloneCount);
                                                clonedFormL.find("[id^='misc_amount_logistics']").attr('id', 'misc_amount_logistics_' + logisticsCloneCount);

                                                clonedFormL.find('.btn-primary').replaceWith('<button class="btn btn-danger remove-form4" type="button">-</button>');
                                                $("#formSet4").after(clonedFormL);
                                            });

                                            $(document).on('click', '.remove-form4', function() {
                                                $(this).closest('.row').remove();
                                            });
                                        });
                                        </script>
                                        </fieldset>

                                        <fieldset class="row" style="background: #E7CBA9;">
                                                <legend> <i class="icon-cost mt-6" style="color:#000"></i> Quote Cost Information </legend>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="total_weight">Total Weight</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="total_weight" id="total_weight"
                                                        maxlength="11" value="{{ (float) $details->total_weight ?? 0 }}" placeholder="Enter Total Weight" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('total_weight'))
                                                        <div class="" style="color:red">{{ $errors->first('total_weight') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="freight_charges">Supplier Freight </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>

                                                        <input class="form-control" name="freight_charges" id="freight_charges" value="{{ round($details->freight_charges,2) ?? '0'}}" placeholder="Enter Freight Charges" type="text" aria-describedby="basic-addon3" step="0.01">
                                                    </div>

                                                    @if ($errors->has('freight_charges'))
                                                        <div class="" style="color:red">{{ $errors->first('freight_charges') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Select Freight Cost</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                        </div>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="freight_cost_option">
                                                            
                                                            <option value="{{$details->freight_cost_option ?? 'NO' }}">{{$details->freight_cost_option ?? 'NO' }} </option>
                                                            <option value=""> </option>
                                                            <option value="NO" >NO</option>
                                                            <option value="YES">YES</option>
                                                            
                                                        </select>
                                                    </div>

                                                    @if ($errors->has('freight_cost_option'))
                                                        <div class="" style="color:red">{{ $errors->first('freight_cost_option') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Transport Mode</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                        </div>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="transport_mode">
                                                            <option value="">Select mode of transport </option>
                                                            <option value="Air" {{$details->transport_mode == 'Air' ? 'selected' : ''}}>Air </option>
                                                            <option value="Sea" {{$details->transport_mode == 'Sea' ? 'selected' : ''}}>Sea</option>
                                                            <option value="Land" {{$details->transport_mode == 'Land' ? 'selected' : ''}}>Land</option>
                                                            <option value="Undecided" {{$details->transport_mode == 'Undecided' ? 'selected' : ''}}>Undecided</option>
                                                        </select>
                                                    </div>

                                                    @if ($errors->has('transport_mode'))
                                                        <div class="" style="color:red">{{ $errors->first('transport_mode') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="supplier_quote">Supplier Quote</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                        </div>
@php
    if ($details->supplier_quote_usd != 0 && $details->supplier_quote_usd !== NULL && $details->supplier_quote_usd !== '') {
        $supplier_quote = $details->supplier_quote_usd;
    } else {
        $supplier_quote = $tq;
    }
@endphp
                                                        <input class="form-control" name="supplier_quote" id="supplier_quote" value="{{ round($supplier_quote,2) ?? '0'}}" placeholder="Enter Quote for Naira" type="text"
                                                            aria-describedby="basic-addon3" readonly>
                                                    </div>

                                                    @if ($errors->has('supplier_quote'))
                                                        <div class="" style="color:red">{{ $errors->first('supplier_quote') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="cost_of_funds">Cost of Funds</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-select-arrows" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="cost_of_funds" id="cost_of_funds" value="{{ round($details->cost_of_funds,2) ?? 0 }}" readonly placeholder="Enter Cost of Funds" type="number"
                                                        aria-describedby="basic-addon3" step="">
                                                    </div>

                                                    @if ($errors->has('cost_of_funds'))
                                                        <div class="" style="color:red">{{ $errors->first('cost_of_funds') }}</div>
                                                    @endif

                                                </div>
                                            </div>                                            
                                            @php
                                            // $subTotalCost = $details->supplier_quote_usd + $details->freight_charges + $details->other_cost + $loc;
                                            // $fund_transfer_charge = (0.005 / 100) * $subTotalCost;
                                            // $vat_transfer_charge = (0.075 / 100 ) * $fund_transfer_charge;
                                            @endphp
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="">Funds Transfer Charge</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="fund_transfer_charge" id="fund_transfer_charge" value="{{ round($details->fund_transfer_charge,2) ?? '0'}}" placeholder="" type="text"
                                                            aria-describedby="basic-addon3" readonly>
                                                    </div>

                                                    @if ($errors->has('fund_transfer_charge'))
                                                        <div class="" style="color:red">{{ $errors->first('fund_transfer_charge') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="">VAT on Transfer Charge</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="vat_transfer_charge" id="vat_transfer_charge" value="{{ round($details->vat_transfer_charge, 2) ?? '0'}}" placeholder="" type="text"
                                                            aria-describedby="basic-addon3" readonly>
                                                    </div>

                                                    @if ($errors->has('vat_transfer_charge'))
                                                        <div class="" style="color:red">{{ $errors->first('vat_transfer_charge') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="supplier_quote">Offshore Charge</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="offshore_charges" id="offshore_charges" value="{{ round($details->offshore_charges,2) ?? '0'}}" placeholder="" type="text"
                                                            aria-describedby="basic-addon3" required>
                                                    </div>

                                                    @if ($errors->has('offshore_charges'))
                                                        <div class="" style="color:red">{{ $errors->first('offshore_charges') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="supplier_quote">Swift Charge</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="swift_charges" id="swift_charges" value="{{ $details->swift_charges ?? '0'}}"
                                                        placeholder="" type="text"
                                                        aria-describedby="basic-addon3" required>
                                                    </div>

                                                    @if ($errors->has('swift_charges'))
                                                        <div class="" style="color:red">{{ $errors->first('swift_charges') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="fund_transfer">Fund Transfer</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-resize-100" style="color:#28a745"></i></span>
                                                        </div>
                                                        @if ($details->fund_transfer > 1)
                                                           @php $fund = $details->fund_transfer; @endphp
                                                        @else
                                                            @php $fund = 0; @endphp
                                                        @endif
                                                        <input class="form-control" name="fund_transfer" id="fund_transfer" value="{{ round($fund,2) ?? '0'}}" readonly placeholder="Enter Fund Transfer" type="text"
                                                        aria-describedby="basic-addon3" step="">
                                                    </div>

                                                    @if ($errors->has('fund_transfer'))
                                                        <div class="" style="color:red">{{ $errors->first('fund_transfer') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="other_cost">Other Cost</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-magnet" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="other_cost" id="other_cost" maxlength="" value="{{ round($details->other_cost,2) ?? '0'}}" required placeholder="Enter Other Cost" type="text" aria-describedby="basic-addon3" step="">
                                                    </div>

                                                    @if ($errors->has('other_cost'))
                                                        <div class="" style="color:red">{{ $errors->first('other_cost') }}</div>
                                                    @endif

                                                </div>
                                            </div>


                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="ncd">NCD </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-line-graph" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="ncd" id="ncd" value="{{ round($details->ncd,2) ?? '0'}}" readonly placeholder="Enter NCD" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('ncd'))
                                                        <div class="" style="color:red">{{ $errors->first('ncd') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

                                                <div class="form-group">
                                                    <label for="wht">WHT</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-adjust" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="wht" id="wht" maxlength="" value="{{ round($details->wht,2) ?? '0'}}" readonly placeholder="Enter WHT" type="text"
                                                        aria-describedby="basic-addon3" step="0.01">
                                                    </div>

                                                    @if ($errors->has('wht'))
                                                        <div class="" style="color:red">{{ $errors->first('wht') }}</div>
                                                    @endif

                                                </div>
                                            </div>


                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="percent_margin">Percent Gross Margin </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-price-tag" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="percent_margin" id="percent_margin"
                                                        maxlength="11" value="{{ $details->percent_margin ?? '0'}}" required placeholder="Enter Gross %"
                                                        type="text" aria-describedby="basic-addon3" readonly>
                                                    </div>

                                                    @if ($errors->has('percent_margin'))
                                                        <div class="" style="color:red">{{ $errors->first('percent_margin') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_value">Gross Margin</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-pie-chart" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="net_value" id="net_value"
                                                        maxlength="" value="{{ round($details->net_value,2) ?? '0'}}" readonly placeholder="Enter Gross Margin" type="text" aria-describedby="basic-addon3" step="">
                                                    </div>

                                                    @if ($errors->has('net_value'))
                                                        <div class="" style="color:red">{{ $errors->first('net_value') }}</div>
                                                    @endif

                                                </div>
                                            </div>

        @php
            if ($details->total_quote != 0 && $details->total_quote != NULL) {
                $sumTotalQuote = $details->total_quote;
            } else {
                $sumTotalQuotes = sumTotalQuote($details->rfq_id);
                if ($sumTotalQuotes < 1) {
                    $sumTotalQuote = 1;
                } else {
                    $sumTotalQuote = $sumTotalQuotes;
                }
            }
        @endphp
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="total_quote">Total Quote</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="total_quote" id="total_quote"
                                                         value="{{ round($sumTotalQuote,2) ?? '0'}}" placeholder="Enter Total Quote" type="text"
                                                        aria-describedby="basic-addon3" readonly>
                                                    </div>

                                                    @if ($errors->has('total_quote'))
                                                        <div class="" style="color:red">{{ $errors->first('total_quote') }}</div>
                                                    @endif

                                                </div>
                                                <!-- <input name="total_quote" id="total_quote" value="{{ $sumTotalQuote ?? '0'}}" type="hidden" aria-describedby="basic-addon3"> -->

                                            </div>

                                            @php
                                                $tot_quo = sumTotalQuote($details->rfq_id);
                                                // $tot_ddp = $details->net_percentage;
                                                $subTotalCost =  $tq + $details->freight_charges + $details->other_cost + $loc;
                                                $tot_ddp = $subTotalCost + $details->cost_of_funds + $details->fund_transfer;
                                                $net_margin = ($sumTotalQuote - $tot_ddp) - ($details->wht + $details->ncd);
                                                //$net = ($tot_quo - ($tot_ddp + $details->wht + $details->ncd));
                                                $net = ($tot_quo -($tot_ddp+($details->wht + $details->ncd)));
						                        
                                            @endphp                            
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Net Margin</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-price-tag" style="color:#28a745"></i></span>
                                                        </div>

                                                        <input class="form-control" name="net_percentage" id="net_percentage"
                                                        maxlength="" value="{{ round($details->net_percentage,2) ?? '0'}}" required placeholder="Enter Net %"
                                                            type="text" readonly
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('net_percentage'))
                                                        <div class="" style="color:red">{{ $errors->first('net_percentage') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <?php $comp = ($net_margin / $sumTotalQuote) * 100; ?>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Percent Net Margin</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3">
                                                                <i class="icon-price-tag" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="net_percentage_margin" id="net_percentage_margin"
                                                        maxlength="100" value="{{ round($details->percent_net, 2) ?? 0}}" required placeholder="Percent Net Margin"
                                                            type="text" readonly
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="row" style="background: #CAE7E3;">
                                                <legend> <i class="icon-clipboard mt-6" style="color:#000"></i> Note To Pricing Details </legend>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Estimated Package Weight</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon6"><i class="icon-package" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="estimated_package_weight" placeholder="Enter estimated package weight" type="text" aria-describedby="basic-addon6" value="{{ $details->estimated_package_weight}}" maxlength="150">
                                                    </div>
                                                    @if ($errors->has('estimated_package_weight'))
                                                        <div class="" style="color:red">{{ $errors->first('estimated_package_weight') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Estimated Package Dimension</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon6"><i class="icon-package" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="estimated_package_dimension" placeholder="Enter estimated package dimension" type="text" aria-describedby="basic-addon6" value="{{ $details->estimated_package_dimension}}" maxlength="150">
                                                    </div>
                                                    @if ($errors->has('estimated_package_dimension'))
                                                        <div class="" style="color:red">{{ $errors->first('estimated_package_dimension') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">HS Codes</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon6"><i class="icon-code" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="hs_codes" placeholder="Enter HS Codes" type="text" aria-describedby="basic-addon6" value="{{ $details->hs_codes}}" maxlength="150">
                                                    </div>
                                                    @if ($errors->has('hs_codes'))
                                                        <div class="" style="color:red">{{ $errors->first('hs_codes') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">

                                                    <label for="password">Currency</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon6"><i class="icon-package" style="color:#28a745"></i></span>
                                                        </div>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="currency">
                                                            <option value="{{ $details->currency ?? 'USD' }}"> {{ $details->currency ?? 'USD' }} </option>
                                                            <option value=""></option>
                                                            <option value="USD">USD</option>
                                                            <option value="NGN"> NGN </option>
                                                            <option value="EUR"> EUR </option>
                                                            <option value="GNP"> GNP </option>

                                                        </select>

                                                    </div>
                                                    @if ($errors->has('currency'))
                                                        <div class="" style="color:red">{{ $errors->first('currency') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Validity</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="validity" placeholder="Enter validity" type="text" aria-describedby="basic-addon6" value="{{ $details->validity ?? '30 days'}}" maxlength="150">
                                                    </div>

                                                    @if ($errors->has('validity'))
                                                        <div class="" style="color:red">{{ $errors->first('validity') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Estimated Delivery Time</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon6"><i class="icon-code" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="estimated_delivery_time" type="text" aria-describedby="basic-addon6" value="{{ $details->estimated_delivery_time}}" maxlength="150" placeholder="e.g 10-12 weeks">
                                                    </div>
                                                    @if ($errors->has('estimated_delivery_time'))
                                                        <div class="" style="color:red">{{ $errors->first('estimated_delivery_time') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Certificate offered?</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-book" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="certificates_offered" placeholder="Enter certificates offered by OEM" type="text" aria-describedby="basic-addon6" value="{{ $details->certificates_offered}}" maxlength="150">
                                                    </div>

                                                    @if ($errors->has('certificates_offered'))
                                                        <div class="" style="color:red">{{ $errors->first('certificates_offered') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Delivery Location</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="delivery_location" placeholder="Enter Delivery Location" type="text" required aria-describedby="basic-addon6" value="{{ $details->delivery_location}}" maxlength="150">
                                                    </div>

                                                    @if ($errors->has('delivery_location'))
                                                        <div class="" style="color:red">{{ $errors->first('delivery_location') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Payment Term</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="payment_term" placeholder="Enter Payment Term" type="text" required aria-describedby="basic-addon6" value="{{ $details->payment_term}}" maxlength="500">
                                                    </div>

                                                    @if ($errors->has('delivery_location'))
                                                        <div class="" style="color:red">{{ $errors->first('delivery_location') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">

                                                <div class="form-group mb-5">
                                                    <label for="incoterm">Incoterm</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">
                                                                <i class="icon-cloud" style="color:#28a745"></i>
                                                            </span>
                                                        </div>

                                                        <select class="form-control selectpicker" required name="incoterm">
                                                            <option value="">Select Incoterm</option>
                                                            <option value="Ex Works" <?php if($details->incoterm == 'Ex Works'){echo 'selected';} ?>> Ex Works </option>
                                                            <option value="DDP" <?php if($details->incoterm == 'DDP'){echo 'selected';} ?>> DDP </option>

                                                        </select>

                                                    </div>

                                                    @if ($errors->has('incoterm'))
                                                        <div class="" style="color:red">{{ $errors->first('incoterm') }}</div>
                                                    @endif

                                                </div>
                                        
                                            </div>
                                        </div>

                                    </fieldset>
                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">

                                        <div class="row gutters">


                                            
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                        <div class="row gutters">
                                        <fieldset class="row">
                                                <legend> Notes </legend>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">

                                                    <div class="card m-0"><label for="net_percentage">RFQ Note:</label>
                                                        <textarea class="summernote" name="note" required placeholder="Please enter RFQ Note Here">
                                                            {!! $details->note !!}
                                                        </textarea>
                                                        @if ($errors->has('note'))
                                                            <div class="" style="color:red">{{ $errors->first('note') }}</div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Technical Note:</label>
                                                    <textarea class="summernote2" name="technical_note" placeholder="Please enter technical note (if any)." style="">{!! $details->technical_note !!}</textarea>
                                                    @if ($errors->has('technical_note'))
                                                        <div class="" style="color:red">{{ $errors->first('technical_note') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" >
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="doctor-profile">

                                                            <p align="center"><b>
                                                                @if (file_exists('document/rfq/'.$details->rfq_id.'/'))
                                                                    <?php
                                                                    $dir = 'document/rfq/'.$details->rfq_id.'/';
                                                                    $files = scandir($dir);
                                                                    $total = count($files) - 2; ?>
                                                                    <label for="net_percentage">Total Files ({{ $total ?? 0 }}) </label>

                                                                @else
                                                                <label for="net_percentage"> File (0) </label>
                                                                @endif
                                                            </b></p>
                                                            <div class="input-group mb-3">
                                                                <div class="custom-file">

                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-folder" style="color:#28a745"></i></span>
                                                                        </div>
                                                                        <input type="file" class="form-control" name="document[]" id="document" value="{{old('document[]')}}" multiple aria-describedby="basic-addon3">
                                                                    </div>

                                                                    @if ($errors->has('document'))
                                                                        <div class="" style="color:red">{{ $errors->first('document') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                @if (file_exists('document/rfq/'.$details->rfq_id.'/'))
                                                    <div class="row gutters" style="overflow-y: auto; max-height: 200px; border: 1px solid #ccc; padding: 10px;">
                                                        <ul style="list-style-type: disc; padding: 0;">
                                                            <?php
                                                            $dir = 'document/rfq/'.$details->rfq_id.'/';
                                                            $files = scandir($dir);
                                                            $file = 'document/rfq/'.$details->rfq_id.'/';

                                                            if (is_dir($file)) {
                                                                if ($opendirectory = opendir($file)) {
                                                                    while (($file = readdir($opendirectory)) !== false) {
                                                                        $len = strlen($file);

                                                                        if ($len > 2) {
                                                                            ?>
                                                                            <li style="margin-bottom: 5px;">
                                                                                <a href="{{ asset('document/rfq/'.$details->rfq_id.'/'.$file) }}" title="{{ $file }}" target="_blank">
                                                                                    <span>{{ substr($file, 0, 18) }}</span>
                                                                                </a>
                                                                                <a href="{{ route('remove.file', [$details->rfq_id, $file]) }}" title="{{ 'Delete '.$file }}" onclick="return(confirmToDeleteFile());">
                                                                                    <span class="icon-delete" style="color:red;"></span>
                                                                                </a>
                                                                            </li>
                                                                        <?php
                                                                        }
                                                                    }
                                                                    closedir($opendirectory);
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                            <hr style="margin-top: 15px; margin-bottom:15px;">
                                                @endif                                            
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" >
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="doctor-profile">
                                                            {{-- <div class="doctor-thumb">
                                                                <img src="{{asset('admin/img/icons/three-folders-file-folder-B5m6YM5-600.jpg')}}" alt="File" style="width:100px; height:100px">
                                                            </div> --}}
                                                            <p align="center"><b>
                                                                @if (file_exists('document/rfq/files/'.$details->rfq_id.'/'))
                                                                    <?php
                                                                    $dir = 'document/rfq/files/'.$details->rfq_id.'/';
                                                                    $files = scandir($dir);
                                                                    $total = count($files) - 2; ?>
                                                                    Total Images ({{ $total ?? 0 }})

                                                                @else
                                                                    Image (0)
                                                                @endif
                                                            </b></p>
                                                            <div class="input-group mb-3">
                                                                <div class="custom-file">

                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-folder" style="color:#28a745"></i></span>
                                                                        </div>
                                                                        <input type="file" class="form-control" name="images[]" id="document" value="{{old('images[]')}}" multiple aria-describedby="basic-addon3">
                                                                    </div>

                                                                    @if ($errors->has('images'))
                                                                        <div class="" style="color:red">{{ $errors->first('images') }}</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (file_exists('document/rfq/files/'.$details->rfq_id.'/'))
                                                    <div class="row gutters">
                                                        <?php
                                                        $dir = 'document/rfq/files/'.$details->rfq_id.'/';
                                                        $files = scandir($dir);
                                                        $total = count($files) - 2;
                                                        $file = 'document/rfq/files/'.$details->rfq_id.'/';
                                                        if (is_dir($file)){
                                                            if ($opendirectory = opendir($file)){  $num =1;
                                                                while (($file = readdir($opendirectory)) !== false){?>
                                                                    <?php $len = strlen($file); ?>
                                                                    @if($len > 2)
                                                                        <a href="{{ asset('document/rfq/files/'.$details->rfq_id.'/'.$file) }}" title="" target="_blank">

                                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" style="margin-bottom: 5px">
                                                                                <h6><small>{{ substr($file,0,18) }}</small>
                                                                                <a href="{{route('remove.image',[$details->rfq_id,$file])}}" title="{{ 'Delete '.$file}}" onclick="return(confirmToDeleteImage());">
                                                                                    <span class="icon-delete" style="color:red;"></span>
                                                                                </a>
                                                                                </h6>

                                                                            </div>
                                                                        </a>
                                                                    @endif

                                                                    <?php $num++;

                                                                }
                                                                closedir($opendirectory);
                                                            }
                                                        }

                                                        if($total < 1){ ?>
                                                            <div class="col-xl-12 col-lg-12 col-md-4 col-sm-4 col-12">
                                                                <h4><p style="color:red" align="center">No Image was found </p></h4>
                                                            </div><?php
                                                        }else{

                                                        }?>

                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Notify Shipper</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-database" style="color:#28a745"></i></span>
                                                        </div>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="shipper_mail">
                                                            <option value="{{ $details->shipper_mail }}">{{ $details->shipper_mail }} </option>

                                                            <option value=""> </option>
                                                            <option value="NO">NO </option>
                                                            <option value="YES">YES </option>
                                                        </select>
                                                    </div>

                                                    @if ($errors->has('shipper_mail'))
                                                        <div class="" style="color:red">{{ $errors->first('shipper_mail') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Send Image with Breakdown</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                        </div>

                                                        <select class="form-control selectpicker" data-live-search="true" required name="send_image">
                                                            <option value="{{ $details->send_image ?? 'NO' }}">{{ $details->send_image ?? 'NO' }}  </option>
                                                            <option value="">  </option>
                                                            <option value="NO"> NO </option>
                                                            <option value="YES"> YES </option>

                                                        </select>

                                                    </div>

                                                    @if ($errors->has('send_image'))
                                                        <div class="" style="color:red">{{ $errors->first('send_image') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">

                                                <div class="form-group">
                                                    <label for="inputName">Online Submission</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">
                                                                <i class="icon-cloud" style="color:#28a745"></i>
                                                            </span>
                                                        </div>

                                                        <select class="form-control selectpicker" data-live-search="true" required name="online_submission">
                                                            <option value="{{ $details->online_submission}}"> {{ $details->online_submission}} </option>
                                                            <option value="">  </option>
                                                            <option value="NO"> NO </option>
                                                            <option value="YES"> YES </option>

                                                        </select>

                                                    </div>

                                                    @if ($errors->has('online_submission'))
                                                        <div class="" style="color:red">{{ $errors->first('online_submission') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" >
                                                <b> Supplier Files: {{ count(getSupplierFiles($details->rfq_id, $details->vendor_id) ). ' Files ' ?? ' File' }}</b><br>
                                                <p style="text-justify:auto;">
                                                
                                                    <div class="row gutters">
                                                        @foreach (getSupplierFiles($details->rfq_id, $details->vendor_id) as $item)
                                                            <a href="{{ asset('supplier-document/'.$item->file) }}" title="{{$item->file}}" target="_blank">
                                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" style="margin-left:;">
                                                                    <div class="icon-tiles" style="background: -webkit-linear-gradient(45deg, #3949ab, #4fc3f7); color:white; height:70px; width:180px" >
                                                                        <h6 style="margin-top: -17px;">{{ substr($item->file,0, 40) }}</h6>
                                                            
                                                                    </div>
                                                                </div>
                                                            </a>                                                        
                                                        @endforeach
                                                                            

                                                    </div>
                                                </p>
                                            </div>
                                            <div id="floatingInputContainer">
                                            <div class="row">                                                
                                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                                                    <div class="form-group">
                                                        <label for="mark_up"><b>Mark Up</b></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control" name="mark_up" id="mark_up" value="{{ $details->mark_up ?? '0'}}" placeholder="" type="text" aria-describedby="basic-addon3">
                                                        </div>

                                                        @if ($errors->has('mark_up'))
                                                            <div class="" style="color:red">{{ $errors->first('mark_up') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="autoCalculate">Auto Calculate?</label>
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                            </div>
                                                        <input name="auto_calculate" value="1" class="ml-2" type="checkbox" id="autoCalculate" @if($details->auto_calculate == 1) checked @endif>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            </div>

                                            
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div id="floatingButtonContainer">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" title="Click the button to update the RFQ">Update The RFQ Details</button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                            @php $mail = array('tolajide75@gmail.com','taiwo@enabledjobgroup.net', 'mary@enabledjobs.com', 'hq@enabledjobs.com'); @endphp
                            <div class="modal fade bd-example-modal-lg" id="customModalTwo" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="customModalTwoLabel">Submit Quotation To Buyer</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('submit.quote.store') }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row gutters">
                                                    <div class="col-md-5 col-sm-5 col-5">
                                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="email">
                                                            @foreach (buyers($details->contact_id) as $items)
                                                                <option data-tokens="{{ $items->email ?? 'N/A' }}"
                                                                    value="{{  $items->email  }}">
                                                                    {{ $items->email ?? 'N/A' }}
                                                                </option>
                                                            @endforeach
                                                            <option value="emmanuel.idowu@tagenergygroup.net">Emmanuel.idowu@tagenergygroup.net</option>
                                                        </select>

                                                        @if ($errors->has('email'))
                                                            <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- <div class="col-md-5 col-sm-5 col-5">

                                                        <label for="recipient-name" class="col-form-label">File:</label>
                                                        <input type="file" class="form-control" id="file-name" name="file[]" required multiple>
                                                        @if ($errors->has('file'))
                                                            <div class="" style="color:red">{{ $errors->first('file') }}</div>
                                                        @endif
                                                    </div> --}}

                                                    <div class="col-md-7 col-sm-7 col-7">
                                                        <label for="recipient-name" class="col-form-label">CC Email</label>

                                                        <input type="text" class="form-control" id="recipient-email" name="recipient" value="{{ old('recipient') }}" required>
                                                        @if ($errors->has('recipient'))
                                                            <div class="" style="color:red">{{ $errors->first('recipient') }}</div>
                                                        @endif


                                                    </div>

                                                    <div class="col-md-12 col-sm-12 col-12">
                                                        <label for="additional-file" class="col-form-label">Additional File</label>

                                                        <input type="file" class="form-control" id="additional-file" name="additional-file">

                                                    </div>
                                                    <input type="hidden" name="rfq_id" value="{{ $details->rfq_id }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer custom">

                                                <div class="left-side">
                                                    <button type="button" class="btn btn-link danger" data-dismiss="modal">Cancel</button>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="right-side">
                                                    <button type="submit" class="btn btn-link success">Send Quotation</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade bd-example-modal-lg" id="customModals" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="customModalTwoLabel">Request Approval</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('breakdown.submit') }}" class="" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">

                                                <div class="row gutters">
                                                    <div class="col-md-4 col-sm-4 col-4">
                                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                        <!-- <input type="email" class="form-control" id="recipient-email" name="rec_email"
                                                        value="bidadmin@tagenergygroup.net" readonly> -->
                                                        <input type="email" class="form-control" id="recipient-email" name="rec_email"
                                                        value="emmanuel.idowu@tagenergygroup.net" readonly>
                                                        @if ($errors->has('rec_email'))
                                                            <div class="" style="color:red">{{ $errors->first('rec_email') }}</div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="col-md-8 col-sm-8 col-8">
                                                        <label for="recipient-name" class="col-form-label">CC Email:</label>
                                                        <!-- <input type="text" class="form-control" id="recipient-email" name="quotation_recipient" value="contact@tagenergygroup.net; sales@tagenergygroup.net" readonly> -->
                                                        <input type="text" class="form-control" id="recipient-email" name="quotation_recipient" value="emmanuel@enabledgroup.net; jackomega.idnoble@gmail.com">
                                                        @if ($errors->has('quotation_recipient'))
                                                            <div class="" style="color:red">{{ $errors->first('quotation_recipient') }}</div>
                                                        @endif
                                                    </div>
                                                    <input type="hidden" name="rfq_id" value="{{ $details->rfq_id }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer custom">

                                                <div class="left-side">
                                                    <button type="button" class="btn btn-link danger" data-dismiss="modal">Cancel</button>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="right-side">
                                                    <button type="submit" class="btn btn-link success">Request Approval</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<script>
                                            function calculateCostOfFunds() {
                                                if ($("#autoCalculate").is(":checked")) {
                                                // Get values from the main form fields
                                                const supplierQuote = parseFloat($("#supplier_quote").val()) || 0;
                                                const freightCharges = parseFloat($("#freight_charges").val()) || 0;
                                                const localDelivery = parseFloat($("#local_delivery").val()) || 0;
                                                const percentInterest = parseFloat($("#percent_interest").val()) || 0;
                                                const interestRate = parseFloat($("#intrest_rate").val()) || 0;
                                                const duration = parseFloat($("#duration").val()) || 0;
                                                
                                                const logisticsPercent = parseFloat($("#percent_logistics").val()) || 0;
                                                const logisticsInterestRate = parseFloat($("#intrest_rate_logistics").val()) || 0;
                                                const logisticsDuration = parseFloat($("#duration_logistics").val()) || 0;

                                                var clonedsupplier = document.getElementsByClassName("form-control cloned_supplier_percent");
                                                var clonedlogistics = document.getElementsByClassName("form-control cloned_logistics_percent");
                                                var miscSupplier = document.getElementsByClassName("form-control misc_amount_supplier");
                                                var miscLogistics = document.getElementsByClassName("form-control misc_amount_logistics");

                                                let totalMiscSupplier = 0;
                                                for( var s = 0; s < miscSupplier.length; s++ )
                                                {
                                                    var ss = s+1;
                                                    const miscAmountSupplier = parseFloat($("#misc_amount_supplier_" + ss).val()) || 0; // Correct the selector
                                                    totalMiscSupplier += miscAmountSupplier; // Add the missing multiplication
                                                    //console.log('worked Supplier' + s);
                                                    //console.log('total Misc Supplier' + totalMiscSupplier);
                                                };
                                                
                                                let totalMiscLogistics = 0;
                                                for( var l = 0; l < miscLogistics.length; l++ )
                                                {
                                                    var ll = l+1;
                                                    const miscAmountLogistics = parseFloat($("#misc_amount_logistics_" + ll).val()) || 0; // Correct the selector
                                                    totalMiscLogistics += miscAmountLogistics; // Add the missing multiplication
                                                    //console.log('worked Logistic' + l);
                                                    //console.log('Total misc Logistic' + totalMiscLogistics);
                                                };

                                                //console.log('Total misc Logistic' + totalMiscLogistics);


                                                let totalCostOfFunds = 0; // Initialize the total cost of funds
                                                //console.log(clonedsupplier.length);
                                                // Calculate cost of funds for the main form fields
                                                totalCostOfFunds += ((supplierQuote + freightCharges + totalMiscSupplier) * parseFloat($("#intrest_percent").val()) / 100 * parseFloat($("#intrest_rate").val()) * parseFloat($("#duration").val())) +
                                                ((localDelivery + totalMiscLogistics) * parseFloat($("#percent_logistics").val()) / 100 * parseFloat($("#intrest_logistics").val()) * parseFloat($("#duration_logistics").val()));

                                                // Iterate through the cloned supplier rows and calculate cost of funds for each
                                                for( var i = 0; i < clonedsupplier.length; i++ )
                                                {
                                                    var ii = i+1;
                                                    const interestRatesq = parseFloat($("#intrest_rate_" + ii).val()) || 0; // Correct the selector
                                                    const durationsq = parseFloat($("#duration_" + ii).val()) || 0; // Correct the selector
                                                    const percentInterestsq = parseFloat($("#intrest_percent_" + ii).val()) || 0; // Correct the selector
                                                    totalCostOfFunds += ((supplierQuote + freightCharges + totalMiscSupplier) * percentInterestsq / 100 * interestRatesq * durationsq); // Add the missing multiplication
                                                    //console.log('worked' + i);
                                                };
                                                
                                                // Iterate through the cloned logistics rows and calculate cost of funds for each
                                                for( var j = 0; j < clonedlogistics.length; j++ )
                                                {
                                                    
                                                    var jj = j+1;
                                                    const interestRatelg = parseFloat($("#intrest_logistics_" + jj).val()) || 0;
                                                    const durationlg = parseFloat($("#duration_logistics_" + jj).val()) || 0;
                                                    const percentLogistics = parseFloat($("#percent_logistics_" + jj).val()) || 0;

                                                    totalCostOfFunds += ((localDelivery + totalMiscLogistics) * percentLogistics / 100 * interestRatelg * durationlg);
                                                };

                                                // Update the cost of funds field
                                                $("#cost_of_funds").val(totalCostOfFunds.toFixed(2)) || 0;
                                            }
                                            }

                                            // Add event listeners to cloned rows
                                            $(document).on("input", "[id^='misc_amount_supplier_'], [id^='misc_amount_logistics_'], [id^='intrest_percent'], [id^='percent_logistics'], [id^='intrest_rate'], [id^='intrest_logistics'], [id^='duration'], [id^='duration_logistics']", function() {
                                                calculateCostOfFunds();
                                            });

                                            // Add event listeners to cloned rows
                                            $(document).on("input", "[id^='intrest_percent_'], [id^='percent_logistics_'], [id^='intrest_rate_'], [id^='intrest_logistics_'], [id^='duration_'], [id^='duration_logistics_'], #freight_charges", function() {
                                                calculateCostOfFunds();
                                            });

                                            $(document).on("change", "#local_delivery, #supplier_quote, #freight_charges, #lumpsum, #soncap, #trucking, #clearing, #customs", function() {
                                                calculateCostOfFunds();
                                            });

                                            // Add event listener to local_delivery field
                                            $(document).on("change", "#local_delivery", function() {
                                                calculateCostOfFunds();
                                            });

                                            $(document).ready(function() {
                                                calculateCostOfFunds();
                                            });

                                            lumpSumField.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                soncapFields.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                customFields.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                clearingFields.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                truckingFields.querySelector('input').addEventListener('input', calculateCostOfFunds);


                                            function calculateCostOfFunds() {
                                                if ($("#autoCalculate").is(":checked")) {
                                                // Get values from the main form fields
                                                const supplierQuote = parseFloat($("#supplier_quote").val()) || 0;
                                                const freightCharges = parseFloat($("#freight_charges").val()) || 0;
                                                const localDelivery = parseFloat($("#local_delivery").val()) || 0;
                                                const percentInterest = parseFloat($("#percent_interest").val()) || 0;
                                                const interestRate = parseFloat($("#intrest_rate").val()) || 0;
                                                const duration = parseFloat($("#duration").val()) || 0;
                                                
                                                const logisticsPercent = parseFloat($("#percent_logistics").val()) || 0;
                                                const logisticsInterestRate = parseFloat($("#intrest_rate_logistics").val()) || 0;
                                                const logisticsDuration = parseFloat($("#duration_logistics").val()) || 0;

                                                var clonedsupplier = document.getElementsByClassName("form-control cloned_supplier_percent");
                                                var clonedlogistics = document.getElementsByClassName("form-control cloned_logistics_percent");
                                                var miscSupplier = document.getElementsByClassName("form-control misc_amount_supplier");
                                                var miscLogistics = document.getElementsByClassName("form-control misc_amount_logistics");

                                                let totalMiscSupplier = 0;
                                                for( var s = 0; s < miscSupplier.length; s++ )
                                                {
                                                    var ss = s+1;
                                                    const miscAmountSupplier = parseFloat($("#misc_amount_supplier_" + ss).val()) || 0; // Correct the selector
                                                    totalMiscSupplier += miscAmountSupplier; // Add the missing multiplication
                                                    //console.log('worked Supplier' + s);
                                                    //console.log('total Misc Supplier' + totalMiscSupplier);
                                                };
                                                
                                                let totalMiscLogistics = 0;
                                                for( var l = 0; l < miscLogistics.length; l++ )
                                                {
                                                    var ll = l+1;
                                                    const miscAmountLogistics = parseFloat($("#misc_amount_logistics_" + ll).val()) || 0; // Correct the selector
                                                    totalMiscLogistics += miscAmountLogistics; // Add the missing multiplication
                                                    //console.log('worked Logistic' + l);
                                                    //console.log('Total misc Logistic' + totalMiscLogistics);
                                                };

                                                //console.log('Total misc Logistic' + totalMiscLogistics);


                                                let totalCostOfFunds = 0; // Initialize the total cost of funds
                                                //console.log(clonedsupplier.length);
                                                // Calculate cost of funds for the main form fields
                                                totalCostOfFunds += ((supplierQuote + freightCharges + totalMiscSupplier) * parseFloat($("#intrest_percent").val()) / 100 * parseFloat($("#intrest_rate").val()) * parseFloat($("#duration").val())) +
                                                ((localDelivery + totalMiscLogistics) * parseFloat($("#percent_logistics").val()) / 100 * parseFloat($("#intrest_logistics").val()) * parseFloat($("#duration_logistics").val()));

                                                // Iterate through the cloned supplier rows and calculate cost of funds for each
                                                for( var i = 0; i < clonedsupplier.length; i++ )
                                                {
                                                    var ii = i+1;
                                                    const interestRatesq = parseFloat($("#intrest_rate_" + ii).val()) || 0; // Correct the selector
                                                    const durationsq = parseFloat($("#duration_" + ii).val()) || 0; // Correct the selector
                                                    const percentInterestsq = parseFloat($("#intrest_percent_" + ii).val()) || 0; // Correct the selector
                                                    totalCostOfFunds += ((supplierQuote + freightCharges + totalMiscSupplier) * percentInterestsq / 100 * interestRatesq * durationsq); // Add the missing multiplication
                                                    //console.log('worked' + i);
                                                };
                                                
                                                // Iterate through the cloned logistics rows and calculate cost of funds for each
                                                for( var j = 0; j < clonedlogistics.length; j++ )
                                                {
                                                    
                                                    var jj = j+1;
                                                    const interestRatelg = parseFloat($("#intrest_logistics_" + jj).val()) || 0;
                                                    const durationlg = parseFloat($("#duration_logistics_" + jj).val()) || 0;
                                                    const percentLogistics = parseFloat($("#percent_logistics_" + jj).val()) || 0;

                                                    totalCostOfFunds += ((localDelivery + totalMiscLogistics) * percentLogistics / 100 * interestRatelg * durationlg);
                                                };

                                                // Update the cost of funds field
                                                $("#cost_of_funds").val(totalCostOfFunds.toFixed(2)) || 0;
                                            }
                                            }

                                            // Add event listeners to cloned rows
                                            $(document).on("input", "[id^='misc_amount_supplier_'], [id^='misc_amount_logistics_'], [id^='intrest_percent'], [id^='percent_logistics'], [id^='intrest_rate'], [id^='intrest_logistics'], [id^='duration'], [id^='duration_logistics']", function() {
                                                calculateCostOfFunds();
                                            });

                                            // Add event listeners to cloned rows
                                            $(document).on("input", "[id^='intrest_percent_'], [id^='percent_logistics_'], [id^='intrest_rate_'], [id^='intrest_logistics_'], [id^='duration_'], [id^='duration_logistics_'], #freight_charges", function() {
                                                calculateCostOfFunds();
                                            });

                                            $(document).on("change", "#local_delivery, #supplier_quote, #freight_charges, #lumpsum, #soncap, #trucking, #clearing, #customs", function() {
                                                calculateCostOfFunds();
                                            });

                                            // Add event listener to local_delivery field
                                            $(document).on("change", "#local_delivery", function() {
                                                calculateCostOfFunds();
                                            });

                                            $(document).ready(function() {
                                                calculateCostOfFunds();
                                            });

                                            lumpSumField.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                soncapFields.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                customFields.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                clearingFields.querySelector('input').addEventListener('input', calculateCostOfFunds);
                                                truckingFields.querySelector('input').addEventListener('input', calculateCostOfFunds);

                                            let timeout;

                                            function calculateTotalQuote() {
                                                if ($("#autoCalculate").is(":checked")) {
                                                clearTimeout(timeout); // Clear any previous timeouts

                                                timeout = setTimeout(function() {
                                                    const supplierQuote = parseFloat($("#supplier_quote").val()) || 0;
                                                    const percent_Margin = parseFloat($("#percent_margin").val()) || 0;

                                                    const Total_Quote = ((percent_Margin / 100) * supplierQuote) + supplierQuote;

                                                    $("#total_quote").val(Total_Quote.toFixed(2));
                                                    
                                                    // After updating Total_Quote, call the main calculation function
                                                    calculateFundsTransferCharge();
                                                }, 500); // Delay for 1 second (1000 milliseconds)
                                            }
                                            }

                                            // Add event listener to trigger the calculation for #percent_margin
                                            $(document).on("input", "#percent_margin", function() {
                                                calculateTotalQuote();
                                            });

                                            function calculateFundsTransferCharge() {
                                                if ($("#autoCalculate").is(":checked")) {
                                                
                                                clearTimeout(timeout); // Clear any previous timeouts

                                                timeout = setTimeout(function() {
                                                    const supplierQuote = parseFloat($("#supplier_quote").val()) || 0;
                                                    const freightCharges = parseFloat($("#freight_charges").val()) || 0;
                                                    const otherCharges = parseFloat($("#other_cost").val()) || 0;
                                                    const localDelivery = parseFloat($("#local_delivery").val()) || 0;
                                                    const offshoreCharge = parseFloat($("#offshore_charges").val()) || 0;
                                                    const SwiftCharge = parseFloat($("#swift_charges").val()) || 0;
                                                    const TotalQuote = parseFloat($("#total_quote").val()) || 0;
                                                    const percent_Margin = parseFloat($("#percent_margin").val()) || 0;
                                                    const Costoffunds = parseFloat($("#cost_of_funds").val()) || 0;
                                                    const MarkUp = parseFloat($("#mark_up").val()) || 0;

                                                    var miscSupplier = document.getElementsByClassName("form-control misc_amount_supplier");
                                                    var miscLogistics = document.getElementsByClassName("form-control misc_amount_logistics");

                                                    let totalMiscSupplier = 0;
                                                    for( var s = 0; s < miscSupplier.length; s++ )
                                                    {
                                                        var ss = s+1;
                                                        const miscAmountSupplier = parseFloat($("#misc_amount_supplier_" + ss).val()) || 0; // Correct the selector
                                                        totalMiscSupplier += miscAmountSupplier; // Add the missing multiplication
                                                        //console.log('worked Supplier' + s);
                                                        //console.log('total Misc Supplier' + totalMiscSupplier);
                                                    };
                                                    
                                                    let totalMiscLogistics = 0;
                                                    for( var l = 0; l < miscLogistics.length; l++ )
                                                    {
                                                        var ll = l+1;
                                                        const miscAmountLogistics = parseFloat($("#misc_amount_logistics_" + ll).val()) || 0; // Correct the selector
                                                        totalMiscLogistics += miscAmountLogistics; // Add the missing multiplication
                                                        //console.log('worked Logistic' + l);
                                                        //console.log('Total misc Logistic' + totalMiscLogistics);
                                                    };

                                                    const subTotalCost = supplierQuote + freightCharges + totalMiscSupplier + otherCharges + localDelivery + totalMiscLogistics;
                                                    const fundsTransferCharge = 0.005 * (supplierQuote + freightCharges + otherCharges + localDelivery);
                                                    const vatcharge = 0.075 * fundsTransferCharge;
                                                    const FundTransfer = fundsTransferCharge + vatcharge + offshoreCharge + SwiftCharge;
                                                    const Wht = 0.05 * (TotalQuote - subTotalCost);
                                                    const Ncd = 0.01 * (TotalQuote - subTotalCost);
                                                    const TotalDDP = subTotalCost + FundTransfer + Costoffunds;
                                                    const NetMargin = TotalQuote - (TotalDDP + Wht + Ncd);
                                                    const PercentNetMargin = (NetMargin/TotalQuote) * 100;
                                                    const GrossMargin = TotalQuote - supplierQuote;
                                                    const PercentGrossMargin = (GrossMargin / supplierQuote) * 100;
                                                    const Total_Quote = ((MarkUp) * supplierQuote) + supplierQuote;

                                                    $("#fund_transfer_charge").val(fundsTransferCharge.toFixed(2));
                                                    $("#vat_transfer_charge").val(vatcharge.toFixed(2));
                                                    $("#fund_transfer").val(FundTransfer.toFixed(2));
                                                    $("#wht").val(Wht.toFixed(2));
                                                    $("#ncd").val(Ncd.toFixed(2));
                                                    $("#net_percentage_margin").val(PercentNetMargin.toFixed(2));
                                                    $("#net_percentage").val(NetMargin.toFixed(2));
                                                    $("#net_value").val(GrossMargin.toFixed(2));
                                                    $("#percent_margin").val(PercentGrossMargin.toFixed(2));
                                                    $("#total_quote").val(Total_Quote.toFixed(2));
                                                    $("#percent_margin").val(PercentGrossMargin.toFixed(2));
                                                }, 500); // Delay for 1 second (1000 milliseconds)
                                            }
                                            }

                                            // Add event listeners to trigger the calculation
                                            $(document).on("input", "#lumpsum, #mark_up, #total_quote, #soncap, #trucking, #clearing, #customs, #supplier_quote, #freight_charges, #other_cost, #percent_margix   n, #local_delivery, #offshore_charges, #swift_charges,[id^='intrest_percent'], [id^='percent_logistics'], [id^='intrest_rate'], [id^='intrest_logistics'], [id^='duration'], [id^='duration_logistics'], [id^='misc_amount_supplier_'], [id^='misc_amount_logistics_']", function() {
                                                calculateFundsTransferCharge();
                                            });

                                            $(document).ready(function() {
                                                calculateFundsTransferCharge(); // Initial calculation
                                            });
    // Event listener for the checkbox
    $(document).on("change", "#autoCalculate", function() {
        // Trigger the calculations
        calculateTotalQuote();
        calculateCostOfFunds();
        calculateFundsTransferCharge();
    });
</script>

<script>
const percentages = document.querySelectorAll(".percentage");

percentages.forEach(function(percentage) {
    percentage.addEventListener("input", function() {
        if (parseFloat(this.value) > 100) {
            this.value = "100";
        }
    });
});
</script>
@endsection
