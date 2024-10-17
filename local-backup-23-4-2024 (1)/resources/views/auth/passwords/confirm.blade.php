<?php $title = 'Retrieve Account' ?>
@extends('layouts.login')

@section('content')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
     style="background:url({{asset('design/assets/images/big/auth-bg.jpg')}}) no-repeat center center;">
    <div class="auth-box" style="font-family:Times New Roman; margin-top:20px ">

        <div id="loginform text-black">

            <div class="logo">
                <span class="db"><img src="{{asset('design/assets/images/danfoPay.png')}}" alt="logo" style="diwth:80px; height:80px" /></span>
                <h5 class="font-medium m-b-20">Retrieve your account</h5>
            </div>
            <!-- Form -->
            <div class="row">
                <div class="col-12">
                    @if(session('status'))
                        <div class="card-alert card gradient-45deg-green-teal">
                            <div class="card-content white-text">
                                <p>
                                <i class="material-icons"></i> {{session('status')}}.</p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('password.confirm') }}" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon2"><i class="ti-lock"></i></span>
                            </div>
                            <input type="password" name="password" required class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password"
                                aria-label="Password" aria-describedby="basic-addon1"  value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group m-b-0 m-t-10">
                            <div class="col-sm-12 text-center">
                                Already have an account?
                                <a href="/signin" class="text-info m-l-5"><b>
                                    Login</b></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection
