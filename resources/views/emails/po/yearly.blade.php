<?php set_time_limit(9000); ?>
<!DOCTYPE html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> YEAR TO DATE ON-TIME DELIVERY REPORTS & SHIPPERS PERFORMANCE EVALUATION</title>
    
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"> --}}

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
            background: white;
            color: black !important;
            font-size:9.5pt !important;
        }

        .table th, .table td {
            border: 1px solid #000;
            color: black !important;
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
            color: black !important;
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

<body>
    <div class="container">
        
        <div class="row">
            <p >
                Dear Sir,<br/>

                Good morning, I trust this mail finds you well. <br/>
                Please see below updated YTD On-Time Delivery Report and Shippers Performance Evaluation with respect to On-time Delivery.<br/>
                Thank you.
            </p>
            <!--<div class="col-md-12" align="center" style="margin-top: 43px;"> -->
            <!--    <strong> YEAR TO DATE ON-TIME DELIVERY REPORTS & SHIPPERS PERFORMANCE EVALUATION </strong>-->
            <!--</div>-->

            <div class="col-md-4" style="margin-bottom: 40px; margin-top: 43px; width:30% !important;">
                <table class="table table-bordered" style="width: 30% !important;">
                    <thead class="text-black" style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif;  mso-fareast-language:ZH-CN">
                        <tr>
                            <th style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"><b>Total Numbers of POs <br/> Delivered from <br/>January {{date('Y')}} till <br/> December {{date('Y')}} </b></th>
                            <th style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"><b>Total Numbers of POs <br/>Delivered on time </b></th>
                            <th style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"><b> Total Numbers of POs <br/> Delivered Late </b></th>

                            <th style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"><b>% POs Delivered <br/>On-time </b></th>
                            
                        </tr>
                    </thead>
                    <tbody style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                                                
                        <td align="center" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"> {{ count(getyearPOInfo()) ?? 0 }} </td>
                        <td align="center" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"> {{ count(getyearPOInfoCon('YES')) ?? 0 }} </td>
                        <td align="center" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">{{ count(getyearPOInfoCon('NO')) ?? 0 }} </td>
                        <td align="center" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">
                            @if(count(getyearPOInfo()) == 0)
                            0%
                            @else
                             {{ round((count(getyearPOInfoCon('YES')) / count(getyearPOInfo())) * 100,2) ?? 0}}%
                             @endif
                             </td>
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-12" style="margin-bottom: 40px;">
                <table class="table table-bordered">
                    <thead class="bg-success text-black" style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN;">
                        <tr>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268"><b>S/N </b></th>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268"><b>CLIENT </b></th>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268"><b> PO NUMBER </b></th>

                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268"><b>TAG REF NUMBER </b></th>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268; width:17%;" align="center"><b> DESCRIPTION </b></th>

                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268; width:6%"><b>PO RECEIPT DATE </b></th>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268; width:6%"><b> DELIVERY DATE </b></th>

                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268; width:7%" align="center"><b>ACTUAL DELIVERY DATE </b></th>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268; width:6%" align="center"><b> ONTIME DELIVERY ? </b></th>

                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268" align=""><b>OEM </b></th>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268"> <b>SHIPPER </b
                            </th>
                            <th scope="col" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn; background-color: #9fe268; width:17%;" align="center"><b>COMMENTS </b></th>
                        </tr>
                    </thead>
                    <tbody style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN; background: #e6e6e6 !important;">
                        <?php $num =1; ?>
                        @foreach ($po as $rfqs)
                            <tr> 
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn" align="center" >{{ $num++ }} </td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">{{ $rfqs->client->client_name ?? 'Null' }} </td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn" align="center"> {{ $rfqs->po_number ?? ''}}</td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn" align="center"> {{ $rfqs->rfq->refrence_no ?? 'Null' }}</td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"> {{ $rfqs->description ?? '' }}</td>

                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn" align="center">{{ $rfqs->po_date ?? ' ' }} </td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn" align="center">{{ substr($rfqs->delivery_due_date, 0,10)  ?? ' ' }} </td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn" align="center"> {{ substr($rfqs->actual_delivery_date,0,10) ?? '' }}</td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn" align="center">{{ $rfqs->timely_delivery ?? ' ' }}</td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"> {{ $rfqs->rfq->vendor->vendor_name ?? 'Null' }}</td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">{{ $rfqs->rfq->shipper->shipper_name ?? 'Null' }}</td>
                                

                                <td> {!! $rfqs->tag_comment ?? '' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <br/> <br/>
            
            <h4>SHIPPERS PERFORMANCE EVALUATION</h4>
            <div class="col-md-6" style="width:30% !important;">
                <table class="table table-bordered" style="width: 30% !important;">
                    <thead class="bg-success text-black" style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                        <tr>
                            <th style="background-color: #9fe268; font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"> <b>S/N </b></th>
                            <th style="background-color: #9fe268; font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"> <b>SHIPPER </b></th>
                            <th style="background-color: #9fe268; font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"><b>TOTAL PO <br/> DELIVERED </b></th>
                            <th style="background-color: #9fe268; font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"><b> TOTAL PO <br/> DELIVERED <br/> ON-TIME</b> </th>
                            <th style="background-color: #9fe268; font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"><b>PERFORMANCE <br/>INDEX (%) </b></th>
                            
                        </tr>
                    </thead>
                    <tbody style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                        @php 
                                        $totalPO = 0;
                                        $totalOntimePO = 0;
                                        $count = 0;
                                        $totalindex = 0;
                                        @endphp
                        @foreach ($shipper as $item)
                            <tr>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">
                                    @php $count += 1; @endphp
                                    {{ $count }}
                                </td>
                                <td style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">
                                    @foreach (getSh($item->shipper_id) as $it)
                                        {{ $it->shipper_name ?? ' N/A' }}
                                    @endforeach
                                </td>
                                <td align="center" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn"> 
                                @php $totalPO += count(countShipperPOyearly($item->shipper_id)) ?? 0 @endphp  
                                
                                {{ count(countShipperPOyearly($item->shipper_id)) ?? 0 }}</td>
                                <td align="center" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">
                                @php $totalOntimePO += count(countShipperPOCon($item->shipper_id,'YES')) ?? 0 @endphp  
                                
                                    {{ count(countShipperPOCon($item->shipper_id,'YES')) ?? 0}} </td>
                                <td align="center" style="font-size:8.0pt; font-family:&quot;arial&quot;,sans-serif; mso-fareast-language:zh-cn">
                                    @if(count(countShipperPOyearly($item->shipper_id)) == 0)
                                    0%
                                    @else
                                    {{ round((count(countShipperPOCon($item->shipper_id,'YES'))  / count(countShipperPOyearly($item->shipper_id))) * 100,2) ?? 0 }}%
                                    
                                    @php $totalindex +=  round((count(countShipperPOCon($item->shipper_id,'YES'))  / count(countShipperPOyearly($item->shipper_id))) * 100,2) ?? 0; @endphp
                                    @endif</td>
                            </tr>
                        @endforeach
                        @php
                        $avgindex = $totalindex/$count;
                        @endphp
                        <tr>
                        <td></td>
                        <td> <b>Total</b></td>
                        <td> <b>{{ $totalPO }}</b></td>
                        <td> <b>{{ $totalOntimePO }} </b></td>
                        <td>{{ $avgindex }}%</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="margin-bottom: 40px;">
                <p style="font-size: 8.0pt;font-family: Arial,sans-serif; color: #1F497D;"> Best Regards, <br/> 
                    {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, 
                    <br> @if(Auth::user()->role == 'HOD' ) 
                                        {{ 'SCM Lead' }} 
                                        @elseif(Auth::user()->role == 'Employer' )
                                        {{ 'Procurement Associate' }} 
                                        @elseif(Auth::user()->role == 'SuperAdmin' )
                                        {{ 'SCM Admin' }}
                                        @else
                                        {{ 'Procurement Associate' }}
                                        @endif <br>
                    PHONE</span></b><span style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                        : +234 1 342 8420&nbsp;| </span>
                        <span style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                        +234 906 243 5410&nbsp; </span><span style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                    </span><br><b><span style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864">EMAIL:
                    </span></b><span style="color:#2F5496"><a href="mailto:sales@tagenergygroup.net"><b><span style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif">
                        sales@tagenergygroup.net</span></b></a>
                    </span>

                </p>
                <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
            </div>
        </div>
    </div>
   
</body>
</html>
