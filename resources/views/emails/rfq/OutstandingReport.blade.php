
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/design.css')}}">
    <style type="text/css">
        body{
            background: white;
        }
        .table {
            border-collapse: collapse;
            background: white;
            color: black !important;
            font-size:9.5pt !important;
        }
        .table th, .table td {
            border: 1px solid #000;
            color: black !important;
            padding: 3px 3px !important;
            font-size:9.0pt !important;
            text-align: left;
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
                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;"> 
                                                    Good Afternoon Ma,<br/>
                                                I hope this mail finds you well.
                                                <br/>
                                                Please see below list of outstanding RFQs as requested.
                                                <br/>
                                                Thank you.
                                                </p>

<div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-container">
                                
                                <div class="table-responsive">
                                    <table id="" class="table" style="font-size:9.0pt; width:80%;">
                                        <thead class="bg-success text-white">
                                            <tr style="background:#ed7d31;">
                                <td colspan="8" style="text-align:center; font-size: 15pt !important; color:black;"><b>LIST OF OUTSTANDING RFQs </b></td>
                                            </tr>
                                            <tr style="background:#5b9bd5; font-size:9.0pt;">
                                                <th>S/N</th>
                                                <th>RFQ NO</th>
                                                <th> Client Ref. No. </th>

                                                <th>CLIENT</th>
                                                <th>DESCRIPTION</th>

                                                <th>STATUS</th>
                                                <th>DEADLINE &nbsp; &nbsp;</th>

                                                <th>ASSIGNED TO</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:9.0pt;">
                                            <?php $num =1; ?>
                                            @foreach ($rfqs as $rfq)
                                                <tr style="font-size:9.0pt;"> 
                                                    <td style="background:#acb9ca; width:10px;">{{ $num++ }} </td>
                                                    <td>{{ $rfq->refrence_no ?? 'Null' }} </td>
                                                    <td> {{ $rfq->rfq_number ?? ''}}</td>
                                                    <td> {{ $rfq->client->client_name ?? 'Null' }}</td>
                                                    <td> {{ $rfq->description ?? '' }}</td>

                                                    <td>{{ $rfq->status ?? ' ' }} </td>
                                                    <td style="white-space:nowrap;">{{ isset($rfq->delivery_due_date) ? date('d-m-Y', strtotime($rfq->delivery_due_date)) : ' ' }} </td>
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

            </div>
         </div>
         <br/><br/>

                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                Thank you.
                                                </p>
                                                <p style="font-size: 8.5pt;font-family: Arial,sans-serif; color: #1F497D;">Best Regards,<br> {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, <br>@if(Auth::user()->role == 'HOD' ) 
                                        {{ 'SCM Lead' }} 
                                        @elseif(Auth::user()->role == 'Employer' )
                                        {{ 'Procurement Associate' }} 
                                        @elseif(Auth::user()->role == 'SuperAdmin' )
                                        {{ 'SCM Admin' }}
                                        @else
                                        {{ 'Procurement Associate' }}
                                        @endif <br>
                                                    PHONE</span></b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                        : +234 1 342 8420&nbsp;| </span>
                                                        <span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                                                        +234 906 243 5410&nbsp; </span><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                    </span><br><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864">EMAIL:
                                                    </span></b><span style="color:#2F5496"><a href="mailto:sales@tagenergygroup.net"><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif">
                                                        sales@tagenergygroup.net</span></b></a>
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
            
