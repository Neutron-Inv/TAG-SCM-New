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
        @php
            $client = session('client') ?? $client;
            $rfqtotal = session('rfqtotal') ?? $rfqtotal;
            $pototal = session('pototal') ?? $pototal;
            $rfq = session('rfq') ?? $rfq;
            $po = session('po') ?? $rfq;
            $clients = session('clients') ?? $clients;
            if(session('start_date')){
                $start = session('start_date')->format('Y-m-d');
            }else{
                $start = '';
            }
            if(session('end_date')){
                $end = session('end_date')->format('Y-m-d');
            }else{
                $end = '';
            }
        @endphp
         <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to generate report </div>
							</div>
                            <form action="{{ route('po.report.fetch') }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group"><label> Start Date </label>
                                            <div class="input-group">
                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker-date-format2" required name="start_date"
                                                value="{{ session('start_date', $start_date)->format('jS F, Y') }}" placeholder="Start Date">
                                                </select>
                                            </div>

                                            @if ($errors->has('year'))
                                                <div class="" style="color:red">{{ $errors->first('year') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group"><label> End Date </label>
                                            <div class="input-group">
                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker-date-format2" required name="end_date"
                                                value="{{ session('end_date', $end_date)->format('jS F, Y') }}" placeholder="End Date">
                                                </select>
                                            </div>

                                            @if ($errors->has('end_date'))
                                                <div class="" style="color:red">{{ $errors->first('end_date') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> Client </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="client">
                                                    <option value="{{ $client }}"> {{ json_decode(clis($client))[0]->client_name   ?? '-- Select Client --' }} </option>
                                                @foreach($clients as $cli)
                                                    <option value="{{ $cli->client_id }}"> {{ $cli->client_name }} </option>
                                                @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has('end_month'))
                                                <div class="" style="color:red">{{ $errors->first('end_month') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create report" style="float: right;">Create Report</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                        @if(isset($client))
                            <h6 style="text-align:center; padding:1%;"><b> RFQs for {{session('start_date', $start_date)->format('jS F, Y')}} to {{session('end_date', $end_date)->format('jS F, Y')}} </b></h6>
                        @else
                            <h6 style="text-align:center; padding:1%;"><b> RFQs for {{session('start_date', $start_date)->format('jS F, Y')}} to {{session('end_date', $end_date)->format('jS F, Y')}} </b></h6>
                        @endif
                                <div class="table-responsive">
									<table class="table m-0">
                                        <thead class="text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>COMPANY</th>
                                                <th>NUMBER OF RFQ RECEIVED </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $num =1; ?>
                                            @foreach ($rfq as $rfq_detail)
                                            <tr>
                                            <td> {{ $num++ }} </td>
                                            <td class="text-align"> {{ $rfq_detail->client->client_name }} </td>
                                            <td class="text-align">{{ $rfq_detail->count }} </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td> Total RFQs </td>
                                                <td>{{ $rfqtotal }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                            <h6 style="text-align:center; padding:1%;"><b> POs for {{session('start_date', $start_date)->format('jS F, Y')}} to {{session('end_date', $end_date)->format('jS F, Y')}} </b></h6>
                                <div class="table-responsive">
									<table class="table m-0">
                                        <thead class="text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>COMPANY</th>
                                                <th>NUMBER OF PO RECEIVED </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $num =1; ?>
                                            @foreach ($po as $po_detail)
                                            <tr>
                                            <td> {{ $num++ }} </td>
                                            <td class="text-align"> {{ $po_detail->client->client_name }} </td>
                                            <td class="text-align">{{ $po_detail->count }} </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td> Total PO(s) </td>
                                                <td>{{ $pototal }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

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
{{ count(getValveRfqc('114', '2018-01-01', '2023-11-14' )) ?? 0 }}
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                
                                <div class="table table-bordered">
                            <h5 style="text-align:center; vertical-align:center; padding:1%;"><b>  RFQ's & PO's for {{ json_decode(clis($client))[0]->client_name ?? 'Client' }} from {{session('start_date', $start_date)->format('jS F, Y')}} to {{session('end_date', $end_date)->format('jS F, Y')}} </b></h5>
                                    <table id="fixedHeader1" class="monthlytable table">
                                    <thead style="color:black; font-weight:bold !important;"> <!-- Top-level header -->
                                    <tr>
                                    <th colspan="1" style="text-align:center; background-color:white;"></th>
                                    <th colspan="2" style="text-align:center; background-color:#8ea9db; border: 1px solid #000; font-weight: bold;">{{ json_decode(clis($client))[0]->client_name ?? 'Client' }}</th>
                                    </tr>
                                    <tr>
                                    <th style="text-align:center; background-color:white; font-weight: bold;">PRODUCTS</th>
                                    <th style="text-align:center; background-color:#8ea9db; border: 1px solid #000; font-weight: bold;">RFQ RECEIVED</th>
                                    <th style="text-align:center; background-color:#8ea9db; border: 1px solid #000; font-weight: bold;">PO RECEIVED</th>
                                    </tr>

                                </thead>
                                <tbody>
    <tr>
        <td style="font-weight:bold;text-align:left;">VALVES</td>
        <td>{{ count(getValveRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getValvePoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">GASKET</td>
        <td>{{ count(getGasketRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getGasketPoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">BOLTS & NUTS</td>
        <td>{{ count(getBoltAndNutRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getBoltAndNutPoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">FLANGES</td>
        <td>{{ count(getFlangesRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getFlangesPoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">PIPES & FITTINGS</td>
        <td>{{ count(getPipeRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getPipePoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">ROTORK ACTUATOR & GEARBOX</td>
        <td>{{ count(getRotorkRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getRotorkPoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">OTHERS (REGULATOR, TUBE, SLABS, ETC)</td>
        <td>{{ count(getOtherRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getOtherPoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">FLANGE MANAGEMENT SERVICES</td>
        <td>{{ count(getFMSRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getFMSPoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">TOTAL</td>
        <td>{{ count(getTotalRfqc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
        <td>{{ count(getTotalPoc($client, session('start_date'), session('end_date'))) ?? 0 }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;text-align:left;">PO Conversion Rate</td>
        <td colspan="2" style="text-align:center; font-weight:bold;">
            {{ (count(getTotalRfqc($client, session('start_date'), session('end_date'))) > 0) ? (count(getTotalPoc($client, session('start_date'), session('end_date'))) / count(getTotalRfqc($client, session('start_date'), session('end_date'))) * 100) : 0 }}%
        </td>
    </tr>
</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<style>
    .fixed-height-table {
        max-height: 300px; /* Set the fixed height */
        overflow-y: auto; /* Enable vertical scrolling */
        display: block; /* Allow the table to be a block element */
    }
</style>


                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b>TAG List of {{ json_decode(clis($client))[0]->client_name ?? 'Client' }} RFQs</b></h6>
                                <div class="table-responsive">
									<table class="table m-0 fixed-height-table">
                                        <thead class=" text-white">
                                            <tr>
                                                
                                                <th>S/N</th>
                                                <th>TAG REF NUMBER</th>
                                                <th>{{ json_decode(clis($client))[0]->client_name ?? 'Client' }} RFQ NUMBER</th>
                                                <th> BUYER </th>
                                                <th>PRODUCTS</th>
                                                <th>PROJECT NAME</th>
                                                <th>DATE RECEIVED</th>
                                                <th>DUE DATE</th>
                                                <th>VALUE</th>
                                                <th>STATUS</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num = 1 ?>
                                            @php
                                            $client_rfqs = allclientrfq($client, $start, $end) ?? 0;
                                            @endphp
                                            @if($client_rfqs)
                                            @foreach ($client_rfqs as $client_rfq)
                                                <tr>
                                                    <td>{{ $num++}}</td>
                                                    <td>{{ $client_rfq->rfq_number}}</td>
                                                    <td>{{ $client_rfq->refrence_no}}</td>
                                                    <td>{{ fbuyers($client_rfq->contact_id)->first_name ?? '' }} {{fbuyers($client_rfq->contact_id)->last_name ?? '' }}</td>
                                                    <td>{{ $client_rfq->product}}</td>
                                                    <td>{{ $client_rfq->description}}</td>
                                                    <td>{{ $client_rfq->rfq_date}}</td>
                                                    <td>{{ $client_rfq->delivery_due_date}}</td>
                                                    <td>{{ $client_rfq->total_quote}}</td>
                                                    <td>{{ $client_rfq->status}}</td>
                                                </tr>
                                            @endforeach
                                            @else

                                            @endif
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-container">
                                <div class="table-responsive">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b>TAG List of {{ json_decode(clis($client))[0]->client_name ?? 'Client' }} POs</b></h6>
                                <table class="table fixed-height-table">
                                    <thead class="bg-success text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>STATUS</th>
                                                <th>PO NUMBER</th>
                                                <th>{{ json_decode(clis($client))[0]->short_code ?? 'Client' }} RFQ NUMBER</th>
                                                <th>VALUE</th>
                                                <th> BUYER </th>
                                                <th>DESCRIPTION</th>
                                                <th>DATE RECEIVED</th>
                                                <th>DELIVERY DUE DATE</th>
                                                <th>ASSIGNED TO</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num = 1 ?>
                                            @php
                                            $client_pos = allclientpo($client, $start, $end) ?? 0;
                                            @endphp
                                            @if($client_pos)
                                            @foreach($client_pos as $po_item)
                                                <tr>
                                                    <td>{{ $num++}}</td>
                                                    <td>{{ $po_item->status}}</td>
                                                    <td>{{ $po_item->po_number}}</td>
                                                    <td>{{ $po_item->rfq_number}}</td>
                                                    <td>
                                                    @if($po_item->po_value_foreign > 0)
                                                    ${{ number_format($po_item->po_value_foreign, 2) }}
                                                    @endif
                                                    
                                                    @if($po_item->po_value_foreign > 0 && $po_item->po_value_naira > 0)
                                                    , 
                                                    @endif

                                                    @if($po_item->po_value_naira > 0)
                                                    ₦{{ number_format($po_item->po_value_naira, 2) }}
                                                    @endif
                                                    </td>
                                                    <td>{{ fbuyers($po_item->contact_id)->first_name ?? '' }} {{fbuyers($po_item->contact_id)->last_name ?? '' }}</td>
                                                    <td>{{ $po_item->description}}</td>
                                                    <td>{{ $po_item->po_date}}</td>
                                                    <td>{{ $po_item->delivery_due_date}}</td>
                                                    <td>
                                                    @php
                                                        $employee = empDetails($po_item->employee_id);
                                                    @endphp
                                                    {{ $employee->full_name ?? ''}}</td>
                                                </tr>
                                            @endforeach
                                            @else

                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <br/>
                @if($client)
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="form-group">
                            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#WeeklyReport">Send Custom Report</button>                             
                    </div>
                </div>
                @endif
            </div>
         </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="WeeklyReport" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Send Custom Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('po.report.sendCustomReport') }}" class="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="row gutters">
                        <div class="col-md-4 col-sm-4 col-4">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <!-- <input type="email" class="form-control" id="recipient-email" name="rec_email"
                            value="bidadmin@tagenergygroup.net" readonly> -->
                            <input type="email" class="form-control" id="recipient-email" name="rec_email"
                            value="contact@tagenergygroup.net" >
                            @if ($errors->has('rec_email'))
                                <div class="" style="color:red">{{ $errors->first('rec_email') }}</div>
                            @endif
                        </div>
                        
                        <div class="col-md-8 col-sm-8 col-8">
                            <label for="recipient-name" class="col-form-label">CC Email:</label>
                            <!-- <input type="text" class="form-control" id="recipient-email" name="quotation_recipient" value="contact@tagenergygroup.net; sales@tagenergygroup.net" readonly> -->
                            <input type="text" class="form-control" id="recipient-email" name="report_recipient" value="emmanuel@enabledgroup.net; jackomega.idnoble@gmail.com">
                            @if ($errors->has('report_recipient'))
                                <div class="" style="color:red">{{ $errors->first('quotation_recipient') }}</div>
                            @endif
                        </div>

                        <input type="date" class="form-control" id="" name="start_date" value="{{$start}}" hidden>
                        <input type="date" class="form-control" id="" name="end_date" value="{{$end}}" hidden>
                        <input type="text" class="form-control" id="" name="client" value="{{$client}}" hidden>

                    </div>
                </div>
                <div class="modal-footer custom">

                    <div class="left-side">
                        <button type="button" class="btn btn-link danger" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-link success">Send Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
