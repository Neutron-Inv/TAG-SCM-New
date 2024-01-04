<?php $title = 'Generate Yearly Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('po.report.index') }}">Report</a></li>

                <li class="breadcrumb-item">Generate Weekly Report</li>
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
                            <h6 style="text-align:center; padding:1%;"><b> RFQs for <?php echo now()->startOfWeek()->format('jS F, Y'); ?> to <?php echo now()->startOfWeek()->addDays(4)->format('jS F, Y'); ?> </b></h6>
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
                            <h6 style="text-align:center; padding:1%;"><b> POs for <?php echo now()->startOfWeek()->format('jS F, Y'); ?> to <?php echo now()->startOfWeek()->addDays(4)->format('jS F, Y'); ?> </b></h6>
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
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                
                                <div class="table-responsive">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b> NLNG PO Status update for <?php echo date('Y'); ?> </b></h6>
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th> PO No </th>
                                                <th> Delivery Date </th>
                                                <th>Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($nlng as $nlng_detail)
                                                <tr> 
                                                    <td>{{ $num++ }} </td>
                                                    <td>{{ $nlng_detail->po_number }} </td>
                                                    <td> {{ $nlng_detail->delivery_due_date}}</td>
                                                    <td> {{ $nlng_detail->status}}</td>
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
                                <h6 class="table-title" style="text-align:center; padding:1%;">Outstanding GRN</h6>
                                <div class="table-responsive">
									<table class="table m-0">
                                        <thead class=" text-white">
                                        <tr>
                                            <th>S/N</th>
                                            <th>PO NO. </th>
                                            <th>CLIENT</th>
                                            <th>DELIVERY DATE</th>
                                            <th>EXPECTED DELIVERY</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 1; ?>
                                            @foreach ($grn as $item)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td> {{ $item->po_number }}</td>
                                                    <td> {{ $item->client->client_name }}</td>
                                                    <td> {{ \Carbon\Carbon::parse($item->delivery_due_date)->format('d-m-Y') }}</td>
                                                    <td> {{ \Carbon\Carbon::parse($item->actual_delivery_date)->format('d-m-Y') }}</td>
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
                            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#WeeklyReport">Send Weekly Report</button>                             
                    </div>
                </div>
            </div>
         </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="WeeklyReport" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Send Weekly Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('po.report.sendWeeklyReport') }}" class="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="row gutters">
                        <div class="col-md-4 col-sm-4 col-4">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <!-- <input type="email" class="form-control" id="recipient-email" name="rec_email"
                            value="bidadmin@tagenergygroup.net" readonly> -->
                            <input type="email" class="form-control" id="recipient-email" name="rec_email"
                            value="emmanuel.idowu@tagenergygroup.net" readonly>
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
