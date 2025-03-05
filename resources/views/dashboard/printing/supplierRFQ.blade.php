<?php
$cli_title = clis($rfq->client_id);
$result = json_decode($cli_title, true);

    $title = "TAG Energy Request for Quotation TE-" . $result[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ", " . $rfq->description;
    set_time_limit(900);
?>
@extends('layouts.print')
@section('content')

    @if(count($line_items) == 0)
        <h3><p style="color:red" align="center"> No Line Item was found for the RFQ </p></h3>
    @else
        
         <div class="invoice-container" id="printableArea" style="background-color: white !important;width:600px; ">
            <p style="page-break-after:avoid; font-size: 4.1pt;font-family: Calibri,sans-serif;float: right;margin-top: -12px;margin-bottom: 2px; margin-right: -25px;font-weight: 400;">TAGFlow 208 v1.0 </p><br>
            <div class="invoice-header" style="padding: .5rem 1.5rem;">

                <div class="row gutters" style="position: relative;">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="position: relative;margin-left:23px;padding-right: 15px;padding-left: 15px;">
                        <div class="invoice-logo" style="font-size: 1.2rem;color: #074b9c;font-weight: 700; margin-left: 10px; margin-bottom:15px;">
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{$log}}" style="width: 101px;" alt="{{$log}}">
                                @endforeach
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12" style="position: relative; width: 100%; padding-right: 15px; padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;">
                            @foreach (clis($rfq->client_id) as $cli)
                                <p style="color:black; line-height:7px; margin-bottom:18px;">
                                 <span style="font-weight:bold; font-size:6pt;">{{ $vendor->vendor_name ?? ' ' }}  </span><br>
                                    {{ $vendor->address ?? ' ' }}
                                </p><br>
                            @endforeach


                            <div style="margin-top:-45px; color:black;">
                                <p>
                                    <b style="font-size:5pt;font-family: Calibri, sans-serif;">Attn: {{ $vendor_contact->first_name . ' '. $vendor_contact->last_name ?? ' '}} </b>
                                </p>
                                <h6 style="margin-top: -15px;">
                                    <u style="color: blue; font-size:5pt;">{{ $vendor_contact->email ?? ' ' }}</u>
                                </h6>
                                <h6 style="font-size:5pt; margin-top: -13px;margin-bottom: .2rem;font-weight: 700;line-height: 180%;font-weight: 400;">
                                    Tel: {{ $vendor_contact->office_tel ?? ' ' }} 
                                </h6><br>
                            </div>

                             

                                    <p style=" color:black; width:500px; font-family: Calibri, sans-serif; font-size:7pt; margin-top: -35px; margin-bottom: .2rem; font-weight: 700; line-height: 180%; font-weight: 400;">
                                        <b>  </b>
                                    </p>
                                        
                                    <br/>
                                        
                                @foreach (comp($rfq->company_id) as $comp)
                                    <p class="producttag" style="color: black; margin-top: -25px; line-height: 180%; white-space:nowrap;">
                                        <?php 
                                        if($comp->company_name == "TAG Energy Nigeria Limited"){
                                            $company_name = "TAG Energy";
                                        }else{
                                            $company_name = $comp->company_name; 
                                        }
                                        ?>
                                        <span style="font-weight:bold; font-size: 12px;">Request for Quotation RFQ{{ preg_replace('/[^0-9]/', '', $rfq->refrence_no ?? '') }}</span>
                        				<br/>
                                    </p>
                                @endforeach

                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 offset-lg-4 offset-md-4 offset-sm-4" style="position: absolute; top: 0; right: 0; text-align: right;">
                        <p style="font-size:5pt;font-family: Calibri,sans-serif;widows: 1;font-weight: 400; line-height:1;"><strong style="font-weight: bolder;"> Ref No: RFQ{{ preg_replace('/[^0-9]/', '', $rfq->refrence_no ?? '') }}</strong> 
                        <br/> {{ $rfq->company->company_name ?? ' ' }} <br/>
                        {{$rfq->company->address }}<br/>
                        {{ date("l, d F Y") }} </p>
                        <div class="line" style="width: 110px;height: 0.7px;background-color: #000;float:right;margin-right:0px; margin-top:0px; margin-bottom:2px;"></div><br/>
                        <p style="font-family: Calibri,sans-serif; font-size: 25px !important; margin-top: -22px !important;"> <b style="white-space: nowrap;">Request for Quotation</b></p><br/>
                    </div>
                </div>

                <div class="row gutters" style="margin-top:-15px;">

                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left:30px; padding-right: 15px;">
                        <div class="table-responsive" style="display: block;overflow-x: auto; margin-bottom:4px;">

                            <table class="tablex" style="font-size: 1.5pt; font-family: Calibri, sans-serif; margin-bottom:opx;color: #000000;background: #ffffff;
                                border: 0;-webkit-print-color-adjust: exact;margin-left:15px;">
                                <thead class="text-white" style=" color: #000;">
                                    <tr style="page-break-inside: auto;">
                                        <th style="width: 5%; background-color: #C4D79B; vertical-align: top; font-weight: 600; 
                                            border: 0; text-align: center; padding-top: 3px;">
                                            <p style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">Item</p>
                                        </th>
                                        <th style="width: 18%; max-width: 265px; background-color: #F0F3F4; text-align: left; 
                                            padding: .15rem 0 .10rem 0; vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                          <p style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">Mesc Code</p>
                                        </th>
                                        <th style="width: 65%; background-color: #F0F3F4; text-align: left; padding: .15rem 0 .10rem 0; 
                                            vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">Description</p>
                                        </th>
                                        <th style="width: 6%; background-color: #F0F3F4; text-align: center; padding: .15rem 0 .10rem 0; 
                                            vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">Qty</p>
                                        </th>
                                        <th style="width: 8%; background-color: #F0F3F4; text-align: center;padding: .15rem 0 .10rem 0; 
                                            vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top; line-height:1.3;">UOM</p>
                                        </th>
                                    </tr>
                                </thead>


                                <tbody style="font-family: Calibri, sans-serif;">

                                    <?php $num =1; $wej = array(); ?>
                                    @foreach ($line_items as $items)
                                        <tr style="font-family: Calibri, sans-serif; font-weight: 400; border: none !important; margin-bottom:0px;page-break-inside: auto;">
                                            <td class="list" style="vertical-align: top;padding-top: 2px; background-color: #EBF1DE !important; text-align: center; font-family: Calibri, sans-serif;">
                                                <p style="font-family: Calibri, sans-serif;"> <b>{{ $items->item_serialno }} </b></p>
                                            </td>
                                            
                                            <td style="padding-top: 2px; line-height:1.3;vertical-align:top !important;">
                                            @if($items->mesc_code != '' AND $items->mesc_code AND 'N/A' OR $items->mesc_code != "0")
                                            
                                                <p style="font-family: Calibri, sans-serif;"> <b>{{ $items->mesc_code }} </b></p><br/>
                                            
                                            @endif
                                            </td>

                                            <td style="font-weight: 400; padding-top: 2px;font-family: Calibri, sans-serif; vertical-align:top !important;"> 
                                            <p style="font-weight: 400; text-align: justify">
                                                    {!! $items->item_description ?? 'N/A' !!}
                                                </p>
                                            </td>

                                            <td style="font-weight: 400; padding-top: 2px; text-align: center; font-family: Calibri, sans-serif; vertical-align:top;"><b> {{$items->quantity ?? 0}} </b></td>

                                            <td style="font-weight: 400; padding-top: 2px; font-family: Calibri, sans-serif; vertical-align:top;" align="center"><b>{{$items->uom ?? 0}}</b> </td>

                                        </tr>
                                    <?php $num++; ?>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xl-8 col-lg-8col-md-8 col-sm-8" style="margin-top:20px;">

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
                            <b>Best Regards </b> <br/>
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
                    <script type="text/javascript">
    // Script to position the image at the bottom of each page
    function numberPages() {
        var img = document.getElementById("fixedLogo");

        if (img) {
            var yOffset = img.y;

            function jump() {
                window.scroll(0, yOffset);
            }

            jump();
        }
    }

    numberPages();
</script>
                </div>

            </div>
        </div>
        

    @endif

@endsection

