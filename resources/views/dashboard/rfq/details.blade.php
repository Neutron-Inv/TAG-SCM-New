<?php $title = 'Client RFQ Details'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.details', $details->refrence_no) }}"> RFQ Details</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>
                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item"><a href="{{ route('rfq.edit', $details->refrence_no) }}">Edit RFQ </a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rfq.create',$details->client_id) }}">Create RFQ</a></li>

                    <li class="breadcrumb-item"><a href="{{ route('client.index') }}"> Clients List</a></li>
                @endif
                <li class="breadcrumb-item">RFQ Details</li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="row gutters">
						<div class="col-12">

							<!-- Card start -->
							<div class="card">
								<div class="card-header">
									<div class="card-title">{{ $details->client->client_name }} RFQ Details for {{ $details->refrence_no }}
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
                                                                    <td>Supplier Quote USD</td>
                                                                    <td><span class="icon-dollar-sign"></span>{{ ($details->supplier_quote_usd) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Freight Charges</td>
                                                                    <td>{{ ($details->freight_charges) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Local Delivery</td>
                                                                    <td>{{ ($details->local_delivery) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Other Cost</td>
                                                                    <td>{{ ($details->other_cost) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Fund Transfer</td>
                                                                    <td>&#8358;{{ ($details->fund_transfer) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Cost of Funds</td>
                                                                    <td>&#8358;{{ ($details->cost_of_funds) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>WHT</td>
                                                                    <td>{{ ($details->wht) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>NCD</td>
                                                                    <td>{{ ($details->ncd) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>



                                                            <tbody>
                                                                <tr>
                                                                    <td>Net Margin</td>
                                                                    <td>{{ round($details->net_value,2) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Percent Net Margin </td>
                                                                    <td>{{ round($details->net_percentage,2) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Total Weight</td>
                                                                    <td>{{ $details->total_weight ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Value Quote USD</td>
                                                                    <td><span class="icon-dollar-sign"></span>{{ number_format($details->value_of_quote_usd) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Value Quote NGN</td>
                                                                    <td>&#8358;{{ number_format($details->value_of_quote_ngn) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Contract PO Quote USD</td>
                                                                    <td><span class="icon-dollar-sign"></span>{{ ($details->contract_po_value_usd) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Contract PO Quote NGN</td>
                                                                    <td>&#8358;{{ ($details->contract_po_value_ngn) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>


                                                            <tbody>
                                                                <tr>
                                                                    <td>Line Items</td>
                                                                    <td>
                                                                        <?php $co = countLineItems($details->rfq_id) ?>
                                                                        @if($co > 0 )


                                                                            <a href="{{ route('line.preview', $details->rfq_id) }}" style="color:blue">{{ $co }}</a>
                                                                        @else
                                                                        @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                                <a href="{{ route('line.create', $details->rfq_id) }}" style="color:blue">{{ $co }} </a>
                                                                            @endif
                                                                        @endif
                                                                    </td>
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
                                                                    <td>Company Name</td>
                                                                    <td>{{ $details->client->company->company_name ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Client Name</td>
                                                                    <td>{{ $details->client->client_name ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Assigned To</td>
                                                                    <td>{{ $details->employee->full_name ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>RFQ Number</td>
                                                                    <td>{{ $details->rfq_number ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>RFQ Date</td>
                                                                    <td>{{ $details->rfq_date ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Product</td>
                                                                    <td>{{ $details->product ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Description</td>
                                                                    <td>{!! $details->description ?? '' !!}</td>

                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Buyer</td>
                                                                    <td>{{ $details->contact->first_name . " ". $details->contact->last_name ?? ''  }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Shipper</td>
                                                                    <td>{{ $details->shipper->shipper_name ?? 'Null' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Supplier Name</td>
                                                                    <td>{{ $details->vendor->vendor_name ?? '' }}</td>

                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Delivery Due Date</td>
                                                                    <td>{{ $details->delivery_due_date ?? '' }}</td>
                                                                </tr>
                                                            </tbody>


                                                            <tbody>
                                                                <tr>
                                                                    <td>RFQ Acknowledge</td>
                                                                    <td>{{ $details->rfq_acknowledge ?? 'Null' }}</td>
                                                                </tr>
                                                            </tbody>


                                                            <tbody>
                                                                <tr>
                                                                    <td>Status</td>
                                                                    <td>
                                                                        @if($details->status == 'Quotation Submitted')
                                                                            <span class="badge badge-pill badge-info"> {{ $details->status ?? '' }} </span>
                                                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                                                                <b>
                                                                                    <a href="{{ route('rfq.send',$details->refrence_no) }}" class="" onclick="return(sendEnq());">
                                                                                        Send Status Enq
                                                                                    </a>
                                                                                </b>
                                                                            @endif
                                                                        @elseif($details->status == 'Received RFQ')
                                                                           <p style="color:green"><b> {{ $details->status ?? '' }} </b></p>

                                                                        @elseif($details->status == 'RFQ Acknowledged')
                                                                            <span class="badge badge-pill badge-secondary"> {{ $details->status ?? '' }} </span>

                                                                        @elseif($details->status == 'Awaiting Pricing')
                                                                            <span class="badge badge-pill badge-gray"> {{ $details->status ?? '' }} </span>

                                                                        @elseif($details->status == 'Awaiting Shipping')
                                                                            <span class="badge badge-pill badge-danger"> {{ $details->status ?? '' }} </span>

                                                                        @elseif($details->status == 'Awaiting Approval')
                                                                            <span class="badge badge-pill badge-warning"> {{ $details->status ?? '' }} </span>

                                                                        @elseif($details->status == 'Approved')
                                                                            <span class="badge badge-pill badge-orange"> {{ $details->status ?? '' }} </span>

                                                                        @elseif($details->status == 'No Bid')
                                                                            <span class="badge badge-pill badge-primary"> {{ $details->status ?? '' }} </span>

                                                                        @else
                                                                        <p style="color:green"><b> {{ $details->status ?? '' }} </b></p>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Created On</td>
                                                                    <td>{{ $details->created_at ?? 'Null' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Modified On</td>
                                                                    <td>{{ $details->updated_at ?? 'Null' }}</td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p style="text-justify">
                                                @if (file_exists('document/rfq/'.$details->rfq_id.'/'))
                                                    <div class="row gutters">
                                                        <?php
                                                        $dir = 'document/rfq/'.$details->rfq_id.'/';
                                                        $files = scandir($dir);
                                                        $total = count($files) - 2;
                                                        $file = 'document/rfq/'.$details->rfq_id.'/';
                                                        if (is_dir($file)){
                                                            if ($opendirectory = opendir($file)){  $num =1;
                                                                while (($file = readdir($opendirectory)) !== false){?>

                                                                    <?php $len = strlen($file); ?>
                                                                        @if($len > 2)

                                                                        <a href="{{ asset('document/rfq/'.$details->rfq_id.'/'.$file) }}" target="_blank">
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                                <div class="icon-tiles" style="background: -webkit-linear-gradient(45deg, #3949ab, #4fc3f7); color:white; height:150px; width:250px" >
                                                                                    <h6>File: {{ $file }}</h6>
                                                                                    {{-- <p><p style="margin-top:-20px"> File {{$num - 2}}</p></b> --}}
                                                                                    <img src="{{asset('admin/img/icons/contract.png')}}" style="height:150px; width:200px" alt="Files " />
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                        @endif

                                                                    <?php $num++;

                                                                }
                                                                closedir($opendirectory);
                                                            }
                                                        } ?>

                                                    </div>

                                                @else
                                                    File (0)
                                                @endif

                                            </p>

                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p style="text-justify">RFQ Note: {!! $details->note !!} </p>
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
