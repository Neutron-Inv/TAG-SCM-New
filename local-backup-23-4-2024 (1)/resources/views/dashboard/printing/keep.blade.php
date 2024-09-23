<?php
// $title = 'Price Quotation';

$title = "TAG Energy Quotation " .$rfq->refrence_no . ", ". $rfq->description;
// dd($title);
set_time_limit(900);
?>

@extends('layouts.print')
@section('content')


    @if(count($line_items) == 0)
        <h3><p style="color:red" align="center"> No Line Item was found for the RFQ </p></h3>
    @else
        <div class="invoice-container" id="printableArea" style="background-color: white !important;font-family: Calibri, sans-serif;border-box;">
            <p style="font-size: 8.0pt;font-family: Calibri,sans-serif;float: right;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">SCM 208 v1.0 </p><br style="border-box;">
            <div class="invoice-header" style="font-family: Calibri, sans-serif;border-box;padding: .5rem 1.5rem;">

                <div class="row gutters" style="border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -8px;margin-left: -8px;">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;
                        -ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;">
                        <div class="invoice-logo" style="border-box;font-size: 1.2rem;color: #074b9c;font-weight: 700;">
                            <img src="https://scm.enabledjobs.com/pat/image019.png" style="width: 101px;margin-left: -5px;border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;" alt="SCM Solutions">

                        </div>
                        <br style="border-box;">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left: -12px;font-family: Calibri,sans-serif;margin-top: -10px;border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;">
                            @foreach (clis($rfq->client_id) as $cli)
                                <p style="font-size: 9.9pt;font-family: Calibri,sans-serif;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                    <strong style="border-box;font-weight: bolder; orphans: 3;widows: 3;line-height: 180%;font-weight: 400;"> <b>{{ $cli->client_name ?? ' ' }} </b> </strong>
                                </p><br style="border-box;">
                                <p style="font-size: 9.9pt;margin-top: -27px;border-box;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                    {{ $cli->address ?? ' ' }}
                                </p><br style="border-box;">
                            @endforeach

                            @foreach (buyers($rfq->contact_id); as $buy)
                                <h6 style="font-size: 8.9pt;border-box;margin-top: 0;margin-bottom: .2rem;font-weight: 700;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                    <b>Attn: {{ $buy->first_name . ' '. $buy->last_name ?? ' '}} </b>
                                </h6>
                                <h6 style="font-size: 8.9pt;border-box;margin-top: 0;margin-bottom: .2rem;font-weight: 700;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                    <b><u style="color: blue;border-box;">{{ $buy->email ?? ' ' }}</u></b>
                                </h6>
                                <h6 style="font-size: 8.9pt;border-box;margin-top: 0;margin-bottom: .2rem;font-weight: 700;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                    <b>Tel: {{ $buy->office_tel ?? ' ' }} </b>
                                </h6><br style="border-box;">
                             @endforeach
                            <h6 style="font-size: 8.9pt;margin-top: -20px;border-box;margin-bottom: .2rem;font-weight: 700;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                <b>Rfx: {{ $rfq->rfq_number ?? ' ' }} </b>
                            </h6><br style="border-box;"><br style="border-box;">

                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8" style="margin-left:510px ;" align="right">

                        <p style="font-size: 9.5pt;font-family: Calibri,sans-serif;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400; margin-left:30px;">{{ $rfq->client->client_name ?? ' ' }} </p>
                        <p style="font-size: 9.5pt;font-family: Calibri,sans-serif;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;"><strong style="border-box;font-weight: bolder;">REF No: {{ $rfq->refrence_no ?? ' ' }} </strong></p>
                        <img src="https://scm.enabledjobs.com/img/price.png" style="width: 260px;height: 95px;margin-top: 25px;border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;" alt="Certification">
                        <br style="border-box;">
                        <p style="font-size: 8.9pt;font-family: Calibri,sans-serif;border-box;margin-top: -130;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;
                        font-weight: 300;">{{ date("l, d F Y") }} </p>
                    </div>

                </div><br>

                <div class="row gutters" >

                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left: 6px; font-size: 9.9pt;  margin-top:-214px;">
                        <p style="font-size: 11.5pt;font-family:Calibri,sans-serif; margin-left: 3px;">
                            @foreach (comp($rfq->company_id) as $comps)
                                <b> {{ $comps->company_name  .' Quotation for '. $rfq->product ?? ' '}} </b>
                            @endforeach

                        </p>
                        <div class="table-responsive" style="font-size: 9.9pt;font-family: Calibri, sans-serif;border-box;display: block;width: 90%;overflow-x: auto;-webkit-overflow-scrolling: touch;">

                            <table class="table" style="font-size: 9.9pt;font-family: Calibri, sans-serif;border-box;border-collapse: collapse!important;width: 1150px;margin-bottom: 1rem;color: #000000;background: #ffffff;
                                border: 0;-webkit-print-color-adjust: exact;">
                                <thead class="text-white" style="font-size: 9.9pt;font-family: Calibri, sans-serif;border-box;display: table-header-group;background: #6610f2;color: #000000 !important;">
                                    <tr style="border: 2mm ridge black; border-bottom: ridge;border-bottom-color: #dd3939;font-size: 9.9pt;font-family: Calibri, sans-serif;border-box;page-break-inside: avoid;">
                                        <th class="" style="border: 2mm ridge #000000; padding-top: 3px;width: 30px;background-color: #C4D79B !important;font-family: Calibri, sans-serif;
                                            font-size: 9.9pt;border-box;text-align: inherit;
                                            padding: .25rem .75rem .10rem .25rem; margin-top:-19px; border-bottom: ridge; border-bottom-color: #000000;
                                            vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;">
                                            <strong style="border-box;font-weight: bolder; color: #000000;" >Item </strong>
                                        </th>
                                        <th class="" style="padding-top: 3px;width: 400px;color: black;background-color: #F0F3F4 !important;text-align: left;
                                            font-family: Calibri, sans-serif;font-size: 9.9pt;border-box; border-bottom: ridge; border-bottom-color: #000000;
                                            padding: .25rem .75rem .10rem .25rem;vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;
                                            border: 0;">
                                            <b style="border-box;font-weight: bolder; color: black;"> Description  </b>
                                        </th>

                                        <th class="" style="padding-top: 3px;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 9.9pt;
                                            border-box; text-align: right;
                                            padding: .25rem .75rem .10rem .30px; width: 50%; border-bottom: ridge; border-bottom-color: #000000;
                                            vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;" align="right">
                                            <b style="border-box;font-weight: bolder; color: black;">UOM </b>
                                        </th>

                                        <th class="" style="text-color:#000000; padding-top: 3px;text-align: center;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 9.9pt;border-box;
                                            padding: .25rem .75rem .10rem .25rem;border-bottom: ridge; border-bottom-color: #000000;
                                            vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;">
                                            <b style="border-box;font-weight: bolder; color: black;"> Qty </b>
                                        </th>

                                        <th style="padding-top: 3px;text-align: center;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 9.9pt;width: 120px;border-box;
                                            padding: .25rem .75rem .10rem .25rem;border-bottom: ridge; border-bottom-color: #000000;
                                            vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;"><b style="border-box;font-weight: bolder;"> Unit Price
                                            <br style="border-box;"><span style="text-align: center;border-box; color: black;"> ({{ $rfq->currency ?? 'USD' }})  </span>
                                        </th>

                                        <th style="padding-top: 3px;text-align: center;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 9.9pt;width: 120px;border-box;
                                            padding: .25rem .75rem .10rem .25rem; border-bottom: ridge; border-bottom-color: #000000;
                                            vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;">
                                            <b style="border-box;font-weight: bolder; color: black;"> Total Price
                                            <br style="border-box;"><span style="text-align: center;border-box; color: black;">  ({{ $rfq->currency ?? 'USD' }})</span></b>
                                        </th>
                                    </tr>

                                </thead>
                                <tbody style="font-size: 9.9pt;font-family: Calibri, sans-serif;border-box;">

                                    <?php $num =1; $wej = array(); ?>
                                    @foreach ($line_items as $items)
                                        @php
                                            $unit_cost = $items->unit_cost;
                                            $percent = $items->unit_frieght;
                                            $unitMargin = (($percent/100) * $items->unit_cost);
                                        @endphp
                                        <tr style="font-size: 9.0pt; font-family: Calibri, sans-serif; orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                            <td class="list" style="padding-top: 2px; background-color: #EBF1DE !important; text-align: center; font-family: Calibri, sans-serif;
                                                font-size: 9.0pt;">
                                                {{-- <b>{{ $num }}</b> --}}
                                                <p style="margin-top:-5px; font-size: 9.0pt; font-family: Calibri, sans-serif;"> <b>{{ $num }} </b></p>
                                            </td>
                                            <td style="padding-top: 2px; text-align: justify; text-justify: inter-word;">
                                                <p style="margin-top:-5px; font-size: 9.0pt; font-family: Calibri, sans-serif;"> <b>{{ $items->item_name }} </b></p>
                                                <p style="font-size: 9.0pt; orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                                    {!! htmlspecialchars_decode($items->item_description) ?? 'N/A' !!}
                                                </p>
                                            </td>

                                            @foreach (getUOM($items->uom) as $item)
                                                <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; font-size: 9.0pt; font-family: Calibri, sans-serif; text-align: right;"><b> {{$item->unit_name ?? ''}} </b></td>
                                            @endforeach

                                            <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; text-align: center; font-size: 9.0pt; font-family: Calibri, sans-serif;"><b > {{$items->quantity ?? 0}} </b></td>

                                            <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; font-size: 9.0pt; font-family: Calibri, sans-serif;" align="center"><b> {{number_format($items->unit_quote, 2) ?? 0}}</b> </td>

                                            <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; font-size: 9.0pt; font-family: Calibri, sans-serif;" align="center"><b> {{ number_format($items->total_quote, 2) }} </b></td>
                                            @php $tot = $items->quantity * $items->unit_quote;
                                            array_push($wej, $tot);  @endphp
                                        </tr><?php $num++; ?>
                                    @endforeach

                                    <tr style="font-size: 9.9pt; font-family: Calibri, sans-serif;">

                                        <td colspan="2" style="background-color:white; padding-top: 3px; border:#000000; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                            <p style="font-size: 10pt; font-family: Calibri, sans-serif; margin-left:-5px"><b style="color:red"><b>ESTIMATED PACKAGED WEIGHT: {{ $rfq->estimated_package_weight}} <br>
                                            ESTIMATED PACKAGED DIMENSION : {{ $rfq->estimated_package_dimension}}<br>
                                            HS CODE: {{ $rfq->hs_codes ?? 'N/A' }}</b> <br>
                                            @if($rfq->certificates_offered != NULL)
                                                <b>CERTIFICATE OFFERED: {{strtoupper($rfq->certificates_offered)}}</b>
                                            @endif
                                        </td>

                                        @php $sumTotalQuote = sumTotalQuote($rfq->rfq_id); $ship=0; @endphp
                                        <td style="background-color:white;"> </td> <td style="background-color:white;"> </td>

                                        <td colspan="3" style="background-color:white; font-size: 9.0pt; font-family: Calibri, sans-serif; margin-left: 100px;" align="left">
                                            <p style="border-bottom: ridge; border-bottom-color: #000000; border-top: ridge;
                                                border-top-color: #000000; text-align: center; width: 65%; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                                <strong> Sub total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="text-align: ;"> {{ number_format($sumTotalQuote,2 )  }}</strong>
                                            </p>

                                            <p style="text-align: center; width: 65%; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                                <b> Total </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <strong ><span style="">{{ number_format($sumTotalQuote + $ship, 2) ?? 0 }} </strong>
                                            </p>
                                            <p style="border-bottom: ridge; border-bottom-color: #000000; border-top: ridge; border-top-color: #000000; width: 65%;"></p>
                                            <p style="border-bottom: double; border-bottom-color: #000000; border-top-color: #000000; width: 65%;"></p>
                                        </td>
                                    </tr>
                                    @if($rfq->technical_note != NULL)
                                        <tr>
                                            <td colspan="4" style="background-color:white; font-size: 9.9pt; font-family: Calibri, sans-serif;">

                                                <p style="color:red; font-weight: bold; margin-left: -5px; font-size: 9.9pt; font-family: Calibri, sans-serif;"><b>Technical Notes: </b>
                                                {!! htmlspecialchars_decode($rfq->technical_note)!!}</p>
                                                <br>

                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        <div class="table-responsive" style="font-size: 9.9pt;font-family: Calibri, sans-serif;border-box;display: block;width: 90%;overflow-x: auto;-webkit-overflow-scrolling: touch;">

                            <table class="table" style="font-size: 9.9pt;font-family: Calibri, sans-serif;border-box;border-collapse: collapse!important;width: 1150px;margin-bottom: 1rem;color: #000000;background: #ffffff;">

                                <tr>

                                    <td colspan="3" style="background-color:white; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                        <p style="font-size: 10.5pt; font-family: Calibri; margin-left:-5px"><b style="color:red">Notes to Pricing: </b><br>
                                        1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }} after Confirmed Order.<br>
                                        <b>2. Mode of transportation: <b>{{ $rfq->transport_mode ?? ''}} </b></b>
                                        <br>
                                        <b>3. Delivery Location: <b>{{ $rfq->delivery_location ?? ''}} </b></b>
                                        <br>
                                        4. Where Legalisation of C of O and/or invoices are required, additional cost will apply
                                            and will be charged at cost. <br>
                                        5. Validity: This quotation is valid for <b>{{ $rfq->validity ?? ''}}. </b><br>
                                        6. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br>
                                        7. Pricing: Prices quoted are in <b>{{ $rfq->currency ?? 'USD' }} </b><br>
                                        8. Prices are based on quantity quoted <br>
                                        9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
                                        10. Oversized Cargo: <b>{{ $rfq->oversized ?? 'NO' }} </b><br>
                                        <b> Best Regards  <br>
                                        <img src="https://scm.enabledjobs.com/pat/image017.png" style="width:80px; height:80px; margin-left:0px; margin-top:10px;" alt="SCM Solutions" /> <br><br>
                                        <p style="margin-top: -45px; margin-left:0px; color:black;">
                                            @foreach (emps($rfq->employee_id) as $emp)
                                                <b>{{ $emp->full_name ?? ' ' }} </b>
                                            @endforeach

                                        </p>
                                        <p style="margin-top: -8px; margin-left:0px"><b>
                                            For: TAG Energy Nigeria. </b>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>


            </div>

        </div>
    @endif

@endsection

