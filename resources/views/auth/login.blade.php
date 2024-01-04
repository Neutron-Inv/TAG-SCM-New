<?php $title = 'User Login' ?>
@extends('layouts.login')
    @section('content')
    <div class="container">

        <form action="{{ route('user.login') }}" class="" method="POST" style="font-family: Trebuchet MS">
            {{ csrf_field() }}
            <div class="row justify-content-md-center">
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                    <div class="login-screen">
                        <div class="login-box">

                            {{-- <div  align="center">
                                <img src="{{asset('admin/img/img2.jpeg')}}" alt="logo" style="width:100px; height:100px" align="center" />
                            </div> --}}
                            <a href="/" class="login-logo">
                                TAG SCM
                             </a>
                            @include('layouts.alert')
                            <h5 align="center">Please Login to your Account.</h5>
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
                            <div class="form-group"><label for="cardNum">Password</label><div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon6"><i class="icon-lock" style="color:#074b9c"></i></span>
                                </div>
                                <input type="password" class="form-control" name="password" placeholder="Password" />
                                </div>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="actions">
                                @if (Route::has('password.request'))

                                    <a href="{{ route('password.request') }}">Forgot password ?</a>
                                @endif

                                <button type="submit" class="btn btn-info">Login</button>
                            </div>
                            <hr>
                            {{--  <div class="m-0">
                                <span class="additional-link">No account? <a href="signup.html" class="btn btn-secondary">Signup</a></span>
                            </div>  --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection
