<?php $title = 'Suppliers'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('vendor.index') }}">Add a Supplier</a></li>

                <li class="breadcrumb-item">Add New Supplier</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">@include('layouts.alert')</div>
                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Employer')))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="card-title">Please fill the below form to add supplier details </div>
                                </div>
                                <form action="{{ route('vendor.save') }}" class="" method="POST">
                                    {{ csrf_field() }}

                                    <div class="row gutters">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Company Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="company_id">
                                                        @if (Gate::allows('SuperAdmin', auth()->user()))
                                                            <option value="">Select Company</option>
                                                            @foreach ($company as $companies)
                                                                <option data-tokens="{{ $companies->company_id }}" value="{{ $companies->company_id }}">
                                                                    {{ $companies->company_name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option data-tokens="{{ $company->company_id }}" value="{{ $company->company_id }}">
                                                                {{ $company->company_name }}
                                                            </option>
                                                        @endif

                                                    </select>
                                                </div>

                                                @if ($errors->has('company_id'))
                                                    <div class="" style="color:red">{{ $errors->first('company_id') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Supplier Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="vendor_name" required placeholder="Enter Supplier Name" type="text"
                                                    value="{{old('vendor_name')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('supplier_name'))
                                                    <div class="" style="color:red">{{ $errors->first('vendor_name') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Supplier Code</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="vendor_code" required placeholder="Enter Supplier Code" type="text"
                                                    value="{{old('vendor_code')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('vendor_code'))
                                                    <div class="" style="color:red">{{ $errors->first('vendor_code') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="eMail">Category</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-edit" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="industry_id">
                                                        @foreach ($industry as $industries)
                                                            <option data-tokens="{{ $industries->industry_id }}" value="{{ $industries->industry_id }}">{{ $industries->industry_name ?? '' }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                @if ($errors->has('category'))
                                                    <div class="" style="color:red">{{ $errors->first('category') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Contact Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="contact_name" required placeholder="Enter Name" type="text" value="{{old('contact_name')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('contact_name'))
                                                    <div class="" style="color:red">{{ $errors->first('contact_name') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Contact Phone Number</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-phone" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="contact_phone" placeholder="Enter Phone" type="number" value="{{old('contact_phone')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('contact_phone'))
                                                    <div class="" style="color:red">{{ $errors->first('contact_phone') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <label for="nameOnCard">Login Email</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-mail" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="contact_email" required placeholder="Enter Email" type="email" value="{{old('contact_email')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('contact_email'))
                                                    <div class="" style="color:red">{{ $errors->first('contact_email') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Country </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-document-landscape" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="country_code">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $item)
                                                            <option data-tokens="{{ $item->name }}" value="{{ $item->name }}">{{ $item->nicename }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                                @if ($errors->has('country_code'))
                                                    <div class="" style="color:red">{{ $errors->first('country_code') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Tamap</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-edit" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="tamap">
                                                        <option value="No"> No </option>
                                                        <option value="Yes"> Yes </option>
                                                    </select>

                                                </div>

                                                @if ($errors->has('tamap'))
                                                    <div class="" style="color:red">{{ $errors->first('tamap') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Agency Letter</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-edit" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="agency">
                                                        <option value="No"> No </option>
                                                        <option value="Yes"> Yes </option>
                                                    </select>

                                                </div>

                                                @if ($errors->has('agency'))
                                                    <div class="" style="color:red">{{ $errors->first('agency') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Supplier Description</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea class="form-control" id="nameOnCard" name="description" required placeholder="Enter description">{{ old('description') }}</textarea>
                                                </div>

                                                @if ($errors->has('description'))
                                                    <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Supplier Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-my_location" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea class="form-control" id="nameOnCard" name="address" required placeholder="Enter address">{{ old('address') }}</textarea>
                                                </div>

                                                @if ($errors->has('address'))
                                                    <div class="" style="color:red">{{ $errors->first('address') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" title="Click the button to add Supplier details">Add Supplier Details</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($vendor) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                        <h5 class="table-title">List of all Suppliers
                                        {{-- <a href="{{ route('vendor.load') }}" class="btn btn-primary">Upload Supplier Details to user table</a></h5> --}}
                                    @else
                                        <h5 class="table-title">My Details</h5>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company Name</th>
                                                    <th>Supplier Name</th>
                                                    <th>Supplier Code</th>
                                                    <th>Industry</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Contact Email</th>
                                                    {{-- <th>Country Code</th> --}}
                                                    <th>Description</th>
                                                    <th>Tamap</th>
                                                    <th>Agency Letter</th>
                                                    <th>Address</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($vendor as $shippers)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            <a href="{{ route('vendor.edit',$shippers->vendor_id) }}" title="Edit Vendor Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                {{-- <a href="{{ route('vendor.delete',$shippers->vendor_id) }}" title="Delete Vendor Details" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a> --}}
                                                            @endif
                                                        </td>
                                                        <td>{{ $shippers->company->company_name ?? '' }}</td>
                                                        <td>{{ $shippers->vendor_name ?? '' }} </td>
                                                        <td>{{ $shippers->vendor_code ?? '' }} </td>
                                                        <td>{{ $shippers->industry->industry_name ?? '' }} </td>
                                                        <td>{{ $shippers->contact_name ?? '' }} </td>
                                                        <td>{{ $shippers->contact_phone ?? '' }} </td>
                                                        <td>{{ $shippers->contact_email ?? '' }} </td>
                                                        {{-- <td>{{ $shippers->country_code ?? '' }} </td> --}}
                                                        <td>
                                                            <a href="" data-toggle="modal" data-target=".bd-example-modal-lx-{{ $num }}">
                                                                {{ substr($shippers->description, 0, 30) ?? 'N/A' }}
                                                            </a>

                                                            <div class="modal fade bd-example-modal-lx-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lx-{{ $num }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="myLargeModalLabel-{{ $num }}">{{ $shippers->vendor_name ?? '' }} Description</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ $shippers->description ?? '' }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>{{ $shippers->tamap ?? '' }} </td>
                                                        <td>{{ $shippers->agency ?? '' }} </td>
                                                        <td>
                                                            <a href="" data-toggle="modal" data-target=".bd-example-modals-lx-{{ $num }}">
                                                                {{ substr($shippers->address, 0, 30) ?? 'N/A' }}
                                                            </a>

                                                            <div class="modal fade bd-example-modals-lx-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lx-{{ $num }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-success">
                                                                            <h5 class="modal-title" id="myLargeModalLabel-{{ $num }}">{{ $shippers->vendor_name ?? '' }} Address</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ $shippers->address ?? '' }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>

                                                    </tr><?php $num++; ?>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
