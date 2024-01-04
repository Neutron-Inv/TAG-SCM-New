<?php $title = 'Edit Client RFQ'; ?>
@extends('layouts.app')

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

                                                        <input type="text" class="form-control datepicker-date-format2" name="rfq_date" value="{{ $details->rfq_date }}" placeholder="RFQ Date">
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
                                                        <input type="text" class="form-control datepicker-date-format2" name="delivery_due_date" value="{{ $details->delivery_due_date ?? old('delivery_due_date')}}"
                                                        placeholder="Sub Due Date">
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
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="for5m-group">
                                                    <label for="company_name">Supplier Name</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                        </div>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="vendor_id" required>
                                                            <option value="{{ $details->vendor_id }}">{{ $details->vendor->vendor_name }}</option>
                                                            <option value=""> </option>"
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
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="lastName">Product</label><div class="input-group">
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
                                            
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                        <div class="row gutters">

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
                                        </div>
                                    </div>
                                </div>
                                <div class="row gutters">

                                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">

                                        <div class="row gutters">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-58 col-12">

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

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

                                                <div class="form-group">
                                                    <label for="net_percentage">Shipper Submission Date</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input type="date" class="form-control" name="shipper_submission_date"
                                                        value="{{ $details->shipper_submission_date ?? old('shipper_submission_date')}}" required placeholder="Shipper Sub Date">

                                                    </div>

                                                    @if ($errors->has('shipper_submission_date'))
                                                        <div class="" style="color:red">{{ $errors->first('shipper_submission_date') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="intrest_rate">Interest Rate (Supplier)</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="intrest_rate" id="intrest_rate"
                                                        maxlength="11" value="{{ $details->intrest_rate ?? '0'}}" required placeholder="Enter Intrest Rate Supplier" type="text"
                                                        aria-describedby="basic-addon3" >
                                                    </div>
                                                    @if ($errors->has('intrest_rate'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_rate') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="freight_charges">Duration (Supplier) </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="duration" id="duration" value="{{ $details->duration ?? '0'}}" placeholder="Enter Duration Supplier"
                                                        type="number" aria-describedby="basic-addon3" required>
                                                    </div>
                                                    @if ($errors->has('duration'))
                                                        <div class="" style="color:red">{{ $errors->first('duration') }}</div>
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

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="intrest_rate">Interest Rate (Logistics)</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="intrest_logistics" id="intrest_rate"
                                                        maxlength="11" value="{{ $details->intrest_logistics ?? '0'}}" required placeholder="Enter Intrest Rate Logistics" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>
                                                    @if ($errors->has('intrest_logistics'))
                                                        <div class="" style="color:red">{{ $errors->first('intrest_logistics') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
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



                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="total_weight">Total Weight</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="total_weight" id="total_weight"
                                                        maxlength="11" value="{{ $details->total_weight ?? '0'}}" required placeholder="Enter Total Weight" type="number"
                                                        aria-describedby="basic-addon3" step="0.01">
                                                    </div>

                                                    @if ($errors->has('total_weight'))
                                                        <div class="" style="color:red">{{ $errors->first('total_weight') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="freight_charges">Freight </label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>

                                                        <input class="form-control" name="freight_charges" id="freight_charges" value="{{ $details->freight_charges ?? '0'}}" placeholder="Enter Freight Charges" type="number" aria-describedby="basic-addon3" step="0.01">
                                                    </div>

                                                    @if ($errors->has('freight_charges'))
                                                        <div class="" style="color:red">{{ $errors->first('freight_charges') }}</div>
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
                                                    <label for="local_delivery">Local Delivery</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-address" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="local_delivery" id="local_delivery" value="{{ $details->local_delivery ?? '0'}}" required placeholder="Enter Local Delivery" type="number"
                                                        aria-describedby="basic-addon3" step="0.01">
                                                    </div>

                                                    @if ($errors->has('local_delivery'))
                                                        <div class="" style="color:red">{{ $errors->first('local_delivery') }}</div>
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
                                                        <input class="form-control" name="supplier_quote" id="supplier_quote" value="{{ $tq ?? '0'}}" placeholder="Enter Quote for Naira" type="text"
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
                                                        <input class="form-control" name="cost_of_funds" id="cost_of_funds" value="{{ $details->cost_of_funds ?? 0 }}" readonly placeholder="Enter Cost of Funds" type="number"
                                                        aria-describedby="basic-addon3" step="0.01">
                                                    </div>

                                                    @if ($errors->has('cost_of_funds'))
                                                        <div class="" style="color:red">{{ $errors->first('cost_of_funds') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            @php
                                            // $subTotalCost = $details->supplier_quote_usd + $details->freight_charges + $details->other_cost + $details->local_delivery;
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
                                                        <input class="form-control" name="offshore_charges" id="offshore_charges" value="{{ $details->offshore_charges ?? '0'}}" placeholder="" type="number"
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
                                                        placeholder="" type="number"
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
                                                        <input class="form-control" name="fund_transfer" id="fund_transfer" value="{{ round($fund,2) ?? '0'}}" readonly placeholder="Enter Fund Transfer" type="number"
                                                        aria-describedby="basic-addon3" step="0.01">
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
                                                        <input class="form-control" name="other_cost" id="other_cost" maxlength="" value="{{ $details->other_cost ?? '0'}}" required placeholder="Enter Other Cost" type="number" aria-describedby="basic-addon3" step="0.01">
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
                                                        <input class="form-control" name="ncd" id="ncd" value="{{ round($details->ncd,2) ?? '0'}}" readonly placeholder="Enter NCD" type="number"
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
                                                        <input class="form-control" name="wht" id="wht" maxlength="" value="{{ round($details->wht,2) ?? '0'}}" readonly placeholder="Enter WHT" type="number"
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
                                                        maxlength="" value="{{ number_format($details->percent_margin,4,".","") ?? '0'}}" required placeholder="Enter Net %"
                                                        type="number" aria-describedby="basic-addon3" step="0.0001">
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
                                                        maxlength="" value="{{ round($details->net_value,2) ?? '0'}}" readonly placeholder="Enter Gross Margin" type="text" aria-describedby="basic-addon3" step="0.01">
                                                    </div>

                                                    @if ($errors->has('net_value'))
                                                        <div class="" style="color:red">{{ $errors->first('net_value') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            @php
                                                $sumTotalQuotes = sumTotalQuote($details->rfq_id);
                                                if($sumTotalQuotes < 1){ $sumTotalQuote = 1; }else { $sumTotalQuote = $sumTotalQuotes; }

                                            @endphp
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="total_quote">Total Quote</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="total_quote" id="total_quote"
                                                        maxlength="11" value="{{ round($sumTotalQuote,2) ?? '0'}}" readonly placeholder="Enter Total Quote" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('total_quote'))
                                                        <div class="" style="color:red">{{ $errors->first('total_quote') }}</div>
                                                    @endif

                                                </div>
                                                <input name="total_quote" id="total_quote" value="{{ $sumTotalQuote ?? '0'}}" type="hidden" aria-describedby="basic-addon3">

                                            </div>

                                             @php
                                                $tot_quo = sumTotalQuote($details->rfq_id);
                                                // $tot_ddp = $details->net_percentage;
                                                $subTotalCost =  $tq + $details->freight_charges ;
                                                $tot_ddp = $subTotalCost + $details->cost_of_funds + $details->fund_transfer;
                                                $net_margin = ($tot_quo - $tot_ddp) - ($details->wht + $details->ncd);
                                                //$net = ($tot_quo - ($tot_ddp + $details->wht + $details->ncd));
                                                $net = ($tot_quo -($tot_ddp+($details->wht + $details->ncd)));
						dd($details->cost_of_funds);
                                            @endphp                                            
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Net Margin</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-price-tag" style="color:#28a745"></i></span>
                                                        </div>

                                                        <input class="form-control" name="net_percentage" id="net_percentage"
                                                        maxlength="" value="{{ round($net,2) ?? '0'}}" required placeholder="Enter Net %"
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
                                                        maxlength="" value="{{ number_format($comp, 2) ?? 0}}" required placeholder="Percent Net Margin"
                                                            type="text" readonly
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                </div>
                                            </div>
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

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
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

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
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
                                        </div>

                                    </div>

                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">

                                        <div class="row gutters">


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

                                                    <div class="row gutters">
                                                        <?php
                                                        $dir = 'document/rfq/'.$details->rfq_id.'/';
                                                        $files = scandir($dir);
                                                        $total = count($files) - 2;
                                                        $file = 'document/rfq/'.$details->rfq_id.'/';
                                                        if (is_dir($file)){
                                                            if ($opendirectory = opendir($file)){  $num =1;
                                                                while (($file = readdir($opendirectory)) !== false){?>
                                                                    <?php $len = strlen($file); ?>
                                                                    @if($len > 2)
                                                                        <a href="{{ asset('document/rfq/'.$details->rfq_id.'/'.$file) }}" title="{{$file}}" target="_blank">
                                                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4" style="margin-bottom: 5px">

                                                                                <h6><small>{{ substr($file,0, 18) }}</small>
                                                                                <a href="{{route('remove.file',[$details->rfq_id,$file])}}" title="{{ 'Delete '.$file}}" onclick="return(confirmToDeleteFile());">
                                                                                    <span class="icon-delete" style="color:red;"></span>
                                                                                </a></h6>
                                                                            </div>
                                                                        </a>
                                                                    @endif
                                                                    <?php $num++;
                                                                }
                                                                closedir($opendirectory);
                                                            }
                                                        } ?>
                                                    </div>
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
                                                <p style="text-justify">
                                                
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
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" style="float: right" title="Click the button to update the RFQ">Update The RFQ Details</button>
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
                                                        <input type="email" class="form-control" id="recipient-email" name="rec_email"
                                                        value="bidadmin@tagenergygroup.net" readonly>
                                                        @if ($errors->has('rec_email'))
                                                            <div class="" style="color:red">{{ $errors->first('rec_email') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- <div class="col-md-6 col-sm-6 col-6">
                                                        <label for="recipient-name" class="col-form-label">File:</label>
                                                        <input type="file" class="form-control" id="file-name" name="quotation_file[]" multiple required>
                                                        @if ($errors->has('quotation_file'))
                                                            <div class="" style="color:red">{{ $errors->first('quotation_file') }}</div>
                                                        @endif
                                                    </div> --}}
                                                    <div class="col-md-8 col-sm-8 col-8">
                                                        <label for="recipient-name" class="col-form-label">CC Email:</label>
                                                        <input type="text" class="form-control" id="recipient-email" name="quotation_recipient" value="contact@tagenergygroup.net; sales@tagenergygroup.net" readonly>
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

@endsection
