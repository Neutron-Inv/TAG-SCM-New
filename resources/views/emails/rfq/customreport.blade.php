
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/design.css')}}">
<style>
hr {
    margin-top: 25px;
    margin-bottom: 25px;
}
</style>    
</head>
    <body background-color="white" style="background: white !important;">
        
        <div class="row" style="background: white !important;margin-left:3% !important;">
            
            <div class="col-lg-12" style="background: white !important;">
                <div class="mb-0" style="background: white !important;">
                    <div style="width: 100%; background: white !important; color: black;">
                        <div style="max-width: 90%; font-size: 14px; background: white !important;">
                                                   
                            
                            <div style="background: white !important;">
                                                <p style="font-size: 9.0pt;font-family: Calibri, sans-serif;"> 
                                                    Dear Sir/Madam,<br/>
                        							<br>Good day, I trust this mail finds you well.<br/>
                                                    <br/>Please see Custom Report on {{ json_decode(clis($client))[0]->client_name ?? 'Client' }} from {{ \Carbon\Carbon::parse(session('start_date', $start_date))->format('jS F, Y')}} to {{ \Carbon\Carbon::parse(session('end_date', $end_date))->format('jS F, Y')}} for your use.
                                                </p><br/>

            <!-- Bootstrap Table with Caption -->
            <div class="main-container">
@php
    $client = session('client') ?? $client;
    $rfqtotal = session('rfqtotal') ?? $rfqtotal;
    $pototal = session('pototal') ?? $pototal;
    $rfq = session('rfq') ?? $rfq;
    $po = session('po') ?? $rfq;
    $clients = session('clients') ?? $clients;
    if($start_date){
        $start = \Carbon\Carbon::parse($start_date)->format('Y-m-d');
    }else{
        $start = '';
    }
    if($end_date){
        $end = \Carbon\Carbon::parse($end_date)->format('Y-m-d');
    }else{
        $end = '';
    }
@endphp
 <div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="table-container">
                @if(isset($client))
                    <h6 style="text-align:center; padding:1%; font-size: 9.0pt;"><b> RFQs for {{ \Carbon\Carbon::parse(session('start_date', $start_date))->format('jS F, Y')}} to {{ \Carbon\Carbon::parse(session('end_date', $end_date))->format('jS F, Y')}} </b></h6>
                @else
                    <h6 style="text-align:center; padding:1%; font-size: 9.0pt;"><b> RFQs for {{ \Carbon\Carbon::parse(session('start_date', $start_date))->format('jS F, Y')}} to {{ \Carbon\Carbon::parse(session('end_date', $end_date))->format('jS F, Y')}} </b></h6>
                @endif
                        <div class="table-responsive">
                        <table class="table m-0" style="border-collapse: collapse; width: 100%;color:black !important;">
                            <thead class="text-white">
                                <tr>
                                    <th style="width: 40%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">S/N</th>
                                    <th style="width: 40%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">COMPANY</th>
                                    <th style="width: 40%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">NUMBER OF RFQ RECEIVED</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @foreach ($rfq as $rfq_detail)
                                    <tr>
                                        <td style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $num++ }}</td>
                                        <td class="text-align" style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $rfq_detail->client->client_name }}</td>
                                        <td class="text-align" style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $rfq_detail->count }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"></td>
                                    <td style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">Total RFQs</td>
                                    <td style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $rfqtotal }}</td>
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
                    <h6 style="text-align:center; padding:1%; font-size: 9.0pt;"><b> POs for {{ \Carbon\Carbon::parse(session('start_date', $start_date))->format('jS F, Y')}} to {{ \Carbon\Carbon::parse(session('end_date', $end_date))->format('jS F, Y')}} </b></h6>
                        <div class="table-responsive">
                            <table class="table m-0" style="border-collapse: collapse; width: 100%; color:black !important;">
                                <thead class="text-white">
                                    <tr>
                                        <th  style=" width: 40%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt;font-family: Calibri, sans-serif;">S/N</th>
                                        <th  style=" width: 40%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt;font-family: Calibri, sans-serif;">COMPANY</th>
                                        <th  style=" width: 40%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt;font-family: Calibri, sans-serif;">NUMBER OF PO RECEIVED </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $num =1; ?>
                                    @foreach ($po as $po_detail)
                                    <tr>
                                    <td style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"> {{ $num++ }} </td>
                                    <td class="text-align" style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"> {{ $po_detail->client->client_name }} </td>
                                    <td class="text-align" style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $po_detail->count }} </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td  style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"></td>
                                        <td  style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"> Total PO(s) </td>
                                        <td  style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $pototal }}</td>
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
                    <h5 style="text-align:center; vertical-align:center; padding:1%;"><b>  RFQ's & PO's for {{ json_decode(clis($client))[0]->client_name ?? 'Client' }} from {{ \Carbon\Carbon::parse(session('start_date', $start_date))->format('jS F, Y')}} to {{ \Carbon\Carbon::parse(session('end_date', $end_date))->format('jS F, Y')}} </b></h5>
                    <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%; font-size: 9.0pt !important; color:black !important;">
                    <thead style="color: black; font-weight: bold;"> <!-- Top-level header -->
                            <tr>
                            <th colspan="1" style="text-align: center; background-color: white;"></th>
                            <th colspan="2" style="text-align: center; background-color: #8ea9db;">{{ json_decode(clis($client))[0]->client_name ?? 'Client' }}</th>
                            </tr>
                            <tr>
                            <th style="text-align: left; background-color: white; font-weight: bold;">PRODUCTS</th>
                            <th style="text-align: center; background-color: #8ea9db;">RFQ RECEIVED</th>
                            <th style="text-align: center; background-color: #8ea9db;">PO RECEIVED</th>
                            </tr>
                        </thead>
                        <tbody>
<tr>
<td style="font-weight: bold; text-align: left;font-size: 9.0pt;">VALVES</td>
<td style="text-align: center;font-size: 9.0pt;">{{ count(getValveRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center;font-size: 9.0pt;">{{ count(getValvePoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight: bold; text-align: left;font-size: 9.0pt;">GASKET</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getGasketRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getGasketPoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">BOLTS & NUTS</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getBoltAndNutRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getBoltAndNutPoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">FLANGES</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getFlangesRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getFlangesPoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">PIPES & FITTINGS</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getPipeRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getPipePoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">ROTORK ACTUATOR & GEARBOX</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getRotorkRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getRotorkPoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">OTHERS (REGULATOR, TUBE, SLABS, ETC)</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getOtherRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getOtherPoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">FLANGE MANAGEMENT SERVICES</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getFMSRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getFMSPoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">TOTAL</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getTotalRfqc($client, $start_date, $end_date)) ?? 0 }}</td>
<td style="text-align: center; font-size: 9.0pt;">{{ count(getTotalPoc($client, $start_date, $end_date)) ?? 0 }}</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:left; font-size: 9.0pt;">PO Conversion Rate</td>
<td colspan="2" style="text-align:center; font-weight:bold; font-size: 9.0pt;">
    {{ (count(getTotalRfqc($client, $start_date, $end_date)) > 0) ? (count(getTotalPoc($client, $start_date, $end_date)) / count(getTotalRfqc($client, $start_date, $end_date)) * 100) : 0 }}%
</td>
</tr>
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
                        <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%; font-size: 10.0pt;"><b>TAG List of {{ json_decode(clis($client))[0]->client_name ?? 'Client' }} RFQs for {{ \Carbon\Carbon::parse(session('start_date', $start_date))->format('jS F, Y')}} to {{ \Carbon\Carbon::parse(session('end_date', $end_date))->format('jS F, Y')}}</b></h6>
                        <div class="table-responsive">
                        <table class="table m-0 fixed-height-table" style="border-collapse: collapse; width: 100%;color:black !important;">
                            <thead class="text-white">
                                <tr>
                                    <th style="width: 5%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">S/N</th>
                                    <th style="width: 10%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">TAG REF NUMBER</th>
                                    <th style="width: 15%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ json_decode(clis($client))[0]->client_name ?? 'Client' }} RFQ NUMBER</th>
                                    <th style="width: 10%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">BUYER</th>
                                    <th style="width: 15%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">PRODUCTS</th>
                                    <th style="width: 15%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">PROJECT NAME</th>
                                    <th style="width: 10%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">DATE RECEIVED</th>
                                    <th style="width: 10%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">DUE DATE</th>
                                    <th style="width: 10%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">VALUE</th>
                                    <th style="width: 10%; padding:1px 4px; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">STATUS</th>
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
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $num++}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->rfq_number}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->refrence_no}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ fbuyers($client_rfq->contact_id)->first_name ?? '' }} {{fbuyers($client_rfq->contact_id)->last_name ?? '' }}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->product}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->description}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->rfq_date}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->delivery_due_date}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->total_quote}}</td>
                                        <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_rfq->status}}</td>
                                    </tr>
                                @endforeach
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
                        <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%; font-size: 10.0pt;"><b>TAG List of {{ json_decode(clis($client))[0]->client_name ?? 'Client' }} POs for {{ \Carbon\Carbon::parse(session('start_date', $start_date))->format('jS F, Y')}} to {{ \Carbon\Carbon::parse(session('end_date', $end_date))->format('jS F, Y')}}</b></h6>
                        <table id="fixedHeader" class="table fixed-height-table" style="border-collapse: collapse; width: 100%;">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th style="width: 5%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">S/N</th>
                                            <th style="width: 10%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">STATUS</th>
                                            <th style="width: 10%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">PO NUMBER</th>
                                            <th style="width: 15%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ json_decode(clis($client))[0]->short_code ?? 'Client' }} RFQ NUMBER</th>
                                            <th style="width: 15%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">VALUE</th>
                                            <th style="width: 10%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">BUYER</th>
                                            <th style="width: 15%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">DESCRIPTION</th>
                                            <th style="width: 10%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">DATE RECEIVED</th>
                                            <th style="width: 10%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">DELIVERY DUE DATE</th>
                                            <th style="width: 10%; text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">ASSIGNED TO</th>
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
                                            <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $num++}}</td>
                                            <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $po_item->status}}</td>
                                            <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $po_item->po_number}}</td>
                                            <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $po_item->rfq_number}}</td>
                                            <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">
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
                                            <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ fbuyers($po_item->contact_id)->first_name ?? '' }} {{fbuyers($po_item->contact_id)->last_name ?? '' }}</td>
                                            <td style="text-align: center; border: 1px solid black; white-space: nowrap; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $po_item->description}}</td>
                                            <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $po_item->po_date}}</td>
                                            <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $po_item->delivery_due_date}}</td>
                                            <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">
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
        </div>
         </div>
        </div>
        <br/>
                                                <hr>


                                                <p style="font-size: 9.0pt;font-family: Calibri, sans-serif;">
                                                Thank you. <br/>
                                                </p><br><br>
                                                <p style="font-size: 8.5pt;font-family: Arial,sans-serif; color: #1F497D;">Best Regards,<br> {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, <br> SCM Associate <br>
                                                    PHONE</span></b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                        : +234 1 342 8420&nbsp;| </span>
                                                        <span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                                                        +234 906 243 5410&nbsp; </span><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                    </span><br><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864">
                                                        </span></b></a>
                                                    </span>

                                                </p>
                                                <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
                                                <div style="text-align: center; font-size: 9px; color: #ffffff; background-color: white;" >
                                                    <p style="color: black; font-size: 9px;">
                                                        &copy; Enabled Business Solution - All rights reserved.
                                                        
                                                    </p>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    </td>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
</body>
</html>
            
