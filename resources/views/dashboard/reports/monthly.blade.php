<?php $title = 'Generate Yearly Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('po.report.index') }}">Report</a></li>

                <li class="breadcrumb-item">Generate monthly Report</li>
            </ol>
            @include('layouts.logo')
        </div>

         <div class="content-wrapper">
            <div class="row gutters">
                @include('layouts.alert')

       <!--         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">-->
       <!--             <div class="card">-->
       <!--                 <div class="card-body">-->
       <!--                     <div class="card-header">-->
							<!--	<div class="card-title">Please fill the below form to generate report </div>-->
							<!--</div>-->
       <!--                     <form action="{{ route('po.report.year') }}" class="" method="POST">-->
       <!--                         {{ csrf_field() }}-->
       <!--                         @include('layouts.alert')-->
       <!--                         <div class="row gutters">-->
       <!--                             <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">-->
       <!--                                 <div class="form-group"><label> Report Year </label>-->
       <!--                                     <div class="input-group">-->
                                                
       <!--                                         <div class="input-group-prepend">-->
       <!--                                             <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>-->
       <!--                                         </div>-->
       <!--                                         <select class="form-control selectpicker" data-live-search="true" required name="year">-->
       <!--                                             <option value="{{ old('year') }}"> {{ old('year') ?? '-- Select Start Year --' }} </option>-->
       <!--                                             <option value=""> </option>-->
       <!--                                             @for ($i=2016; $i<=date('Y'); $i++)-->
       <!--                                                 <option value="{{ $i }}">{{ $i }}</option>-->
       <!--                                             @endfor-->
       <!--                                         </select>-->
       <!--                                     </div>-->

       <!--                                     @if ($errors->has('year'))-->
       <!--                                         <div class="" style="color:red">{{ $errors->first('year') }}</div>-->
       <!--                                     @endif-->

       <!--                                 </div>-->
       <!--                             </div>-->
       <!--                             <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">-->
       <!--                                 <div class="form-group">-->
       <!--                                     <label> Start Month </label>-->
       <!--                                     <div class="input-group">-->
       <!--                                         <div class="input-group-prepend">-->
       <!--                                             <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>-->
       <!--                                         </div>-->
                                                
       <!--                                         <select class="form-control selectpicker" data-live-search="true" required name="start_month">-->
       <!--                                             <option value="{{ old('start_month') }}"> {{ old('start_month') ?? '-- Select The Month --' }} </option>-->
       <!--                                             <option value=""> </option>-->
       <!--                                             <option value="01">January</option>-->
       <!--                                             <option value="02">February</option>-->
       <!--                                             <option value="03">March</option>-->
       <!--                                             <option value="04">April</option>-->
       <!--                                             <option value="05">May</option>-->
       <!--                                             <option value="06">June</option>-->
       <!--                                             <option value="07">July</option>-->
       <!--                                             <option value="08">August</option>-->
       <!--                                             <option value="09">September</option>-->
       <!--                                             <option value="10">October</option>-->
       <!--                                             <option value="11">November</option>-->
       <!--                                             <option value="12">December</option>-->
       <!--                                         </select>-->
       <!--                                     </div>-->

       <!--                                     @if ($errors->has('start_month'))-->
       <!--                                         <div class="" style="color:red">{{ $errors->first('start_month') }}</div>-->
       <!--                                     @endif-->

       <!--                                 </div>-->
       <!--                             </div>-->

       <!--                             <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">-->
       <!--                                 <div class="form-group">-->
       <!--                                     <label> End Month</label>-->
       <!--                                     <div class="input-group">-->
       <!--                                         <div class="input-group-prepend">-->
       <!--                                             <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>-->
       <!--                                         </div>-->
       <!--                                         <select class="form-control selectpicker" data-live-search="true" required name="end_month">-->
       <!--                                             <option value="{{ old('end_month') }}"> {{ old('end_month') ?? '-- Select End Month --' }} </option>-->
       <!--                                             <option value=""> </option>-->
       <!--                                             <option value="01">January</option>-->
       <!--                                             <option value="02">February</option>-->
       <!--                                             <option value="03">March</option>-->
       <!--                                             <option value="04">April</option>-->
       <!--                                             <option value="05">May</option>-->
       <!--                                             <option value="06">June</option>-->
       <!--                                             <option value="07">July</option>-->
       <!--                                             <option value="08">August</option>-->
       <!--                                             <option value="09">September</option>-->
       <!--                                             <option value="10">October</option>-->
       <!--                                             <option value="11">November</option>-->
       <!--                                             <option value="12">December</option>-->
       <!--                                         </select>-->
       <!--                                     </div>-->

       <!--                                     @if ($errors->has('end_month'))-->
       <!--                                         <div class="" style="color:red">{{ $errors->first('end_month') }}</div>-->
       <!--                                     @endif-->

       <!--                                 </div>-->
       <!--                             </div>-->
                                    
       <!--                             <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">-->
       <!--                                 <div class="form-group">-->
       <!--                                     <button class="btn btn-primary" type="submit" title="Click the button to create report" style="float: right;">Create Report</button>-->
       <!--                                 </div>-->
       <!--                             </div>-->
       <!--                         </div>-->
       <!--                     </form>-->

       <!--                 </div>-->
       <!--             </div>-->
       <!--         </div>-->

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                            <h6 style="text-align:center; padding:1%;"><b> RFQs from 1st Jan, <?php echo now()->year; ?> - <?php echo date('jS F, Y'); ?> </b></h6>
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
                            <h6 style="text-align:center; padding:1%;"><b> POs for 1st Jan, <?php echo now()->year; ?> - <?php echo date('jS F, Y'); ?> </b></h6>
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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                
                                <div class="table table-bordered">
                            <h5 style="text-align:center; vertical-align:center; padding:1%;"><b> TAG Year  to Date List of RFQ's & PO's for <?php echo date('Y'); ?> </b></h5>
                                    <table id="fixedHeader" class="monthlytable table">
                                    <thead style="color:black; font-weight:bold !important;"> <!-- Top-level header -->
                                    <tr>
                                    <th colspan="1" style="text-align:center; background-color:white;"></th>
                                    <th colspan="2" style="text-align:center; background-color:#8ea9db; border: 1px solid #000; font-weight: bold;">NLNG</th>
                                    <th colspan="2" style="text-align:center; background-color:#f4b084; border: 1px solid #000; font-weight: bold;">TOTAL</th>
                                    <th colspan="2" style="text-align:center; background-color:#ffd966; border: 1px solid #000; font-weight: bold;">SHELL</th>
                                    <th colspan="2" style="text-align:center; background-color:#00b0f0; border: 1px solid #000; font-weight: bold;">SAIPEM</th>
                                    <th colspan="2" style="text-align:center; background-color:#a5a5a5; border: 1px solid #000; font-weight: bold;">DAEWOO</th>
                                    </tr>
                                    <tr>
                                    <th style="text-align:center; background-color:white; font-weight: bold;">PRODUCTS</th>
                                    <th style="text-align:center; background-color:#8ea9db; border: 1px solid #000; font-weight: bold;">RFQ RECEIVED</th>
                                    <th style="text-align:center; background-color:#8ea9db; border: 1px solid #000; font-weight: bold;">PO RECEIVED</th>
                                    <th style="text-align:center; background-color:#f4b084; border: 1px solid #000; font-weight: bold;">RFQ RECEIVED</th>
                                    <th style="text-align:center; background-color:#f4b084; border: 1px solid #000; font-weight: bold;">PO RECEIVED</th>
                                    <th style="text-align:center; background-color:#ffd966; border: 1px solid #000; font-weight: bold;">RFQ RECEIVED</th>
                                    <th style="text-align:center; background-color:#ffd966; border: 1px solid #000; font-weight: bold;">PO RECEIVED</th>
                                    <th style="text-align:center; background-color:#00b0f0; border: 1px solid #000; font-weight: bold;">RFQ RECEIVED</th>
                                    <th style="text-align:center; background-color:#00b0f0; border: 1px solid #000; font-weight: bold;">PO RECEIVED</th>
                                    <th style="text-align:center;background-color:#a5a5a5; border: 1px solid #000; font-weight: bold;">RFQ RECEIVED</th>
                                    <th style="text-align:center;background-color:#a5a5a5; border: 1px solid #000; font-weight: bold;">PO RECEIVED</th>
                                    </tr>

                                </thead>
                                        <tbody>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">VALVES</td>
                                        <td>{{ count(getValveRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getValvePo('114')) ?? 0 }}</td>
                                        <td>{{ count(getValveRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getValvePo('148')) ?? 0 }}</td>
                                        <td>{{ count(getValveRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getValvePo('2')) ?? 0 }}</td>
                                        <td>{{ count(getValveRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getValvePo('266')) ?? 0 }}</td>
                                        <td>{{ count(getValveRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getValvePo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">GASKET</td>
                                        <td>{{ count(getGasketRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getGasketPo('114')) ?? 0 }}</td>
                                        <td>{{ count(getGasketRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getGasketPo('148')) ?? 0 }}</td>
                                        <td>{{ count(getGasketRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getGasketPo('2')) ?? 0 }}</td>
                                        <td>{{ count(getGasketRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getGasketPo('266')) ?? 0 }}</td>
                                        <td>{{ count(getGasketRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getGasketPo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">BOLTS & NUTS</td>
                                        <td>{{ count(getBoltAndNutRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutPo('114')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutPo('148')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutPo('2')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutPo('266')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getBoltAndNutPo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">FLANGES</td>
                                        <td>{{ count(getFlangesRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesPo('114')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesPo('148')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesPo('2')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesPo('266')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getFlangesPo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">PIPES & FITTINGS</td>
                                        <td>{{ count(getPipeRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getPipePo('114')) ?? 0 }}</td>
                                        <td>{{ count(getPipeRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getPipePo('148')) ?? 0 }}</td>
                                        <td>{{ count(getPipeRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getPipePo('2')) ?? 0 }}</td>
                                        <td>{{ count(getPipeRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getPipePo('266')) ?? 0 }}</td>
                                        <td>{{ count(getPipeRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getPipePo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">ROTORK ACTUATOR & GEARBOX</td>
                                        <td>{{ count(getRotorkRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkPo('114')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkPo('148')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkPo('2')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkPo('266')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getRotorkPo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">OTHERS (REGULATOR, TUBE, SLABS, ETC)</td>
                                        <td>{{ count(getOtherRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getOtherPo('114')) ?? 0 }}</td>
                                        <td>{{ count(getOtherRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getOtherPo('148')) ?? 0 }}</td>
                                        <td>{{ count(getOtherRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getOtherPo('2')) ?? 0 }}</td>
                                        <td>{{ count(getOtherRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getOtherPo('266')) ?? 0 }}</td>
                                        <td>{{ count(getOtherRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getOtherPo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">FLANGE MANAGEMENT SERVICES</td>
                                        <td>{{ count(getFMSRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getFMSPo('114')) ?? 0 }}</td>
                                        <td>{{ count(getFMSRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getFMSPo('148')) ?? 0 }}</td>
                                        <td>{{ count(getFMSRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getFMSPo('2')) ?? 0 }}</td>
                                        <td>{{ count(getFMSRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getFMSPo('266')) ?? 0 }}</td>
                                        <td>{{ count(getFMSRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getFMSPo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">TOTAL</td>
                                        <td>{{ count(getTotalRfq('114')) ?? 0 }}</td>
                                        <td>{{ count(getTotalPo('114')) ?? 0 }}</td>
                                        <td>{{ count(getTotalRfq('148')) ?? 0 }}</td>
                                        <td>{{ count(getTotalPo('148')) ?? 0 }}</td>
                                        <td>{{ count(getTotalRfq('2')) ?? 0 }}</td>
                                        <td>{{ count(getTotalPo('2')) ?? 0 }}</td>
                                        <td>{{ count(getTotalRfq('266')) ?? 0 }}</td>
                                        <td>{{ count(getTotalPo('266')) ?? 0 }}</td>
                                        <td>{{ count(getTotalRfq('167')) ?? 0 }}</td>
                                        <td>{{ count(getTotalPo('167')) ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">PO Conversion Rate</td>
                                        <td colspan="2" style="text-align:center; font-weight:bold;">{{ (count(getTotalRfq('114')) > 0) ? number_format((count(getTotalPo('114')) / count(getTotalRfq('114')) * 100), 2) : 0.00 }}%</td>
                                        <td colspan="2" style="text-align:center; font-weight:bold;">{{ (count(getTotalRfq('148')) > 0) ? number_format((count(getTotalPo('148')) / count(getTotalRfq('148')) * 100), 2) : 0.00 }}%</td>
                                        <td colspan="2" style="text-align:center; font-weight:bold;">{{ (count(getTotalRfq('2')) > 0) ? number_format((count(getTotalPo('2')) / count(getTotalRfq('2')) * 100), 2) : 0.00}}%</td>
                                        <td colspan="2" style="text-align:center; font-weight:bold;">{{ (count(getTotalRfq('266')) > 0) ? number_format((count(getTotalPo('266')) / count(getTotalRfq('266')) * 100), 2) : 0.00 }}%</td>
                                        <td colspan="2" style="text-align:center; font-weight:bold;">{{ (count(getTotalRfq('167')) > 0) ? number_format((count(getTotalPo('167')) / count(getTotalRfq('167')) * 100), 2) : 0.00 }}%</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="form-group">
                            <!-- <a href="{{ route('po.report.sendRfqPoMonthlyReport') }}" class="btn btn-primary" style="float: right;">Send RFQs & POs Monthly Report</a> -->
                            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#customModals">Send RFQs & POs Monthly Report</button> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b>TAG List of Saipem Bids</b></h6>
                                <div class="table-responsive">
									<table class="table m-0">
                                        <thead class=" text-white">
                                            <tr>
                                                
                                                <th>S/N</th>
                                                <th>TAG REF NUMBER</th>
                                                <th>SAIPEM RFQ NUMBER</th>
                                                <th> BUYER </th>
                                                <th>PRODUCTS</th>
                                                <th>PROJECT NAME</th>
                                                <th>CLIENT NAME</th>
                                                <th>DATE RECEIVED</th>
                                                <th>DUE DATE</th>
                                                <th>VALUE</th>
                                                <th>STATUS</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num = 1 ?>
                                            @foreach ($saipem as $saipem_details)
                                                <tr>
                                                    <td>{{ $num++}}</td>
                                                    <td>{{ $saipem_details->rfq_number}}</td>
                                                    <td>{{ $saipem_details->refrence_no}}</td>
                                                    <td>{{ fbuyers($saipem_details->contact_id)->first_name . ' ' . fbuyers($saipem_details->contact_id)->last_name }}</td>
                                                    <td>{{ $saipem_details->product}}</td>
                                                    <td>{{ $saipem_details->description}}</td>
                                                    <td>{{ $saipem_details->client->client_name}}</td>
                                                    <td>{{ $saipem_details->rfq_date}}</td>
                                                    <td>{{ $saipem_details->delivery_due_date}}</td>
                                                    <td>{{ $saipem_details->total_quote}}</td>
                                                    <td>{{ $saipem_details->status}}</td>
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
                            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#SaipemModals">Send Saipem Report</button> 
                        <!-- <A href="{{ route('po.report.sendReport') }}" class="btn btn-primary" style="float: right;">Send Report</a> -->
                            
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
            <form action="{{ route('po.report.sendRfqPoMonthlyReport') }}" class="" method="POST" enctype="multipart/form-data">
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



<div class="modal fade bd-example-modal-lg" id="SaipemModals" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Send Monthly Saipem bids Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('po.report.sendSaipemReport') }}" class="" method="POST" enctype="multipart/form-data">
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
