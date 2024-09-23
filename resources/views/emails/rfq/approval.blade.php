
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/design.css')}}">
    </head>
    <body background-color="white" style="background: white !important;">
        
        <div class="row" style="background: white !important;margin-left:3% !important;">
            
            <div class="col-lg-12" style="background: white !important;">
                <div class="mb-0" style="background: white !important;">
                    <div style="width: 100%; background: white !important; color: black;">
                        <div style="max-width: 90%; font-size: 14px; background: white !important;">
                    
                            @php
                                $sumTotalQuotes = sumTotalQuote($rfq->rfq_id);
                                $tot_quo = sumTotalQuote($rfq->rfq_id);
                                $subTotalCost =  $tq + $rfq->freight_charges + $rfq->other_cost + $rfq->local_delivery;
                                $tot_ddp = $subTotalCost + $rfq->cost_of_funds + $rfq->fund_transfer;
                                $net_margin = ($sumTotalQuotes - $tot_ddp) - ($rfq->wht + $rfq->ncd);

                                

                                if($rfq->client_id == 114){
                                    $newWht = (0.05 * (sumTotalQuote($rfq->rfq_id) - $subTotalCost));
                                    $newNcd = (0.01 * (sumTotalQuote($rfq->rfq_id) - $subTotalCost));
                                }else{
                                    $newWht = (0.05 * (sumTotalQuote($rfq->rfq_id)));
                                    $newNcd = (0.01 * (sumTotalQuote($rfq->rfq_id)));
                                }
                                
                                if($sumTotalQuotes < 1){ 
                                    $sumTotalQuote = 1; 
                                }else { 
                                    $sumTotalQuote = $sumTotalQuotes; 
                                }
                                $comp = ($net_margin / sumTotalQuote($rfq->rfq_id)) * 100;
                                //$cal = (7.5 * 100)/$rfq->cost_of_funds;
                                $cal = $rfq->net_percentage_margin; 
                            @endphp
                                
                            @if(count(getRRQShipQuote($rfq->rfq_id, 'get')) > 0)
                                @php 
                                    $shi = getRRQShipQuote($rfq->rfq_id, 'first');
                                    $shipCurrency = $shi->currency;
                                    $soncap = $shi->soncap_charges;
                                    $trucking = $shi->trucking_cost;
                                    $customs = $shi->customs_duty;
                                    $clearing = $shi->clearing_and_documentation;
                                    $loc = $soncap + $trucking + $customs + $clearing;

                                @endphp
                            @else 
                                @php 

                                    $shipCurrency = 'NGN'; $clearing = 0;
                                    $soncap = 0; $trucking = 0; $customs = 0;
                                    $loc = $soncap + $trucking + $customs + $clearing;
                                @endphp
                            @endif
                            <?php $value = $tq + $rfq->freight_charges + $rfq->other_cost + $loc; 
                            
                            ?>
                                
                            
                            <div style="background: white !important;">
						                        <!-- @foreach (getLogo($rfq->company_id) as $item)
                                                    @php $log = 'https://scm.enabledjobs.com/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                    <img src="{{$log}}" width="100" height="70" alt="SCM"style="height: 40px; margin-left: 3px;" 
                                                    >
                                                @endforeach --> 
                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;"> 
                                                    Dear Sir/Madam,<br/>
                        							<br>Good day, I trust this mail finds you well.<br/>
                                                    <br/>Please see below cost breakdown and attached spreadsheet for your approval.  
                                                </p>
                                        <p>
                                            {!! $extra_note ?? '' !!}
                                        </p>

                                                <p style="font-size: 10.0pt; color: black !important;">  Client: <strong> {{ $rfq->client->client_name ?? ' ' }} </strong> </p>
                                                <p style="font-size: 10.0pt; color: black !important;">  Buyer: <strong> {{ $rfq->contact->first_name . ' '. $rfq->contact->last_name ?? ' '}} </strong> </p>
                                                <p style="font-size: 10.0pt; color: black !important;">  Supplier: <strong>  {{ $rfq->vendor->vendor_name }} </strong> </p>
                                                <p style="font-size: 10.0pt; color: black !important;">  Description: <strong>  {!! $rfq->description !!} </strong> </p>
                                                
                                        @foreach (explode(';', $rfq->estimated_package_weight ?? '') as $est_weight)
                                        <p style="font-size: 10.0pt; color: black !important;">  Estimated Package Weight: <strong> {{ trim($est_weight) }}</strong> </p>
                                        @endforeach
                                        
                                        
                                        @foreach (explode(';', $rfq->estimated_package_dimension ?? '') as $est_dim)
                                        <p style="font-size: 10.0pt; color: black !important;">  Estimated Package Dimension: <strong> {{ trim($est_dim) }} </strong> </p>
                                        @endforeach
                                                
                                                
                                                <p style="font-size: 10.0pt; color: black !important;">  Oversized Cargo: <strong>  {!! $rfq->oversized !!} </strong> </p>
                                                
                                        @foreach (explode(';', $rfq->hs_codes ?? '') as $hs_code)
                                        <p style="font-size: 10.0pt; color: black !important;">  HS Code: <strong> {{ trim($hs_code) }} </strong> </p>
                                        @endforeach
                                                
                                                <p style="font-size: 10.0pt; color: black !important;">  Incoterm: <strong> {{ $rfq->incoterm ?? ''}} </strong> </p>
                                                <p style="font-size: 10.0pt; color: black !important;">  Currency: <strong>  {{ $rfq->currency ?? ''}} </strong> </p>
                                                
                                                
                                                <table style="border-collapse: collapse; border: 0; width: 50%; background: white !important; padding-left:2px;">
                                                <thead>
                                                    <tr>
                                                        <th  style=" width: 40%; text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </th>
                                                        <th  style="width: 60%; text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                            &nbsp;
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             {{number_format((float)$tq,2) ?? 0 }}
                                                            
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             Total Ex-Works
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $sumTotalMiscSupplier = 0;
                                                        $shipper = getSh($rfq->shipper_id);
                                                    @endphp
                        @if(!empty(json_decode($rfq->misc_cost_supplier, true)))
                                    @foreach(json_decode($rfq->misc_cost_supplier, true) as $item)
                                        <tr>
                                            <td style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                @if(isset($item['amount']) && is_numeric($item['amount']) && $item['amount'] > 0)
                                                    {{ number_format((float)$item['amount'], 2) }}
                                                @endif
                                            </td>
                                            <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                {{ $item['desc'] ?? '' }}
                                            </td>
                                        </tr>
                                        @php
                                            $sumTotalMiscSupplier += isset($item['amount']) && is_numeric($item['amount']) ? (float)$item['amount'] : 0;
                                        @endphp
                                    @endforeach
                                @endif
                                
                                <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                
                                @php
                                $sumTotalMiscOthers = 0;
                              
                                @endphp
        @if(!empty(json_decode($rfq->misc_cost_others, true)))
                    @foreach(json_decode($rfq->misc_cost_others, true) as $other_item)
                        <tr>
                            <td style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                @if(isset($other_item['amount']) && is_numeric($other_item['amount']) && $other_item['amount'] > 0)
                                    {{ number_format((float)$other_item['amount'], 2) }}
                                @endif
                            </td>
                            <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                {{ $other_item['desc'] ?? '' }}
                            </td>
                        </tr>
                        @php
                            $sumTotalMiscOthers += isset($other_item['amount']) && is_numeric($other_item['amount']) ? (float)$other_item['amount'] : 0;
                        @endphp
                    @endforeach
                @endif
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    @if($rfq->local_delivery > 0)
                                                        @if($rfq->is_lumpsum == 1)
                                                        <tr>
                                                            <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                {{number_format((float)$rfq->local_delivery ,2) ?? 0 }}
                                                            </td>
                                                            <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                {{ $shiname }} Freight Charges
                                                            </td>
                                                        </tr>
                                                        @else
                                                            @if($shi->soncap_charges > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->soncap_charges ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Soncap Charges
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if($shi->trucking_cost > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->trucking_cost ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Trucking Cost
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if($shi->clearing_and_documentation > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->clearing_and_documentation ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Clearing and Documentation
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if($shi->customs_duty > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->customs_duty ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Customs Duty
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @php
                                                        $sumTotalMiscLogistics = 0;
                                                    @endphp
            @if(!empty(json_decode($rfq->misc_cost_logistics, true)))
                @foreach(json_decode($rfq->misc_cost_logistics, true) as $iteml)
                    <tr>
                        <td style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                            @if(isset($iteml['amount']) && is_numeric($iteml['amount']) && $iteml['amount'] > 0)
                                {{ number_format((float)$iteml['amount'], 2) }}
                            @endif
                        </td>
                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                            {{ $iteml['desc'] ?? '' }}
                        </td>
                    </tr>
                    @php
                        $sumTotalMiscLogistics += isset($iteml['amount']) && is_numeric($iteml['amount']) ? (float)$iteml['amount'] : 0;
                    @endphp
                @endforeach
            @endif
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$tq + $sumTotalMiscLogistics + $sumTotalMiscSupplier + $sumTotalMiscOthers + $rfq->local_delivery,2) ?? 0 }}</b> 
                                                        </td>
                                                        @php
                                                            $subtotal = $tq + $sumTotalMiscLogistics + $sumTotalMiscOthers + $sumTotalMiscSupplier + $rfq->local_delivery;
                                                        @endphp
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            {{-- {{ number_format((float)sumTotalQuote($rfq->rfq_id),2) ?? 0}}  --}}
                                                            <b>Sub Total 1</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;color:red;">
                                                             {{ number_format((float)$rfq->cost_of_funds,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
            @php
            // Decode the JSON string into an array of objects
                $data = json_decode($rfq->supplier_cof);
                
                // Initialize $highest_duration to the duration of the first item
                $highest_duration = $data[0]->duration;
                
                // Loop through the array of objects starting from the second item
                for ($i = 1; $i < count($data); $i++) {
                    // Check if the duration of the current item is greater than $highest_duration
                    if ($data[$i]->duration > $highest_duration) {
                        // Update $highest_duration with the duration of the current item
                        $highest_duration = $data[$i]->duration;
                    }
                }
            @endphp
                                                            Cost of funds (Subtotal * 1.3% * {{ $highest_duration }} Months)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                            {{ number_format((float)$rfq->fund_transfer_charge,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Cost of Fund Transfer(0.5 % of Total Ex- Works) 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                            {{ number_format((float)$rfq->vat_transfer_charge,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             VAT on Transfer Cost (7.5% of Funds Transfer)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                             {{ number_format((float)$rfq->offshore_charges,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Offshore Charges
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                             {{ number_format((float)$rfq->swift_charges,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Swift Charges (fixed @ $25)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 2px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             @php
                                                                $total_exworks = $subtotal + $rfq->swift_charges + $rfq->offshore_charges + $rfq->vat_transfer_charge + $rfq->fund_transfer_charge + $rfq->cost_of_funds
                                                             @endphp
                                                             {{ number_format((float)$total_exworks,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Total {{ $rfq->incoterm }} Cost
                                                        </td>
                                                    </tr>
                                                    <tr style="background:#f2f2f2;">
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->total_quote ,2) ?? 0 }}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            <b>Total Quotation</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             -
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             VAT
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        {{ number_format((float)$rfq->wht + $rfq->ncd,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                        @if($rfq->ncd > 0)
                                                            WHT &amp; NCD  <br> ((Total Quote minus Sub Total 1 * 6%)
                                        @elseif($rfq->ncd == 0)
                                                            WHT <br> ((Total Quote minus Sub Total 1 * 5%)
                                        @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        {{ number_format((float)$rfq->wht + $rfq->ncd,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; background:#d9d9d9;">
                                                             Total TAXES
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->net_percentage,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            <b>Net Margin <br>(Total Quote minus ({{ $rfq->incoterm }} + WHT))</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; background:#d9d9d9;">
                                                        <b>{{ number_format((float)$rfq->percent_net,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            % Net Margin
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->net_value,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Gross Margin
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->percent_margin,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            % Gross Margin
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                        @php
                                        $sn = 1;
                                        @endphp
                                                    <b style="color:red">Notes to Pricing: </b><br>
                                        {{ $sn }}. Delivery: <b>{{ $rfq->estimated_delivery_time ?? '17-19 weeks' }}. </b><br/>
                            @php $sn += 1 @endphp
                            
                        @if($rfq->transport_mode == 'Undecided' OR $rfq->incoterm == 'Ex Works')
                            
                        @else
                            {{ $sn }}. Mode of transportation: <b>{{ $rfq->transport_mode ?? ''}} </b>
                            <br/>
                        @php $sn += 1 @endphp
                            
                            @endif
                            {{ $sn }}. Delivery Location: <b>{{ $rfq->delivery_location ?? ''}} </b>
                            <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Where Legalisation of C of O and/or invoices are required, additional cost will apply
                                and will be charged at cost. <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Validity: This quotation is valid for <b>{{ $rfq->validity ?? ''}}.</b> <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Pricing: Prices quoted are in <b>{{ $rfq->currency ?? 'USD' }}</b> <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Prices are based on quantity quoted <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. A revised quotation will be submitted for confirmation in the event of a partial order. <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Oversized Cargo: <b>{{ $rfq->oversized ?? 'NO' }} </b> <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Pricing is exclusive of VAT.
                                <br/>
                            @php $sn += 1 @endphp
                                
                            {{ $sn }}. Payment Term: <b>{{ $rfq->payment_term ?? '' }}</b> <br/>
                            @php $sn += 1 @endphp
                            
                            @if($rfq->vendor_id == '167')
                            {{ $sn }}. Goods will be cleared in South Africa by Bosch Authorised Export Agent. <br/><br/>
                            @else
                            <br/>
                            @endif

                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                Thank you. <br/>
                                                </p>
                                                <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                    <tbody>
                                                        <tr>
                                                            <td class="o_btn o_bg-primary o_br o_heading o_text" align="center" data-bgcolor="Bg Primary" data-size="Text Default" data-min="12" data-max="20"
                                                                style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;
                                                                background-color: #28a745;border-radius: 4px;">
                                                                <?php $url = 'https://scm.tagenergygroup.net/dashboard/request-for-quotation/approve-breakdown/'.$rfq->refrence_no; ?>
                                                                <a class="o_text-white" href="{{ $url }}" data-color="White" style="text-decoration: none;outline: none;color: #ffffff;
                                                                    display: block;padding: 12px 24px;mso-text-raise: 3px;">
                                                                    Approve </a>
                                                            </td>
                                                            <?php $url2 = 'https://scm.tagenergygroup.net/dashboard/request-for-quotation/decline-breakdown/'.$rfq->refrence_no; ?>
                                                            <td class="o_btn o_bg-dark o_br o_heading o_text" align="center" data-bgcolor="Bg Dark" data-size="Text Default" data-min="12" data-max="20" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;
                                                                margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #242b3d;border-radius: 4px;">
                                                                <a class="o_text-white" href="{{ $url2 }}" data-color="White" style="background-color: #dc3545;text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px; padding-left; -10px">
                                                                    Decline 
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table><br><br>
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
                                                    </span></b><span style="color:#2F5496"><a href="mailto:{{ $reply }}"><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif">
                                                        {{ $reply }}</span></b></a>
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
            
