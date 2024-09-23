<?php $title = 'Error 503'; ?>
@extends('layouts.app')
@section('content')
  <div class="main-container">
    <div class="page-header"></div>

    <div class="content-wrapper">
      <div class="row gutters justify-content-center">
        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
          <div class="newsletter">
            <div class="title">
              <h3>Internal Server Error</h3>
            </div>
            <h6>Server unable to handle request.</h6><br>
            <p><a href="/dashboard" class="btn btn-primary"><i class="icon-reply"></i> Return Home</a></p>
          </div>
        </div>
      </div>

    </div>

  </div>

@endsection
