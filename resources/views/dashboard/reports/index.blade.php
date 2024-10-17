<?php $title = 'Generate Yearly Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('po.report.index') }}">Year till Date</a></li>

                <li class="breadcrumb-item">Generate Yearly Report</li>
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
                            <form action="{{ route('po.report.year') }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group"><label> Report Year </label>
                                            <div class="input-group">
                                                
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="year">
                                                    <option value="{{ old('year') }}"> {{ old('year') ?? '-- Select Start Year --' }} </option>
                                                    <option value=""> </option>
                                                    @for ($i=2016; $i<=date('Y'); $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            @if ($errors->has('year'))
                                                <div class="" style="color:red">{{ $errors->first('year') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> Start Month </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>
                                                
                                                <select class="form-control selectpicker" data-live-search="true" required name="start_month">
                                                    <option value="{{ old('start_month') }}"> {{ old('start_month') ?? '-- Select The Month --' }} </option>
                                                    <option value=""> </option>
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>

                                            @if ($errors->has('start_month'))
                                                <div class="" style="color:red">{{ $errors->first('start_month') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> End Month</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="end_month">
                                                    <option value="{{ old('end_month') }}"> {{ old('end_month') ?? '-- Select End Month --' }} </option>
                                                    <option value=""> </option>
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
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
                                
                                <div class="table-responsive">
									<table class="table m-0">
                                        <thead class=" text-white">
                                            <tr>
                                                <th>Total Numbers of POs Delivered from January {{date('Y')}} till December {{date('Y')}}</th>
                                                <th>Total Numbers of POs Delivered on time</th>
                                                <th> Total Numbers of POs Delivered Late </th>

                                                <th>% POs Delivered On-time</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <td> {{ count(getyearPOInfo()) ?? 0 }} </td>
                                            <td class="text-align"> {{ count(getyearPOInfoCon('YES')) ?? 0 }} </td>
                                            <td class="text-align">{{ count(getyearPOInfoCon('NO')) ?? 0 }} </td>
                                            <td> 
                                        @if(count(getyearPOInfo()) == 0)
                                        0%
                                        @else
                                         {{ round((count(getyearPOInfoCon('YES')) / count(getyearPOInfo())) * 100,2) ?? 0}}%
                                         @endif
                                            </td>
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
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>CLIENT NAME</th>
                                                <th> PO NUMBER </th>

                                                <th>TAG REF NUMBER</th>
                                                <th> DESCRIPTION </th>

                                                <th>PO RECEIPT DATE</th>
                                                <th> DELIVERY DATE </th>

                                                <th>ACTUAL DELIVERY DATE</th>
                                                <th>TOTAL NUMBER OF DAYS FROM PO TO DELIVERY</th>
                                                <th> ONTIME DELIVERY ? </th>
                                                <th> SHIPPER ONTIME DELIVERY ? </th>

                                                <th>OEM</th>
                                                <th>SHIPPER </th>
                                                <th>COMMENT </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($po as $rfqs)
                                                <tr> 
                                                    <td>{{ $num++ }} </td>
                                                    <td>{{ $rfqs->client->client_name ?? 'Null' }} </td>
                                                    <td> {{ $rfqs->po_number ?? ''}}</td>
                                                    <td> {{ $rfqs->rfq->refrence_no ?? 'Null' }}</td>
                                                    <td> {{ $rfqs->description ?? '' }}</td>

                                                    <td>{{ $rfqs->po_date ?? ' ' }} </td>
                                                    <td>{{ $rfqs->delivery_due_date  ?? ' ' }} </td>
                                                    <td> {{ $rfqs->actual_delivery_date ?? '' }}</td>
                                                    <td> @if($rfqs->po_date && $rfqs->actual_delivery_date)
                                                        {{ \Carbon\Carbon::parse($rfqs->po_date)->diffInDays(\Carbon\Carbon::parse($rfqs->actual_delivery_date)) }}
                                                    @endif
                                                    </td>
                                                    <td>
                                                        @if($rfqs->actual_delivery_date && $rfqs->delivery_due_date)
                                                        @if(\Carbon\Carbon::parse($rfqs->actual_delivery_date)->greaterThan(\Carbon\Carbon::parse($rfqs->delivery_due_date)))
                                                            No
                                                        @else
                                                            Yes
                                                        @endif
                                                    @endif
<<<<<<< HEAD
                                                </td>
=======
                                                    </td>
                                                    <td>{{ $rfqs->shipper_timely_delivery ?? 'Null' }} </td>
>>>>>>> master
                                                    <td> {{ $rfqs->rfq->vendor->vendor_name ?? 'Null' }}</td>
                                                    <td>{{ $rfqs->rfq->shipper->shipper_name ?? 'Null' }}</td>
                                                    

                                                    <td> {!! $rfqs->tag_comment ?? '' !!}</td>
                                                </tr>
                                            @endforeach
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
                                <h5 class="table-title">SHIPPERS PERFORMANCE EVALUATION </h5>
                                <div class="table-responsive">
									<table class="table m-0">
                                        <thead class=" text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>SHIPPER</th>
                                                <th>TOTAL PO DELIVERED</th>
                                                <th> TOTAL PO DELIVERED ON-TIME </th>
                                                <th>PERFORMANCE INDEX (%)</th>
                                                
                                            </tr>
                                        </thead>
                                        @php 
                                        $totalPO = 0;
                                        $totalOntimePO = 0;
                                        $count = 0;
                                        $totalindex = 0;
                                        @endphp
                                        <tbody>
                                            @foreach ($shipper as $item)
                                            @if(count(countShipperPOyearly($item->shipper_id)) != 0)
                                                <tr>
                                                    <td>
                                                    @php $count += 1; @endphp
                                                    {{ $count }}
                                                    </td>
                                                    <td>
                                                        @foreach (getSh($item->shipper_id) as $it)
                                                            {{ $it->shipper_name ?? ' N/A' }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                        @php $totalPO += count(countShipperPOyearly($item->shipper_id)) ?? 0 @endphp                
                                                         {{ count(countShipperPOyearly($item->shipper_id)) ?? 0 }}</td>
                                                    <td>
                                        @php $totalOntimePO += count(countShipperPOCon($item->shipper_id,'YES')) ?? 0 @endphp  
                                                        {{ count(countShipperPOCon($item->shipper_id,'YES')) ?? 0}} </td>
                                                    <td>
                                        @if(count(countShipperPOyearly($item->shipper_id)) == 0)
                                        0%
                                        @else   
                                        {{ round((count(countShipperPOCon($item->shipper_id,'YES'))  / count(countShipperPOyearly($item->shipper_id))) * 100,2) ?? 0 }}%
                                        
                                        @php $totalindex +=  round((count(countShipperPOCon($item->shipper_id,'YES'))  / count(countShipperPOyearly($item->shipper_id))) * 100,2) ?? 0; @endphp
                                        @endif
                                        </td>
                                             </tr>   
                                            @endif
                                            @endforeach
                                            @php
                                            $avgindex = $totalindex/$count;
                                            @endphp
                                            <tr>
                                            <td></td>
                                            <td> <b>Total</b></td>
                                            <td> <b>{{ $totalPO }}</b></td>
                                            <td> <b>{{ $totalOntimePO }} </b></td>
                                            <td>{{ number_format($avgindex,2) }}%</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#customModals">Send YTD Report</button> 
                            
                    </div>
                </div>
            </div>
         </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="customModals" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customModalTwoLabel">Send monthly RFQs and POs Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('po.report.sendReport') }}" class="" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
    
                        <div class="row gutters">
                            <div class="col-md-4 col-sm-4 col-4">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
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
                            </div>
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
