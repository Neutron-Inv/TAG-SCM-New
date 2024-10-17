<?php $title = 'RFQ History'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.history') }}"> RFQ History</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>

                <li class="breadcrumb-item">List of RFQ History</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            @if(count($hist) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4> <p style="color:red" align="center"> No RFQ History was found </p> </h4>
                                    </div>
                                </div>
                            @else
                                <h5 class="table-title">List of Client RFQ Histories</h5>

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product</th>
                                                <th>RFQ Nos</th>
                                                <th>Reference Nos</th>
                                                <th>User Detains</th>
                                                <th>Action</th>
                                                <th> Date </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($hist as $rfqs)
                                                <tr>

                                                    <td>{{ $num }} </td>
                                                    <td>{{ $rfqs->rfq->product ?? 'RFQ Delete'}} </td>
                                                    <td>{{ $rfqs->rfq->rfq_number ?? ''}} </td>
                                                    <td> {{ $rfqs->rfq->refrence_no ?? ''}} </td>
                                                    <td>
                                                        @foreach(usersId($rfqs->user_id) as $details)
                                                            {{ $details->first_name . ' '. $details->last_name ."(". $details->email .")" ?? 'N/A' }} 
                                                        @endforeach
                                                    </td>
                                                    
                                                    <td>{{ $rfqs->action }} </td>
                                                    <td>{{ $rfqs->created_at }} </td>
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
@endsection
