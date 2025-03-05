<?php $title = 'Generate Custom Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('po.report.index') }}">Report</a></li>

                <li class="breadcrumb-item">Generate Client PO Report</li>
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
                                <form action="{{ route('po.report.ClientPoEdit') }}" method="GET" class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> Client </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>
                                                @php
                                                $client
                                                @endphp
                                                <select class="form-control selectpicker" data-live-search="true" required name="client">
                                                        <option value="{{ isset($client[0]) ? $client[0]->client_id ?? '' : '' }}"> {{ isset($client[0]) && $client[0]->client_id ? optional(json_decode(clis($client[0]->client_id))[0])->client_name ?? '-- Select Client --'
        : '-- Select Client --' }} </option>
                                                @foreach($clients as $cli)
                                                    <option value="{{ $cli->client_id }}"> {{ $cli->client_name }} </option>
                                                @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has('end_month'))
                                                <div class="" style="color:red">{{ $errors->first('end_month') }}</div>
                                            @endif
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create report" style="float: right;">Fetch Report</button>
                                        </div>
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

@if ($client != null)

                <!-- PO Status Table -->

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                
                                <div class="table-responsive">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b> {{ $clients_det->client_name}} PO Status update for <?php echo date('Y'); ?> </b></h6>
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th> PO No </th>
                                                <th>PO Issued to <br/> Supplier Date</th>
                                                <th> Delivery Date </th>
                                                <th>Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($client as $client_detail)
                                                <tr> 
                                                    <td>{{ $num++ }} </td>
                                                    <td>{{ $client_detail->po_number }} </td>
                                                    <td> {{ $client_detail->supplier_issued_date}}</td>
                                                    <td> {{ $client_detail->delivery_due_date}}</td>
                                                    <td> {{ $client_detail->status}} <br/> 
                                                    @php
                                                        $notesArray = explode('.', $client_detail->note);
                                                        $firstParagraphContent = strip_tags($notesArray[0]);
                                                    @endphp
                                                    <p>{!! $firstParagraphContent !!}.</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Po Status Table-->


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
    <div class="modal fade bd-example-modal-lg" id="WeeklyReport" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel" style="color: white;">Send Custom Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('po.report.sendClientPoReport') }}" class="" method="POST" enctype="multipart/form-data">
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
                            <!-- <input type="text" class="form-control" id="recipient-email" name="quotation_recipient" value="contact@tagenergygroup.net; sales@tagenergygroup.net" readonly> -->
                            <input type="text" class="form-control" id="recipient-email" name="report_recipient" value="sales@tagenergygroup.net; mary.erengwa@tagenergygroup.net">
                            @if ($errors->has('report_recipient'))
                                <div class="" style="color:red">{{ $errors->first('quotation_recipient') }}</div>
                            @endif

                            <input type="text" class="form-control" id="client-id" name="client" value="{{ $client_id }}" hidden>

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
