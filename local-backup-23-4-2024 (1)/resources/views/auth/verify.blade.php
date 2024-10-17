<?php $title = 'Email Verification'; ?>
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    @include('layouts.alert')
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card">
                <div class="card-header">

                    Tag SCM Portal Account Verification
                </div>

                <div class="card-body">

                    <p class="caption mb-0" style="color:red">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address, Please click on it to confirm your account.') }}
                            </div>
                            {{ __('If you did not receive the email') }},
                            <a href="{{ route('verification.resend') }}">  {{ __('click here to request another') }}</a>.
                        @else
                            Dear <?php echo Auth::user()->first_name. ", "; ?>{{  __(' Please Verify Your Email Address') }}
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <a href="{{ route('verification.resend') }}">  {{ __('click here to request another') }}</a>.
                        @endif

                    </p>

                </div>
            </div>
        </div>
    </div>

@endsection
