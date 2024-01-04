<?php $title = 'Help Desk'; ?>
@extends('layouts.app')
@section('content')

  <div class="main-container">

    <div class="page-header"></div>

    <div class="content-wrapper">
      <div class="row gutters justify-content-center">
        <div id="loader"></div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Submit Complaint</div>
            </div>
            @include('layouts.alert')
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissable" style="background:red; color: #fff">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 Whoops! Issue not created
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
              </div>
            @endif
            <div class="card-body">
              <form method="POST" action="{{ route('issue.create') }}" onsubmit="$('#loader').show();">
                {!! csrf_field() !!}
                <div class="row gutters">

                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="sender_name">Sender Name: </label>
                      <input type="text" class="form-control" name="sender_name" value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}" required readonly/>
                    </div>
                    <div class="row gutters">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="issue_category">Issue Category:</label>
                          <select class="form-control selectpicker" name="category" required>
                            <option value="">Select Category</option>
                            <option value="SCM Portal 3.0">SCM Portal 3.0</option>
                            <option value="Login Issues">Login Issues</option>
                            <option value="New Feature">New Feature Request</option>
                            <option value="Company Registration">Company Registration</option>
                            <option value="User Registration">User Registration</option>
                            <option value="Tax Clearance Certificates">Tax Clearance Certificates</option>
                            <option value="License & Permit Renewals">License & Permit Renewals</option>
                            <option value="Facilities Management">Facilities Management</option>
                            <option value="RFQ">RFQ</option>
                            <option value="PO">PO</option>
                            <option value="Line Item">Line Item</option>
                            <option value="Email">Email</option>
                            <option value="Survey">Buyer Survey</option>
                            <option value="Shipper">Shipper</option>
                            <option value="Supplier">Supplier</option>
                            <option value="Invoice">Invoice</option>
                            <option value="Others">Others</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="assign_to">Completion Date:</label>
                          <input type="date" class="form-control" name="completion_time" value="{{date('d/m/Y h:i:s') ?? old('completion_time')}}" required/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="sender_email">Sender Email</label>
                      <input type="email" class="form-control" name="sender_email" value="{{Auth::user()->email}}" required readonly/>
                    </div>
                    <div class="row gutters">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="phone">Priority:</label>
                          <select class="form-control selectpicker" name="priority" required>
                            <option value="">Select Priority</option>
                            <option value="Priority 1">Priority 1</option>
                            <option value="Immediate">Immediate</option>
                            <option value="Urgent">Urgent</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="assign_to">Assign Issue to:</label>
                          <select class="form-control selectpicker" name="assigned_to" required>
                            <option value="">Select Staff to assign to:</option>
                            @foreach ($staffs as $staff)
                              <option value="{{$staff->email}}">{{$staff->full_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <label for="dob">Issue/Task:</label>
                      <textarea class="form-control" rows="4" name="message" minlength="15" maxlength="2000" required></textarea>
                    </div>
                    @if ($errors->has('message'))
                      <div class="" style="color:red">{{ $errors->first('message') }}</div>
                    @endif
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary"><i class="icon-file"></i> Submit Issue</button>
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
