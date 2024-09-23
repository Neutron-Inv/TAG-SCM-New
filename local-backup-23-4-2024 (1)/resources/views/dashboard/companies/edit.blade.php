<?php $title = 'Edit Company' ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('company.edit',$comp->email) }}">Edit Company</a></li>
                <li class="breadcrumb-item "><a href="{{ route('company.index') }}">View All Companies</a></li>
                 <li class="breadcrumb-item"><a href="{{ route('company.create') }}">Add a Company</a></li>

                <li class="breadcrumb-item">Edit The Company Details</li>
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
                                <div class="card-title">Please fill the below for to update the company details </div>
                            </div>
                            <form action="{{ route('company.update',$comp->email) }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')

                                @if(count(getLogo($comp->company_id)) > 0)
                                    @foreach (getLogo($comp->company_id) as $item)
                                        <img src="{{ asset('company-logo/'.$comp->company_id.'/'.$item->company_logo) }}" style="width: 101px; padding-right:20px; margin-bottom: 15px;" alt="">
                                        <img src="{{ asset('company-logo/'.$comp->company_id.'/'.$item->signature) }}" style="width: 101px; padding-right:20px; margin-bottom: 15px;" alt="">
                                    @endforeach
                                @endif
                                <div class="row gutters">
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="fullName">Change Company Logo ? (Optional)</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="image"><i class="icon-image" style="color:#28a745"></i></span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="image" name="company_logo" value="{{ old('company_logo') }}" aria-describedby="inputGroupFileAddon01">

                                                </div>
                                            </div>
                                            @if ($errors->has('company_logo'))
                                                <div class="" style="color:red">{{ $errors->first('company_logo') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="signature">Company Signature( Optional )</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="image"><i class="icon-image" style="color:#28a745"></i></span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="" name="signature" value="{{ old('signature') }}" aria-describedby="inputGroupFileAddon01">

                                                </div>
                                            </div>
                                            @if ($errors->has('signature'))
                                                <div class="" style="color:red">{{ $errors->first('signature') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="company_name">Company Name</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required id="company_name" name="company_name" value="{{ $comp->company_name ?? '' }}" placeholder="Enter company name"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('company_name'))
                                                <div class="" style="color:red">{{ $errors->first('company_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="company_code">Company Code</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required id="company_code" name="company_code" value="{{ $comp->company_code ?? old('company_code') }}" placeholder="Enter company code"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('company_code'))
                                                <div class="" style="color:red">{{ $errors->first('company_code') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="eMail">Industry</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-edit" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="industry_id"><option data-tokens="{{ $comp->industry_id ?? '' }}" value="{{ $comp->industry_id ?? ''}}">{{ $comp->industry->industry_name ?? '' }}</option><option value=""></option>
                                                    @foreach ($industry as $industries)
                                                        <option data-tokens="{{ $industries->industry_id }}" value="{{ $industries->industry_id }}">{{ $industries->industry_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            @if ($errors->has('industry_id'))
                                                <div class="" style="color:red">{{ $errors->first('industry_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="email">Login Email</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="email" class="form-control" id="email" name="email" readonly value="{{ $comp->email ?? ''}}" placeholder="Enter login email"
                                                aria-describedby="basic-addon5">
                                            </div>
                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="phone">Phone</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="number" class="form-control" id="phone" name="phone" value="{{ $comp->phone ?? ''}}" required placeholder="Enter phone number"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('phone'))
                                                <div class="" style="color:red">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="webadd">Website</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-globe" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required id="webadd" value="{{ $comp->webadd ?? ''}}" name="webadd" placeholder="Enter website"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('webadd'))
                                                <div class="" style="color:red">{{ $errors->first('webadd') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="contact">Contact Name</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required id="contact" value="{{ $comp->contact ?? ''}}" name="contact" placeholder="Enter Contact Name"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('contact'))
                                                <div class="" style="color:red">{{ $errors->first('contact') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="sTate">Contact Email</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required id="sTate" value="{{ $comp->contact_email ?? ''}}" name="contact_email" placeholder="Enter Contact Email"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('contact_email'))
                                                <div class="" style="color:red">{{ $errors->first('contact_email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="password">Change Password</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5"><i class="icon-lock" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="password" id="password" placeholder="Enter Password" type="password"
                                                aria-describedby="basic-addon5">
                                            </div>

                                            @if ($errors->has('password'))
                                                <div class="" style="color:red">{{ $errors->first('password') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="password">Repeat Password</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-lock" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter Password" type="password"
                                                aria-describedby="basic-addon6">
                                            </div>
                                            @if ($errors->has('password_confirmation'))
                                                <div class="" style="color:red">{{ $errors->first('password_confirmation') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="counTry">Contact Phone</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required id="counTry" value="{{ $comp->contact_phone ?? ''}}" name="contact_phone" placeholder="Enter Contact Phone"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('contact_phone'))
                                                <div class="" style="color:red">{{ $errors->first('contact_phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="expDate">LGA</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="expDate" value="{{ $comp->lgaId ?? ''}}" name="lgaId" required placeholder="Enter LGA"
                                                aria-describedby="basic-addon6">
                                            </div>

                                            @if ($errors->has('lgaId'))
                                                <div class="" style="color:red">{{ $errors->first('lgaId') }}</div>
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="cardNum">Company Description</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" id="cardNum" name="company_description" required placeholder="Enter Company Description">{{ $comp->company_description ?? ''}}</textarea>
                                            </div>

                                            @if ($errors->has('company_description'))
                                                <div class="" style="color:red">{{ $errors->first('company_description') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Address</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-my_location" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" id="nameOnCard" name="address" required placeholder="Enter address">{{ $comp->address ?? ''}}</textarea>
                                            </div>

                                            @if ($errors->has('address'))
                                                <div class="" style="color:red">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div><input type="hidden" name="company_id" value="{{ $comp->company_id}}">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Please Click the button to update the Company Details">Update The Company Details</button>
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
