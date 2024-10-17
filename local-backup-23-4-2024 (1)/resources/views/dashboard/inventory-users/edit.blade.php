<?php $title = 'Edit Inventory User'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('inventory.user.index') }}">Inventory Users</a></li>
                <li class="breadcrumb-item">List of Inventory Users</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header" align="center" >
								<div class="card-title"><b>Please fill the below form to add a new Warehouse User </b></div>
							</div>
                            <form action="{{ route('inventory.user.update',$details->user_id) }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">First Name</label><div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                            </div>
                                            <input class="form-control" name="first_name" id="inputName" value="{{ $details->first_name ?? old('first_name')}}" required placeholder="Enter First Name" type="text"
                                            aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('first_name'))
                                                <div class="" style="color:red">{{ $errors->first('first_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="last_name" value="{{$details->last_name ?? old('last_name')}}" id="lastName" required placeholder="Enter Last Name" type="text"
                                                aria-describedby="basic-addon2">
                                            </div>
                                            @if ($errors->has('last_name'))
                                                <div class="" style="color:red">{{ $errors->first('last_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="phone_number" id="phone_number" minlength="9"
                                                maxlength="11" value="{{$details->phone_number ?? old('phone_number')}}" required placeholder="Enter Phone number" type="number"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('phone_number'))
                                                <div class="" style="color:red">{{ $errors->first('phone_number') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Ware House</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon4"><i class="far fa-building" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="warehouse">
                                                    @php
                                                    $deeds = getUserWareHouse($details->user_id);
                                                    $warehouse_id = $deeds->warehouse_id;
                                                    $rests = getWareHouse($warehouse_id); @endphp
                                                    <option value="{{ $warehouse_id }}">{{ $rests->name ?? 'Select Ware House'}}</option>
                                                    <option value=""></option>
                                                    @foreach ($warehouse as $warehouses)
                                                        <option value="{{$warehouses->warehouse_id}}">{{$warehouses->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has('warehouse'))
                                                <div class="" style="color:red">{{ $errors->first('warehouse') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Login Email</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon4"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="email" id="email" value="{{$details->email ?? old('email')}}" readonly placeholder="Enter E-Mail" type="email"
                                                aria-describedby="basic-addon4">
                                            </div>

                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Change Password</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5"><i class="icon-lock" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="password" id="password" placeholder="Enter Password" type="password"
                                                aria-describedby="basic-addon5">
                                            </div>

                                            @if ($errors->has('password'))
                                                <div class="" style="color:red">{{ $errors->first('password') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary " type="submit" title="Click the button to update the user details"
                                             style="margin-top: ">Update the user</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($user) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of All Super Admin </h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Warehouse Name</th>
                                                    <th>Status</th>
                                                    <th> Action </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($user as $users)@php
                                                    $deed = getUserWareHouse($users->user_id);
                                                    $warehouse_id = $deed->warehouse_id;
                                                    $rest = getWareHouse($warehouse_id); @endphp
                                                    <tr>

                                                        <td>{{ $num }}</td>
                                                        <td>{{ $users->first_name }}</td>
                                                        <td>{{ $users->last_name }}</td>
                                                        <td>{{ $users->email }}</td>
                                                        <td>{{ $users->phone_number }}</td>
                                                        <td>{{ $rest->name }}</td>
                                                        <td>

                                                            @if($users->user_activation_code == 1)
                                                                <p style="color:green"> Active </p>
                                                            @else
                                                            <p style="color:red"> Suspended </p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('inventory.user.edit',$users->email) }}" title="Edit User Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            {{-- <a href="{{ route('inventory.user.delete',$users->email) }}" title="Delete The User Details" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a> --}}
                                                            @if($users->user_activation_code == 1)
                                                                <a href="{{ route('users.suspend',$users->email) }}" class=""
                                                                onclick="return(confirmToSuspend());" title="Suspend User Account">
                                                                    <i class="icon-check" style="color:blueviolet"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('users.unsuspend',$users->email) }}" class=""
                                                                onclick="return(confirmToUnSuspend());" title="Un Suspend User Account">
                                                                    <i class="icon-circle-with-cross" style="color:green"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr><?php $num++; ?>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
