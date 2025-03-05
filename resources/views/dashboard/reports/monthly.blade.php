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
                        <div class="card-body" style="max-height:500px; min-height:500px; overflow-y: auto;">
                            
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
                        <div class="card-body" style="max-height:500px; min-height:500px; overflow-y: auto;">
                            
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
                                        <th colspan="2" style="text-align:center; background-color:#8ea9db; border: 1px solid #000; font-weight: bold;">
                                            {{ isset($topclients[0]) ? optional(clis($topclients[0])[0])->client_name : '' }}
                                        </th>
                                        <th colspan="2" style="text-align:center; background-color:#f4b084; border: 1px solid #000; font-weight: bold;">
                                            {{ isset($topclients[1]) ? optional(clis($topclients[1])[0])->client_name : '' }}
                                        </th>
                                        <th colspan="2" style="text-align:center; background-color:#ffd966; border: 1px solid #000; font-weight: bold;">
                                            {{ isset($topclients[2]) ? optional(clis($topclients[2])[0])->client_name : '' }}
                                        </th>
                                        <th colspan="2" style="text-align:center; background-color:#00b0f0; border: 1px solid #000; font-weight: bold;">
                                            {{ isset($topclients[3]) ? optional(clis($topclients[3])[0])->client_name : '' }}
                                        </th>
                                        <th colspan="2" style="text-align:center; background-color:#a5a5a5; border: 1px solid #000; font-weight: bold;">
                                            {{ isset($topclients[4]) ? optional(clis($topclients[4])[0])->client_name : '' }}
                                        </th>
                                    </tr>

                                    <tr>
                                    <th style="text-align:center; background-color:white; color:grey; font-weight: bold;">PRODUCTS</th>
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
                                        @foreach($product as $item)
                                        
                                        <tr>
                                            <td style="font-weight:bold;text-align:left;">{{$item}}</td>
                                            <td>{{ isset($topclients[0]) ? count(getProductRfq($topclients[0], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[0]) ? count(getProductPo($topclients[0], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[1]) ? count(getProductRfq($topclients[1], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[1]) ? count(getProductPo($topclients[1], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[2]) ? count(getProductRfq($topclients[2], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[2]) ? count(getProductPo($topclients[2], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[3]) ? count(getProductRfq($topclients[3], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[3]) ? count(getProductPo($topclients[3], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[4]) ? count(getProductRfq($topclients[4], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[4]) ? count(getProductPo($topclients[4], $item) ?? []) : 0 }}</td>
                                        </tr>

                                        @endforeach
                                        
                                        
                                        <tr>
                                        <td style="font-weight:bold;text-align:left;">TOTAL</td>
                                        <td>{{ isset($topclients[0]) ? count(getTotalRfq($topclients[0], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[0]) ? count(getTotalPo($topclients[0], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[1]) ? count(getTotalRfq($topclients[1], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[1]) ? count(getTotalPo($topclients[1], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[2]) ? count(getTotalRfq($topclients[2], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[2]) ? count(getTotalPo($topclients[2], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[3]) ? count(getTotalRfq($topclients[3], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[3]) ? count(getTotalPo($topclients[3], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[4]) ? count(getTotalRfq($topclients[4], $item) ?? []) : 0 }}</td>
                                            <td>{{ isset($topclients[4]) ? count(getTotalPo($topclients[4], $item) ?? []) : 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;text-align:left;">PO Conversion Rate</td>
                                            <td colspan="2" style="text-align:center; font-weight:bold;">
                                                {{ isset($topclients[0]) && count($rfq = getTotalRfq($topclients[0]) ?? []) > 0 
                                                    ? number_format((count($po = getTotalPo($topclients[0]) ?? []) / count($rfq) * 100), 2) 
                                                    : 0.00 }}%
                                            </td>
                                            <td colspan="2" style="text-align:center; font-weight:bold;">
                                                {{ isset($topclients[1]) && count($rfq = getTotalRfq($topclients[1]) ?? []) > 0 
                                                    ? number_format((count($po = getTotalPo($topclients[1]) ?? []) / count($rfq) * 100), 2) 
                                                    : 0.00 }}%
                                            </td>
                                            <td colspan="2" style="text-align:center; font-weight:bold;">
                                                {{ isset($topclients[2]) && count($rfq = getTotalRfq($topclients[2]) ?? []) > 0 
                                                    ? number_format((count($po = getTotalPo($topclients[2]) ?? []) / count($rfq) * 100), 2) 
                                                    : 0.00 }}%
                                            </td>
                                            <td colspan="2" style="text-align:center; font-weight:bold;">
                                                {{ isset($topclients[3]) && count($rfq = getTotalRfq($topclients[3]) ?? []) > 0 
                                                    ? number_format((count($po = getTotalPo($topclients[3]) ?? []) / count($rfq) * 100), 2) 
                                                    : 0.00 }}%
                                            </td>
                                            <td colspan="2" style="text-align:center; font-weight:bold;">
                                                {{ isset($topclients[4]) && count($rfq = getTotalRfq($topclients[4]) ?? []) > 0 
                                                    ? number_format((count($po = getTotalPo($topclients[4]) ?? []) / count($rfq) * 100), 2) 
                                                    : 0.00 }}%
                                            </td>
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
                
                <br/>
                <br/>
                <br/>
                <br/>
@php
if(Auth::user()->hasRole('SuperAdmin')){
$company_idtp = '2';
}elseif(Auth::user()->hasRole('Admin')){
$company_idtp = json_decode(companyByMail(Auth::user()->email));
}else{
$company_idtp = json_decode(empDet(Auth::user()->email))[0]->company_id;
}

if($company_idtp == 2){
$hidden = "";
}else{
$hidden = "hidden";
}
@endphp
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" {{$hidden}}>
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b>TAG List of Saipem Bids</b></h6>
                                <div class="table-responsive">
									<table id="fixedHeader" class="table">
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
                                                    <td>{{ $saipem_details->refrence_no}}</td>
                                                    <td>{{ $saipem_details->rfq_number}}</td>
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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="form-group">
                            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#SaipemModals">Send Saipem Report</button> 
                        <!-- <A href="{{ route('po.report.sendReport') }}" class="btn btn-primary" style="float: right;">Send Report</a> -->
                            
                    </div>
                </div>
                        </div>
                    </div>
                </div>

                
                
                <br/>
                <br/>
                <br/>
                <br/>
                
                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" {{$hidden}}>
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b>TAG BHA Bids</b></h6>
                                <div class="table-responsive">
									<table id="basicExample" class="table">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                
                                                <th>S/N</th>
                                                <th>TAG REF NUMBER</th>
                                                <th>CLIENT RFQ/PO NUMBER</th>
                                                <th> BUYER </th>
                                                <th>PROJECT NAME</th>
                                                <th>CLIENT NAME</th>
                                                <th>DATE RECEIVED</th>
                                                <th>DUE DATE</th>
                                                <th>PO DATE</th>
                                                <th>VALUE</th>
                                                <th>STATUS</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num = 1 ?>
                                            @foreach ($bha as $saipem_details)
                                                <tr>
                                                    <td>{{ $num++}}</td>
                                                    <td>{{ $saipem_details->refrence_no}}</td>
                                                    <td>
                                                        @if($saipem_details->status == "PO Issued")
                                        {{ $saipem_details->po_number}}
                                        @else
                                        {{ $saipem_details->rfq_number}}
                                        @endif
                                                        </td>
                                                    <td>{{ fbuyers($saipem_details->contact_id)->first_name . ' ' . fbuyers($saipem_details->contact_id)->last_name }}</td>
                                                    <td>{{ $saipem_details->description}}</td>
                                                    <td>{{ $saipem_details->client->client_name}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($saipem_details->rfq_date)->format('d-M-Y')}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($saipem_details->delivery_due_date)->format('d-M-Y') }}</td>
                                                    <td>{{ $saipem_details->po_date ? \Carbon\Carbon::parse($saipem_details->po_date)->format('d-M-Y') : '' }}
                                                    </td>
                                                    <td>
                                        @if($saipem_details->currency == "NGN")
                                        <?php $symbol = "₦"; ?>
                                        @elseif($saipem_details->currency == "USD")
                                        <?php $symbol = "$"; ?>
                                        @elseif($saipem_details->currency == "EUR")
                                        <?php $symbol = "€"; ?>
                                        @elseif($saipem_details->currency == "GBP")
                                        <?php $symbol = "£"; ?>
                                        @endif
                                        
                                        @if($saipem_details->status == 'PO Issued')
                                        {{ $symbol.number_format($saipem_details->po_value_foreign, 2)}}
                                        
                                        @else
                                        
                                        @if($saipem_details->total_quote > 1)
                                        {{$symbol.number_format($saipem_details->total_quote,2)}}
                                        @else
                                        TBD
                                        @endif
                                        
                                        @endif
                                        </td>
                                        <td>
                                        @if($saipem_details->status == "PO Issued")
                                        {{ $saipem_details->po_status}}
                                        @else
                                        {{ $saipem_details->status}}
                                        @endif
                                        </td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                    <div class="form-group">
                            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#BHAModals">Send BHA Report</button> 
                        <!-- <A href="{{ route('po.report.sendReport') }}" class="btn btn-primary" style="float: right;">Send Report</a> -->
                            
                    </div>
                </div>
                        </div>
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

<div class="modal fade bd-example-modal-lg" id="BHAModals" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Send BHA bids Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('po.report.sendBHAReport') }}" class="" method="POST" enctype="multipart/form-data">
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
