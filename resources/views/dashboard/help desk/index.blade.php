<?php $title = 'Help Desk'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboad </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('help.index') }}">Help Desk</a></li>

                <li class="breadcrumb-item">SCM Help Desk</li>
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
								<div class="card-title">Please fill the below form to use the help desk </div>
							</div>
                            <form action="" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Name</label><div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                            </div>
                                            <input class="form-control" name="name" id="inputName" value="{{ Auth::user()->name }}" readonly placeholder="Enter RFQ Nos" type="text"
                                            aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('name'))
                                                <div class="" style="color:red">{{ $errors->first('name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Email</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="email" value="{{ Auth::user()->email }}" id="lastName" readonly placeholder="Enter The Product" type="text"
                                                aria-describedby="basic-addon2">
                                            </div>
                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="description">Priority</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <?php $prio = array("Priority 1", "Intermidiate", "Urgent", "High", "Medium", "Low"); ?>
                                                <select class="form-control selectpicker" data-live-search="true" required name="employer_id">
                                                    @foreach ($prio as $priority)
                                                        <option data-tokens="{{ $priority}}" value="{{ $priority }}">
                                                            {{ $priority }}
                                                        </option>

                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has('description'))
                                                <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="description">Assignee</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-folder" style="color:#28a745"></i></span>
                                                </div>
                                                @if(count($employer) < 1)
                                                    <input class="form-control" name="" readonly placeholder="Enter Refrence Number" type="text"
                                                    aria-describedby="basic-addon6" value=" Employee is Empty">
                                                @else
                                                    <select class="form-control selectpicker" data-live-search="true" required name="employer_id">
                                                        @foreach ($employer as $employers)
                                                            <option data-tokens="{{ $employers->full_name }}" value="{{ $employers->employee_id }}"> {{ $employers->full_name }}</option>
                                                        @endforeach

                                                    </select>
                                                @endif
                                            </div>

                                            @if ($errors->has('description'))
                                                <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                            @endif

                                        </div>
                                    </div>


                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="description">Message</label>
                                            <textarea class="summernote" name="note" required placeholder="Please enter the RFQ Note">{{ old('note') }} </textarea>
                                        </div>

                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit" title="Click the button to contact the help desk">Submit </button>
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
