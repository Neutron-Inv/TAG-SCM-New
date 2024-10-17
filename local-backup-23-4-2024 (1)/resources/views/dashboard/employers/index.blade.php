<?php $title = 'Companies'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('company.index') }}">View Companies</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.create') }}">Add Company</a></li>
                {{-- <li class="breadcrumb-item"><a href="{{ route('users.restore') }}">Bin</a></li> --}}
                <li class="breadcrumb-item">List of Companies</li>
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
                            @include('layouts.alert')
                            @if(count($employer) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Staff </h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-success text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company Name</th>
                                                    <th>Email</th>
                                                    <th>Web Address</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company Name</th>
                                                    <th>Email</th>
                                                    <th>Web Address</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($employer as $companies)
                                                    <tr>

                                                        <td>{{ $num }} </td>
                                                        <td>{{ $companies->company_name ?? '' }}</td>

                                                        <td>{{ $companies->email ?? '' }}</td>
                                                        <td>{{ $companies->webadd ?? '' }}</td>
                                                        <td>{{ $companies->contact ?? '' }}</td>
                                                        <td>{{ $companies->contact_phone ?? '' }}</td>
                                                        <td>
                                                            <a href="{{ route('company.details',$companies->company_id) }}" title="View Company Details" class="">
                                                                <i class="icon-list" style="color:green"></i>
                                                            </a>
                                                            <a href="{{ route('company.edit',$companies->company_id) }}" title="Edit Company Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            {{-- <a href="{{ route('company.delete',$companies->company_id) }}" title="Delete The Company Details" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a> --}}
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
