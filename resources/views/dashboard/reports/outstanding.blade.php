<?php $title = 'Generate Yearly Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('po.report.index') }}">RFQ Report</a></li>

                <li class="breadcrumb-item">Oustanding RFQ Report</li>
            </ol>
            @include('layouts.logo')
        </div>

         <div class="content-wrapper">
             @include('layouts.alert')
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                
                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-success text-white">
                                            <tr style="background:#ed7d31;">
                                <td colspan="8" style="text-align:center; font-size: 14pt; color:black;"><b>LIST OF OUTSTANDING RFQs </b></td>
                                            </tr>
                                            <tr style="background:#5b9bd5;">
                                                <th>S/N</th>
                                                <th>RFQ NO</th>
                                                <th> Client Ref. No. </th>

                                                <th>CLIENT</th>
                                                <th>DESCRIPTION</th>

                                                <th>STATUS</th>
                                                <th>DEADLINE</th>

                                                <th>ASSIGNED TO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($rfqs as $rfq)
                                                <tr> 
                                                    <td style="background:#acb9ca;">{{ $num++ }} </td>
                                                    <td>{{ $rfq->refrence_no ?? 'Null' }} </td>
                                                    <td> {{ $rfq->rfq_number ?? ''}}</td>
                                                    <td> {{ $rfq->client->client_name ?? 'Null' }}</td>
                                                    <td> {{ $rfq->description ?? '' }}</td>

                                                    <td>{{ $rfq->status ?? ' ' }} </td>
                                                    <td style="white-space:nowrap;">{{ isset($rfq->delivery_due_date) ? date('d-m-Y', strtotime($rfq->delivery_due_date)) : ' ' }}</td>
                                                    <td> {{ empDetails($rfq->	employee_id)->full_name ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12" style="margin-bottom:10px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#customModals">Send Outstanding Report</button> 
                            
                    </div>
                </div>
            </div>
         </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="customModals" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customModalTwoLabel">Send Outstanding RFQs Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('po.report.sendOutstandingReport') }}" class="" method="POST" enctype="multipart/form-data">
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
