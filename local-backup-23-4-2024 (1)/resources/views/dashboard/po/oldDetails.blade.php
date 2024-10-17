<?php $title = 'Purchase Order Details'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('po.details',$details->po_id) }}"> PO Details</a></li>
                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item active"><a href="{{ route('po.edit',$details->po_id) }}">Edit PO Details</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ route('po.index') }}">View All PO</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.edit',$details->rfq->refrence_no) }}">Edit RFQ</a></li>
                <li class="breadcrumb-item">PO Details</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
						<div class="col-12">
                            @include('layouts.alert')
							<!-- Card start -->
							<div class="card">
								<div class="card-header">
									<div class="card-title">Purchase Order Details
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
                                                                    <td>Status</td>
                                                                    <td>{{ $details->status ?? "" }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Our Ref</td>
                                                                    <td>{{ $details->rfq_number ?? "" }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Client</td>
                                                                    <td>{{ $details->client->client_name ?? 'Null' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>PO Number</td>
                                                                    <td>{{ $details->po_number ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Product</td>
                                                                    <td>{{ $details->rfq->product ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Decription</td>
                                                                    <td>{{ $details->description ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Total PO (USD)</td>
                                                                    <td>{{ $details->po_value_foreign ?? '' }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Total PO (NGN)</td>
                                                                    <td>{{ $details->po_value_naira  ?? ''}}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Buyer </td>
                                                                    <td>{{ $details->rfq->client->client_name ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>PO Date</td>
                                                                    <td>{{ $details->po_date  ?? ''}}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Delivery Due Date</td>
                                                                    <td>{{ $details->delivery_due_date ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Assigned To</td>
                                                                    <td>{{ $details->rfq->employee->full_name ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>PO Receipt Date</td>
                                                                    <td>{{ $details->po_receipt_date ?? "" }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Esp Production Time</td>
                                                                    <td>{{ $details->est_production_time ?? "" }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Esp DDPLead Time </td>
                                                                    <td>{{ $details->est_ddp_lead_time ?? 'Null' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Est Delivery Date</td>
                                                                    <td>{{ $details->est_delivery_date ?? '' }}</td>

                                                                </tr>

                                                            </tbody>

                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

										</div>

										<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">

											<div class="card">
												<div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">

                                                            <tbody>

                                                                <tr>
                                                                    <td>Supplier Proforma Foreign</td>
                                                                    <td>{{ $details->supplier_proforma_foreign	 ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Supplier Proforma Naira</td>
                                                                    <td>{{ $details->supplier_proforma_naira ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Shipping Cost</td>
                                                                    <td>{{ $details->shipping_cost ?? '' }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>PO Issued to Supplier</td>
                                                                    <td>{{ $details->po_issued_to_supplier  ?? ''}}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Payment Details Received </td>
                                                                    <td>{{ $details->payment_details_received ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Payment Made</td>
                                                                    <td>{{ $details->payment_made  ?? ''}}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Payment Confirmed</td>
                                                                    <td>{{ $details->payment_confirmed }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td> Work Order</td>
                                                                    <td>{{ $details->work_order ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Shippment Initiated</td>
                                                                    <td>{{ $details->shipment_initiated }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Shipment Arrived</td>
                                                                    <td>{{ $details->shipment_arrived }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Docs to Shipper</td>
                                                                    <td>{{ $details->docs_to_shipper }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td> Delivered to Customer</td>
                                                                    <td>{{ $details->delivered_to_customer ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Delivery Note Submitted</td>
                                                                    <td>{{ $details->delivery_note_submitted }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Customer Paid</td>
                                                                    <td>{{ $details->customer_paid }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Docs to Shipper</td>
                                                                    <td>{{ $details->docs_to_shipper }}</td>

                                                                </tr>


                                                                <tr>
                                                                    <td> Payment Due</td>
                                                                    <td>{{ $details->payment_due ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Status 2</td>
                                                                    <td>{{ $details->status_2 }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Created At</td>
                                                                    <td>{{ $details->created_at }}</td>

                                                                </tr>


                                                            </tbody>


                                                        </table>
                                                    </div>
												</div>
											</div>


                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <p style="text-justify">PO Note: {!! $details->note !!} </p>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="row gutters">

                                                @if (file_exists('document/po/'.$details->po_id.'/'))

                                                    <?php
                                                    $dir = 'document/po/'.$details->po_id.'/';
                                                    $files = scandir($dir);
                                                    $total = count($files) - 2;
                                                    $file = 'document/po/'.$details->po_id.'/';
                                                    if (is_dir($file)){
                                                        if ($opendirectory = opendir($file)){
                                                            while (($file = readdir($opendirectory)) !== false){?>
                                                                <a href="{{ asset('document/po/'.$details->po_id.'/'.$file) }}" target="_blank">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="">
                                                                        <?php
                                                                        $len = strlen($file); ?>
                                                                        @if($len > 2)
                                                                            <h6 style="margin-left:;"> {{ substr($file, 0, 25) }} </h6><br>
                                                                        @endif
                                                                    </div>
                                                                </a><?php
                                                            }
                                                            closedir($opendirectory);
                                                        }
                                                    } ?>

                                                @else
                                                    File (0)
                                                @endif
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
    </div>
@endsection
