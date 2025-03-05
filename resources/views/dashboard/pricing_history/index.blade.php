<?php $title = 'Pricing History'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item"><a href="{{ route('line.preview', $rfq->rfq_id) }}">Line Items</a></li>
                <li class="breadcrumb-item active">Pricing History</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">@include('layouts.alert')</div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($histories) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">Pricing Request History</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Supplier Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Contact Email</th>
                                                    <th>Requested by</th>
                                                    <th>Status</th>
                                                    <th>Line Items</th>
                                                    <th>Date Requested</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($histories as $history)
                                                    <tr>
                                                        @php
                                                            $contact = getVendorContact($history->contact_id);
                                                        @endphp
                                                        <td>{{ $num }}

                                                            <a href="{{ route('pricing.edit',$history->id) }}" title="Rate Vendor Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:rgb(255, 145, 0)"></i>
                                                            </a>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                {{-- <a href="{{ route('vendor.delete',$shippers->vendor_id) }}" title="Delete Vendor Details" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a> --}}
                                                            @endif
                                                        </td>
                                                        <td>{{ $history->vendor->vendor_name ?? '' }}</td>
                                                        <td>{{ $history->vendor->contact_name ?? '' }} , <br/> {{$contact->first_name.' '.$contact->last_name ?? ''}} </td>
                                                        <td>{{ $history->vendor->contact_phone ?? '' }} , <br/> {{$contact->office_tel ?? ''}}</td>
                                                        <td>{{ $history->vendor->contact_email ?? '' }} , <br/> {{$contact->email ?? ''}}</td>
                                                        
                                                        <td>{{ $history->user->first_name.' '.$history->user->last_name ?? '' }} </td>
                                                        <td>{{ $history->status ?? '' }} </td>
                                                        <td>{{ $history->line_items ?? '' }} </td>
                                                        <td>{{ date('d-M-Y H:i:s', strtotime($history->created_at)) ?? '' }} </td>
                                                        <td><a href="{{route('pricing.correspondence', $history->id)}}"> Correspondence </a> </td>
                                                        {{-- <td>{{ $shippers->country_code ?? '' }} </td> --}}
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
