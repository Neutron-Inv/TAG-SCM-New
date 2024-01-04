<?php $title = 'Inventory Users'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('warehouse.users',$warehouse_id) }}">{{ $rest->name ?? ' Inventory ' }} Users</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('warehouse.inventory',$warehouse_id) }}">{{ $rest->name ?? ' Inventory ' }} Inventory</a></li>
                <li class="breadcrumb-item">List of {{ $rest->name ?? ' Inventory ' }} Users</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">

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
                                    <h5 class="table-title">List of All {{ $rest->name }} Users </h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-promari text-white">
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
                                                    $details = userId($users->user_id);
                                                    $deed = getUserWareHouse($users->user_id);
                                                    $warehouse_id = $deed->warehouse_id;
                                                    $rest = getWareHouse($warehouse_id); @endphp
                                                    <tr>

                                                        <td>{{ $num }}</td>
                                                        <td>{{ $details->first_name ?? ''}}</td>
                                                        <td>{{ $details->last_name ?? '' }}</td>
                                                        <td>{{ $details->email ?? '' }}</td>
                                                        <td>{{ $details->phone_number ?? '' }}</td>
                                                        <td>{{ $rest->name ?? '' }}</td>
                                                        <td>

                                                            @if($details->user_activation_code == 1)
                                                                <p style="color:green"> Active </p>
                                                            @else
                                                            <p style="color:red"> Suspended </p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('inventory.user.edit',$details->email) }}" title="Edit User Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            {{-- <a href="{{ route('inventory.user.delete',$users->email) }}" title="Delete The User Details" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a> --}}
                                                            @if($details->user_activation_code == 1)
                                                                <a href="{{ route('users.suspend',$details->email) }}" class=""
                                                                onclick="return(confirmToSuspend());" title="Suspend User Account">
                                                                    <i class="icon-check" style="color:blueviolet"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('users.unsuspend',$details->email) }}" class=""
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
