<?php $title = 'Clients'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('client.restore') }}">Bin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Add Client</a></li>

                <li class="breadcrumb-item">List of Deleted Client</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
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
                                    <h5 class="table-title">List of Deleted Clients</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company Name</th>
                                                    <th>Client Name</th>
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

                                                            <a href="{{ route('client.undelete',$clients->client_id) }}" class=""
                                                            onclick="return(confirmToRestore());" title="Restore the deleted Client">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a>

                                                        </td>
                                                        <td>{{ $clients->company->company_name ?? '' }}</td>
                                                        <td>{{ $clients->client_name ?? '' }} </td>
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
