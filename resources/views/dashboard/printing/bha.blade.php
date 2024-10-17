

<?php
$cli_title = clis($rfq->client_id);
$result = json_decode($cli_title, true);

    $title = "BHA Quotation TE-" . $result[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ", " . $rfq->description;
    set_time_limit(900);
?>
@extends('layouts.bhaHead')
@section('content')
    @if(count($line_items) == 0)
        <h3><p style="color:red" align="center"> No Line Item was found for the RFQ </p></h3>
    @else
@php
$count = 1;
@endphp
@foreach($line_items as $line_item)
<div style="page-break-inside: avoid !important;">
    @php
    $comp = comp($rfq->company_id);
    $uom = getUOM($line_item->uom);
    $total_cost = $line_item->quantity * $line_item->unit_cost;
    $freight_charge = freight_pricing($line_item->location, $line_item->weight);
    $freight = (int)$freight_charge * (int)$line_item->weight;
    $subtotal_cif = $freight + $total_cost;
    $duty = 0.20 * $subtotal_cif;
    $surcharge = 0.07 * $duty;
    $etls = 0.005 * $subtotal_cif;
    $ciss = 0.01 * $total_cost;
    $vat = 0.075 * ($subtotal_cif + $duty + $surcharge + $etls +$ciss);
    $local_handling = 0.01 * $subtotal_cif;
    $subtotal_b = $subtotal_cif + $duty + $surcharge + $etls + $ciss + $vat + $local_handling;
    $mark_up = 0.09 * $subtotal_b;
    $total_selling = $subtotal_b + $mark_up;
    @endphp
        <div class="col-12" style="flex: 0 0 100%; position: relative; text-align: center; font-size: 7px !important;margin-bottom:10px; display: block !important;"><b>{{strtoupper($comp[0]->company_name)}} COMMERCIAL SUBMISSION</b></div>
        <div class="col-12" style="position: relative; background-color:#f2f2f2; text-align: center; font-size: 7px !important; display: block !important; margin-top:-11px;"><b>BUYING HOUSE AGREEMENT BHA 2021/002</b></div>
        <div class="col-12" style="position: relative; background-color:#d9d9d9; border: 1px solid #000; text-align: center; font-size: 7px !important; display: block !important;"><b>INCOTERMS: {{ strtoupper($rfq->incoterm) }} </b></div><br/>
        
        <div class="col-4" style="position: relative; background-color:#002060; border: 1px solid #000; text-align: center; font-size: 7px !important; display: block !important;color:#fff;"><b>NLNG: </b></div>
        <div class="col-12" style="position: relative; background-color:#f2f2f2; text-align: center; font-size: 7px !important; display: block !important; ">&nbsp;</div>
        <div class="col-4" style="position: relative; text-align: center; font-size: 7px !important; display: block !important; "><b> LINE ITEM {{$count}} </b></div>
        <div style="display:flex;">
        <div class="col-9">
            <table style="font-size:7px !important; left:0px !important; margin-left:-17px; border:1px solid #fff !important; border-collapse: collapse; width:95%; vertical-align:bottom !important;">
                <thead style="background-color: #f2f2f2; font-weight: bold; vertical-align:bottom;">
                    <tr>
                    <th style="width:2%;">S/N</th>
                    <th style="width:43%;">Items </th>
                    <th style="width:13%;">Unit of Measure ({{$uom[0]->unit_name}})</th>
                    <th style="width:10%;">Rate ({{$rfq->currency}})</th>
                    <th style="width:10%;">Total Price ({{$rfq->currency}})</th>
                    <th style="width:22%;">Guidance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="vertical-align:bottom !important;">
                        <td>&nbsp;</td>
                        <td style="font-weight: bold !important; line-height: 7.5px !important; vertical-align:bottom !important;">
                            @if($line_item->mesc_code != '' && $line_item->mesc_code != 'N/A' && $line_item->mesc_code != 0)
                                                <p style="font-size: 9.0pt; font-family: Calibri, sans-serif;"> <b>MESC CODE: {{ $line_item->mesc_code }} </b></p><br/>
                                        @endif
                                                <p style="font-size: 9.0pt; font-weight: 400; text-align: justify;">
                                                    {!! $line_item->item_description ?? 'N/A' !!}
                                                </p>
                        </td>
                        <td>{{$line_item->quantity ?? 0}}</td>
                        <td>{{number_format($line_item->unit_cost, 2) ?? 0}}</td>
                        <td style="text-align:right !important;">{{number_format($total_cost, 2) ?? 0}}</td>
                        <td>This will be the ex-works/OEM price for the item including all discounts and export documentation. $100 here is an assumption</td>
                    </tr>
                    <tr style="background-color:#c5d9f1; font-weight:bold !important; vertical-align:bottom !important;">
                        <td>2</td>
                        <td><b>FOB</b></td>
                        <td>LOT</td>
                        <td></td>
                        <td style="text-align:right !important;">{{number_format($total_cost, 2) ?? 0}}</td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#fff; vertical-align:bottom !important;">
                        <td>3</td>
                        <td>Freight</td>
                        <td>LOT</td>
                        <td style="background-color:#fcd5b4;"></td>
                        <td style="text-align:right !important;">{{number_format($freight,2) ?? 0}}</td>
                        <td>Will be extracted from table 2.0 below based on item weight i.e Price/KG * Item weight</td>
                    </tr>
                    <tr style="background-color:#c5d9f1; font-weight:bold !important;">
                        <td>A</td>
                        <td><b>Subtotal - A CIF</b></td>
                        <td>LOT</td>
                        <td></td>
                        <td style="text-align:right !important;">{{number_format($subtotal_cif,2)}}</td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#fff;">
                        <td>4</td>
                        <td>Duty (% of CIF)</td>
                        <td>%</td>
                        <td style="background-color:#fcd5b4;">20%</td>
                        <td style="text-align:right !important;">{{number_format($duty,2)}}</td>
                        <td>item HS code</td>
                    </tr>
                    <tr style="background-color:#fff;">
                        <td>5</td>
                        <td>Surcharge (% of Duty)</td>
                        <td>%</td>
                        <td>7.0%</td>
                        <td style="text-align:right !important;">{{number_format($surcharge,2)}}</td>
                        <td>Statutory rate. DO NOT ALTER</td>
                    </tr>
                    <tr style="background-color:#fff;">
                        <td>6</td>
                        <td>ETLS (% of CIF)</td>
                        <td>%</td>
                        <td>0.5%</td>
                        <td style="text-align:right !important;">{{number_format($etls,2)}}</td>
                        <td>Statutory rate. DO NOT ALTER</td>
                    </tr>
                    <tr style="background-color:#fff;">
                        <td>7</td>
                        <td>CISS (% of FOB)</td>
                        <td>%</td>
                        <td>1.0%</td>
                        <td style="text-align:right !important;">{{number_format($ciss,2)}}</td>
                        <td>Statutory rate. DO NOT ALTER</td>
                    </tr>
                    <tr style="background-color:#fff;">
                        <td>8</td>
                        <td>CUSTOM VAT</td>
                        <td>%</td>
                        <td style="background-color:#fcd5b4;">7.5%</td>
                        <td style="text-align:right !important;">{{number_format($vat,2)}}</td>
                        <td>depending item HS code.</td>
                    </tr>
                    <tr style="background-color:#fff;">
                        <td>9</td>
                        <td>Local Handling (% of CIF)</td>
                        <td>%</td>
                        <td>1.0%</td>
                        <td style="text-align:right !important;">{{number_format($local_handling,2)}}</td>
                        <td>Statutory rate. DO NOT ALTER</td>
                    </tr>
                    <tr style="background-color:#fff;">
                        <td></td>
                        <td>Subtotal - B Total Landing cost</td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right !important;">{{number_format($subtotal_b,2)}}</td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#fff; vertical-align:bottom !important;">
                        <td>10</td>
                        <td>Markup (% of SUBTOTAL B)</td>
                        <td>%</td>
                        <td style="background-color:#fff000;">9.0%</td>
                        <td style="text-align:right !important;">{{number_format($mark_up,2)}}</td>
                        <td>
                            Vendor to insert their mark-up
                            percentage. This should
                            EXCLUDE VAT
                        </td>
                    </tr>
                    <tr style="background-color:#c5d9f1; font-weight:bold !important;">
                        <td>C</td>
                        <td><b>Total Selling Price (Subtotal B+Mark up)= C</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right !important;">{{number_format($total_selling,2)}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="col-3" style="position: absolute; float:right; margin-right:-42px;">
            <table style="font-size:7px !important; border:1px solid #fff !important; border-collapse: collapse; width:85%;">
                <thead>
                    <tr>
                        <th style="width:50%;">Weight of Item</th>
                        <th style="width:50%;">Guidance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="">
                        <td style="background-color: #ccc0da;height: 110px;vertical-align:bottom;text-align:right;"> {{$line_item->weight}} </td>
                        <td style="background-color: #538dd5; vertical-align:bottom"> 
                            <b>Vendor may
                            insert different
                            weights to test
                            final price.
                            Formula column
                            'E10' is 25kg X $4
                            as an example</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> 
        </div>
        
        <div class="col-9" style="display:flex; color: #0000ff;">
        <table style="font-size:7px !important; left:0px !important; margin-left:-17px; border:1px solid white !important; border-collapse: collapse; width:95%; vertical-align:bottom !important;">
                <thead style="background-color: #fff; font-weight: bold; vertical-align:bottom; border:1px solid white !important;">
                    <tr>
                    <th style="width:3%; border:1px solid white !important;">&nbsp;&nbsp;</th>
                    <th style="width:43%; border:1px solid white !important;"></th>
                    <th style="width:13%; border:1px solid white !important;">NET VALUE</th>
                    <th style="width:10%; border:1px solid white !important;"></th> 
                <th style="width:10%; border:1px solid white !important; text-align:right; !important">{{number_format($total_selling,2)}}</th>
                    <th style="width:21%; border:1px solid white !important;"></th>
                    </tr>
                </thead>
        </table>
        </div>
        
        <div>
                <p style="line-height: 7px;"><b>Table 2.0</b><br/>
                Guidance: Input actual rates per kg in USD</p>
        </div>
        
         <div class="col-11" style="">
            <table style="margin-left:-17px; font-size:7px !important; border:1px solid #fff !important; border-collapse: collapse; width:95%;">
                <thead>
                    <tr>
                        <th colspan="7">AIR FREIGHT PRICING</th>
                    </tr>
                    <tr style="background-color:#f2f2f2">
                        <th style="width:5%;">&nbsp;</th>
                        <th style="width:40%;">Weight range in KG</th>
                        <th style="width:13%;">Unit price in $/kg - Europe</th>
                        <th style="width:13%;">Unit price in $/kg - UK</th>
                        <th style="width:13%;">Unit price in $/kg - USA</th>
                        <th style="width:13%;">Unit price in $/kg - China / Asia</th>
                        <th style="width:13%;">Unit price in $/kg - Middle East</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> 1 </td>
                        <td> 1 - 50 </td>
                        <td style="background-color:#fff000; text-align: right;"> 7.5 </td>
                        <td style="background-color:#fff000; text-align: right;"> 7 </td>
                        <td style="background-color:#fff000; text-align: right;"> 8.5 </td>
                        <td style="background-color:#fff000; text-align: right;"> 12 </td>
                        <td style="background-color:#fff000; text-align: right;"> 11 </td>
                    </tr>
                    <tr>
                        <td> 2 </td>
                        <td> 51 - 100 </td>
                        <td style="background-color:#fff000; text-align: right;"> 7.5 </td>
                        <td style="background-color:#fff000; text-align: right;"> 7 </td>
                        <td style="background-color:#fff000; text-align: right;"> 8.5 </td>
                        <td style="background-color:#fff000; text-align: right;"> 11 </td>
                        <td style="background-color:#fff000; text-align: right;"> 10 </td>
                    </tr>
                    <tr>
                        <td> 3 </td>
                        <td> 100 - 150 </td>
                        <td style="background-color:#fff000; text-align: right;"> 7 </td>
                        <td style="background-color:#fff000; text-align: right;"> 6.5 </td>
                        <td style="background-color:#fff000; text-align: right;"> 8 </td>
                        <td style="background-color:#fff000; text-align: right;"> 10 </td>
                        <td style="background-color:#fff000; text-align: right;"> 9 </td>
                    </tr>
                </tbody>
            </table>
        </div> 
        <div class="col-9" style="margin-left:-17px; padding-top:10px;">
                            @if($rfq->technical_note != NULL)
                           
                                <p style="color:red; font-weight: bold; margin-left: 0px; font-size: 5pt !important; font-family: Calibri, sans-serif;"><b>Technical Notes: </b>
                                <span style="font-size: 5pt !important; font-family: Calibri, sans-serif; page-break-inside: avoid;">
                                {!! htmlspecialchars_decode($rfq->technical_note)!!}</span>
                                </p>
                               
                            @endif
                            
                            <style>
                                .no-page-break {
                                    display: block;
                                    position: relative;
                                    page-break-inside: avoid !important;
                                }
                            </style>
                        @php
                        $sn = 1;
                        @endphp
                        <div style="page-break-inside: avoid;">
                            <p style="font-size: 5pt !important; font-family: Calibri, sans-serif !important; margin-left:0px; font-weight:400;"><b style="color:red;">Notes to Pricing: </b><br/>
                            {{ $sn }}. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }}.<br/>
                            @php $sn += 1 @endphp
                            
                        @if($rfq->transport_mode == 'Undecided' OR $rfq->incoterm == 'Ex Works')
                             
                        @else
                            {{ $sn }}. Mode of transportation: {{ $rfq->transport_mode ?? ''}}
                            <br/>
                        @php $sn += 1 @endphp
                            @endif
                            {{ $sn }}. Delivery Location: {{ $rfq->delivery_location ?? ''}} 
                            <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Where Legalisation of C of O and/or invoices are required, additional cost will apply
                                and will be charged at cost. <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Validity: This quotation is valid for {{ $rfq->validity ?? ''}}. <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Pricing: Prices quoted are in {{ $rfq->currency ?? 'USD' }} <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Prices are based on quantity quoted <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. A revised quotation will be submitted for confirmation in the event of a partial order. <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Oversized Cargo: {{ $rfq->oversized ?? 'NO' }} <br/>
                            @php $sn += 1 @endphp
                            
                            {{ $sn }}. Pricing is exclusive of VAT.
                                <br/>
                            @php $sn += 1 @endphp
                                
                            {{ $sn }}. Payment Term: {{ $rfq->payment_term ?? '' }} <br/>
                            @php $sn += 1 @endphp
                            
                            @if($rfq->vendor_id == '167')
                            {{ $sn }}. Goods will be cleared in South Africa by Bosch Authorised Export Agent. <br/><br/>
                            @else
                            <br/>
                            @endif
                            <b>Best Regards </b> <br/>
                            </p> 
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $logsign = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->signature; @endphp
                                    <img src="{{ $logsign }}" width="80" style="margin-left:0px; margin-top:5px;padding-bottom:10px;" alt="SCM Solutions">
                                @endforeach
                             <br/><br/>
                            <div class="line" style="width: 100px;height: 0.7px;background-color: #000;float:left;margin-top:-27px;margin-right:-10px;"></div>
                            <div style="margin-top:-25px;">
                            <p style="margin-top:0px; margin-left:0px; color:black; font-size:5pt !important;">
                                @foreach (emps($rfq->employee_id) as $emp)
                                    @php 
                                        $email = $emp->email;
                                        $userDe = userEmail($email);
                                    @endphp
                                    <b>{{ $userDe->first_name . ' '.  strtoupper($userDe->last_name) ?? ' ' }} </b>
                                @endforeach
                            </p>
                            <p style="margin-top: -5px; font-size:5pt !important;"></p>
                                <p style="margin-top: -8px; font-size:5pt !important;"><b>
                                 @foreach (comp($rfq->company_id) as $comps) {{ 'For: '. $comps->company_name ?? ' Company Name' }} @endforeach </b>
                            </p>
                            </div>
                            </div>
            </div>
            
</div>
@php
$count++
@endphp
@endforeach
    @endif

@endsection

