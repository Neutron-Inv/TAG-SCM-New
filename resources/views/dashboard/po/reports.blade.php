<?php $title = 'Create Client PO Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('po.reports') }}"> Client PO Report</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">View Client</a></li>
                <li class="breadcrumb-item"> Create PO Report</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                </div>

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
                                    <h5 class="table-title">List of all Clients

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-info text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company</th>
                                                    <th> Company Vendor Code </th>
                                                    <th>Client Name</th>
                                                    <th>Short Code</th>
                                                    <th>PO(s) </th>
                                                    <th> Contact(s) </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($client as $clients)
                                                    @php $cli = clits($clients->client_id); $cop = cops($cli->company_id); $cont = buyersContact($cli->client_id); @endphp
                                                    <tr>
                                                        <td>{{ $num }}
                                                            <a href="{{ route('po.reports.client',$clients->client_id) }}" class="">
                                                                <i class="icon-book" style="color:#6610f2"></i> Send Report
                                                            </a>
                                                        </td>
                                                        <td>{{ $cop->company_name ?? '' }}</td>
                                                        <td>{{ $cop->company_code ?? '' }} </td>
                                                        <td>{{ $cli->client_name ?? '' }} </td>
                                                        <td>{{ $cli->short_code ?? '' }} </td>

                                                        <td>  <?php echo $co = countClientPO($clients->client_id); $list = array(); ?> </td>
                                                        <td>
                                                            <?php echo $co = countContact($clients->client_id) ?>

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
