<?php $title = 'Forgot Password'  ?>
@extends('layouts.login')

@section('content')
<div class="container">

    <form action="{{ route('password.email') }}" method="POST">
        {{ csrf_field() }}
        <div class="row justify-content-md-center">
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                <div class="login-screen">
                    <div class="login-box">
                        {{-- <div  align="center">
                            <img src="{{asset('admin/img/img2.jpeg')}}" alt="logo" style="width:100px; height:100px" align="center" />
                        </div> --}}
                        <a href="/" class="login-logo">
                            Tag SCM Portal
                        </a>
                        @if(session('status'))
                            <p style="color:green"> {{session('status')}} </p>
                        @endif
                        <h5 align="center">{{ __('Forgot Your Password') }}.</h5>
                        <div class="form-group"><label for="cardNum">Username</label><div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon6"><i class="icon-mail" style="color:#074b9c"></i></span>
                            </div>
                            <input type="email" required name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter E-Mail" value="{{ old('email') }}" >
                            </div>

                            @if ($errors->has('email'))
                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <hr>
                        <div class="actions">
                            <a href="/">Already have account ?</a>
                            <button type="submit" class="btn btn-info">Reset Password</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </form>

</div>


@endsection
