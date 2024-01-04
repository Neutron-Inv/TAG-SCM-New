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
                                                <th>Total Numbers of POs Delivered till date</th>
                                                <th>Total Numbers of POs Delivered on time</th>
                                                <th> Total Numbers of POs Delivered Late </th>

                                                <th>% POs Delivered On-time</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <td> {{ count(getPOInfo()) ?? 0 }} </td>
                                            <td class="text-align"> {{ count(getPOInfoCon('YES')) ?? 0 }} </td>
                                            <td class="text-align">{{ count(getPOInfoCon('NO')) ?? 0 }} </td>
                                            <td> {{ round((count(getPOInfoCon('YES')) / count(getPOInfo())) * 100,2) ?? 0}}% </td>
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
                                                <th> ONTIME DELIVERY ? </th>

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

                                                    <td>{{ $rfqs->po_receipt_date ?? ' ' }} </td>
                                                    <td>{{ $rfqs->delivery_due_date  ?? ' ' }} </td>
                                                    <td> {{ $rfqs->actual_delivery_date ?? '' }}</td>
                                                    <td>{{ $rfqs->timely_delivery ?? ' ' }}</td>
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
                                                
                                                <th>SHIPPER</th>
                                                <th>TOTAL PO COLLECTED</th>
                                                <th> TOTAL PO DELIVRED ON-TIME </th>
                                                <th>PERFORMANCE INDEX (%)</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shipper as $item)
                                                <tr>
                                                    <td>
                                                        @foreach (getSh($item->shipper_id) as $it)
                                                            {{ $it->shipper_name ?? ' N/A' }}
                                                        @endforeach
                                                    </td>
                                                    <td> {{ count(countShipperPO($item->shipper_id)) ?? 0 }}</td>
                                                    <td>{{ count(countShipperPOCon($item->shipper_id,'YES')) ?? 0}} </td>
                                                    <td>{{ round((count(countShipperPOCon($item->shipper_id,'YES'))  / count(countShipperPO($item->shipper_id))) * 100,2) ?? 0 }}%</td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="form-group">
                        <A href="{{ route('po.report.sendReport') }}" class="btn btn-primary" style="float: right;">Send Report</a>
                            
                    </div>
                </div>
            </div>
         </div>
    </div>
@endsection
