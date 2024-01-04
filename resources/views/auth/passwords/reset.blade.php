<?php $title = 'Reset Password' ?>
@extends('layouts.login')
@section('content')
<div class="container">

    <form action="{{ route('password.update') }}" method="POST">
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
                        @include('layouts.alert')
                        <h5 align="center">{{ __('Reset Password Your Password') }}.</h5>
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group"><label for="cardNum">Username</label><div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon6"><i class="icon-mail" style="color:#074b9c"></i></span>
                            </div>
                            <input type="email" name="email" readonly class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter E-Mail" value="{{ $email ?? old('email') }}" >
                            </div>

                            @if ($errors->has('email'))
                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group"><label for="cardNum">Password</label><div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon6"><i class="icon-lock" style="color:#074b9c"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" />
                            </div>

                            @if ($errors->has('password'))
                                <div class="" style="color:red">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-group"><label for="cardNum">Repeat Password</label><div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon6"><i class="icon-lock" style="color:#074b9c"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Repeat Password" />
                            </div>

                            @if ($errors->has('password_confirmation'))
                                <div class="" style="color:red">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>

                        <div class="actions">
                            @if (Route::has('password.request'))

                                <a href="/">Already have account ?</a>
                            @endif

                            <button type="submit" class="btn btn-info">Update The Password</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection
