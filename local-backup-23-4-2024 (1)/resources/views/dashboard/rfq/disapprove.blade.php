<?php $title = 'Disapprove Breakdown'; ?>
@extends('layouts.app')
@include('layouts.fussion-chart')
@section('content')
    <div class="main-container">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.disapprove',$refrence_no) }}"> Disapprove Breakdown</a></li>
                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item "><a href="{{ route('rfq.edit', $refrence_no) }}">Edit RFQ </a></li>
                @endif
                <li class="breadcrumb-item "><a href="{{ route('rfq.price', $refrence_no) }}"> Price Quotation</a></li>
                <li class="breadcrumb-item "><a href="{{ route('rfq.details', $refrence_no) }}"> RFQ Details</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View All RFQ</a></li>
                <li class="breadcrumb-item">Disapprove Breakdown</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('rfq.disapproveQuote') }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row gutters">
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12"></div>
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                        <input type="hidden" name="refrence_no" value="{{ $refrence_no }}">
                                        <div class="form-group">
                                            <label for="net_percentage">Reason for Disapproval:</label>
                                            <textarea class="form-control" name="reason" placeholder="Please enter the reason." required >{{ old('reason') }}</textarea>
                                            @if ($errors->has('reason'))
                                                <div class="" style="color:red">{{ $errors->first('reason') }}</div>
                                            @endif
                                        </div>
                                        <button class="btn btn-primary" type="submit" style="float: right" title="Click the button to update the RFQ">Submit Details</button>

                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
