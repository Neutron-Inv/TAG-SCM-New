<?php $title = 'Edit an Employee' ?>
@extends('layouts.app')
@php
if (auth()->user()->hasRole('SuperAdmin')){
$hidden = "";
}else{
$hidden = 'hidden';
}
@endphp
@section('content')
    <div class="main-container">
        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('employer.edit', $emp->employee_id) }}">Edit an Employee</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('employer.create') }}">
                    @if (Gate::allows('SuperAdmin', auth()->user()))
                        Add Employee
                    @else
                         Details
                    @endif
                    </a>
                </li>

                <li class="breadcrumb-item">Edit an Employee</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below for to edit the employee details </div>
							</div>
                            <form action="{{ route('employer.update',$emp->employee_id) }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')

                                <div class="row gutters">
                                    @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="company_name">Company Name</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-home" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="company_id">
                                                        <option data-tokens="{{ $emp->company->company_name }}" value="{{ $emp->company_id }}">
                                                            {{ $emp->company->company_name }}
                                                        </option>
                                                        <option value="">
                                                        </option>
                                                        @if (Gate::allows('SuperAdmin', auth()->user()))
                                                            @foreach ($company as $companies)
                                                                <option data-tokens="{{ $companies->company_name }}" value="{{ $companies->company_id }}">
                                                                    {{ $companies->company_name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option data-tokens="{{ $company->company_name }}" value="{{ $company->company_id }}">
                                                                {{ $company->company_name }}
                                                            </option>
                                                        @endif

                                                    </select>
                                                </div>

                                                @if ($errors->has('company_name'))
                                                    <div class="" style="color:red">{{ $errors->first('company_name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputName">First Name</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="first_name" id="inputName" value="{{ $user->first_name ?? '' }}" required placeholder="Enter First Name" type="text"
                                                aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('first_name'))
                                                    <div class="" style="color:red">{{ $errors->first('first_name') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="lastName">Last Name</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="icon-user" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="last_name" value="{{ $user->last_name ?? ''  }}" id="lastName" required placeholder="Enter Last Name" type="text"
                                                    aria-describedby="basic-addon2">
                                                </div>
                                                @if ($errors->has('last_name'))
                                                    <div class="" style="color:red">{{ $errors->first('last_name') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12" {{$hidden}}>
                                            <div class="form-group">
                                                <label for="company_name">User Role</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="role">
                                                        @if($user->role == 'Employer')
                                                            @php $nam = 'Empoyee'; @endphp
                                                        @else 
                                                            @php $nam = $user->role; @endphp
                                                        @endif
                                                        <option data-tokens="{{$nam ?? ''}}" value="{{$user->role ?? ''}}">{{$nam ?? ''}}</option>
                                                        <option value=""> </option>
                                                        <option data-tokens="Employee" value="Employer"> Employee</option>
                                                        <option data-tokens="HOD" value="HOD"> Head of Department</option>
                                                    </select>
                                                </div>

                                                @if ($errors->has('company_name'))
                                                    <div class="" style="color:red">{{ $errors->first('company_name') }}</div>
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
                                                    maxlength="11" value="{{$user->phone_number}}" required placeholder="Enter Phone number" type="number"
                                                    aria-describedby="basic-addon3">
                                                </div>

                                                @if ($errors->has('phone_number'))
                                                    <div class="" style="color:red">{{ $errors->first('phone_number') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="email">Employee Email</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon4"><i class="icon-mail" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="email" id="email" value="{{$user->email ?? ''}}" readonly placeholder="Enter E-Mail" type="email"
                                                    aria-describedby="basic-addon4">
                                                </div>

                                                @if ($errors->has('email'))
                                                    <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="password">Password (Optional)</label><div class="input-group">
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
                                    @else
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">First Name</label><div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                            </div>
                                            <input class="form-control" name="first_name" id="inputName" value="{{ $user->first_name ?? '' }}" required placeholder="Enter First Name" type="text"
                                            aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('first_name'))
                                                <div class="" style="color:red">{{ $errors->first('first_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="last_name" value="{{ $user->last_name ?? ''  }}" id="lastName" required placeholder="Enter Last Name" type="text"
                                                aria-describedby="basic-addon2">
                                            </div>
                                            @if ($errors->has('last_name'))
                                                <div class="" style="color:red">{{ $errors->first('last_name') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="phone_number" id="phone_number" minlength="9"
                                                maxlength="11" value="{{$user->phone_number}}" required placeholder="Enter Phone number" type="number"
                                                aria-describedby="basic-addon3">
                                            </div>

                                            @if ($errors->has('phone_number'))
                                                <div class="" style="color:red">{{ $errors->first('phone_number') }}</div>
                                            @endif

                                        </div>

                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Employer Email</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon4"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="email" id="email" value="{{$user->email ?? ''}}" readonly placeholder="Enter E-Mail" type="email"
                                                aria-describedby="basic-addon4">
                                            </div>

                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Password (Optional)</label><div class="input-group">
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
                                    <input type="hidden" name="role" value="{{$user->role}}">
                                    <input type="hidden" name="company_id" value="{{ $emp->company_id }}">

                                    @endif
                                    <input type="hidden" name="employee_id" value="{{$user->employee_id}}">
                                    <input type="hidden" name="user_id" value="{{$user->user_id}}">

                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to update the staff details">Update Employee Details</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">-->

                <!--    @if(count($employer) == 0)-->
                <!--        <div class="card">-->
                <!--            <div class="card-body">-->
                <!--                <h4><p style="color:red" align="center"> The List is Empty </p></h4>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    @else-->
                <!--        <div class="table-container">-->
                <!--            <h5 class="table-title">List of all Company Staffs </h5>-->

                <!--            <div class="table-responsive">-->
                <!--                <table id="basicExample" class="table">-->
                <!--                    <thead class="bg-warning text-white">-->
                <!--                        <tr>-->
                <!--                            <th>S/N</th>-->
                <!--                            <th>Full Name</th>-->
                <!--                            <th>Email</th>-->
                <!--                            <th>Phone Number</th>-->
                <!--                            <th>Role</th>-->
                <!--                            <th>Status</th>-->
                <!--                            @if (Gate::allows('SuperAdmin', auth()->user()))-->
                <!--                                <th>Company</th>-->
                <!--                            @endif-->
                <!--                            <th>Action</th>-->

                <!--                        </tr>-->
                <!--                    </thead>-->

                <!--                    <tbody>-->
                <!--                        <?php $num =1; ?>-->
                <!--                        @foreach ($employer as $employers)-->
                <!--                            <tr>-->
                <!--                                @foreach (users($employers->email) as $item)-->
                <!--                                <td>{{ $num }}-->

                <!--                                </td>-->
                <!--                                <td>{{ $employers->full_name ?? '' }}</td>-->
                <!--                                <td>{{ $employers->email ?? '' }}</td>-->
                <!--                                <td>{{ $item->phone_number ?? '' }}</td>-->
                <!--                                <td>-->
                <!--                                    @if($item->role == 'Employer')-->
                <!--                                        Empoyee-->
                <!--                                    @else -->
                <!--                                        {{ $item->role }}-->
                <!--                                    @endif-->
                <!--                                </td>-->
                <!--                                <td>-->
                <!--                                    @if($item->user_activation_code == 1)-->
                <!--                                        <p style="color:green"> Active </p>-->
                <!--                                    @else-->
                <!--                                    <p style="color:red"> Suspended </p>-->
                <!--                                    @endif-->
                <!--                                </td>-->


                <!--                                @if (Gate::allows('SuperAdmin', auth()->user()))-->
                <!--                                    <td>{{ $employers->company->company_name ?? '' }}</td>-->
                <!--                                @endif-->
                <!--                                <td>-->
                <!--                                    @if (Gate::allows('SuperAdmin', auth()->user()) OR (auth()->user()->hasRole('Admin')))-->
                <!--                                    @if($item->user_activation_code == 1)-->
                <!--                                        <a href="{{ route('employer.suspend',$employers->email) }}" class=""-->
                <!--                                        onclick="return(confirmToSuspend());" title="Suspend Emplyer Account">-->
                <!--                                            <i class="icon-check" style="color:blueviolet"></i>-->
                <!--                                        </a>-->
                <!--                                    @else-->
                <!--                                        <a href="{{ route('employer.unsuspend',$employers->email) }}" class=""-->
                <!--                                        onclick="return(confirmToUnSuspend());" title="UnSuspend Emplyer Account">-->
                <!--                                            <i class="icon-circle-with-cross" style="color:green"></i>-->
                <!--                                        </a>-->
                <!--                                    @endif-->


                <!--                                @endif-->
                <!--                                @if (Gate::allows('SuperAdmin', auth()->user()))-->
                <!--                                    {{-- <a href="{{ route('employer.delete',$employers->employee_id) }}" title="Delete Emplyer Account" class="" onclick="return(confirmToDelete());">-->
                <!--                                        <i class="icon-delete" style="color:red"></i>-->
                <!--                                    </a> --}}-->
                <!--                                @endif-->
                <!--                                <a href="{{ route('employer.edit',$employers->employee_id) }}" title="Edit Emplyer Account" class="" onclick="return(confirmToEdit());">-->
                <!--                                    <i class="icon-edit" style="color:blue"></i>-->
                <!--                                </a>-->

                <!--                            </td>-->

                <!--                            </tr><?php $num++; ?> @endforeach-->
                <!--                        @endforeach-->

                <!--                    </tbody>-->
                <!--                </table>-->
                <!--            </div>-->

                <!--        </div>-->
                <!--    @endif-->
                <!--</div>-->

            </div>
        </div>
    </div>

@endsection
