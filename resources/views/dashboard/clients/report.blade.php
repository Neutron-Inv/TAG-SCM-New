<?php $title = 'Client Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('report.index',$client->client_id) }}"> Client Report</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">View Client</a></li>
                <li class="breadcrumb-item"> Client Reports for {{ $client->client_name }}</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                </div>
                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to add client report </div>
							</div>
                            <form action="{{ route('report.save') }}" class="" method="POST">
                                {{ csrf_field() }}

                                <div class="row gutters">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card m-0">
                                            <div class="card-header">
                                                <div class="card-title">Report Note</div>

                                            </div>
                                            <textarea class="summernote" name="note" required placeholder="Please enter RFQ Note">{{ old('note') }} </textarea>
                                            @if ($errors->has('note'))
                                                <div class="" style="color:red">{{ $errors->first('note') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <input type="hidden" name="client_id" value="{{ $client->client_id }}">
                                    <input type="hidden" name="client_name" value="{{ $client->client_name }}">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Add Client Report</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                @endif
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($report) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of Client Reports for {{ $client->client_name }}</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Client Name</th>
                                                    <th>Added By</th>
                                                    <th>Note</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($report as $clients)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))


                                                                <a href="{{ route('report.edit',$clients->report_id) }}" title="Edit Client Report" class="" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>

                                                            @endif
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))

                                                                {{-- <a href="{{ route('report.delete',$clients->report_id) }}" title="Delete Client Report" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a> --}}
                                                            @endif

                                                        </td>
                                                        <td>{{ $client->client_name ?? '' }}</td>
                                                        <td>{{ $clients->user->first_name . " ". $clients->user->last_name ?? '' }} </td>
                                                        <td>{{ $clients->note ?? '' }} </td>

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
