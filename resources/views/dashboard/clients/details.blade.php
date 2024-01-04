<?php $title = 'View Client Details'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('client.edit',$client->client_id) }}">Edit Client</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Add Client</a></li>

                <li class="breadcrumb-item">View Client Details</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ $client->client_name }} Details
                        </div>
                        <div class="card-body">

                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">

                                    <!-- Card start -->
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="table-responsive">

                                                <table class="table m-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>Client Name</td>
                                                            <td>{{ $client->client_name ?? '' }}</td>

                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>Company Name</td>
                                                            <td>{{ $client->company->company_name ?? '' }}</td>

                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>Client Address</td>
                                                            <td>{{ $client->address ?? '' }}</td>

                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>State</td>
                                                            <td>{{ $client->state ?? '' }}</td>

                                                        </tr>
                                                    </tbody>


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card end -->

                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">

                                    <!-- Card start -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table m-0">

                                                    <tbody>
                                                        <tr>
                                                            <td>City</td>
                                                            <td>{{ $client->city ?? '' }}</td>

                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Country Code</td>
                                                            <td>{{ $client->country_code ?? '' }}</td>

                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Client Phone Number</td>
                                                            <td>{{ $client->phone ?? '' }}</td>

                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Client Email</td>
                                                            <td>{{ $client->email ?? '' }}</td>

                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Short Code</td>
                                                            <td>{{ $client->short_code ?? '' }}</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card end -->

                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                    <!-- Card start -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table m-0">

                                                    <tbody>
                                                        <tr>
                                                            <td>Trasnfer Code</td>
                                                            <td>{{ $client->transfer ?? '' }}</td>

                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Comnay Vendor Code</td>
                                                            <td>{{ $client->company_vendor_code ?? '' }}</td>

                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Login URL</td>
                                                            <td>{{ $client->login_url ?? '' }}</td>

                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Vendor Username</td>
                                                            <td>{{ $client->vendor_username ?? '' }}</td>

                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>Vendor Password</td>
                                                            <td>{{ $client->vendor_password ?? '' }}</td>

                                                        </tr>
                                                    </tbody>


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card end -->

                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h4> Document Section </h4>
                                    @if(count(getClientDocument($client->client_id)) > 0)
                                        <div class="row gutters">
                                            @foreach (getClientDocument($client->client_id) as $item)
                                                <a href="{{ asset('client-files/'.$item->file) }}" target="_blank">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="icon-tiles" style="background: -webkit-linear-gradient(45deg, #3949ab, #4fc3f7); color:white; height:150px; width:250px" >
                                                            <h6>{{ $item->file?? '' }}</h6>

                                                            <img src="{{asset('admin/img/icons/contract.png')}}" style="height:150px; width:200px" alt="Files " />
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <h3><p style="text-justify; color: red"> No Document was found </p></h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
