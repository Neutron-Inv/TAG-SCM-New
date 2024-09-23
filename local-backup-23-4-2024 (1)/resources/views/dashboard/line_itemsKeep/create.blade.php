<?php $title = 'Create Line Items' ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">
        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                {{--  @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')))  --}}
                    <li class="breadcrumb-item active"><a href="{{ route('line.create',$rfq->rfq_id) }}">Create Line Item</a></li>
                {{--  @endif  --}}
                <li class="breadcrumb-item"><a href="{{ route('line.preview', $rfq->rfq_id) }}">View Line Items</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.edit', $rfq->refrence_no) }}">Edit RFQ </a></li>
                <li class="breadcrumb-item">Create a new line item</li>
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

                            <form action="{{ route('line.save') }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')

                                <div class="row gutters">

                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="card-header">
                                                    <div class="card-title">Please fill the below for to add line items </div>
                                                </div>
                                                <div class="row gutters">
                                                    <input type="hidden" name="rfq_id" value="{{ $rfq->rfq_id }}">
                                                    <input type="hidden" name="client_id" value="{{ $rfq->client_id }}">
                                                    <input type="hidden" name="refrence_no" value="{{ $rfq->refrence_no }}">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Item Number</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" readonly id="item_number" name="item_number" value="{{$rfq->rfq_number }}" placeholder="Enter Item Number"
                                                                aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('item_number'))
                                                                <div class="" style="color:red">{{ $errors->first('item_number') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-8 col-lg-8 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Item Name</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" required id="item_name" name="item_name" value="{{ $line_items->item_name ?? ''}}" placeholder="Enter Item Name"
                                                                aria-describedby="basic-addon6" required>
                                                            </div>

                                                            @if ($errors->has('item_name'))
                                                                <div class="" style="color:red">{{ $errors->first('item_name') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
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

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label for="measurement">Unit of Measurement</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <select class="form-control selectpicker" data-live-search="true" required name="uom" required>

                                                                    <option value="">-- Select UOM --</option>
                                                                    @foreach ($unit as $measures)
                                                                        <option data-tokens="{{ $measures->unit_name }}" value="{{ $measures->unit_id }}">
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
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Supplier Name</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                                </div>
                                                                <select class="form-control selectpicker" data-live-search="true" required name="vendor_id" required>
                                                                    <option data-tokens="{{ $rfq->vendor->vendor_name }}" value="{{ $rfq->vendor_id }}">
                                                                            {{ $rfq->vendor->vendor_name }}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            @if ($errors->has('vendor_id'))
                                                                <div class="" style="color:red">{{ $errors->first('vendor_id') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="company_name">Mesc Code</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6">
                                                                        <i class="icon-table" style="color:#28a745"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" id="mesc_code" name="mesc_code" value="{{old('mesh_code')}}" placeholder="Enter The Mesc"
                                                                aria-describedby="basic-addon6">
                                                            </div>

                                                            @if ($errors->has('mesc_code'))
                                                                <div class="" style="color:red">{{ $errors->first('mesc_code') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <input class="form-control" name="unit_cost" id="unit_cost"
                                                        maxlength="" value="0" placeholder="Enter Unit Cost NGN" type="hidden"
                                                        aria-describedby="basic-addon3">
                                                    <input class="form-control" name="unit_margin" id="unit_margin"
                                                            maxlength="" value="0" placeholder="Enter Unit Margin" type="hidden"
                                                            aria-describedby="basic-addon3">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">

                                            <div class="input-group">
                                                <textarea class="summernote" name="item_description" id="description"  required placeholder="Enter Product Description" type="text"
                                                aria-describedby="basic-addon3" required>{{old('item_description')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to Edit the Line Item">Create The Line Item</button>
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
