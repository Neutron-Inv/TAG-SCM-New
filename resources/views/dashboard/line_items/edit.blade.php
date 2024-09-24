<?php $title = 'Edit Line Item' ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">
        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item active"><a href="{{ route('line.edit',$line_items->line_id) }}">Edit Line Item</a></li>
                <li class="breadcrumb-item"><a href="{{ route('line.create',$rfq->rfq_id) }}">Create Line Item</a></li>

                <li class="breadcrumb-item"><a href="{{ route('line.preview', $rfq->rfq_id) }}">Line Items</a></li>
                <li class="breadcrumb-item">Edit a line item</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below for to update the line items </div>
							</div>
                            <form action="{{ route('line.update',$line_items->line_id) }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')


                                <div class="row gutters">

                                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="row gutters">
                                                    <input type="hidden" name="rfq_id" value="{{ $rfq->rfq_id }}">
                                                    <input type="hidden" name="client_id" value="{{ $rfq->client_id }}">
                                                    <input type="hidden" name="refrence_no" value="{{ $rfq->refrence_no }}">

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">S/N</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" id="item_serialno" name="item_serialno" value="{{$line_items->item_serialno }}" placeholder="Enter Serial Number"
                                                                    aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('item_serialno'))
                                                                <div class="" style="color:red">{{ $errors->first('item_serialno') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Item Number</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input type="number" class="form-control" id="item_number" name="item_number" value="{{$line_items->item_number }}" placeholder="Enter Item Number"
                                                                    aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('item_number'))
                                                                <div class="" style="color:red">{{ $errors->first('item_number') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Item Name</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" required id="item_name" name="item_name" value="{{ $line_items->item_name ?? ''}}" placeholder="Enter Item Name"
                                                                aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('item_name'))
                                                                <div class="" style="color:red">{{ $errors->first('item_name') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label for="quantity">Quantity</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input type="number" class="form-control" required id="quantity" name="quantity" value="{{ $line_items->quantity ?? 0 }}"
                                                                placeholder="Enter Quantity" required
                                                                aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('quantity'))
                                                                <div class="" style="color:red">{{ $errors->first('quantity') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label for="measurement">Unit of Measurement</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <select class="form-control selectpicker" data-live-search="true" required name="uom" required>
                                                                    <option value="">Select UOM</option>
                                                                    @foreach ($unit as $measures)
                                                                        <option data-tokens="{{ $measures->unit_name }}" value="{{ $measures->unit_id }}" @if($line_items->uom == $measures->unit_id)  selected="selected" @endif>
                                                                            {{ $measures->unit_name }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>

                                                            @if ($errors->has('uom'))
                                                                <div class="" style="color:red">{{ $errors->first('uom') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-12">
                                                        <div class="for5m-group">
                                                            <label for="company_name">Supplier Name</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                
                                                                <select class="form-control selectpicker" data-live-search="true" required name="vendor_id" required>
                                                                    
                                                                    @foreach($vendor as $vendors)
                                                                    <option data-tokens="{{ $vendors->vendor_name }}" value="{{ $vendors->vendor_id }}" {{ $line_items->vendor_id == $vendors->vendor_id ? 'selected' : '' }}>
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

                                                    <input class="form-control" name="unit_cost" id="unit_cost"
                                                        maxlength="" value="0" placeholder="Enter Unit Cost NGN" type="hidden"
                                                        aria-describedby="basic-addon3">
                                                    <input class="form-control" name="unit_margin" id="unit_margin"
                                                            maxlength="" value="0" placeholder="Enter Unit Margin" type="hidden"
                                                            aria-describedby="basic-addon3">

                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="unit_cost_naira">Unit Cost</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="unit_cost" id=""
                                                                maxlength="" value="{{$line_items->unit_cost ?? 0}}" placeholder="Enter Unit Cost NGN" type="text"
                                                                aria-describedby="basic-addon3" step="">
                                                            </div>

                                                            @if ($errors->has('unit_cost'))
                                                                <div class="" style="color:red">{{ $errors->first('unit_cost') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="unit_cost_naira">Unit Percent</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="unit_percent" id=""
                                                                maxlength="" value="{{$unitPercent ?? 0}}" placeholder="Enter Unit Cost NGN" type="number"
                                                                aria-describedby="basic-addon3" readonly>
                                                            </div>

                                                            @if ($errors->has('unit_cost'))
                                                                <div class="" style="color:red">{{ $errors->first('unit_cost') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <?php $unitMargin = $unitPercent * $line_items->unit_cost; ?>

                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="unit_margin">Unit Margin </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="unit_margin" id="unit_margin" value="{{ $line_items->unit_margin ?? ''}}" placeholder="Enter Unit Margin" type="text" aria-describedby="basic-addon3" >
                                                            </div>

                                                            @if ($errors->has('unit_margin'))
                                                                <div class="" style="color:red">{{ $errors->first('unit_margin') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="total_cost">Total Cost</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="total_cost" id="total_cost"
                                                                maxlength="" value="{{number_format($line_items->unit_cost * $line_items->quantity, 2) ?? ''}}" placeholder="Enter Total Cost USD" type="text" aria-describedby="basic-addon3" readonly>
                                                            </div>

                                                            @if ($errors->has('total_cost'))
                                                                <div class="" style="color:red">{{ $errors->first('total_cost') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="total_margin">Total Margin </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="total_margin" id="total_margin"
                                                                maxlength="" value="{{ number_format($unitMargin * $line_items->quantity, 2) ?? ''}}" placeholder="Enter Total Margin" type="text" aria-describedby="basic-addon3" readonly>
                                                            </div>

                                                            @if ($errors->has('total_margin'))
                                                                <div class="" style="color:red">{{ $errors->first('total_margin') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="unit_quote">Unit Quote</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="unit_quote" id="unit_quote"
                                                                maxlength="" value="{{ number_format($line_items->unit_cost + $unitMargin, 2) }}" placeholder="Enter Unit Quote" type="text"
                                                                aria-describedby="basic-addon3" readonly>
                                                            </div>

                                                            @if ($errors->has('unit_quote'))
                                                                <div class="" style="color:red">{{ $errors->first('unit_quote') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="total_quote">Total Quote</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-check" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="total_quote" id="total_quote" value="{{ number_format(($line_items->unit_cost + $unitMargin) * $line_items->quantity, 2)}}" placeholder="Enter Total Quote" type="text"
                                                                aria-describedby="basic-addon3" readonly>
                                                            </div>

                                                            @if ($errors->has('total_quote'))
                                                                <div class="" style="color:red">{{ $errors->first('total_quote') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Mesc Code</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6">
                                                                        <i class="icon-table" style="color:#28a745"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" id="mesc_code" name="mesc_code" value="{{$line_items->mesc_code ?? old('mesc_code') }}" placeholder="Enter The Mesc"
                                                                aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('mesc_code'))
                                                                <div class="" style="color:red">{{ $errors->first('mesc_code') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if($rfq->product == "BHA")
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="weight">Weight (in Kg)</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6">
                                                                        <i class="icon-package" style="color:#28a745"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="number" class="form-control" id="weight" name="weight" value="{{$line_items->weight}}" placeholder="Enter The Weight"
                                                                aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('weight'))
                                                                <div class="" style="color:red">{{ $errors->first('weight') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="location">Location</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6">
                                                                        <i class="icon-location" style="color:#28a745"></i>
                                                                    </span>
                                                                </div>
                                                                <select class="form-control" id="location" name="location" aria-describedby="basic-addon6">
                                                                    <option value="">Select a location</option>
                                                                    <option value="UK" {{ $line_items->location == 'UK' ? 'selected' : '' }}>UK</option>
                                                                    <option value="US" {{ $line_items->location == 'US' ? 'selected' : '' }}>US</option>
                                                                    <option value="China" {{ $line_items->location == 'China' ? 'selected' : '' }}>China/Asia</option>
                                                                    <option value="Africa" {{ $line_items->location == 'Africa' ? 'selected' : '' }}>Africa</option>
                                                                    <option value="Middle East" {{ $line_items->location == 'Middle East' ? 'selected' : '' }}>Middle East</option>
                                                                    <option value="Europe" {{ $line_items->location == 'Europe' ? 'selected' : '' }}>Europe</option>
                                                                </select>
                                                            </div>
                                                    
                                                            @if ($errors->has('location'))
                                                                <div style="color:red">{{ $errors->first('location') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Active?</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6">
                                                                        <i class="icon-table" style="color:#28a745"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ $line_items->active ? 'checked' : '' }} aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('active'))
                                                                <div class="" style="color:red">{{ $errors->first('active') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">


                                        <div class="card-body">
                                            <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">

                                                        <div class="input-group">

                                                            <textarea class="summernote" name="item_description" id="description"  required placeholder="Enter Product Description" type="text"
                                                            aria-describedby="basic-addon3" rows="" cols="">{!! $line_items->item_description !!}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to Edit the Line Item">Update The Line Item</button>
                                        </div>
                                    </div>

                                </div>


                                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR (Auth::user()->hasRole('HOD'))))
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                        @if(count($rfqs) == 0)
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4><p style="color:red" align="center"> No RFQ was found for

                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                All Clients
                                                            @else
                                                                {{ $company->company_name ?? ' Your' }} company
                                                            @endif
                                                        </p>
                                                    </h4>
                                                </div>
                                            </div>
                                        @else
                                            <div class="table-container">
                                                <h5 class="table-title">
                                                </h5>

                                                <div class="table-responsive">
                                                    <table class="table m-0">
                                                        <thead class="bg-warning text-white">
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Status</th>
                                                                <th>Client</th>
                                                                <th>Ref Nos</th>
                                                                <th>Rfq No</th>
                                                                <th>Assigned To</th>
                                                                <th>Buyer</th>
                                                                <th>Rfq Date</th>
                                                                <th>Product</th>

                                                                <th>Total Quote </th>
                                                                <th> Shipper Quote </th>
                                                                <th> Supplier Quote </th>
                                                                <th>Line Item</th>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php $num =1; ?>
                                                            @foreach ($rfqs as $rfqss)
                                                                <tr>

                                                                    <td>{{ $num }}

                                                                        {{-- <a href="{{ route('rfq.edit',$rfqss->refrence_no) }}" title="Edit The RFQ" class="" onclick="return(confirmToEdit());">
                                                                            <i class="icon-edit" style="color:blue"></i>
                                                                        </a> --}}


                                                                        <a href="{{ route('rfq.details',$rfqss->refrence_no) }}" title="View RFQ Details" class="" onclick="return(confirmToDetails());">
                                                                            <i class="icon-list" style="color:green"></i>
                                                                        </a>
                                                                        <a href="{{ route('rfq.price',$rfqss->refrence_no) }}" title="View RFQ Price Quotation" class="" onclick="">
                                                                            <i class="icon-book" style="color:green"></i>
                                                                        </a>

                                                                    </td>
                                                                    <td>
                                                                        @if($rfqss->status == 'Quotation Submitted')
                                                                            <span class="badge badge-pill badge-info"> {{ $rfqss->status ?? '' }} </span>
                                                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                                                                <b><a href="{{ route('rfq.send',$rfqss->refrence_no) }}" class="" onclick="return(sendEnq());">
                                                                                    Send Status Enq
                                                                                </a></b>
                                                                            @endif
                                                                        @elseif($rfqss->status == 'Received RFQ')
                                                                            <span class="badge badge-pill badge-success"> {{ $rfqss->status ?? '' }} </span>

                                                                        @elseif($rfqss->status == 'RFQ Acknowledged')
                                                                            <span class="badge badge-pill badge-secondary"> {{ $rfqss->status ?? '' }} </span>

                                                                        @elseif($rfqss->status == 'Awaiting Pricing')
                                                                            <span class="badge badge-pill badge-gray"> {{ $rfqss->status ?? '' }} </span>

                                                                        @elseif($rfqss->status == 'Awaiting Shipping')
                                                                            <span class="badge badge-pill badge-danger"> {{ $rfqss->status ?? '' }} </span>

                                                                        @elseif($rfqss->status == 'Awaiting Approval')
                                                                            <span class="badge badge-pill badge-warning"> {{ $rfqss->status ?? '' }} </span>

                                                                        @elseif($rfqss->status == 'Approved')
                                                                            <span class="badge badge-pill badge-orange"> {{ $rfqss->status ?? '' }} </span>

                                                                        @elseif($rfqss->status == 'No Bid')
                                                                            <span class="badge badge-pill badge-primary"> {{ $rfqss->status ?? '' }} </span>

                                                                        @else
                                                                            <span class="badge badge-pill badge-success">{{ $rfqss->status ?? '' }} </span>
                                                                        @endif
                                                                    </td>

                                                                    <td>{{ $rfqss->client->client_name ?? '' }}</td>
                                                                    <td><a href="{{ route('rfq.edit', $rfqss->refrence_no) }}" style="color:blue">
                                                                        {{ $rfqss->refrence_no ?? '' }} </a>
                                                                    </td>
                                                                    <td>{{ $rfqss->rfq_number ?? '' }}</td>
                                                                    @if (Gate::allows('SuperAdmin', auth()->user()))

                                                                        <td>
                                                                            @foreach (employ($rfqss->employee_id) as $item)
                                                                                <a href="mailto:{{ $item->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? ''   }}</a>
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            @foreach (buyers($rfqss->contact_id) as $items)
                                                                                <a href="mailto:{{ $items->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'Null' }}</a>
                                                                            @endforeach
                                                                        </td>
                                                                    @else

                                                                        <td>
                                                                            @foreach (employ($rfqss->employee_id) as $item)
                                                                                <a href="mailto:{{ $item->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? 'Null'   }}</a>
                                                                            @endforeach
                                                                        </td>
                                                                        <td>
                                                                            @foreach (buyers($rfqss->contact_id) as $items)
                                                                                <a href="mailto:{{ $items->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'Null' }}</a>
                                                                            @endforeach
                                                                        </td>
                                                                    @endif


                                                                    <td>{{ $rfqss->rfq_date ?? '' }}</td>
                                                                    <td>{{ $rfqss->product ?? '' }}</td>

                                                                    <td>
                                                                        @if($rfqss->value_of_quote_ngn < 2)
                                                                            &#36;{{ number_format($rfqss->supplier_quote_usd + $rfqss->freight_charges)  }}
                                                                        @else
                                                                           &#36;{{ number_format($rfqss->value_of_quote_ngn,2) ?? '' }}
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: right"> @php $sup = countShipQuote($rfqss->rfq_id); @endphp
                                                                            @if($sup < 1)
                                                                                0
                                                                            @else
                                                                                <a href="{{ route('ship.quote.show', $rfqss->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                                            @endif
                                                                    </td>
                                                                    <td style="text-align: right"> @php $sup = countSupQuote($rfqss->rfq_id); @endphp
                                                                        @if($sup < 1)
                                                                            0
                                                                        @else
                                                                            <a href="{{ route('sup.quote.show', $rfqss->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: right">
                                                                        <?php $co = countLineItems($rfqss->rfq_id) ?>
                                                                        @if($co > 0 )
                                                                            {{-- @foreach (editLineItems($rfqss->rfq_id) as $item)
                                                                                <a href="{{ route('line.details', $item->line_id) }}" style="color:blue">{{ $co }} </a>
                                                                            @endforeach --}}

                                                                            <a href="{{ route('line.preview', $rfqss->rfq_id) }}" style="color:blue">{{ $co }}</a>
                                                                        @else
                                                                        @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                                <a href="{{ route('line.create', $rfqss->rfq_id) }}" style="color:blue">{{ $co }} </a>
                                                                            @endif
                                                                        @endif
                                                                    </td>

                                                                </tr><?php $num++; ?>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        @endif
                                    </div>
                                @elseif(Auth::user()->hasRole('Shipper'))
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        @if(count($rfqs) == 0)
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4><p style="color:red" align="center"> No RFQ was found for

                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                All Clients
                                                            @else
                                                                {{ $company->company_name ?? ' Your' }} company
                                                            @endif
                                                        </p>
                                                    </h4>
                                                </div>
                                            </div>
                                        @else
                                            <div class="table-container">
                                                <h5 class="table-title">List of Client RFQs for
                                                    @if (Gate::allows('SuperAdmin', auth()->user()))
                                                        All Clients
                                                    @else
                                                        {{ $company->company_name ?? ' Your' }} company
                                                    @endif
                                                </h5>

                                                <div class="table-responsive">
                                                    <table id="fixedHeader" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Status</th>
                                                                <th>Client</th>
                                                                <th>Ref Nos</th>
                                                                {{--  <th>Rfq No</th>  --}}
                                                                <th>Rfq Date</th>
                                                                <th>Product</th>
                                                                <th>Weight</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Status</th>
                                                                <th>Client</th>
                                                                <th>Ref Nos</th>

                                                                <th>Rfq Date</th>
                                                                <th>Product</th>
                                                                <th>Weight</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php $num =1; ?>
                                                            @foreach ($rfqs as $rfqss)
                                                                <tr>

                                                                    <td>{{ $num }}</td>
                                                                    <td>
                                                                        Status

                                                                    </td>

                                                                    <td>{{ $rfqss->client->client_name ?? '' }}</td>
                                                                    <td><a href="{{ route('rfq.details', $rfqss->refrence_no) }}" style="color:blue">
                                                                        {{ $rfqss->refrence_no ?? '' }} </a>
                                                                    </td>

                                                                    <td>{{ $rfqss->rfq_date ?? '' }}</td>
                                                                    <td>{{ $rfqss->product ?? '' }}</td>
                                                                    <td>{{ $rfqss->total_weight ?? '' }}</td>
                                                                    <td>
                                                                        <a href="{{ route('rfq.shipper.quote',$rfqss->rfq_id) }}" class="" onclick="return(confirmToDetails());">
                                                                            <i class="icon-list" style="color:green"></i>Quote
                                                                        </a>
                                                                    </td>


                                                                </tr><?php $num++; ?>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        @endif

                                    </div>
                                @elseif(Auth::user()->hasRole('Supplier'))
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        @if(count($rfqs) == 0)
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4><p style="color:red" align="center"> No RFQ was found
                                                        </p>
                                                    </h4>
                                                </div>
                                            </div>
                                        @else
                                            <div class="table-container">
                                                <h5 class="table-title">List of RFQs for
                                                    {{ $vendor->vendor_name ?? ' ' }}
                                                </h5>

                                                <div class="table-responsive">
                                                    <table id="fixedHeader" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Status</th>
                                                                <th>Client</th>
                                                                <th>Ref Nos</th>

                                                                <th>Rfq Date</th>
                                                                <th>Product</th>
                                                                <th>Weight</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Status</th>
                                                                <th>Client</th>
                                                                <th>Ref Nos</th>

                                                                <th>Rfq Date</th>
                                                                <th>Product</th>
                                                                <th>Weight</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php $num =1; ?>
                                                            @foreach ($rfqs as $rfqss)
                                                                <tr>

                                                                    <td>{{ $num }}</td>
                                                                    <td>
                                                                        Status

                                                                    </td>

                                                                    <td>{{ $rfqss->client->client_name ?? '' }}</td>
                                                                    <td><a href="{{ route('rfq.details', $rfqs->refrence_no) }}" style="color:blue">
                                                                        {{ $rfqss->refrence_no ?? '' }} </a>
                                                                    </td>

                                                                    <td>{{ $rfqss->rfq_date ?? '' }}</td>
                                                                    <td>{{ $rfqss->product ?? '' }}</td>
                                                                    <td>{{ $rfqss->total_weight ?? '' }}</td>
                                                                    <td>
                                                                        <a href="{{ route('rfq.supplier.quote', $rfqs->rfq_id)}}" class="" onclick="return(confirmToDetails());">
                                                                            Submit Quote
                                                                        </a>
                                                                    </td>


                                                                </tr><?php $num++; ?>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        @endif

                                    </div>
                                @else
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                    </div>
                                @endif

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">


                                    @if(count($line_item) == 0)
                                        <div class="card">
                                            <div class="card-body">
                                                <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                            </div>
                                        </div>
                                    @else
                                        <div class="table-container">
                                            <h5 class="table-title">List of All Line Items</h5>

                                            <div class="table-responsive">
                                                <table id="basicExample" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th hidden>S/N</th>
                                                            <th>Item S/N</th>
                                                            <th>Item Description</th>
                                                            <th>Item Nos</th>
                                                            <th>Item Specification</th>
                                                            <th>Supplier</th>
                                                            <th>Qty</th>
                                                            <th>Unit Cost
                                                                @php $sumUnitCost = sumUnitCost($rfq->rfq_id); @endphp

                                                            </th>
                                                            <th>Total Cost

                                                                @php $sumTotalCost = sumTotalCost($rfq->rfq_id); @endphp
                                                                @if($sumTotalCost > 0 )
                                                                    {{ number_format($sumTotalCost, 2) ?? 0}}
                                                                @else
                                                                    0
                                                                @endif
                                                            </th>
                                                            <th>Unit Margin
                                                                @php $sumUnitMargin = sumUnitMargin($rfq->rfq_id); @endphp

                                                            </th>
                                                            <th>Total Margin
                                                                @php $sumTotalMargin = sumTotalMargin($rfq->rfq_id); @endphp

                                                            </th>
                                                            <th>Unit Quote

                                                            </th>
                                                            <th>Total Quote
                                                                @php $sumTotalQuote = sumTotalQuote($rfq->rfq_id); @endphp
                                                                @if($sumTotalQuote > 0 )
                                                                    {{ number_format($sumTotalQuote, 2) ?? 0 }}
                                                                @else
                                                                    0
                                                                @endif
                                                            </th>

                                                            <th> Action </td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $num =1; $wej = array(); ?>
                                                        @foreach ($line_item as $items)
                                                            <tr>
                                                                <td hidden> {{ $num ?? '0' }}
                                                                </td>
                                                                <td> {{ $items->item_serialno ?? '0' }}
                                                                    @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                        <a href="{{ route('line.edit',$items->line_id) }}" title="Edit Line Items" class="" onclick="return(confirmToEdit());">
                                                                            <i class="icon-edit" style="color:blue"></i>
                                                                        </a>
                                                                        <a href="{{ route('line.delete',$items->line_id) }}" title="Edit Line Items" class="" onclick="return(confirmToDelete());">
                                                                            <i class="icon-trash" style="color:red"></i>
                                                                        </a>
                                                                    @endif

                                                                </td>

                                                                <td> {{$items->item_name ?? ''}} </td>
                                                                <td> {{$items->item_number ?? ''}} </td>
                                                                <td>
                                                                    <a href="" data-toggle="modal" data-target=".bd-example-modal-lx-{{ $num }}">
                                                                    {!! substr(strip_tags($items->item_description), 0, 100) ?? 'N/A' !!}...
                                                                    </a>
                                                                    
                                                                </td>
                                                                <td>  {{$rfq->vendor->vendor_name ?? 'N/A'}} </td>
                                                                <td> {{$items->quantity ?? 0}} </td>
                                                                @php
                                                                    $unit_cost = $items->unit_cost;
                                                                    $percent = $rfq->percent_margin;
                                                                    $unitMargin = ($items->unit_unit_margin);
                                                                @endphp
                                                                <td style="text-align: right"> {{number_format($items->unit_cost,2) ?? 0}} </td>
                                                                <td style="text-align: right"> {{number_format($items->total_cost) ?? 0}} </td>

                                                                <td style="text-align: right"> {{number_format($items->unit_margin, 2) ?? 0}} </td>
                                                                <td style="text-align: right"> {{number_format($items->total_margin) ?? 0}} </td>

                                                                <td style="text-align: right"> {{number_format($items->unit_quote, 2) ?? 0}} </td>

                                                                <td style="text-align: right"> {{number_format($items->total_quote) ?? 0}} </td>
                                                                <td>
                                                                    <a href="#" title="Duplicate Line Items" class="duplicate-link" data-line-id="{{ $items->line_id }}" data-toggle="modal" data-target="#duplicateModal">
                                                                        Duplicate
                                                                    </a>
                                                                </td>
                                                                <div class="modal fade" id="duplicateModal" tabindex="-1" role="dialog" aria-labelledby="duplicateModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="duplicateModalLabel">Duplicate Line Item</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p>How many times do you want to duplicate this line item?</p>
                                                                                <input type="number" id="duplicateCount" class="form-control" value="1">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                                <button type="button" class="btn btn-primary" id="confirmDuplicate">Duplicate</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $(".duplicate-link").on("click", function () {
                                                                            // Get the line ID and set it in the modal's data attribute
                                                                            var lineId = $(this).data("line-id");
                                                                            $("#duplicateModal").data("line-id", lineId);
                                                                        });

                                                                        $("#confirmDuplicate").on("click", function () {
                                                                            // Get the line ID and duplication count from modal data
                                                                            var lineId = $("#duplicateModal").data("line-id");
                                                                            var duplicateCount = $("#duplicateCount").val();

                                                                            // Construct the URL with the line ID and duplication count
                                                                            var url = "{{ route('line.duplicate', ':lineId') }}";
                                                                            url = url.replace(':lineId', lineId) + '?count=' + duplicateCount;

                                                                            // Redirect to the duplicated URL
                                                                            window.location.href = url;

                                                                            // Close the modal
                                                                            $("#duplicateModal").modal("hide");
                                                                        });
                                                                    });
                                                                </script>
                                                                <div class="modal fade bd-example-modal-lx-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lx-{{ $num }}">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="myLargeModalLabel-{{ $num }}">Line Item Description</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                {!! $items->item_description ?? 'N/A' !!}
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>@php $tot = $items->total_quote;
                                                                array_push($wej, $tot);  @endphp

                                                            </tr><?php $num++; ?>
                                                        @endforeach

                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>
                                    @endif
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
