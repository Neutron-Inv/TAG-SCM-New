<?php $title = 'Shippers'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('shipper.index') }}">Add Shipper</a></li>

                <li class="breadcrumb-item">Add New Shipper</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Employer')))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="card-title">Please fill the below form to add shipper details </div>
                                </div>
                                <form action="{{ route('shipper.save') }}" class="" method="POST">
                                    {{ csrf_field() }}
                                    @include('layouts.alert')
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
                                                <label for="nameOnCard">Shipper Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="shipper_name" required placeholder="Enter Shipper Name" type="text"
                                                    value="{{old('shipper_name')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('shipper_name'))
                                                    <div class="" style="color:red">{{ $errors->first('shipper_name') }}</div>
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
                                                    <input class="form-control" name="contact_phone" required placeholder="Enter Phone" type="number" value="{{old('contact_phone')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('contact_phone'))
                                                    <div class="" style="color:red">{{ $errors->first('contact_phone') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <label for="nameOnCard">Email</label>
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
                                                <label for="nameOnCard">Country</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-document-landscape" style="color:#28a745"></i></span>
                                                    </div>
                                                    
                                                    @php
                                                    $countries = getCountries();
                                                    @endphp
                                                    <select id="country" class="form-control selectpicker" data-live-search="true" name="country_code">
                                                        <option value="">Select a country</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{$country->name}}" data-name="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                @if ($errors->has('country_code'))
                                                    <div class="" style="color:red">{{ $errors->first('country_code') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Shipper Address</label>
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
                                                <button class="btn btn-primary" type="submit" title="Click the button to add Shipper details">Add Shipper Details</button>
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
                            @if(count($shipper) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Shippers
                                    {{-- <a href="{{ route('shipper.load') }}" class="btn btn-primary">Upload Shipper Details to user table</a></h5> --}}

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-danger text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                     @if (Gate::allows('SuperAdmin', auth()->user()))<th>Company Name</th>@endif
                                                    <th>Shipper Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Contact Email</th>
                                                    <th>Country Code</th>
                                                    <th>Address</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($shipper as $shippers)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                                                <a href="{{ route('shipper.edit',$shippers->shipper_id) }}" title="Edit Shipper Details" class="" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                            @endif
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                {{-- <a href="{{ route('shipper.delete',$shippers->shipper_id) }}" title="Delete The Shipper Details" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a> --}}
                                                            @endif
                                                        </td>
                                                         @if (Gate::allows('SuperAdmin', auth()->user()))<td>{{ $shippers->company->company_name ?? '' }}</td>@endif
                                                        <td>{{ $shippers->shipper_name ?? '' }} </td>
                                                        <td>{{ $shippers->contact_name ?? '' }} </td>
                                                        <td>{{ $shippers->contact_phone ?? '' }} </td>
                                                        <td>{{ $shippers->contact_email ?? '' }} </td>

                                                        <td>{{ $shippers->country_code ?? '' }} </td>
                                                        <td>{{ $shippers->address ?? '' }} </td>
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
