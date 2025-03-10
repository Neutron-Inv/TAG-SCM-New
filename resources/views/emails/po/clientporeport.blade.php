<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/design.css') }}">
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
                            <p style="font-size: 11.0pt;font-family: Calibri, sans-serif; color: black;">
                                Dear Sir/Madam,<br />
                                <br>Good day, I trust this mail finds you well.<br />
                                <br />Please see below {{ $clients_det->client_name }} Orders Status Update.
                                <br /> <br />
                                Thank you.
                            </p><br />

                            <table style="width:70%; max-width: 400px; font-size: 14px; margin-left:3% !important;">
                                <thead>
                                    <th style="width:20%;">Key</th>
                                    <th style="width:70%;"></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td Style="background-color: #92d050;"></td>
                                        <td> &nbsp; On Schedule</td>
                                    </tr>
                                    <tr>
                                        <td Style="background-color: #ffff00;"></td>
                                        <td> &nbsp; Off Schedule</td>
                                    </tr>
                                    <tr>
                                        <td Style="background-color: #ff0000;"></td>
                                        <td> &nbsp; Stalled. Off Schedule</td>
                                    </tr>
                                </tbody>
                            </table>


                            <!-- Bootstrap Table with Caption -->
                            <div class="main-container">
                                <div class="content-wrapper">
                                    <div class="row gutters">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="table-container">
                                                        <div class="table-responsive">
                                                            <h4 class="table-title"
                                                                style="text-align:center; vertical-align:center; padding:1%;">
                                                                <b> {{ $clients_det->client_name }} PO Status update for
                                                                    <?php echo date('Y'); ?> </b>
                                                            </h4>
                                                            <table class="table"
                                                                style="border-collapse: collapse; width: 98%; color:black !important; margin-left:3% !important; margin-right:-3% !important; position: relative;">
                                                                <thead class="">
                                                                    <tr>
                                                                        <th
                                                                            style="width: 3%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;text-align: center;">
                                                                            S/N</th>
                                                                        <th
                                                                            style="width: 10%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                                                            PO No </th>
                                                                        <th
                                                                            style="width: 15%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                                                            PO Issued to <br />Supplier Date </th>
                                                                        <th
                                                                            style="width: 15%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                                                            PO Expected Delivery Date</th>
                                                                        <th
                                                                            style="width: 55%; text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                                                            Status </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $num = 1; ?>
                                                                    @foreach ($client as $client_detail)
                                                                        @php
                                                                            $color = '';
                                                                            $schedule = $client_detail->schedule;

                                                                            if ($schedule == 'On Schedule') {
                                                                                $color = '#92d050';
                                                                            } elseif ($schedule == 'Off Schedule') {
                                                                                $color = '#ffff00';
                                                                            } elseif ($schedule == 'Stalled') {
                                                                                $color = '#ff0000';
                                                                            }
                                                                        @endphp
                                                                        <tr
                                                                            style="background-color: <?php echo $color; ?>;">
                                                                            <td
                                                                                style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif; color: black,">
                                                                                {{ $num++ }} </td>
                                                                            <td
                                                                                style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif; color: black;">
                                                                                {{ $client_detail->po_number }} </td>
                                                                            <td
                                                                                style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif; color:red;">
                                                                                {{ $client_detail->supplier_issued_date }}
                                                                            </td>
                                                                            <td
                                                                                style="text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif; color:red;">
                                                                                {{ $client_detail->delivery_due_date }}
                                                                            </td>
                                                                            <td
                                                                                style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif; color: black;">
                                                                                {{ $client_detail->status }} <br />
                                                                                @php
                                                                                    $notesArray = explode(
                                                                                        '.',
                                                                                        $client_detail->note,
                                                                                    );
                                                                                    $firstParagraphContent = strip_tags(
                                                                                        $notesArray[0],
                                                                                    );
                                                                                @endphp
                                                                                {!! $firstParagraphContent !!}.
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
                                    </div>
                                </div>
                            </div>
                            <br />
                            <hr>
                            <p style="font-size: 8.5pt;font-family: Arial,sans-serif; color: #1F497D;">Best Regards,<br>
                                {{ Auth::user()->first_name . ' ' . strtoupper(Auth::user()->last_name) }}, <br>
                                @if (Auth::user()->role == 'HOD')
                                    {{ 'SCM Lead' }}
                                @elseif(Auth::user()->role == 'Employer')
                                    {{ 'Procurement Associate' }}
                                @elseif(Auth::user()->role == 'SuperAdmin')
                                    {{ 'SCM Admin' }}
                                @else
                                    {{ 'Procurement Associate' }}
                                @endif <br>
                                PHONE</span></b><span
                                    style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                    : +234 1 342 8420&nbsp;| </span>
                                <span
                                    style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                                    +234 906 243 5410&nbsp; </span><span
                                    style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                </span>
                                <br>
                                Email</span></b><span
                                    style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                    : <a href="mailto:sales@tagenergygroup.net">sales@tagenergygroup.net</a></span>
                            </p>
                            <img src="{{ asset('admin/img/signature.jpg') }}" alt="SCM" style="width: 100%;">
                            <div style="text-align: center; font-size: 9px; color: #ffffff; background-color: white;">
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
