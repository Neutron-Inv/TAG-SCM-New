<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style type="text/css">
    body{
        background: white;
    }
        .container {
            background: white;
            color: black !important;
            font-size:9.5pt !important;
        }

        .email-text {
            color: #1F497D !important;
            font-size:9.5pt !important;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            font-size:9.5pt !important;
        }

        .table th, .table td {
            border: 1px solid #000;
            color: #1f4e79 !important;
            padding: 5px 13px !important;
            font-size:9.5pt !important;
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
            font-size:9.5pt !important;
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
@php 
    $start_date = $monday->format('jS F, Y');
    $end_date = $friday->format('jS F, Y');
@endphp
<body>
    <div class="container">
        <p class="email-text">Good Day Sir,</p><br/>
        <p class="email-text">I trust this mail meets you well.</p><br/>
        <p class="email-text">Please see below tables showing total number of RFQs, POs and Outstanding GRN received from <?php echo $start_date ?> to <?php echo $end_date ?></p><br/>
        <br/>
        <br/>
        <h5 style="text-align:center; padding:1%;"><b> RFQs for <?php echo $start_date; ?> to <?php echo $end_date; ?> </b></h5>
        <div class="table-container">
            <table class="table">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>COMPANY</th>
                    <th>NO. OF RFQ <br/>RECEIVED </th>
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
        <br/>
        <br/>
        <br/>
        <h5 style="text-align:center; padding:1%;"><b> POs for <?php echo $start_date; ?> to <?php echo $end_date; ?> </b></h5>
        <div class="table-container">
            <table class="table">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>COMPANY</th>
                    <th>NO. OF PO<br/> RECEIVED </th>
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
        <br/>
        <br/>
        <h5 style="text-align:center; padding:1%;"><b> OUTSTANDING GRN </b></h5>
        <div class="table-container">
            <table class="table">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>PO NO. </th>
                    <th>CLIENT</th>
                    <th>DELIVERY DATE</th>
                    <th>EXPECTED DATE OF GRN</th>
                </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($grn as $item)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td> {{ $item->po_number }}</td>
                            <td> {{ $item->client->client_name }}</td>
                            <td> {{ \Carbon\Carbon::parse($item->actual_delivery_date)->format('d-m-Y') }}</td>
                            <td> {{ \Carbon\Carbon::parse($item->actual_delivery_date)->addDays(14)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if( count($grn) == 0)
                    <p style="text-align: center;"><br/> No Awaiting GRN</p>
            @endif
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