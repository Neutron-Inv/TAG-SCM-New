<?php $title = 'Change Password'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('pass.change') }}">Change Password</a></li>
                <li class="breadcrumb-item">Change Password</li>
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
                            <div class="card-header" align="center">
								<div class="card-title"><b>Please fill the below form to change your password </b></div>
							</div>
                            <form action="{{ route('pass.update',$user->user_id) }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon4"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="email" id="email" value="{{ $user->email ?? old('email')}}" readonly placeholder="Enter E-Mail" type="email"
                                                aria-describedby="basic-addon4">
                                            </div>

                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">New Password</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5"><i class="icon-lock" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="password" id="password" required placeholder="Enter Password" type="password"
                                                aria-describedby="basic-addon5">
                                            </div>

                                            @if ($errors->has('password'))
                                                <div class="" style="color:red">{{ $errors->first('password') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Repeat New Password</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-lock" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="password_confirmation" id="password_confirmation" required placeholder="Enter Password" type="password"
                                                aria-describedby="basic-addon6">
                                            </div>
                                            @if ($errors->has('password_confirmation'))
                                                <div class="" style="color:red">{{ $errors->first('password_confirmation') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary " type="submit" title="Click the button to add new super user details">Change Password</button>
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
