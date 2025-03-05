<?php $title = 'Error 404'; ?>
@extends('layouts.errorhead')
@section('content')
  <div class="main-container" style="display:flex col; align-items:middle;">
    <div class="page-header"></div>
 

      <div class="row gutters justify-content-center">
        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
          <div class="newsletter">
             <img src="{{asset('admin/assets/img/tag-flow.png')}}" class="mb-2 ml-2 mt-1" width="200" style="width:100px !important;">
             <div class="title">
              <h3>Page Not Found</h3>
            </div>
            <h6>Oh Snap! The requested page doesn't exist.</h6><br>
            <p><a href="/dashboard" class="btn btn-primary"><i class="icon-reply"></i> Return Home</a></p>
          </div>
        </div>
      </div>


 
  </div>
 
@endsection
