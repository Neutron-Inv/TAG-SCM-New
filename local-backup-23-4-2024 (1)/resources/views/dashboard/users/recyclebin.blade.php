<?php $title = 'Users Bin'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.restore') }}">Bin</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></li>

                <li class="breadcrumb-item">List of Deleted Users</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($user) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h5><p style="color:red" align="center"> The List is Empty </p></h5>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of Deleted Super Admin </h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Role</th>
                                                    <th>Status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($user as $users)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            <a href="{{ route('users.undelete',$users->user_id) }}" class="btn btn-outline-danger"
                                                            onclick="return(confirmToRestore());" title="Restore the user details">
                                                                <i class="icon-delete" style=""></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $users->first_name }}</td>
                                                        <td>{{ $users->last_name }}</td>
                                                        <td>{{ $users->email }}</td>
                                                        <td>{{ $users->phone_number }}</td>
                                                        <td>{{ $users->role }}</td>
                                                        <td>

                                                            @if($users->user_activation_code == 1)
                                                                <p style="color:green"> Active </p>
                                                            @else
                                                            <p style="color:red"> Suspended </p>
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
