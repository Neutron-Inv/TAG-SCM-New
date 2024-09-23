<?php $title = 'PO Breakdown'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('po.new.details',$rfq->rfq_id) }}">View PO</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.create',$rfq->client->client_id) }}">Create RFQ</a></li>

                <li class="breadcrumb-item">List of Purchase Order for RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>

         <!-- Content wrapper start -->
         <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">

										<div class="invoice-header">
											<!-- Row start -->
											<div class="row gutters">
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="invoice-logo">{{ $rfq->client->client_name }} Purchase Order for RFQ {{$rfq->refrence_no }}</div>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6">
													<div class="btn-group float-right">
														<a href="#" class="btn btn-primary btn-sm">
															<i class="icon-export"></i> Export PDF
														</a>
														<a href="#" class="btn btn-secondary btn-sm ml-2">
															<i class="icon-printer"></i> Print
														</a>
													</div>
												</div>
											</div>
											<!-- Row end -->
										</div>

										<div class="invoice-address">
											<!-- Row start -->
											<div class="row gutters">
												<div class="col-lg-4 col-md-4 col-sm-4">
													<small>Company,</small><br><br>
													<h6>{{ $rfq->client->company->company_name ?? 'Company Name' }}</h6>
													<address>
														{{ $rfq->client->company->address ?? 'Address' }}<br>
														Email: {{ $rfq->client->company->contact_email ?? 'Email' }}<br>
														Phone:  {{ $rfq->client->company->contact_phone ?? 'Phone Number' }}
													</address>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4">
													<small>Client,</small><br><br>
													<h6>{{ $rfq->client->client_name }}</h6>
													<address>
														{{ $rfq->client->city . ', ' . $rfq->client->state. ', '. $rfq->client->address .'.' ?? '' }}<br>
														Email: {{ $rfq->client->email ?? '' }}<br>
														Phone: {{ $rfq->client->phone ?? '' }}
													</address>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4">
													<div class="invoice-details">
														<small>RFQ No - <span class="badge badge-info">{{$rfq->refrence_no }}</span></small><br>
														<small>RFQDate - {{$rfq->rfq_date }}</small><br>
													</div>
												</div>
											</div>
											<!-- Row end -->
										</div>

										<div class="invoice-body">


                                            @if(count($po) < 1)
                                                <div class="row gutters">

                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <h6><p style="color:red" align="center"> No PO was found for RFQ {{$rfq->refrence_no }}

                                                            <a href="{{ route('po.create',$rfq->refrence_no) }}" class="">
                                                                <i class="icon-book" style="color:green"></i>Please click here to create The PO
                                                            </a></p></h6>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Row start -->
                                                <div class="row gutters">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <h5>Hello, {{ Auth::user()->first_name . ' '.Auth::user()->last_name }}</h5>
                                                        <p>List of Purchase Order for {{ $rfq->client->client_name }}. </p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">

                                                    </div>
                                                </div>
                                                <!-- Row end -->
                                                <!-- Row start -->
                                                <div class="row gutters">

                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table id="fixedHeader" class="table">
                                                                <thead class="bg-warning text-white">
                                                                    <tr>
                                                                        <th>S/N</th>
                                                                        <th>Status</th>
                                                                        <th>Our Ref No</th>
                                                                        <th>Client</th>
                                                                        <th>PO Number</th>
                                                                        <th>Description</th>
                                                                        <th>Total PO (USD) </th>
                                                                        <th>Total PO (NGN) </th>
                                                                        <th>Buyer</th>
                                                                        <th>PO Date</th>
                                                                        <th>Delivery Date</th>
                                                                        <th>Assigned To</th>
                                                                        <th>Total</th>
                                                                        <th>Total</th>
                                                                        {{--  <th>Notes</th>  --}}
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <?php $num =1; ?>
                                                                    @foreach ($po as $rfqs)
                                                                        <tr>
                                                                            <td>{{ $num }}
                                                                                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                                                                <a href="{{ route('po.edit',$rfqs->po_id) }}" class="" onclick="return(confirmToEdit());">
                                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                                </a>
                                                                                @endif
                                                                                <a href="{{ route('po.details',$rfqs->po_id) }}" class="" onclick="return(confirmToDetails());">
                                                                                    <i class="icon-list" style="color:green"></i>
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                @if($rfqs->status == 'Quotation Submitted')
                                                                                    <span class="badge badge-pill badge-warning"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'Acknowledge')
                                                                                <span class="badge badge-pill badge-secondary"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'PO Issued')
                                                                                    <span class="badge badge-pill badge-info"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'Bid Closed')
                                                                                    <span class="badge badge-pill badge-danger"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'Awaiting Pricing')
                                                                                    <span class="badge badge-pill badge-success"> {{ $rfqs->status ?? '' }} </span>
                                                                                @else
                                                                                    <p style="color:pink">{{ $rfqs->status ?? '' }} </p>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $rfqs->rfq_number }}</td>

                                                                            <td>{{ $rfqs->client->client_name ?? 'Null' }}</td>
                                                                            <td>{{ $rfqs->po_number }}</td>

                                                                            <td>{{ $rfqs->description }}</td>
                                                                            <td><span class="icon-dollar-sign"></span> {{ $rfqs->po_value_foreign }}</td>
                                                                            <td>&#8358;{{ $rfqs->po_value_naira }}</td>


                                                                            <td>{{ $rfqs->contact->first_name . ' '.  $rfqs->contact->last_name ?? 'Null' }}</td>
                                                                            <td>{{ $rfqs->po_date }}</td>
                                                                            <td>{{ $rfqs->delivery_due_date }}</td>

                                                                            <td>
                                                                                @foreach (employ($rfqs->rfq->employee_id) as $item)
                                                                                    {{ $item->full_name ?? '' }}
                                                                                @endforeach
                                                                            </td>

                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            {{--  <td>0</td>  --}}
                                                                        </tr><?php $num++; ?>
                                                                    @endforeach


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="invoice-payment">
                                                    <div class="row gutters">
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 order-last">
                                                            <table class="table m-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <p>
                                                                                Subtotal<br>
                                                                                Shipping &amp; Handling<br>
                                                                                Tax<br>
                                                                            </p>
                                                                            <h5 class="text-danger"><strong>Grand Total</strong></h5>
                                                                        </td>
                                                                        <td>
                                                                            <p>
                                                                                $7270.00<br>
                                                                                $30.00<br>
                                                                                $50.00<br>
                                                                            </p>
                                                                            <h5 class="text-danger"><strong>$7450.00</strong></h5>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

										</div>

										<div class="invoice-footer">
											Thank you for your Business.
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
