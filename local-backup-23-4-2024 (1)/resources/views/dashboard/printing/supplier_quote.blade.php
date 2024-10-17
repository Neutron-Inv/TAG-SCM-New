

<?php
$title = "QUOTATION" . $rfq->refrence_no . ", ". $rfq->description;
set_time_limit(900);
?>
@extends('layouts.print')
@section('content')

@if(count($line_items) == 0)
    <h3><p style="color:red" align="center"> No Line Item was found for the RFQ </p></h3>
@else

    <style>
        /*@page { size: 10cm 20cm landscape; }*/
  </style>
    <div class="invoice-container" id="printableArea" style="background-color: white !important;font-family: Calibri, sans-serif;border-box;">
        <p style="font-size: 8.0pt;font-family: Calibri,sans-serif;float: right;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">SCM 219</p><br style="border-box;">
        <div class="invoice-header" style="font-family: Calibri, sans-serif;border-box;padding: .5rem 1.5rem;">

            <div class="row gutters" style="border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -8px;margin-left: -8px;">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;
                    -ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;">
                    <div class="invoice-logo" style="border-box;font-size: 1.2rem;color: #074b9c;font-weight: 700;">

                        @foreach (getLogo($rfq->company_id) as $item)
                            @php $log = 'https://scm.enabledjobs.com/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                            <img src="{{$log}}" style="width: 200px; margin-left: -20px;" alt="{{$log}}">
                        @endforeach
                    </div>
                    <br style="border-box;">
                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left: 25px;font-family: Calibri,sans-serif;margin-top: -10px;border-box;position: relative;width: 100%;padding-right: 15px;
                        padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;">
                        @foreach ($sup as $sups)
                            <p style="font-size: 11.0pt;font-family: Calibri,sans-serif;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                <strong style="border-box;font-weight: bolder; orphans: 3;widows: 3;line-height: 180%;font-weight: 400;"> <b>{{ $sups->vendor_name ?? ' ' }} </b> </strong>
                            </p><br style="border-box;">
                            <p style="font-size: 11.0pt;margin-top: -27px;border-box;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                {{ $sups->address ?? ' ' }}
                            </p><br style="border-box;">
                        
                            <h6 style="font-size: 10.0pt;border-box;margin-top: 0;margin-bottom: .2rem;font-weight: 700;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                                <b>Attn: {{ $sups->contact_name ?? ' '}} </b>
                            </h6>
                            
                         @endforeach
                         <p style="font-size: 11.5pt;font-family:Calibri,sans-serif; margin-left: 3px;">
                            <b><u> Ref No: {{ $po->supplier_ref_number ?? 'N/A'  }} </u> </b>
                        </p>
                        
                        
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8" style="margin-left:520px ;" align="">

                    @foreach ($sup as $sups)
                        <p style="font-size: 11.5pt;font-family: Calibri,sans-serif;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;
                        line-height: 180%;font-weight: 450; margin-left:460px;">
                            {{ $sups->vendor_name ?? ' Supplier Name ' }} 
                        </p>
                    @endforeach
                    
                    <p style="margin-left:468px; font-size: 11.0pt;font-family: Calibri,sans-serif;border-box;margin-top: 0;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 180%;font-weight: 400;">
                        <!--<strong style="border-box;font-weight: bolder;">REF No: {{ $rfq->refrence_no ?? ' ' }} </strong>-->
                        @foreach(getVen($rfq->vendor_id) as $vends)
                            <strong style="border-box;font-weight: bolder;">REF No: {{ 'TE-' . $vends->vendor_code . '-'. $rfq->short_code ?? ' ' }} </strong>
                        
                        @endforeach
                    </p>
                    <img src="https://scm.enabledjobs.com/img/label.png" style="margin-left:280px; width: 400px;height: 130px; padding-top:10px; margin-top: 5px;border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;" alt="Certification">
                    <br style="border-box;">
                    <p style="margin-left:498px; font-size: 10.9pt;font-family: Calibri,sans-serif;border-box;margin-top: -13;margin-bottom: 2px;orphans: 3;widows: 3;line-height: 190%;
                    font-weight: 300;">{{ date("l, d F Y") }} </p>
                </div>

            </div><br>

            <div class="row gutters" >

                <div class="col-lg-12 col-md-12 col-sm-12" style="padding-left: 15px; margin-left: 33px; font-size: 10.9pt;  margin-top:-200px;">

                    <p style="font-size: 11.0pt;font-family:Calibri,sans-serif;">
                        We are pleased to issue this purchase order in response to the pricing in your quotation. <br>
                        By this letter, we request that you commence the immediate supply and ensure compliance as per your quotation <br>
                        and the specification.
                    </p><br>
                
                    <div class="table-responsive" style="font-size: 10.9pt;font-family: Calibri, sans-serif;border-box;display: block;width: 150%;overflow-x: auto;-webkit-overflow-scrolling: touch;">

                        <table class="table" style="font-size: 10.9pt;font-family: Calibri, sans-serif;border-box;border-collapse: collapse!important;width: 890px;margin-bottom: 1rem;color: #000000;background: #ffffff;
                            border: 0;-webkit-print-color-adjust: exact;">
                            <thead class="text-white" style="font-size: 10.9pt;font-family: Calibri, sans-serif;border-box;display: table-header-group;background: #6610f2;color: #000000 !important;">
                                <tr style="border: 2mm ridge black; border-bottom: ridge;border-bottom-color: #dd3939;font-size: 10.9pt;font-family: Calibri, sans-serif;border-box;page-break-inside: avoid;">
                                    <th class="" style="border: 2mm ridge #000000; padding-top: 3px;width: 30px;background-color: #C4D79B !important;font-family: Calibri, sans-serif;
                                        font-size: 10.9pt;border-box;text-align: inherit;
                                        padding: .25rem .75rem .10rem .25rem; margin-top:-19px; border-bottom: ridge; border-bottom-color: #000000;
                                        vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;">
                                        <strong style="border-box;font-weight: bolder; color: #000000;" >Item </strong>
                                    </th>
                                    <th class="" style="padding-top: 3px;width: 710px;color: black;background-color: #F0F3F4 !important;text-align: left;
                                        font-family: Calibri, sans-serif;font-size: 10.9pt;border-box; border-bottom: ridge; border-bottom-color: #000000;
                                        padding: .25rem .75rem .10rem .25rem;vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;
                                        border: 0;">
                                        <b style="border-box;font-weight: bolder; color: black;"> Description  </b>
                                    </th>

                                    <th class="" style="padding-top: 3px;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 10.9pt;
                                        border-box; text-align: right;
                                        padding: .25rem .75rem .10rem .30px; width: 50%; border-bottom: ridge; border-bottom-color: #000000;
                                        vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;" align="right">
                                        <b style="border-box;font-weight: bolder; color: black;">UOM </b>
                                    </th>

                                    <th class="" style="text-color:#000000; padding-top: 3px;text-align: cneter;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 10.9pt;border-box;
                                        padding: .25rem .75rem .10rem .25rem;border-bottom: ridge; border-bottom-color: #000000;
                                        vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;">
                                        <b style="border-box;font-weight: bolder; color: black;"> Qty </b>
                                    </th>

                                    <th style="padding-top: 3px;text-align: right;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 10.9pt;width: 120px;border-box;
                                        padding: .25rem .75rem .10rem .25rem;border-bottom: ridge; border-bottom-color: #000000;
                                        vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;"><b style="border-box;font-weight: bolder;"> Unit Price
                                        <br style="border-box;"><span style="text-align: center;border-box; color: black;"> ({{ $rfq->currency ?? 'USD' }})  </span>
                                    </th>

                                    <th style="padding-top: 3px;text-align: right;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 10.9pt;width: 120px;border-box;
                                        padding: .25rem .75rem .10rem .25rem; border-bottom: ridge; border-bottom-color: #000000;
                                        vertical-align: top;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;font-weight: 600;border: 0;">
                                        <b style="border-box;font-weight: bolder; color: black;"> Total Amount
                                        <br style="border-box;"><span style="text-align: center;border-box; color: black;">  ({{ $rfq->currency ?? 'USD' }})</span></b>
                                    </th>
                                </tr>

                            </thead>
                            <tbody style="font-size: 10.9pt;font-family: Calibri, sans-serif;border-box;">

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
                                            
                                            <p style="margin-top:-5px; font-size: 9.0pt; font-family: Calibri, sans-serif;"> <b>{{ $num }} </b></p>
                                        </td>
                                        <td style="padding-top: 2px;">
                                            <p style="margin-top:-5px; font-size: 9.0pt; font-family: Calibri, sans-serif;"> 
                                                <b>{{ $items->item_name }} <br></b>
                                                {!! $items->item_description ?? 'N/A' !!}
                                            </p>
                                            
                                        </td>

                                        @foreach (getUOM($items->uom) as $item)
                                            <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; font-size: 9.0pt; font-family: Calibri, sans-serif; text-align: center;">
                                                {{$item->unit_name ?? ''}} </td>
                                        @endforeach

                                        <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; text-align: right; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{$items->quantity ?? 0}} </td>

                                        <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; font-size: 9.0pt; font-family: Calibri, sans-serif;" align="right"> 
                                            {{number_format($items->unit_cost, 2) ?? 0}} 
                                        </td>

                                        <td style="orphans: 3;widows: 3;line-height: 180%;font-weight: 400; padding-top: 2px; font-size: 9.0pt; font-family: Calibri, sans-serif;" align="right">
                                             <!--{{ number_format($items->unit_cost * $items->quantity, 2) }} -->
                                             {{ number_format($items->total_cost,2) }}
                                             </td>
                                             <!--$tot = $items->quantity * $items->unit_cost;-->
                                        @php 
                                        
                                        $tot = $items->unit_cost * $items->total_cost;
                                        array_push($wej, $tot);  @endphp
                                    </tr><?php $num++; ?>
                                @endforeach

                                <tr style="font-size: 10.9pt; font-family: Calibri, sans-serif;">

                                    <td colspan="4" style="background-color:white; padding-top: 3px; border:#000000; font-size: 9.0pt; font-family: Calibri, sans-serif;">
                                        
                                    </td>

                                    @php $sumTotalQuote = sumTotalQuote($rfq->rfq_id); $ship=0; @endphp
                                    @php $sumTotalQuote = sumTotalQuote($rfq->rfq_id); $ship=0; @endphp
                                    <td colspan="2" style="background-color:white; font-size: 10.9pt font-family: Calibri, sans-serif; margin-left: 100px;" align="left">
                                        
                                        <p style="text-align: right; width: 100%; font-size: 10.9pt; font-family: Calibri, sans-serif;">
                                            <b style="">Sub Total </b> &nbsp;&nbsp;
                                            <strong ><span style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($tq, 2) ?? 0 }} </strong>
                                        </p>

                                        @if($rfq->freight_cost_option == 'YES')
                                            @php $fri = $po->freight_charges_suplier; @endphp
                                            <p style="text-align: left; width:100%; font-size: 10.9pt; font-family: Calibri, sans-serif;">
                                                <strong style="margin-left: 200px;">  <b> Freight Costs to {{ $po->port_of_discharge ?? ''}}</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <!--<b> Freight Costs to Lagos</b><strong style="padding-left:">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                                <span style="text-align: right;"> {{ number_format($fri,2 )  }}</strong>
                                            </p>
                                        @else 
                                            @php $fri = 0; @endphp
                                            
                                        @endif
                                        <br>
                                        <!--$tot  was removed-->
                                        <p style="border-bottom: ridge; border-bottom-color: #000000; border-top-color: #000000; width: 105%; margin-bottom:;"></p>
                                        <p style="text-align: right; width: 100%; font-size: 10.9pt; font-family: Calibri, sans-serif; ">
                                            <b style=""> Total </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong ><span style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($tq + $ship + $fri, 2) ?? 0 }} </strong>
                                        </p>
                                        
                                        <p style="border-bottom: double; border-bottom-color: #000000; border-top-color: #000000; width: 105%; margin-bottom:;"></p>

                                        <p style="border-bottom: double; border-bottom-color: #000000; border-top-color: #000000; width: 105%; margin-bottom:;"></p><br>
                                    </td>
                                </tr>

                                
                            </tbody>
                        </table>
                    </div>
                   
                    @if(count($line_items) == 1)   
                     	<br> <br>
		            @elseif(count($line_items) > 1)
                        <br><br><br>                    
 		            @elseif((count($line_items) > 2) AND ($po->technical_notes == 'N/A'))
                    
                        <br><br><br>                    
                    @else
                        <br><br><br>                    
		            @endif
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9" style="margin-top: -160px;">
                        
                        
                        <p style="font-size: 11.5pt; font-family: Calibri; margin-left:-5px">
                            <b style="color:red">Total Packaged Weight:{{ $po->total_packaged_weight ?? ' ' }}</b><br>
                        </p> 
                        <p style="font-size: 11.5pt; font-family: Calibri; margin-left:-5px">
                            <b style="color:red">Estimated Package Dimension: {{ wordwrap($po->estimated_packaged_dimensions, 100,"<br>\n") ?? ' ' }}</b><br>
                        </p> 
                        <p style="font-size: 11.5pt; font-family: Calibri; margin-left:-5px">
                            <b style="color:red">HSCODE: {{ $po->hs_codes_po ?? ' ' }}</b><br>
                        </p>   
                        <br>
                        @if($po->technical_notes != 'N/A')
                           
                            <p style="color:red; font-weight: bold; margin-left: -5px; font-size: 9.9pt; font-family: Calibri, sans-serif;"><b>Technical Notes: </b>
                            {!! wordwrap(htmlspecialchars_decode($po->technical_notes), 90,"<br>\n") !!}
                            </p>
                            <br>
    
                        @endif
                        
                        
                                             
			            <p style="font-size: 11.5pt; font-family: Calibri; margin-left:-5px">
                            <b style="color:red">NOTE: </b><br>
                        </p>
                        <b> 1. Delivery: </b>  {{ $po->delivery }}.<br>
                        <b> 2. Delivery Locations:</b> {{ $po->delivery_location_po }} <br>
                        <b>3.  Payment Terms: <b>{{ $po->payment_terms }}
                        <br>
                        <b>
                        4. Contact:  </b>
                        @foreach (emps($rfq->employee_id) as $emp)
                            @php 
                                $email = $emp->email;
                                $userDe = userEmail($email);
                            @endphp
                            {{ $userDe->first_name . ' '.  strtoupper($userDe->last_name) ?? ' ' }} , +234 1 342 8420, sales@tagenergygroup.net
                        @endforeach 
                         
                        <br>      
                         @if($rfq->freight_cost_option == 'YES')
                    
                        @else   
                            <br><br>
                        @endif
                        <p style="font-size: 12.5pt; font-family: Calibri; margin-left:-5px">
                            Please kindly endorse below with your signature and company stamp to accept this order.
                        </p>
                        @if(count($line_items) == 1)  
                        
                            <br>
                            <!--<br><br><br><br><br><br><br><br><br>-->
                            
                        @elseif(count($line_items) > 1)
                            <br>
                        
                            <!--<br><br><br><br><br><br><br><br><br>-->
                        @elseif((count($line_items) > 2) AND ($po->technical_notes == 'N/A'))
                        
                            <br>
                        @else
                            <br>
                        @endif
                    </div>
                    <div class="row gutters" style="border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -8px;">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="margin-top:22px;">
                            <b> Best Regards  <br>
                            <img src="https://scm.enabledjobs.com/pat/image017.png" style="width:80px; height:80px; margin-left:0px; margin-top:10px;" alt="" /> <br><br>
                            
                            <hr style="width:35%;text-align:left;margin-left:0; margin-top:-21px;">
                            <p style="font-size: 11.5pt; font-family: Calibri; margin-left:-5px; margin-top:-15px;">
                                @foreach (emps($rfq->employee_id) as $emp)
                                    <b>{{ $emp->full_name ?? ' ' }} </b>
                                @endforeach<br>
                                <b>
                                @foreach (comp($rfq->company_id) as $comps) {{ 'For: '. $comps->company_name ?? ' Company Name' }} @endforeach 
                                </b>
                            </p> 
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="margin-left:920px ; margin-top:120px;" align=""><br>
                            <b style="text-align:right;"> Accepted By:  
                                <br><br><br><br><br><br>
                                
                                <hr style="width:35%;text-align:left;margin-left:0;margin-top:-15px;">
                                <p style="font-size: 11.5pt; font-family: Calibri; margin-left:-5px; margin-top:-10px;">
                                    <b>Name/Title/Signature<br>
                                        @foreach ($sup as $sups) {{ 'For: '. $sups->vendor_name ?? ' Supplier Name' }} @endforeach 
                                    </b>
                                    
                                </p> 
                        </div>
                    </div>
                
                    <script type="text/php">
                        if (isset($pdf)) {
                            $x = 1190;
                            $y = 760;
                            $text = "{PAGE_NUM}";
                            $font = null;
                            $size = 15;
                            $color = array(0,0,0);
                            $word_space = 0.0;
                            $char_space = 0.0;
                            $angle = 0.0;
                            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                        }
                    </script>
                </div>
            
            </div>
        </div>
    </div>

@endif

@endsection

