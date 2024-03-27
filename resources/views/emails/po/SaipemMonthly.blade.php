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
            width: 100%;
            font-size:9pt !important;
        }

        .table th, .table td {
            border: 1px solid #000;
            color: #1f4e79 !important;
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
        <p class="email-text">Please see below list of Saipem Bids from year till date.</p>
        <br/>
        <br/>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>TAG REF NUMBER</th>
                        <th>SAIPEM RFQ NUMBER</th>
                        <th>BUYER</th>
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
                            <td class="nowrap">{{ fbuyers($saipem_details->contact_id)->first_name . ' ' . fbuyers($saipem_details->contact_id)->last_name }}</td>
                            <td>{{ $saipem_details->product}}</td>
                            <td>{{ $saipem_details->description}}</td>
                            <td>{{ $saipem_details->client->client_name}}</td>
                            <td>{{ \Carbon\Carbon::parse($saipem_details->rfq_date)->format('d-m-Y') }}</td>
                            <td class="nowrap">{{ \Carbon\Carbon::parse($saipem_details->delivery_due_date)->format('d-m-Y') }}</td>
                            <td>{{ $saipem_details->total_quote}}</td>
                            <td>{{ $saipem_details->status}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br/>
        <br/>

        <div class="email-text" style="margin-bottom: 40px;">
            <p class="footey">Best Regards,</p>
            <p class="footey">{{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }},</p>
            <p class="footey">Procurement Associate</p>
            <p class="footey">PHONE: +234 1 342 8420 | +234 906 243 5410</p>
            <p class="footey">EMAIL: <a href="mailto:sales@tagenergygroup.net">sales@tagenergygroup.net</a></p>
            <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
        </div>
    </div>
</body>
</html>