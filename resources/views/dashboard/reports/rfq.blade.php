<?php $title = 'Generate Custom Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('po.report.index') }}">Report</a></li>

                <li class="breadcrumb-item">Generate Custom Report</li>
            </ol>
            @include('layouts.logo')
        </div>
         <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to generate report </div>
							</div>
                            
                            <div class="row gutters">
                            
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <form action="{{ route('po.report.rfq') }}" method="GET" class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                    <div>
                                        <div class="form-group"><label> Rfq Reference NO </label>
                                            <div class="input-group">
                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-clipboard" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required name="reference_no"
                                                value="{{ $reference_no }}" placeholder="Reference Number">
                                            </div>

                                            @if ($errors->has('year'))
                                                <div class="" style="color:red">{{ $errors->first('rfq') }}</div>
                                            @endif

                                        </div>                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create report" style="float: right;">Fetch RFQ Details</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <form action="{{ route('po.report.rfq') }}" method="GET" class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div>
                                        <div class="form-group"><label> PO Number </label>
                                            <div class="input-group">
                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-clipboard" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control" required name="po_number"
                                                value="{{ $po_number }}" placeholder="PO Number">
                                                </select>
                                            </div>

                                            @if ($errors->has('year'))
                                                <div class="" style="color:red">{{ $errors->first('po') }}</div>
                                            @endif

                                        </div>                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create report" style="float: right;">Fetch PO Details</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                           

                        </div>
                    </div>
                </div>

                <style>
  .monthlytable th, .monthlytable td, .monthlytable thead {
    border: 1px solid #000;
  }

  .monthlytable th {
    font-weight: bold;
  }

  .monthlytable thead {
    font-weight: bold;
  }

  .monthlytable td {
    padding:5px;
    text-align:center;
  }
</style>

@if ($rfq != null || $po != null)
<!-- Browser States -->
<div class="col-xl-4 col-md-6 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2" style="text-decoration: underline;">
                        @if($requested == "rfq")
                        {{$reference_no}} RFQ Details
                        @elseif($requested == "po")
                        {{$po_number}} PO Details
                        @endif</h5>
                        <small class="text-muted">Counter April 2022</small>
                      </div>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">
                      @if($po != "")
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="fas fa-file-invoice-dollar ti-sm text-danger ml-1 me-3"></i>PO number</h6>
                              </div>

                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">{{ $po->po_number ?? ' ' }}</h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="secondary" data-series="85"></div>
                          </div>
                        </li>
                        @endif
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="ti ti-building ti-sm text-danger me-3"></i>Client</h6>
                              </div>
                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">
                                    @if(request()->has('po_number'))
                                        {{ $po->client->client_name ?? ' ' }}
                                    @else
                                        {{ $rfq->client->client_name ?? ' ' }}
                                    @endif
                                    </h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="success" data-series="70"></div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="ti ti-user ti-sm text-info me-3"></i>Buyer</h6>
                              </div>
                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">
                                    @if(request()->has('po_number'))
                                        {{ optional($po->contact)->first_name ?? '' }} {{ optional($po->contact)->last_name ?? '' }}
                                    @else
                                        {{ optional($rfq->contact)->first_name ?? '' }} {{ optional($rfq->contact)->last_name ?? '' }}
                                    @endif
                                    </h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="primary" data-series="25"></div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="ti ti-settings ti-sm text-primary me-3"></i>Supplier</h6>
                              </div>

                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">
                                    @if(request()->has('po_number'))
                                        {{ $rfq && $rfq->rfq_id > 0 ? $rfq->vendor->vendor_name : '' }}
                                    @else
                                        {{ $rfq && $rfq->rfq_id > 0 ? $rfq->vendor->vendor_name : ''}}
                                    @endif</h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="danger" data-series="75"></div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="ti ti-note ti-sm text-secondary me-3"></i>Description</h6>
                              </div>
                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">
                                    @if(request()->has('po_number'))
                                        {!! isset($rfq) ? $rfq->description : '' !!}
                                    @else
                                        {!! isset($rfq) ? $rfq->description : '' !!}
                                    @endif
                                    </h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="info" data-series="60"></div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="ti ti-ship ti-sm text-primary me-3"></i>Incoterm</h6>
                              </div>
                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">{{ $rfq->incoterm ?? ''}}</h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="warning" data-series="45"></div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="ti ti-coin ti-sm text-info me-3"></i>Currency</h6>
                              </div>
                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">{{ $rfq->currency ?? ''}}</h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="warning" data-series="45"></div>
                          </div>
                        </li>
                        <li class="dd-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="ti ti-loader ti-sm text-danger me-3"></i>Status</h6>
                              </div>
                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">
                                    @if(request()->has('po_number'))
                                         {{ $po->status }}
                                    @else
                                        {{ $rfq->status }}
                                    @endif}
                                </h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="warning" data-series="45"></div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                          <div class="d-flex w-100 align-items-center gap-2">
                            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                              <div>
                                <h6 class="mb-0"><i class="fas fa-user-check ti-sm text-danger ml-1 me-2"></i>Assigned To</h6>
                              </div>
                              
                                @if(request()->has('po_number'))
                                @php
                                    $employee = empDetails($po->employee_id);
                                @endphp
                                 @php
                                    $employee = empDetails($rfq->employee_id);
                                @endphp
                                @endif
                              <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">{{ $employee->full_name ?? '' }}</h6>
                              </div>
                            </div>
                            <div class="chart-progress" data-color="warning" data-series="45"></div>
                          </div>
                        </li>
                      </ul>
                      <hr>
                      <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                    <b style="color:red">Notes to Pricing: </b><br>
                                                    1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }}. <br>
                                                    2. Mode of transportation:  <b>{{ $rfq->transport_mode ?? ''}} </b> <br>
                                                    3. Delivery Location: <b>{{ $rfq->delivery_location ?? ''}} </b><br>
                                                    4. Where Legalisation of C of O and/or invoices are required, additional cost will apply and will be charged at cost. <br>
                                                    5. Validity: This quotation is valid for <b>{{ $rfq->validity ?? ''}} </b>. <br>
                                                    6. FORCE MAJEURE: On notification of any event with impact on delivery schedule,We will extend delivery schedule.<br>
                                                    7. Pricing: Prices quoted are in <b>{{ $rfq->currency ?? 'USD' }} </b> <br>
                                                    8. Prices are based on quantity quoted <br>
                                                    9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
                                                    10. Oversized Cargo: <b>{{ $rfq->oversized ?? 'NO' }} </b><br>
                                                    11. Payment Term: <b>{{ $rfq->payment_term ?? '' }} </b><br>
                                                </p>
                    </div>
                  </div>
                </div>
                <!-- end client information -->

<!-- Breakdown -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-header d-flex justify-content-between">
                      <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2" style="text-decoration: underline;">Breakdown Analysis</h5>
                        <small class="text-muted"></small>
                      </div>
                    </div>
                    <div class="card-body">
    <table style="border-collapse: collapse; border: 0; width: 100%; background: white !important; padding-left:2px;">
                                                <thead>
                                                    <tr>
                                                        <th  style=" width: 27%; text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </th>
                                                        <th  style="width: 73%; text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                            &nbsp;
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             {{number_format((float)$tq,2) ?? 0 }}
                                                            
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             Total Ex-Works
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $sumTotalMiscSupplier = 0;
                                                        $shipper = getSh($rfq->shipper_id);
                                                    @endphp
                                                    @if(!empty(json_decode($rfq->misc_cost_supplier, true) && array_key_exists('amount', json_decode($rfq->misc_cost_supplier, true))))
                                                    @foreach(json_decode($rfq->misc_cost_supplier, true) as $item)
                                                        <tr>
                                                            <td style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                            @if($iteml['amount'] != "" && $iteml['amount'] > 0)
                                                            {{number_format((float)$item['amount'] ,2) ?? 0 }}
                                                            @endif
                                                            </td>
                                                            <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                {{ $item['desc'] }}
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $sumTotalMiscSupplier += $item['amount'];
                                                        @endphp
                                                    @endforeach
                                                    @endif
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    @if($rfq->local_delivery > 0)
                                                        @if($rfq->is_lumpsum == 1)
                                                        <tr>
                                                            <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                {{number_format((float)$rfq->local_delivery ,2) ?? 0 }}
                                                            </td>
                                                            <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                {{ $shiname }} Lump Sum
                                                            </td>
                                                        </tr>
                                                        @else
                                                        @if($shi != null)
                                                        @if($shi->soncap_charges > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->soncap_charges ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Soncap Charges
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if($shi->trucking_cost > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->trucking_cost ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Trucking Cost
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if($shi->clearing_and_documentation > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->clearing_and_documentation ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Clearing and Documentation
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            
                                                            @if($shi->customs_duty > 0 )
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->customs_duty ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Customs Duty
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @php
                                                        $sumTotalMiscLogistics = 0;
                                                    @endphp
                                                    @if(!empty(json_decode($rfq->misc_cost_logistics, true) && array_key_exists('amount', json_decode($rfq->misc_cost_logistics, true))))
                                                    @foreach(json_decode($rfq->misc_cost_logistics, true) as $iteml)
                                                        <tr>
                                                            <td style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                            @if($iteml['amount'] != "" && $iteml['amount'] > 0)
                                                            {{number_format((float)$iteml['amount'] ,2) ?? 0 }}
                                                            @endif
                                                            </td>
                                                            <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                {{ $iteml['desc'] }}
                                                            </td>
                                                        </tr>

                                                        @php
                                                            $sumTotalMiscLogistics += $iteml['amount'];
                                                        @endphp
                                                    @endforeach
                                                    @endif
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format(
                                        (float)$tq +
                                        (is_numeric($sumTotalMiscLogistics) ? $sumTotalMiscLogistics : 0) +
                                        (is_numeric($sumTotalMiscSupplier) ? $sumTotalMiscSupplier : 0) +
                                        (is_numeric($rfq->local_delivery) ? $rfq->local_delivery : 0),
                                        2
                                    ) }}</b> 
                                                        </td>
@php
    $tq_numeric = is_numeric($tq) ? (float)$tq : 0;
    $sumTotalMiscLogistics_numeric = is_numeric($sumTotalMiscLogistics) ? (float)$sumTotalMiscLogistics : 0;
    $sumTotalMiscSupplier_numeric = is_numeric($sumTotalMiscSupplier) ? (float)$sumTotalMiscSupplier : 0;
    $rfq_local_delivery_numeric = is_numeric($rfq->local_delivery) ? (float)$rfq->local_delivery : 0;

    $subtotal = $tq_numeric + $sumTotalMiscLogistics_numeric + $sumTotalMiscSupplier_numeric + $rfq_local_delivery_numeric;
@endphp
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            {{-- {{ number_format((float)sumTotalQuote($rfq->rfq_id),2) ?? 0}}  --}}
                                                            <b>Sub Total 1</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;color:red;">
{{ 
    is_numeric($rfq->cost_of_funds) ? number_format((float)$rfq->cost_of_funds, 2) : 0 
}}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Cost of funds (Subtotal * 1.3% * 4 Months)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                            {{ number_format((float)$rfq->fund_transfer_charge,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Cost of Fund Transfer(0.5 % of Total Ex- Works) 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                            {{ number_format((float)$rfq->vat_transfer_charge,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             VAT on Transfer Cost (7.5% of Funds Transfer)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                             {{ number_format((float)$rfq->offshore_charges,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Offshore Charges
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                             {{ number_format((float)$rfq->swift_charges,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Swift Charges (fixed @ $25)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 2px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             @php
                                                                $total_exworks = $subtotal + $rfq->swift_charges + $rfq->offshore_charges + $rfq->vat_transfer_charge + $rfq->fund_transfer_charge + $rfq->cost_of_funds
                                                             @endphp
                                                             {{ number_format((float)$total_exworks,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Total Ex-works Cost
                                                        </td>
                                                    </tr>
                                                    <tr style="background:#f2f2f2;">
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->total_quote ,2) ?? 0 }}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            <b>Total Quotation</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             -
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             VAT
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        {{ number_format((float)$rfq->wht + $rfq->ncd,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            WHT &amp; NCD  <br> ((Total Quote minus Sub Total 1 * 6%)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        {{ number_format((float)$rfq->wht + $rfq->ncd,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; background:#d9d9d9;">
                                                             Total TAXES
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->net_percentage,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            <b>Net Margin <br>(Total Quote minus (Total DDP Cost + WHT))</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; background:#d9d9d9;">
                                                        <b>{{ number_format((float)$rfq->percent_net,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            % Net Margin
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->net_value,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Gross Margin
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->percent_margin,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            % Gross Margin
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                    </div>
    </div>
</div>
<!-- Breakdown -->

<!-- Note -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card h-100">
    <div class="card-header d-flex justify-content-between">
        <div class="card-title m-0 me-2">
        <h5 class="m-0 me-2" style="text-decoration: underline;">{{ mb_strtoupper($requested) }} Note</h5>
        <small class="text-muted"></small>
        </div>
        </div>
        <div class="card-body" style="max-height:800px; overflow-y: auto;">
        @if($requested == "rfq")
        {!! $rfq->note !!}
        @elseif($requested == "po")
        {!! $po->note !!}
        @endif
        </div>
    </div>
</div>
<!-- Note -->
@if($rfq != null)
<div class="table-container">
                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th> Item Name </th>
                                                <th>Item Number</th>
                                                <th>Description</th>
                                                <th>Supplier</th>
                                                <th>Quantity</th>
                                                <th>Unit Price  </th>
                                                {{--  <th>Total Cost (NGN)</th>  --}}
                                                {{--  <th>Total Cost (NGN)</th>  --}}
                                                <th>Total Price</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($line_items as $items)
                                                    <tr>
                                                        <td> {{ $items->item_serialno ?? '' }}
                                                        </td>

                                                        <td> {{$items->item_name ?? ''}} </td>
                                                        <td> {{$items->item_number ?? ''}} </td>
                                                        <td> {!! $items->item_description ?? 0 !!} </td>
                                                        @foreach(getVen($items->vendor_id) as $ven)
                                                            <td> {{$ven->vendor_name ?? 'Null'}} </td>
                                                        @endforeach
                                                        <td> {{$items->quantity ?? 0}} </td>

                                                        <td> {{$items->unit_price ?? 0}} </td>
                                                        {{--  <td> {{$items->total_cost ?? ''}} </td>  --}}
                                                        {{--  <td> {{$items->total_cost_naira ?? ''}} </td>  --}}
                                                        <td> {{number_format($items->quantity * $items->unit_price) ?? ''}} </td>

                                                    </tr><?php $num++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
</div>
              <hr>
              

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12 mb-4">
                    <div class="form-group">
                            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#WeeklyReport">Send Custom Report</button>                             
                    </div>
                </div>
            </div>
         </div>
    </div>
    @endif  
    @endif  
    <div class="modal fade bd-example-modal-lg" id="WeeklyReport" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel" style="color: white;">Send Custom Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('po.report.rfqreport') }}" class="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="row gutters">
                        <div class="col-md-4 col-sm-4 col-4">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <!-- <input type="email" class="form-control" id="recipient-email" name="rec_email"
                            value="bidadmin@tagenergygroup.net" readonly> -->
                            <input type="email" class="form-control" id="recipient-email" name="rec_email"
                            value="contact@tagenergygroup.net">
                            @if ($errors->has('rec_email'))
                                <div class="" style="color:red">{{ $errors->first('rec_email') }}</div>
                            @endif
                        </div>
                        
                        <div class="col-md-8 col-sm-8 col-8">
                            <label for="recipient-name" class="col-form-label">CC Email:</label>
                            <input type="text" class="form-control" id="recipient-email" name="report_recipient" value="sales@tagenergygroup.net; mary.nwaogwugwu@tagenergygroup.net">
                            @if ($errors->has('report_recipient'))
                                <div class="" style="color:red">{{ $errors->first('quotation_recipient') }}</div>
                            @endif

                            <input type="text" class="form-control" id="recipient-email" name="reference_no" value="{{ $reference_no }}" hidden>

                        </div>
                    </div>
                </div>
                <div class="modal-footer custom row">

                    <div class="left-side">
                        <button type="button" class="btn btn-link danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-link success">Send Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
