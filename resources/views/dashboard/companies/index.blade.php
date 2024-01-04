<?php $title = 'Companies'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('company.index') }}">View All Companies</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.create') }}">Add a Company</a></li>

                <li class="breadcrumb-item">List of all Companies</li>
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
                            @if(count($company) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Companies
                                        {{-- <a href="{{ route('company.load') }}" class="btn btn-primary">Upload Company Details to user table</a> </h5> --}}

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company Logo</th>
                                                    <th>Company Name</th>
                                                    <th>Company Code</th>
                                                    <th>Email</th>
                                                    <th>Web Address</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>RFQ</th>
                                                    <th>PO</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($company as $companies)
                                                    <tr>
                                                        <td>{{ $num }} </td>
                                                        <td>
                                                            <div class="avatar">
                                                                @foreach (getLogo($companies->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$companies->company_id.'/'.$item->company_logo) }}" style="width: 50px; height:50px;" alt="">
                                                                @endforeach

                                                            </div>

                                                        </td>
                                                        <td>{{ $companies->company_name ?? '' }} </td>s

                                                        <td>{{ $companies->company_code ?? '' }}</td>

                                                        <td>{{ $companies->email ?? '' }}</td>
                                                        <td>{{ $companies->webadd ?? '' }}</td>
                                                        <td>{{ $companies->contact ?? '' }}</td>
                                                        <td>{{ $companies->contact_phone ?? '' }}</td>
                                                        <td>
                                                            {{ count(countinInformation('client_rfqs', 'company_id', $companies->company_id)) ?? 0 }}
                                                        </td>
                                                        <td>
                                                            {{ count(countinInformation('client_pos', 'company_id', $companies->company_id)) ?? 0 }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('company.details',$companies->email) }}" title="View Company Details" class="">
                                                                <i class="icon-list" style="color:green"></i>
                                                            </a>
                                                            <a href="{{ route('company.edit',$companies->email) }}" title="Edit Company Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            <a href="{{ route('company.delete',$companies->company_id) }}" title="Delete Company Details" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a>
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
