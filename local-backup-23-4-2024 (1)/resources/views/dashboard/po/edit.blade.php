<?php $title = 'Edit Purchase Order'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item active"><a href="{{ route('po.edit',$details->po_id) }}">Edit PO</a></li>
                @endif
                <li class="breadcrumb-item "><a href="{{ route('po.details',$details->po_id) }}"> PO Details</a></li>
                <li class="breadcrumb-item"><a href="{{ route('po.index') }}">View PO</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.edit',$details->rfq->refrence_no) }}">Edit RFQ</a></li>
                <li class="breadcrumb-item">Edit PO Details</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" align="left">
                                    <a  href="{{ route('line.preview', $details->rfq_id) }}" class="btn btn-primary" >  View Line Items </a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" align="left">
                                    
                                    <a  href="{{ route('po.view.pdf', $details->po_id) }}" target="_blank" class="btn btn-info" >  View PDF</a>
                                </div>
                                {{--  @if(count(po($details->rfq_id)) > 0)
                                    @php $data = poSee($details->rfq_id); @endphp
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" align="right">
                                        <a  href="{{ route('po.pdf',[$data->po_id]) }}" class="btn btn-info" target="_blank">  View The PDF </a>
                                    </div>
                                @endif  --}}
                            </div>
                            <div class="card-header">
                                <div class="card-title">Please fill the below form to update the po details </div>
                            </div>
                            <form action="{{ route('po.update',$details->po_id) }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">

                                    <input type="hidden" name="company_id" value="{{ $rfq->company_id}}" >
                                    <input type="hidden" name="client_id" value="{{ $rfq->client_id}}" >
                                    <input type="hidden" name="rfq_id" value="{{ $rfq->rfq_id}}" >
                                    <input type="hidden" name="refrence_no" value="{{ $rfq->refrence_no }}" >

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Status</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>

                                                <select class="form-control selectpicker" data-live-search="true" required name="status" id="status">
                                                    <option data-tokens="{{ $details->status ?? ''}}" value="{{ $details->status ?? ''}}"> {{ $details->status ?? ''}}</option>
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
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Schedule</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
<select class="form-control selectpicker" data-live-search="true" required name="schedule" id="status">
    <option value="On Schedule" {{ $details->schedule == 'On Schedule' ? 'selected' : '' }}>On Schedule</option>
    <option value="Off Schedule" {{ $details->schedule == 'Off Schedule' ? 'selected' : '' }}>Off Schedule</option>
    <option value="Stalled" {{ $details->schedule == 'Stalled' ? 'selected' : '' }}>Stalled</option>
</select>
                                            </div>

                                            @if ($errors->has('schedule'))
                                                <div class="" style="color:red">{{ $errors->first('schedule') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Buyer</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon4"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>

                                                <select class="form-control selectpicker" data-live-search="true" required name="contact_id">
                                                    @if(count(contactDetail($rfq->contact_id)) > 0)
                                                        <option data-tokens="{{ $rfq->contact->first_name . " ". $rfq->contact->last_name }}" value="{{ $rfq->contact->contact_id }}">
                                                            {{ $rfq->contact->first_name . " ". $rfq->contact->last_name }}
                                                        </option>
                                                        <option value=""> </option>
                                                        @foreach ($client as $list)
                                                            <option data-tokens="{{ $list->first_name . " ". $list->last_name }}" value="{{ $list->contact_id }}">
                                                                {{ $list->first_name . " ". $list->last_name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value=""> </option>
                                                        @foreach ($client as $list)
                                                            <option data-tokens="{{ $list->first_name . " ". $list->last_name }}" value="{{ $list->contact_id }}">
                                                                {{ $list->first_name . " ". $list->last_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif

                                                </select>

                                            </div>

                                            @if ($errors->has('contact_id'))
                                                <div class="" style="color:red">{{ $errors->first('contact_id') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="phone_number">Assigned To</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>

                                                <select class="form-control selectpicker" data-live-search="true" required name="employee_id">
                                                    @if(count(employeeDetails($rfq->employee_id)) > 0)
                                                        <option data-tokens="{{ $details->rfq->employee->full_name ?? 1 }}" value="{{ $details->rfq->employee->employee_id ?? 'Test Emp' }}">
                                                            {{ $details->rfq->employee->full_name }}
                                                        </option>
                                                        <option value=""> </option>
                                                        @foreach ($employer as $employers)
                                                            <option data-tokens="{{ $employers->full_name }}" value="{{ $employers->employee_id }}">
                                                                {{ $employers->full_name ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">   </option>
                                                        @foreach ($employer as $employers)
                                                            <option data-tokens="{{ $employers->full_name }}" value="{{ $employers->employee_id }}">
                                                                {{ $employers->full_name ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>

                                            @if ($errors->has('employer_id'))
                                                <div class="" style="color:red">{{ $errors->first('employer_id') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Reference Number</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-layers" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="refrence_number" readonly placeholder="Enter Reference Number" type="text"
                                                aria-describedby="basic-addon6" value="{{ $rfq->refrence_no ?? ''}}">
                                            </div>
                                            @if ($errors->has('refrence_number'))
                                                <div class="" style="color:red">{{ $errors->first('refrence_number') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">

                                            <label for="password">Currency</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-package" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="currency">
                                                    <option value="{{ $rfq->currency ?? 'USD' }}"> {{ $rfq->currency ?? 'USD' }} </option>
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

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">PO Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>

                                                <input class="form-control" name="po_number" id="inputName" value="{{ $details->po_number ?? ''}}" required placeholder="Enter PO Nos" type="text"
                                                aria-describedby="basic-addon1">

                                            </div>

                                            @if ($errors->has('po_number'))
                                                <div class="" style="color:red">{{ $errors->first('po_number') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">PO Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="date" class="form-control datepicJker-date-format2" required name="po_date"
                                                value="{{ $details->po_date ?? ''}}">
                                            </div>
                                            @if ($errors->has('po_date'))
                                                <div class="" style="color:red">{{ $errors->first('po_date') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Delivery Due Date</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="date" class="form-control dateJpicker-date-format2" required name="delivery_due_date"
                                                value="{{$details->delivery_due_date}}" placeholder="Delivery Due Date">
                                            </div>
                                            @if ($errors->has('delivery_due_date'))
                                                <div class="" style="color:red">{{ $errors->first('delivery_due_date') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Actual Delivery Date</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="date" class="form-control dateJpicker-date-format2" required name="actual_delivery_date"
                                                value="{{$details->actual_delivery_date ?? ''}}" placeholder="Delivery Due Date">
                                            </div>
                                            @if ($errors->has('actual_delivery_date'))
                                                <div class="" style="color:red">{{ $errors->first('actual_delivery_date') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="frieght_charges">On-Time Delivery</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <?php
                                                $term = array('NO', 'YES'); ?>
                                                <select class="form-control selectpicker" data-live-search="true" required name="timely_delivery">
                                                    <option data-tokens="{{ $details->timely_delivery }}" value="{{ $details->timely_delivery }}"> {{ $details->timely_delivery }}</option>
                                                    <option value=""> </option>
                                                    @foreach ($term as $terms)
                                                        <option data-tokens="{{ $terms }}" value="{{ $terms }}"> {{ $terms }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            @if ($errors->has('timely_delivery'))
                                                <div class="" style="color:red">{{ $errors->first('timely_delivery') }}</div>
                                            @endif

                                        </div>
                                    </div>


                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Product</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-documents" style="color:#28a745"></i></span>
                                                </div>
                                                
                            @php
                            $products = getproducts();
                            @endphp
                            <select class="form-control selectpicker" data-live-search="true" required name="product">
                                @foreach($products as $product)
                                    <option value="{{ $product->product_name }}" @if($product->product_name == $rfq->product) selected @endif>
                                        {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                                            </div>
                                            @if ($errors->has('product'))
                                                <div class="" style="color:red">{{ $errors->first('product') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <input type="hidden" name="rfq_number" value="{{$rfq->rfq_number}}">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Description</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" required name="description"
                                                value="{{ $details->description }}" placeholder="Total PO NGN">
                                            </div>
                                            @if ($errors->has('description'))
                                                <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Supplier Reference Number</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-layers" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="supplier_ref_number" required placeholder="Enter Supplier Reference Number" type="text"
                                                aria-describedby="basic-addon6" value="{{ $details->supplier_ref_number ?? ''}}">
                                            </div>
                                            @if ($errors->has('supplier_ref_number'))
                                                <div class="" style="color:red">{{ $errors->first('supplier_ref_number') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Supplier Quote (USD):</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" readonly name="supplier_quote"
                                                value="{{ number_format($tq,2) ?? '0'}}" placeholder="Supplier QUote USD" 
                                                ondrop="return false;" onpaste="return false;">
                                            </div>
                                            @if ($errors->has('total_po_usd'))
                                                <div class="" style="color:red">{{ $errors->first('supplier_quote') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Total PO(USD)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" required name="total_po_usd"
                                                value="{{number_format((float)$details->po_value_foreign, 2, '.', '') ?? ''}}" placeholder="Total PO USD" ondrop="return false;" onpaste="return false;">
                                            </div>
                                            @if ($errors->has('total_po_usd'))
                                                <div class="" style="color:red">{{ $errors->first('total_po_usd') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Total PO(NGN)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" required name="total_po_ngn"
                                                value="{{number_format($details->po_value_naira) ?? ""}}" placeholder="Total PO NGN" ondrop="return false;" onpaste="return false;">
                                            </div>
                                            @if ($errors->has('total_po_ngn'))
                                                <div class="" style="color:red">{{ $errors->first('total_po_ngn') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="payment_terms_client">Payment Terms (Client)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" required name="payment_terms_client"
                                                value="{{$details->payment_terms_client ?? ""}}" placeholder="Payment Terms Client">

                                            </div>

                                            @if ($errors->has('payment_terms_client'))
                                                <div class="" style="color:red">{{ $errors->first('payment_terms_client') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="payment_terms">Payment Terms (Supplier)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" required name="payment_terms"
                                                value="{{$details->payment_terms ?? ""}}" placeholder="Payment Terms Supplier">

                                            </div>

                                            @if ($errors->has('payment_terms'))
                                                <div class="" style="color:red">{{ $errors->first('payment_terms') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="delivery_location">Delivery Location (Client)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-map" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="delivery_location" id="delivery_location"
                                                maxlength="" value="{{ $details->delivery_location ?? ''}}" required placeholder="Enter Delivery Location" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('delivery_location'))
                                                <div class="" style="color:red">{{ $errors->first('delivery_location') }}</div>
                                            @endif

                                        </div>
                                    </div>


                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="delivery_location">Delivery Location (Supplier)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-map" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="delivery_location_po" id="delivery_location_po"
                                                maxlength="" value="{{ $details->delivery_location_po ?? ''}}" required placeholder="Enter Delivery Location for Supplier" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('delivery_location_po'))
                                                <div class="" style="color:red">{{ $errors->first('delivery_location_po') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="frieght_charges">Delivery Terms (Client)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <?php
                                                $term = array('DDP', 'EXW', 'FCA', ''); ?>
                                                <select class="form-control selectpicker" data-live-search="true" required name="delivery_terms">
                                                    <option data-tokens="{{ $details->delivery_terms }}" value="{{ $details->delivery_terms }}"> {{ $details->delivery_terms }}</option>
                                                    <option value=""> </option>
                                                    @foreach ($term as $terms)
                                                        <option data-tokens="{{ $terms }}" value="{{ $terms }}"> {{ $terms }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            @if ($errors->has('delivery_terms'))
                                                <div class="" style="color:red">{{ $errors->first('delivery_terms') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="frieght_charges">Freight Charges (Client)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="frieght_charges" id="frieght_charges"
                                                maxlength="" value="{{$rfq->freight_charges ?? 0}}" required placeholder="Enter Freight Charges" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('frieght_charges'))
                                                <div class="" style="color:red">{{ $errors->first('frieght_charges') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="freight_charges_suplier">Freight Charges (Supplier)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="freight_charges_suplier" id="frieght_charges"
                                                maxlength="" value="{{$details->freight_charges_suplier ?? 0}}" required placeholder="Enter Freight Charges Supplier" type="number"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('freight_charges_suplier'))
                                                <div class="" style="color:red">{{ $errors->first('freight_charges_suplier') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="net_percentage">Select Freight Cost</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="freight_cost_option">
                                                    
                                                    <option value="{{$rfq->freight_cost_option ?? 'NO' }}">{{$rfq->freight_cost_option ?? 'NO' }} </option>
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
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="port_of_discharge">Port of Discharge</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="port_of_discharge" id="port_of_discharge"
                                                maxlength="" value="{{$details->port_of_discharge ?? ''}}" required placeholder="Enter Port of discharge" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('port_of_discharge'))
                                                <div class="" style="color:red">{{ $errors->first('port_of_discharge') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="local_delivery">Local Delivery</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-shopping-cart" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="local_delivery" id="local_delivery"
                                                maxlength="" value="{{$rfq->local_delivery ?? 0}}" required placeholder="Enter Local Delivery" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('local_delivery'))
                                                <div class="" style="color:red">{{ $errors->first('local_delivery') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="frieght_charges">Fund Transfer</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="fund_transfer" id="fund_transfer"
                                                maxlength="" value="{{$rfq->fund_transfer ?? 0}}" required placeholder="Enter Fund Transfer" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('fund_transfer'))
                                                <div class="" style="color:red">{{ $errors->first('fund_transfer') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="cost_of_funds">Cost of Funds</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="cost_of_funds" id="cost_of_funds"
                                                maxlength="" value="{{ $rfq->cost_of_funds ?? 0}}" required placeholder="Enter Freight Charges" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('cost_of_funds'))
                                                <div class="" style="color:red">{{ $errors->first('cost_of_funds') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="wht">WHT</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-adjust" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="wht" id="wht" maxlength="" value="{{ round($rfq->wht,2) ?? 0}}" required placeholder="Enter WHT" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('wht'))
                                                <div class="" style="color:red">{{ $errors->first('wht') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="ncd">NCD</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-line-graph" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="ncd" id="ncd" value="{{round($rfq->ncd,2) ?? 0}}" required placeholder="Enter NCD" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('ncd'))
                                                <div class="" style="color:red">{{ $errors->first('ncd') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="other_cost">Other Cost</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="other_cost" id="other_cost"
                                                maxlength="" value="{{ round($rfq->other_cost,2) ?? 0}}" required placeholder="Enter Other Cost" type="text"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('other_cost'))
                                                <div class="" style="color:red">{{ $errors->first('other_cost') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="net_percentage">Shipping Company</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-database" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="shipper_id">
                                                    <option data-tokens="{{ $rfq->shipper->shipper_name ?? '' }}" value="{{ $rfq->shipper->shipper_id ?? '' }}">
                                                    {{ $rfq->shipper->shipper_name ?? '' }}
                                                </option>
                                        @foreach ($shipper as $shippers)
                                        <option data-tokens="{{ $shippers->shipper_name ?? '' }}" value="{{ $shippers->shipper_id ?? '' }}">
                                                    {{ $shippers->shipper_name ?? '' }}
                                                </option>

                                        @endforeach

                                                </select>
                                            </div>

                                            @if ($errors->has('shipper_id'))
                                                <div class="" style="color:red">{{ $errors->first('shipper_id') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Ex-works Ready Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control datepicker-date-format2" required name="ex_works_date"
                                                value="{{ $details->ex_works_date ?? ''}}" placeholder="Ex-works Ready Date">
                                            </div>
                                            @if ($errors->has('ex_works_date'))
                                                <div class="" style="color:red">{{ $errors->first('ex_works_date') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="delivery">Delivery (Supplier)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="delivery" id="delivery"
                                                maxlength="" value="{{ $details->delivery ?? ''}}" required placeholder="Enter Delivery for Supplier" type="text"
                                                aria-describedby="basic-addon3" >
                                            </div>
                                            @if ($errors->has('delivery'))
                                                <div class="" style="color:red">{{ $errors->first('delivery') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <!--<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label for="password">HS Codes (Client)</label><div class="input-group">-->
                                    <!--            <div class="input-group-prepend">-->
                                    <!--                <span class="input-group-text" id="basic-addon6"><i class="icon-code" style="color:#28a745"></i></span>-->
                                    <!--            </div>-->
                                    <!--            <input class="form-control" name="hs_codes" placeholder="Enter HS Codes" type="text" aria-describedby="basic-addon6" value="{{ $rfq->hs_codes}}" maxlength="150">-->
                                    <!--        </div>-->
                                    <!--        @if ($errors->has('hs_codes'))-->
                                    <!--            <div class="" style="color:red">{{ $errors->first('hs_codes') }}</div>-->
                                    <!--        @endif-->

                                    <!--    </div>-->
                                    <!--</div>-->
                                    <input class="form-control" name="hs_codes" placeholder="Enter HS Codes" type="hidden" aria-describedby="basic-addon6" value="{{ $rfq->hs_codes ?? '00'}}" maxlength="150">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">HS Codes (Supplier)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-code" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="hs_codes_po" placeholder="Enter HS Codes Supplier" type="text" aria-describedby="basic-addon6" value="{{ $details->hs_codes_po}}" maxlength="150">
                                            </div>
                                            @if ($errors->has('hs_codes_po'))
                                                <div class="" style="color:red">{{ $errors->first('hs_codes_po') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="total_packaged_weight">Total Package Weight (Supplier)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="total_packaged_weight" id="total_packaged_weight"
                                                maxlength="" value="{{ $details->total_packaged_weight ?? '0'}}" required placeholder="Enter Total Weight" type="text"
                                                aria-describedby="basic-addon3" step="">
                                            </div>

                                            @if ($errors->has('total_packaged_weight'))
                                                <div class="" style="color:red">{{ $errors->first('total_packaged_weight') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="estimated_packaged_dimensions">Estimated Packaged Dimensions (Supplier) </label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="estimated_packaged_dimensions" id="estimated_packaged_dimensions" value="{{ $details->estimated_packaged_dimensions ?? '0'}}" 
                                                placeholder="Enter Estimated Packaged Dimensions"
                                                type="text" required aria-describedby="basic-addon3">
                                            </div>
                                            @if ($errors->has('estimated_packaged_dimensions'))
                                                <div class="" style="color:red">{{ $errors->first('estimated_packaged_dimensions') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="net_percentage">Transport Mode</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="transport_mode">
                                                    <option value="">Select mode of transport </option>
                                                    <option value="Air" {{$rfq->transport_mode == 'Air' ? 'selected' : ''}}>Air </option>
                                                    <option value="Sea" {{$rfq->transport_mode == 'Sea' ? 'selected' : ''}}>Sea</option>
                                                    <option value="Land" {{$rfq->transport_mode == 'Land' ? 'selected' : ''}}>Land</option>
                                                    <option value="Undecided" {{$rfq->transport_mode == 'Undecided' ? 'selected' : ''}}>Undecided</option>
                                                </select>
                                            </div>

                                            @if ($errors->has('transport_mode'))
                                                <div class="" style="color:red">{{ $errors->first('transport_mode') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    @if (file_exists('document/po/'.$details->po_id.'/'))
                                        <?php
                                        $dir = 'document/po/'.$details->po_id.'/';
                                        $files = scandir($dir);
                                        $total = count($files) - 2; ?>

                                    @else
                                        <?php $total = 0 ; ?>
                                    @endif
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="document">File ({{ $total .' Files' ?? '0 File' }})</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-file" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="document[]" id="document"
                                                maxlength="" value="{{old('document')}}" type="file"
                                                aria-describedby="basic-addon3" multiple>
                                            </div>

                                            @if ($errors->has('document'))
                                                <div class="" style="color:red">{{ $errors->first('document') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="row gutters">
                                    @if ($details->status == 'Paid' || $details->status == 'Invoiced' || $details->status == 'Delivered')

                                        <div class="col-md-12">
                                            <h4 style="color: #000; text-align: center;">=============RATING SECTION=============</h4>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="net_percentage">Reliability</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="shipping_reliability">
                                                        <option value="">Select Rating</option>

                                                        <option value="0" {{$details->shipping_reliability == '0' ? 'selected' : ''}}>0 </option>
                                                        <option value="1" {{$details->shipping_reliability == '1' ? 'selected' : ''}}>1 </option>
                                                        <option value="2" {{$details->shipping_reliability == '2' ? 'selected' : ''}}>2 </option>
                                                        <option value="3" {{$details->shipping_reliability == '3' ? 'selected' : ''}}>3 </option>
                                                        <option value="4" {{$details->shipping_reliability == '4' ? 'selected' : ''}}>4 </option>
                                                        <option value="5" {{$details->shipping_reliability == '5' ? 'selected' : ''}}>5 </option>
                                                        <option value="6" {{$details->shipping_reliability == '6' ? 'selected' : ''}}>6 </option>
                                                        <option value="7" {{$details->shipping_reliability == '7' ? 'selected' : ''}}>7 </option>
                                                        <option value="8" {{$details->shipping_reliability == '8' ? 'selected' : ''}}>8 </option>
                                                        <option value="9" {{$details->shipping_reliability == '9' ? 'selected' : ''}}>9 </option>
                                                        <option value="10" {{$details->shipping_reliability == '10' ? 'selected' : ''}}>10 </option>
                                                    </select>
                                                </div>

                                                @if ($errors->has('shipping_reliability'))
                                                    <div class="" style="color:red">{{ $errors->first('shipping_reliability') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="net_percentage">On-time Delivery</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="shipping_on_time_delivery">
                                                        <option value="">Select Rating</option>

                                                        <option value="0" {{$details->shipping_on_time_delivery == '0' ? 'selected' : ''}}>0 </option>
                                                        <option value="1" {{$details->shipping_on_time_delivery == '1' ? 'selected' : ''}}>1 </option>
                                                        <option value="2" {{$details->shipping_on_time_delivery == '2' ? 'selected' : ''}}>2 </option>
                                                        <option value="3" {{$details->shipping_on_time_delivery == '3' ? 'selected' : ''}}>3 </option>
                                                        <option value="4" {{$details->shipping_on_time_delivery == '4' ? 'selected' : ''}}>4 </option>
                                                        <option value="5" {{$details->shipping_on_time_delivery == '5' ? 'selected' : ''}}>5 </option>
                                                        <option value="6" {{$details->shipping_on_time_delivery == '6' ? 'selected' : ''}}>6 </option>
                                                        <option value="7" {{$details->shipping_on_time_delivery == '7' ? 'selected' : ''}}>7 </option>
                                                        <option value="8" {{$details->shipping_on_time_delivery == '8' ? 'selected' : ''}}>8 </option>
                                                        <option value="9" {{$details->shipping_on_time_delivery == '9' ? 'selected' : ''}}>9 </option>
                                                        <option value="10" {{$details->shipping_on_time_delivery == '10' ? 'selected' : ''}}>10 </option>
                                                    </select>
                                                </div>

                                                @if ($errors->has('shipping_on_time_delivery'))
                                                    <div class="" style="color:red">{{ $errors->first('shipping_on_time_delivery') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="net_percentage">Pricing</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="shipping_pricing">
                                                        <option value="">Select Rating</option>
                                                        <option value="0" {{$details->shipping_pricing == '0' ? 'selected' : ''}}>0 </option>
                                                        <option value="1" {{$details->shipping_pricing == '1' ? 'selected' : ''}}>1 </option>
                                                        <option value="2" {{$details->shipping_pricing == '2' ? 'selected' : ''}}>2 </option>
                                                        <option value="3" {{$details->shipping_pricing == '3' ? 'selected' : ''}}>3 </option>
                                                        <option value="4" {{$details->shipping_pricing == '4' ? 'selected' : ''}}>4 </option>
                                                        <option value="5" {{$details->shipping_pricing == '5' ? 'selected' : ''}}>5 </option>
                                                        <option value="6" {{$details->shipping_pricing == '6' ? 'selected' : ''}}>6 </option>
                                                        <option value="7" {{$details->shipping_pricing == '7' ? 'selected' : ''}}>7 </option>
                                                        <option value="8" {{$details->shipping_pricing == '8' ? 'selected' : ''}}>8 </option>
                                                        <option value="9" {{$details->shipping_pricing == '9' ? 'selected' : ''}}>9 </option>
                                                        <option value="10" {{$details->shipping_pricing == '10' ? 'selected' : ''}}>10 </option>
                                                    </select>
                                                </div>

                                                @if ($errors->has('shipping_pricing'))
                                                    <div class="" style="color:red">{{ $errors->first('shipping_pricing') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="net_percentage">Communication</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3"><i class="icon-truck" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="shipping_communication">
                                                        <option value="">Select Rating</option>
                                                        <option value="0" {{$details->shipping_communication == '0' ? 'selected' : ''}}>0 </option>
                                                        <option value="1" {{$details->shipping_communication == '1' ? 'selected' : ''}}>1 </option>
                                                        <option value="2" {{$details->shipping_communication == '2' ? 'selected' : ''}}>2 </option>
                                                        <option value="3" {{$details->shipping_communication == '3' ? 'selected' : ''}}>3 </option>
                                                        <option value="4" {{$details->shipping_communication == '4' ? 'selected' : ''}}>4 </option>
                                                        <option value="5" {{$details->shipping_communication == '5' ? 'selected' : ''}}>5 </option>
                                                        <option value="6" {{$details->shipping_communication == '6' ? 'selected' : ''}}>6 </option>
                                                        <option value="7" {{$details->shipping_communication == '7' ? 'selected' : ''}}>7 </option>
                                                        <option value="8" {{$details->shipping_communication == '8' ? 'selected' : ''}}>8 </option>
                                                        <option value="9" {{$details->shipping_communication == '9' ? 'selected' : ''}}>9 </option>
                                                        <option value="10" {{$details->shipping_communication == '10' ? 'selected' : ''}}>10 </option>
                                                    </select>
                                                </div>

                                                @if ($errors->has('shipping_communication'))
                                                    <div class="" style="color:red">{{ $errors->first('shipping_communication') }}</div>
                                                @endif

                                            </div>
                                        </div>


                                    @endif

                                    @if ($details->shipping_overall_rating < 1 || $details->shipping_overall_rating > 0)

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="lastName">Overall Rating</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                    </div>

                                                    <input type="text" class="form-control" readonly name="shipping_overall_rating"
                                                    value="{{ $details->shipping_overall_rating ?? ''}}" placeholder="Overall Rating">
                                                </div>
                                                @if ($errors->has('shipping_overall_rating'))
                                                    <div class="" style="color:red">{{ $errors->first('shipping_overall_rating') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="lastName">Rated By</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                    </div>

                                                    <input type="text" class="form-control" readonly name="shipping_rater"
                                                    value="{{ $details->shipping_rater ?? ''}}" placeholder="Rated By">
                                                </div>
                                                @if ($errors->has('shipping_rater'))
                                                    <div class="" style="color:red">{{ $errors->first('shipping_rater') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="lastName">Shipping Comments</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                    </div>

                                                    <textarea class="form-control" required name="shipping_comment"
                                                    value="" placeholder="Comments">{{ $details->shipping_comment ?? ''}}</textarea>
                                                </div>
                                                @if ($errors->has('shipping_comment'))
                                                    <div class="" style="color:red">{{ $errors->first('shipping_comment') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <input type="hidden" name="rater" value="<?php echo Auth::user()->first_name . ' '. Auth::user()->last_name ?>">

                                    @endif
                                </div>
                                
                                <div class="row gutters">

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="card m-0">
                                            <div class="card-header">
                                                <div class="card-title">Technical Note</div>
                                            </div>
                                        <textarea class="summernote1" name="technical_note" placeholder="Please enter technical note (if any)." style="" required>
                                        @if(!empty($details->technical_notes))
                                            {!! $details->technical_notes !!}
                                        @else
                                            N/A
                                        @endif
                                    </textarea>
                                            @if ($errors->has('technical_note'))
                                                <div class="" style="color:red">{{ $errors->first('technical_note') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="card m-0">
                                            <div class="card-header">
                                                <div class="card-title">PO Note</div>
                                            </div>
                                            <textarea class="summernote" name="note" required placeholder="Please enter PO Note">{!! $details->note !!} </textarea>
                                            @if ($errors->has('note'))
                                                <div class="" style="color:red">{{ $errors->first('note') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="card m-0">
                                            <div class="card-header">
                                                <div class="card-title">RFQ Note</div>
                                            </div>

                                            <textarea class="summernote3" name="rfq_note" required placeholder="Please enter RFQ Note">{!! $rfq->note !!} </textarea>
                                            @if ($errors->has('rfq_note'))
                                                <div class="" style="color:red">{{ $errors->first('rfq_note') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="card m-0">
                                            <div class="card-header">
                                                <div class="card-title">Tag Comment</div>
                                            </div>

                                            <textarea class="summernote2" name="tag_comment" required placeholder="Please enter Tag Comment">{!! $details->tag_comment !!} </textarea>
                                            @if ($errors->has('tag_comment'))
                                                <div class="" style="color:red">{{ $errors->first('tag_comment') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                                                                @if (file_exists('document/po/'.$details->po_id.'/'))
                                                <table class="table" id="fixedHeader">
                                                    <thead>
                                            <h3>Files</h3>
                                                        <tr>
                                                            <th>File Name</th>
                                                            <th>Date Created</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $dir = 'document/po/'.$details->po_id.'/';
                                                        $files = scandir($dir);
                                                        $total = count($files) - 2;
                                            
                                                        if (is_dir($dir) && $total > 0) {
                                                            if ($opendirectory = opendir($dir)) {
                                                                while (($file = readdir($opendirectory)) !== false) {
                                                                    $len = strlen($file);
                                            
                                                                    if ($len > 2) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>{{ substr($file, 0, 40) }}</td>
                                                                            <td>{{ date("Y-m-d H:i:s", filectime($dir . $file)) }}</td>
                                                                            <td class="file-menu">
                                                                                    <a href="{{ asset('document/po/'.$details->po_id.'/'.$file) }}" target="_blank">View</a> &nbsp | &nbsp
                                                                                    <a href="{{ route('remove.po.file', [$details->po_id, $file]) }}" title="{{ 'Delete '.$file }}" onclick="return(confirmToDeleteFile());">Delete</a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                closedir($opendirectory);
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='3'>No files available.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            @else
                                                No files available.
                                            @endif


                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to update the PO">Update The PO</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @php $mail = array('tolajide75@gmail.com','taiwo@enabledjobgroup.net', 'mary@enabledjobs.com', 'hq@enabledjobs.com'); @endphp
                            <div class="modal fade bd-example-modal-lg" id="customModalTwo-PO" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="customModalTwoLabel">Submit Quotation To Supplier</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('submitSupplierQuotation.submit') }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row gutters">
                                                    <div class="col-md-6 col-sm-6 col-6">
                                                        <label for="recipient-name" class="col-form-label">Supplier Email:</label>
                                                        <select class="form-control selectpicker" data-live-search="false" required name="email">
                                                            @foreach ($sup as $items)
                                                                <option data-tokens="{{ $items->vendor_name ?? 'N/A' }}"
                                                                    value="{{  $items->contact_email  }}">
                                                                    {{ $items->contact_email  ?? 'N/A' }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @if ($errors->has('email'))
                                                            <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 col-sm-6 col-6">
                                                        <label for="recipient-name" class="col-form-label">Supplier Name:</label>
                                                        <select class="form-control selectpicker" data-live-search="false" required name="name">
                                                            @foreach ($sup as $items)
                                                                <option data-tokens="{{ $items->vendor_name ?? 'N/A' }}"
                                                                    value="{{  $items->vendor_name  }}">
                                                                    {{ $items->vendor_name  ?? 'N/A' }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @if ($errors->has('name'))
                                                            <div class="" style="color:red">{{ $errors->first('name') }}</div>
                                                        @endif
                                                    </div>
                                                    

                                                    <div class="col-md-12 col-sm-12 col-12">
                                                        <label for="recipient-name" class="col-form-label">CC Email </label>

                                                        <input type="text" class="form-control" id="recipient-email" name="recipient" value="{{ old('recipient') }}" required placeholder="taiwo@enabledjobgroup.net; mary@enabledjobs.com; hq@enabledjobs.com">
                                                        @if ($errors->has('recipient'))
                                                            <div class="" style="color:red">{{ $errors->first('recipient') }}</div>
                                                        @endif


                                                    </div>
                                                    <input type="hidden" name="rfq_id" value="{{ $details->rfq_id }}">
                                                    <input type="hidden" name="po_id" value="{{ $details->po_id }}">
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

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
