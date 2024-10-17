<?php $title = 'Line Items Details' ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">
        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('line.details',$line_items->line_id) }}"> Line Item Details</a></li>
                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item"><a href="{{ route('line.edit',$line_items->line_id) }}">Edit Line Item</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ route('line.index') }}">Line Items</a></li>
                <li class="breadcrumb-item">view line item details</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="row gutters">
						<div class="col-12">

							<!-- Card start -->
							<div class="card">
								<div class="card-header">
									<div class="card-title">Line Items Details for RFQ {{$line_items->rfq->rfq_number ?? ''}}
								</div>
								<div class="card-body">

									<!-- Row start -->
									<div class="row gutters">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">

											<!-- Card start -->
											<div class="card">
												<div class="card-body">

                                                    <div class="table-responsive">

                                                        <table class="table m-0">


                                                            <tbody>
                                                                <tr>
                                                                    <td>Client Name</td>
                                                                    <td>{{ $line_items->client->client_name ?? "" }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>RFQ Number</td>
                                                                    <td>{{ $line_items->rfq->rfq_number ?? "" }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Item Name</td>
                                                                    <td>{{ $line_items->item_name ?? 'Null' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Vendor</td>
                                                                    <td>{{ $line_items->vendor->vendor_name ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Unit of Measurement</td>
                                                                    <td>{{ $line_items->uom ?? '' }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Quantity</td>
                                                                    <td>{{ $line_items->quantity ?? '' }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Unit Price</td>
                                                                    <td>{{ $line_items->unit_price ?? '' }}</td>


                                                                </tr>
                                                                <tr>
                                                                    <td>Total Price </td>
                                                                    <td>{{ $line_items->total_price ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Unit Quote</td>
                                                                    <td>{{ $line_items->unit_quote ?? '' }}</td>


                                                                </tr>
                                                                <tr>
                                                                    <td>Total Quote</td>
                                                                    <td>{{ $line_items->total_quote ?? '' }}</td>


                                                                </tr>


                                                            </tbody>

                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

										</div>

										<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
											<!-- Card start -->
											<div class="card">
												<div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">

                                                            <tbody>

                                                                <tr>
                                                                    <td>Unit Margin</td>
                                                                    <td>{{ $line_items->unit_margin ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Total Margin</td>
                                                                    <td>{{ $line_items->total_margin ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Unit Frieght</td>
                                                                    <td>{{ $line_items->unit_frieght ?? '' }}</td>


                                                                </tr>
                                                                <tr>
                                                                    <td>Total Frieght</td>
                                                                    <td>{{ $line_items->total_frieght ?? '' }}</td>


                                                                </tr>
                                                                <tr>
                                                                    <td>Unit Cost</td>
                                                                    <td>{{ $line_items->unit_cost ?? '' }}</td>


                                                                </tr>

                                                                <tr>
                                                                    <td>Total Cost</td>
                                                                    <td>{{ $line_items->total_cost ?? '' }}</td>


                                                                </tr>

                                                                <tr>
                                                                    <td>Unit Cost Naira</td>
                                                                    <td>{{ $line_items->unit_cost_naira ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Total Cost Naira</td>
                                                                    <td>{{ $line_items->total_cost_naira ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td> Item Description</td>
                                                                    <td> <p style="text-align: justify; text-justify: inter-word;"> {{ $line_items->item_description ?? '' }} </p></td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Created At</td>
                                                                    <td>{{ $line_items->created_at }}</td>

                                                                </tr>


                                                            </tbody>


                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
