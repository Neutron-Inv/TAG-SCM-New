<?php $title = 'Shipper Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item"><a href="{{ route('ship.quote.index') }}">View Quotation for RFQ</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.index') }}">View RFQ</a></li>

                <li class="breadcrumb-item">List of Shipper Quote </li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($quote) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of Shipper Quote for RFQs </h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead>
                                                <tr>
                                                    <th> S/N </th>
                                                    <th>Ref Nos</th>
                                                    <th>Rfq No</th>
                                                    <th>Rfq Date</th>
                                                    <th>Product</th>
                                                    <th>Weight</th>
                                                    <th>Soncap Charges</th>
                                                    <th>Customs Duty</th>
                                                    <th>Clearing and Doc</th>
                                                    <th>Trucking Cost</th>
                                                    <th>BMI Charges</th>
                                                    <th>Mode</th>
                                                    <th> Currency </th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($quote as $quotes)
                                                    <tr>

                                                        <td>{{ $num }}
                                                            @if (Auth::user()->hasRole('Shipper'))
                                                                <a href="{{ route('ship.quote.edit',$quotes->quote_id) }}" type="Edit Shipping Quote" class="" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                            @endif

                                                        </td>
                                                        <td>{{ $quotes->rfq->refrence_no ?? '' }}</td>
                                                        <td>{{ $quotes->rfq->rfq_number ?? '' }}</td>
                                                        <td>{{ $quotes->rfq->rfq_date ?? '' }}</td>
                                                        <td>{{ $quotes->rfq->product ?? '' }}</td>
                                                        <td>{{ $quotes->rfq->total_weight ?? ''}}</td>
                                                        <td> {{ $quotes->soncap_charges ?? '' }} </td>
                                                        <td> {{ $quotes->customs_duty ?? '' }} </td>
                                                        <td> {{ $quotes->clearing_and_documentation  ?? ''}} </td>

                                                        <td> {{ $quotes->trucking_cost ?? '' }} </td>
                                                        <td> {{ $quotes->bmi_charges ?? '' }} </td>
                                                        <td> {{ $quotes->mode ?? '' }} </td>
                                                        <td> {{ $quotes->currency ?? '' }} </td>
                                                        <td>{{ $quotes->status ?? '' }}</td>
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

