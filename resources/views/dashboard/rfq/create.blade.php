<?php $title = 'Client RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                {{--  @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')))  --}}
                    <li class="breadcrumb-item active"><a href="{{ route('rfq.create',$clienting->client_id) }}">Create RFQ</a></li>
                {{--  @endif  --}}
                <li class="breadcrumb-item "><a href="{{ route('client.rfq',$clienting->client_id) }}">Client RFQ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>
                <li class="breadcrumb-item "><a href="{{ route('client.index') }}"> Clients List</a></li>

                <li class="breadcrumb-item">Create New RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header" align="center">
                                <div class="card-title">Please fill the below form to add new rfq for {{ ucwords($clienting->client_name)  }} </div>
                            </div>
                            <form action="{{ route('rfq.save') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row gutters">
                                    <input type="hidden" name="company_id" value="{{ $clienting->company_id}}" >
                                    <input type="hidden" name="client_id" value="{{ $clienting->client_id}}" >

                                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="row gutters">

                                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">

                                                        <div class="form-group">
                                                            <label for="password">Company Name</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-user" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="company_name" readonly type="text"
                                                                aria-describedby="basic-addon6" value="{{ $clienting->company->company_name ??  ' '}}">
                                                            </div>
                                                            @if ($errors->has('company_name'))
                                                                <div class="" style="color:red">{{ $errors->first('company_name') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">

                                                        <div class="form-group">
                                                            <label for="password">Refrence Number</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-layers" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="refrence_number" readonly placeholder="Enter Refrence Number" type="text"
                                                                aria-describedby="basic-addon6" value="{{$refrence_number}}">
                                                            </div>
                                                            @if ($errors->has('refrence_number'))
                                                                <div class="" style="color:red">{{ $errors->first('refrence_number') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">

                                                        <div class="form-group">
                                                            <label for="inputName">Status</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                                </div>

                                                                <select class="form-control selectpicker" data-live-search="true" required name="status">

                                                                    <option value="RFQ Received"> RFQ Received </option>

                                                                </select>

                                                            </div>

                                                            @if ($errors->has('status'))
                                                                <div class="" style="color:red">{{ $errors->first('status') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

                                                        <div class="form-group">
                                                            <label for="lastName">Product</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-documents" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input class="form-control" name="product" value="{{old('product')}}" id="lastName" required placeholder="Enter Product Name" type="text"
                                                                aria-describedby="basic-addon2">
                                                            </div>
                                                            @if ($errors->has('product'))
                                                                <div class="" style="color:red">{{ $errors->first('product') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="description">Description</label><div class="input-group">

                                                                <input type="text" class="form-control" name="description" id="description"  required placeholder="Enter Product Description" type="text"
                                                                aria-describedby="basic-addon3" value="{{old('description')}}">
                                                            </div>

                                                            @if ($errors->has('description'))
                                                                <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">

                                                        <div class="form-group">
                                                            <label for="lastName">RFQ Date</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                                </div>

                                                                <input type="datetime-local" class="form-control datepicker-dater-format2" required name="rfq_date" value="{{old('rfq_date')}}" placeholder="RFQ Date">
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
                                                                <input type="datetime-local" class="form-control datepicker-dater-format2" name="delivery_due_date"
                                                                value="{{old('delivery_due_date')}}" required
                                                                placeholder="Sub Due Date">
                                                            </div>

                                                            @if ($errors->has('delivery_due_date'))
                                                                <div class="" style="color:red">{{ $errors->first('delivery_due_date') }}</div>
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

                                                                    <option value="">-- Select Supplier --</option>
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
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">

                                                        <div class="form-group">
                                                            <label for="inputName">Client RFQ No</label><div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><i class="icon-book" style="color:#28a745"></i></span>
                                                            </div>
                                                            <input class="form-control" name="rfq_number" id="inputName" value="{{ 'N/A' ?? old('rfq_number')}}" required placeholder="Enter RFQ Nos" type="text"
                                                            aria-describedby="basic-addon1">
                                                            </div>

                                                            @if ($errors->has('rfq_number'))
                                                                <div class="" style="color:red">{{ $errors->first('rfq_number') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>


                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">

                                                        <div class="form-group">
                                                            <label for="phone_number">Assigned To</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-user" style="color:#28a745"></i></span>
                                                                </div>
                                                                @if(count($employer) == 0)
                                                                    <input class="form-control" name="" readonly placeholder="Enter Refrence Number" type="text"
                                                                    aria-describedby="basic-addon6" value=" Employee is Empty" >
                                                                @else
                                                                    <select class="form-control selectpicker" data-live-search="true" required name="employee_id">
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
                                                            <label for="email">Buyer</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon4"><i class="icon-user" style="color:#28a745"></i></span>
                                                                </div>
                                                                @if(count($contact) < 1)
                                                                    <input class="form-control" name="" readonly type="text"
                                                                    aria-describedby="basic-addon6" value="Client Contact is Empty">
                                                                @else
                                                                    <select class="form-control selectpicker" data-live-search="true" required name="contact_id">
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
                                                            <label for="net_percentage">Shipping Company</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-database" style="color:#28a745"></i></span>
                                                                </div>
                                                                <select class="form-control selectpicker" data-live-search="true" required name="shipper_id">
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
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">

                                                        <div class="form-group">
                                                            <label for="net_percentage">Shipper Submission Date</label><div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon5"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control datepicker-date-format2" name="shipper_submission_date"
                                                                value="{{old('shipper_submission_date')}}"
                                                                placeholder="Shipper Sub Date">

                                                            </div>

                                                            @if ($errors->has('shipper_submission_date'))
                                                                <div class="" style="color:red">{{ $errors->first('shipper_submission_date') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="inputName">Online Submission</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <i class="icon-cloud" style="color:#28a745"></i>
                                                                    </span>
                                                                </div>

                                                                <select class="form-control selectpicker" data-live-search="true" required name="online_submission">

                                                                    <option value="NO"> NO </option>
                                                                    <option value="YES"> YES </option>

                                                                </select>

                                                            </div>

                                                            @if ($errors->has('online_submission'))
                                                                <div class="" style="color:red">{{ $errors->first('online_submission') }}</div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                        <div class="row gutters">

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">

                                                    <label for="description">RFQ Note</label><div class="input-group">
                                                    <textarea class="summernote3" name="note" required placeholder="Please enter RFQ Note">
                                                        {{old('note')}}
                                                    </textarea>
                                                    @if ($errors->has('note'))
                                                        <div class="" style="color:red">{{ $errors->first('note') }}</div>
                                                    @endif
                                                </div>

                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">

                                                    <div class="doctor-profile">
                                                        <div class="doctor-thumb">
                                                            <img src="{{asset('admin/img/icons/contract.png')}}" alt="File" style="width:50px; height:50px">
                                                        </div>
                                                        <p align="center"><b>
                                                            Select Document
                                                        </b></p>
                                                        <div class="input-group mb-3">
                                                            <div class="custom-file">

                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3"><i class="icon-folder" style="color:#28a745"></i></span>
                                                                    </div>
                                                                    <input type="file" class="form-control" name="document[]" id="document" value="{{old('document[]')}}" aria-describedby="basic-addon3">
                                                                </div>

                                                                @if ($errors->has('document'))
                                                                    <div class="" style="color:red">{{ $errors->first('document') }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="text-right">
                                            <button class="btn btn-primary">Create New RFQ</button>
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
