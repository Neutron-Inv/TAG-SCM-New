<?php $title = 'Error 404'; ?>
@extends('layouts.app')
@section('content')
  <div class="main-container">
    <div class="page-header"></div>

    <div class="content-wrapper">
      <div class="row gutters justify-content-center">
        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
          <div class="newsletter">
            <div class="title">
              <h3>Page Not Found</h3>
            </div>
            <h6>Oh Snap! The requested page doesn't exist.</h6><br>
            <p><a href="/dashboard" class="btn btn-primary"><i class="icon-reply"></i> Return Home</a></p>
          </div>
        </div>
      </div>

    </div>

  </div>

@endsection
