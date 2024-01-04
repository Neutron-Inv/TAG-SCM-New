<?php set_time_limit(9000); ?>
<!DOCTYPE html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> YEAR TO DATE ON-TIME DELIVERY REPORTS & SHIPPERS PERFORMANCE EVALUATION</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-12" align="center" style="margin-top: 43px;"> 
                <strong> YEAR TO DATE ON-TIME DELIVERY REPORTS & SHIPPERS PERFORMANCE EVALUATION </strong>
            </div>

            <div class="col-md-6" style="margin-bottom: 40px; margin-top: 43px;">
                <table class="table table-bordered">
                    <thead class="text-black" style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif;  mso-fareast-language:ZH-CN">
                        <tr>
                            <th>Total Numbers of POs Delivered till date</th>
                            <th>Total Numbers of POs Delivered on time</th>
                            <th> Total Numbers of POs Delivered Late </th>

                            <th>% POs Delivered On-time</th>
                            
                        </tr>
                    </thead>
                    <tbody style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                                                
                        <td> {{ count(getPOInfo()) ?? 0 }} </td>
                        <td class="text-align"> {{ count(getPOInfoCon('YES')) ?? 0 }} </td>
                        <td class="text-align">{{ count(getPOInfoCon('NO')) ?? 0 }} </td>
                        <td> {{ round((count(getPOInfoCon('YES')) / count(getPOInfo())) * 100,2) ?? 0}}% </td>
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-12" style="margin-bottom: 40px;">
                <table class="table table-bordered">
                    <thead class="bg-success text-black" style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                        <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">CLIENT NAME</th>
                            <th scope="col"> PO NUMBER </th>

                            <th scope="col">TAG REF NUMBER</th>
                            <th scope="col"> DESCRIPTION </th>

                            <th scope="col">PO RECEIPT DATE</th>
                            <th scope="col"> DELIVERY DATE </th>

                            <th scope="col">ACTUAL DELIVERY DATE</th>
                            <th scope="col"> ONTIME DELIVERY ? </th>

                            <th scope="col">OEM</th>
                            <th scope="col">SHIPPER </th>
                            <th scope="col">COMMENT </th>
                        </tr>
                    </thead>
                    <tbody style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                        <?php $num =1; ?>
                        @foreach ($po as $rfqs)
                            <tr> 
                                <td>{{ $num++ }} </td>
                                <td>{{ $rfqs->client->client_name ?? 'Null' }} </td>
                                <td> {{ $rfqs->po_number ?? ''}}</td>
                                <td> {{ $rfqs->rfq->refrence_no ?? 'Null' }}</td>
                                <td> {{ $rfqs->description ?? '' }}</td>

                                <td>{{ $rfqs->po_receipt_date ?? ' ' }} </td>
                                <td>{{ $rfqs->delivery_due_date  ?? ' ' }} </td>
                                <td> {{ $rfqs->actual_delivery_date ?? '' }}</td>
                                <td>{{ $rfqs->timely_delivery ?? ' ' }}</td>
                                <td> {{ $rfqs->rfq->vendor->vendor_name ?? 'Null' }}</td>
                                <td>{{ $rfqs->rfq->shipper->shipper_name ?? 'Null' }}</td>
                                

                                <td> {!! $rfqs->tag_comment ?? '' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="col-md-6">
                <table class="table table-bordered">
                    <thead class="bg-success text-black" style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                        <tr>
                            
                            <th>SHIPPER</th>
                            <th>TOTAL PO COLLECTED</th>
                            <th> TOTAL PO DELIVRED ON-TIME </th>
                            <th>PERFORMANCE INDEX (%)</th>
                            
                        </tr>
                    </thead>
                    <tbody style="font-size:8.0pt; font-family:&quot;Arial&quot;,sans-serif; mso-fareast-language:ZH-CN">
                        @foreach ($shipper as $item)
                            <tr>
                                <td>
                                    @foreach (getSh($item->shipper_id) as $it)
                                        {{ $it->shipper_name ?? ' N/A' }}
                                    @endforeach
                                </td>
                                <td> {{ count(countShipperPO($item->shipper_id)) ?? 0 }}</td>
                                <td>{{ count(countShipperPOCon($item->shipper_id,'YES')) ?? 0}} </td>
                                <td>{{ round((count(countShipperPOCon($item->shipper_id,'YES'))  / count(countShipperPO($item->shipper_id))) * 100,2) ?? 0 }}%</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="margin-bottom: 40px;">
                <p style="font-size: 8.0pt;font-family: Arial,sans-serif; color: #1F497D;"> Best Regards,  
                    {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, 
                    <br> SCM Specialist II <br>
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
