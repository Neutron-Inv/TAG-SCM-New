<?php $title = 'Create Purchase Order'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item active"><a href="{{ route('po.index') }}">View PO</a></li>
                <li class="breadcrumb-item">Create New PO</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to add new po details </div>
							</div>
                            <form action="{{ route('po.save') }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">

                                    <input type="hidden" name="company_id" value="{{ $rfq->company_id}}" >
                                    <input type="hidden" name="client_id" value="{{ $rfq->client_id}}" >
                                    <input type="hidden" name="rfq_id" value="{{ $rfq->rfq_id}}" >
                                    <input type="hidden" name="refrence_no" value="{{ $rfq->refrence_no }}" >
                                    <input type="hidden" name="rfq_number" value="{{$rfq->rfq_number}}">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Status</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>

                                                <select class="form-control selectpicker" data-live-search="true" required name="status">
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
                                            <label for="phone_number">Assigned To</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                {{-- @if(count($employer) < 1)
                                                    <input class="form-control" name="" readonly placeholder="Enter Refrence Number" type="text"
                                                    aria-describedby="basic-addon6" value=" Employee is Empty" >
                                                @else --}}
                                                    <select class="form-control selectpicker" data-live-search="true" required name="employee_id">
                                                        <option data-tokens="{{ $rfq->employee->full_name }}" value="{{ $rfq->employee->employee_id }}">
                                                            {{ $rfq->employee->full_name }}
                                                        </option>
                                                        <option value=""> </option>
                                                        @foreach ($employer as $employers)
                                                            {{-- <option data-tokens="{{ $employers->full_name }}" value="{{ $employers->employee_id }}">
                                                                {{ $employer->full_name }}
                                                            </option> --}}

                                                            {{-- <option data-tokens="{{ $rfq->employee->full_name }}" value="{{ $rfq->employee->employee_id }}">
                                                                {{ $rfq->employee->full_name }}
                                                            </option> --}}
                                                        @endforeach

                                                    </select>
                                                {{-- @endif --}}

                                            </div>

                                            @if ($errors->has('employer_id'))
                                                <div class="" style="color:red">{{ $errors->first('employer_id') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Product</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-documents" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="product" value="{{ $rfq->product ?? '' }}" id="lastName" readonly placeholder="Enter Product" type="text"
                                                aria-describedby="basic-addon2">
                                            </div>
                                            @if ($errors->has('product'))
                                                <div class="" style="color:red">{{ $errors->first('product') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Buyer</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon4"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                {{-- @if(count($client) < 1)
                                                    <input class="form-control" name="" readonly type="text"
                                                    aria-describedby="basic-addon6" value="Client Contact is Empty">
                                                @else --}}
                                                <select class="form-control selectpicker" data-live-search="true" required name="contact_id">
                                                    {{-- @foreach ($client as $list) --}}
                                                        {{--  @foreach (buyers($clients->client_id) as $list)  --}}
                                                        {{-- <option data-tokens="{{ $list->first_name . " ". $list->last_name }}" value="{{ $list->contact_id }}">
                                                            {{ $list->first_name . " ". $list->last_name }}
                                                        </option> --}}
                                                        {{--  @endforeach  --}}

                                                    {{-- @endforeach --}}
                                                    <option data-tokens="{{ $rfq->contact->first_name . " ". $rfq->contact->last_name }}" value="{{ $rfq->contact->contact_id }}">
                                                        {{ $rfq->contact->first_name . " ". $rfq->contact->last_name }}
                                                    </option>

                                                    <option value=""> </option>
                                                    @foreach ($client as $list)
                                                         <option data-tokens="{{ $list->first_name . " ". $list->last_name }}" value="{{ $list->contact_id }}">
                                                            {{ $list->first_name . " ". $list->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- @endif --}}
                                            </div>

                                            @if ($errors->has('contact_id'))
                                                <div class="" style="color:red">{{ $errors->first('contact_id') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Refrence Number</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-layers" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="refrence_number" readonly placeholder="Enter Refrence Number" type="text"
                                                aria-describedby="basic-addon6" value="{{ $rfq->refrence_no ?? ''}}">
                                            </div>
                                            @if ($errors->has('refrence_number'))
                                                <div class="" style="color:red">{{ $errors->first('refrence_number') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Delivery Due Date</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" readonly name="delivery_due_date"
                                                value="{{$rfq->delivery_due_date}}" placeholder="Delivery Due Date">
                                            </div>
                                            @if ($errors->has('delivery_due_date'))
                                                <div class="" style="color:red">{{ $errors->first('delivery_due_date') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Description</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" required name="description"
                                                value="{{ $rfq->description ?? '' }}" placeholder="Total PO NGN">
                                            </div>
                                            @if ($errors->has('description'))
                                                <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="document">File</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-file" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="document[]" id="document"
                                                maxlength="" value="{{old('document[]')}}" type="file"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('document'))
                                                <div class="" style="color:red">{{ $errors->first('document') }}</div>
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

                                                <input type="text" class="form-control datepicker-date-format2" required name="po_date"
                                                value="{{old('po_date')}}" placeholder="PO Date">
                                            </div>
                                            @if ($errors->has('po_date'))
                                                <div class="" style="color:red">{{ $errors->first('po_date') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">PO No</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="po_number" id="inputName" value="{{old('po_number')}}" required placeholder="Enter PO Nos" type="text"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('po_number'))
                                                <div class="" style="color:red">{{ $errors->first('po_number') }}</div>
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

                                                <input type="number" class="form-control" required name="total_po_usd"
                                                value="{{ old('total_po_usd') }}" placeholder="Total PO USD" ondrop="return false;" onpaste="return false;">
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

                                                <input type="number" class="form-control" required name="total_po_ngn"
                                                value="{{ old('total_po_usd') }}" placeholder="Total PO NGN" ondrop="return false;" onpaste="return false;">
                                            </div>
                                            @if ($errors->has('total_po_ngn'))
                                                <div class="" style="color:red">{{ $errors->first('total_po_ngn') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12">
                                        <div class="row gutters">
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="payment_terms">Payment Terms</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <?php
                                                        $status = array('Daily', 'Monthly', 'Yearly'); ?>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="payment_terms">
                                                            @foreach ($status as $item)
                                                                <option data-tokens="{{ $item }}" value="{{ $item }}"> {{ $item }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    @if ($errors->has('payment_terms'))
                                                        <div class="" style="color:red">{{ $errors->first('payment_terms') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="delivery_location">Delivery Location</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-map" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="delivery_location" id="delivery_location"
                                                        maxlength="" value="{{old('delivery_location')}}" required placeholder="Enter Delivery Location" type="text"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('delivery_location'))
                                                        <div class="" style="color:red">{{ $errors->first('delivery_location') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="frieght_charges">Delivery Terms</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-list" style="color:#28a745"></i></span>
                                                        </div>
                                                        <?php
                                                        $term = array('DDP', 'EXW', 'FCA'); ?>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="delivery_terms">
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
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="frieght_charges">Frieght Charges</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="frieght_charges" id="frieght_charges"
                                                        maxlength="" value="{{$rfq->freight_charges ?? 0}}" required placeholder="Enter Freight Charges" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('frieght_charges'))
                                                        <div class="" style="color:red">{{ $errors->first('frieght_charges') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="local_delivery">Local Delivery</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-shopping-cart" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="local_delivery" id="local_delivery"
                                                        maxlength="" value="{{$rfq->local_delivery ?? 0}}" required placeholder="Enter Local Delivery" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('local_delivery'))
                                                        <div class="" style="color:red">{{ $errors->first('local_delivery') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="frieght_charges">Fund Transfer</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="fund_transfer" id="fund_transfer"
                                                        maxlength="" value="{{$rfq->fund_transfer ?? 0}}" required placeholder="Enter Fund Transfer" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('fund_transfer'))
                                                        <div class="" style="color:red">{{ $errors->first('fund_transfer') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="cost_of_funds">Cost of Funds</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="cost_of_funds" id="cost_of_funds"
                                                        maxlength="" value="{{$rfq->cost_of_funds ?? 0}}" required placeholder="Enter Freight Charges" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('cost_of_funds'))
                                                        <div class="" style="color:red">{{ $errors->first('cost_of_funds') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="wht">WHT</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-adjust" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="wht" id="wht" maxlength="" value="{{$rfq->wht ?? 0}}" required placeholder="Enter WHT" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('wht'))
                                                        <div class="" style="color:red">{{ $errors->first('wht') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="ncd">NCD</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-line-graph" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="ncd" id="ncd" value="{{$rfq->ncd ?? 0}}" required placeholder="Enter NCD" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('ncd'))
                                                        <div class="" style="color:red">{{ $errors->first('ncd') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="other_cost">Other Cost</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-flash" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="other_cost" id="other_cost"
                                                        maxlength="" value="{{$rfq->other_cost ?? 0}}" required placeholder="Enter Other Cost" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('other_cost'))
                                                        <div class="" style="color:red">{{ $errors->first('other_cost') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="net_percentage">Shipping Company</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-database" style="color:#28a745"></i></span>
                                                        </div>
                                                        <select class="form-control selectpicker" data-live-search="true" required name="shipper_id">
                                                            {{-- @foreach ($shipper as $shippers) --}}
                                                                <option data-tokens="{{ $rfq->shipper->shipper_name }}" value="{{ $rfq->shipper->shipper_id }}">
                                                                        {{ $rfq->shipper->shipper_name }}
                                                                </option>

                                                            {{-- @endforeach --}}

                                                        </select>
                                                    </div>

                                                    @if ($errors->has('shipper_id'))
                                                        <div class="" style="color:red">{{ $errors->first('shipper_id') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="total_weight">Total Weight</label><div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="total_weight" id="total_weight"
                                                        maxlength="11" value="{{$rfq->total_weight ?? 0}}" required placeholder="Enter Total Weight" type="number"
                                                        aria-describedby="basic-addon3">
                                                    </div>

                                                    @if ($errors->has('total_weight'))
                                                        <div class="" style="color:red">{{ $errors->first('total_weight') }}</div>
                                                    @endif

                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-3 col-sm-12 col-12">
                                        <div class="card m-0">
                                            <div class="card-header">
                                                <div class="card-title">PO Note</div>

                                            </div>

                                            <textarea class="summernote" name="note" required placeholder="Please enter RFQ Note">{{ old('note') }} </textarea>
                                            @if ($errors->has('note'))
                                                <div class="" style="color:red">{{ $errors->first('note') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="center">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create the PO">Create The PO</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
