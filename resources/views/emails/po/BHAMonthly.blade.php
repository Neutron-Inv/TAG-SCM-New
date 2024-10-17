<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style type="text/css">
        .container {
            background: white;
            color: black !important;
            font-size:9pt !important;
        }

        .email-text {
            color: #1F497D !important;
            font-size:9pt !important;
        }

        .table {
            border-collapse: collapse;
            width: 93%;
            font-size:9pt !important;
        }

        .table th, .table td {
            border: 1px solid #000;
            color: #000 !important;
            padding: 5px 13px !important;
            font-size:9pt !important;
            text-align: center;
        }

        .table th {
            white-space: nowrap;
            background-color: white;
            font-weight: bold;
        }

        .table tbody {
            color: black;
        }

        p {
            font-size:9pt !important;
            line-height: 200;
            margin-bottom:0px;
        }

        .footey {
            color: #1F497D !important;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body style="background-color:white !important;">
    <div class="container">
        <p class="email-text">Good Day Sir,</p>
        <p class="email-text">I trust this mail meets you well.</p>
        <p class="email-text">Please see below list of BHA Bids from year till date.</p>
        <br/>
        <br/>
        <?php 
        $submitted = 0;
        $po_issued = 0;
        $po_canclled =0;
        $total_povalue = 0;
        $total_povalue_cancelled = 0;
        $submitted_value = 0;
        ?>
        
        @foreach ($bha as $bha_details)
        
        @if($bha_details->status == 'Quotation Submitted')
        @php 
        $submitted_value += $bha_details->total_quote;
        $submitted++ 
        @endphp
        @elseif($bha_details->status == 'PO Issued' && $bha_details->po_status != 'PO Cancelled')
        @php 
        
        $total_povalue += $bha_details->po_value_foreign;
        $po_issued++ @endphp
        @elseif($bha_details->status == 'PO Issued' && $bha_details->po_status == 'PO Cancelled')
        @php 
        
        $total_povalue_cancelled += $bha_details->po_value_foreign;
        $po_canclled++ @endphp
        @endif
        @endforeach
        <table class="table" style="width:30%; min-width:200px;">
        <thead>
            <tr>
                <th>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                <th style="background-color:#c2e4ff">Quotes Submitted (Pending POs)</th>
                <th style="background-color:#bdffab">PO Issued (Active)</th>
                <th style="background-color:#c8c8c8">PO Cancelled</th>
            </tr>
        </thead> 
        <tbody>
            <tr>
                <td >Total</td>
                <td>{{$submitted}}</td>
                <td>{{$po_issued}}</td>
                <td>{{$po_canclled}}</td>
            </tr>
            <tr>
                <td>Total Value</td>
                <td>${{number_format($submitted_value,2)}}</td>
                <td>${{number_format($total_povalue,2)}}</td>
                <td>${{number_format($total_povalue_cancelled,2)}}</td>
            </tr>
        </tbody>
        </table>
        <br/>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>TAG REF NUMBER</th>
                        <th>CLIENT RFQ/PO NUMBER</th>
                        <th>BUYER</th>
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
                    @foreach ($bha as $bha_details)
                    @php
                    $bg_color = "";
                    if($bha_details->status == "PO Issued" && $bha_details->po_status != "PO Cancelled"){
                    $bg_color = "#bdffab";
                    }elseif($bha_details->status == "PO Issued" && $bha_details->po_status == "PO Cancelled"){
                    $bg_color = "#c8c8c8";
                    }elseif($bha_details->status == "Quotation Submitted"){
                    $bg_color = "#c2e4ff";
                    }
                    @endphp
                        <tr style="background-color: {{ $bg_color }}">
                            <td>{{ $num++}}</td>
                            <td>{{ $bha_details->refrence_no}}</td>
                            <td>@if($bha_details->status == "PO Issued")
                                        {{ $bha_details->po_number}}
                                        @else
                                        {{ $bha_details->rfq_number}}
                                        @endif</td>
                            <td class="nowrap">{{ fbuyers($bha_details->contact_id)->first_name . ' ' . fbuyers($bha_details->contact_id)->last_name }}</td>
                            <td>{{ $bha_details->description}}</td>
                            <td>{{ $bha_details->client->client_name}}</td>
                            <td>{{ \Carbon\Carbon::parse($bha_details->rfq_date)->format('d-m-Y') }}</td>
                            <td class="nowrap">{{ \Carbon\Carbon::parse($bha_details->delivery_due_date)->format('d-m-Y') }}</td>
                            <td class="nowrap">{{ $bha_details->po_date ? \Carbon\Carbon::parse($bha_details->po_date)->format('d-m-Y') : '' }}</td>
                            <td>
                                        @if($bha_details->currency == "NGN")
                                        <?php $symbol = "₦"; ?>
                                        @elseif($bha_details->currency == "USD")
                                        <?php $symbol = "$"; ?>
                                        @elseif($bha_details->currency == "EUR")
                                        <?php $symbol = "€"; ?>
                                        @elseif($bha_details->currency == "GBP")
                                        <?php $symbol = "£"; ?>
                                        @endif
                                        
                                        @if($bha_details->status == 'PO Issued')
                                        {{ $symbol.number_format($bha_details->po_value_foreign, 2)}}
                                        
                                        @else
                                        
                                        @if($bha_details->total_quote > 1)
                                        {{$symbol.number_format($bha_details->total_quote,2)}}
                                        @else
                                        TBD
                                        @endif
                                        
                                        @endif
                                        </td>
                            <td>@if($bha_details->status == "PO Issued")
                                        {{ $bha_details->po_status}}
                                        @else
                                        {{ $bha_details->status}}
                                        @endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br/>
        <br/>

        <div class="email-text" style="margin-bottom: 40px;">
            <p class="footey">Best Regards,</p>
            @if (Auth::check())
            <p class="footey">{{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }},</p>
            <p class="footey">@if(Auth::user()->role == 'HOD' ) 
                                        {{ 'SCM Lead' }} 
                                        @elseif(Auth::user()->role == 'Employer' )
                                        {{ 'Procurement Associate' }} 
                                        @elseif(Auth::user()->role == 'SuperAdmin' )
                                        {{ 'SCM Admin' }}
                                        @else
                                        {{ 'Procurement Associate' }}
                                        @endif</p>
            @else
             <p class="footey">TAGSourcing Team,</p>
            <p class="footey">Automated Report</p>
            @endif
            <p class="footey">PHONE: +234 1 342 8420 | +234 906 243 5410</p>
            <p class="footey">EMAIL: <a href="mailto:sales@tagenergygroup.net">sales@tagenergygroup.net</a></p>
            <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
        </div>
    </div>
</body>
</html>