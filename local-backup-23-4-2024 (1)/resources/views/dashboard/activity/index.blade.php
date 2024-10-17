<?php $title = 'Activity Log'; ?>
@extends('layouts.app')

@section('content')

<div class="main-container">
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
            <li class="breadcrumb-item active"><a href="{{ route('log') }}">Activity Log</a></li>
            <li class="breadcrumb-item">View Activity Log</li>
        </ol>
        @include('layouts.logo')
    </div>

    <div class="content-wrapper">
        @include('layouts.alert')
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @if(count($log) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                    <h5 class="table-title">List of all Activity Log
                                @else
                                    <h5 class="table-title">My Details</h5>
                                @endif

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Email</th>
                                                <th>Activity</th>
                                                <th>Created At</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($log as $logs)
                                                @php $user = userId($logs->user_id); @endphp
                                                <tr>
                                                    <td>{{ $num }}</td>
                                                    <td>{{ $user->email ?? '' }}</td>
                                                    <td style="width: 700px;">{{ $logs->activities ?? '' }} </td>
                                                    <td>{{ $logs->created_at ?? '' }} </td>
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
