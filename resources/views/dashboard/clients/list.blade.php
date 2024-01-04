<?php $title = 'List of All Clients'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('client.list') }}">All Clients</a></li>
                <li class="breadcrumb-item "><a href="{{ route('client.index') }}">Add Client</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.restore') }}">Bin</a></li>
                <li class="breadcrumb-item">List of all Clients</li>
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
                            @if(count($client) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of All Companies Clients</h5>

                                    <div class="table-responsive">
                                        <table id="basicExample" class="table">
                                            <thead class="bg-danger text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Client Name</th>
                                                    <th>Company Name</th>

                                                    <th>Short Code</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Country Code</th>
                                                    <th>Address</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($client as $clients)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            @if (Gate::allows('SuperAdmin', auth()->user()))

                                                            <a href="{{ route('client.edit',$clients->client_id) }}" title="Edit Client"class="" title="Edit The CLient" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            <a href="{{ route('contact.index',$clients->email) }}" title="Ciew or Create Client Contact" class="" title="Client Contact" onclick="return(());">
                                                                <i class="icon-user" style="color:green"></i>
                                                            </a>

                                                            <a href="{{ route('report.index',$clients->client_id) }}" title="Client Report" class="" onclick="return(());">
                                                                <i class="icon-layers" style="color:orange"></i>
                                                            </a>
                                                            {{-- <a href="{{ route('client.delete',$clients->client_id) }}" title="Delete The Client" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a> --}}

                                                        @endif

                                                        </td>

                                                        <td>{{ $clients->client_name ?? '' }} </td>
                                                        <td>{{ $clients->company->company_name ?? '' }}</td>
                                                        <td>{{ $clients->short_code ?? '' }} </td>
                                                        <td>{{ $clients->email ?? '' }} </td>
                                                        <td>{{ $clients->phone ?? '' }} </td>
                                                        <td>{{ $clients->country_code ?? '' }} </td>
                                                        <td>{{ $clients->city . ', ' . $clients->state. ', '. $clients->address .'.' ?? '' }} </td>
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
