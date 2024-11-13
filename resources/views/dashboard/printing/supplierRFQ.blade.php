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

        <div class="invoice-container" id="printableArea" style="background-color: white !important;font-family: Calibri, sans-serif; width:600px; ">
            <p style="page-break-after:avoid; font-size: 4.1pt;font-family: Calibri,sans-serif;float: right;margin-top: -12px;margin-bottom: 2px; margin-right: -25px;font-weight: 400;">SCM 208 v1.0 </p><br>
            <div class="invoice-header" style="font-family: Calibri, sans-serif;padding: .5rem 1.5rem;">

                <div class="row gutters" style="display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" style="position: relative;width: 100%;margin-left:23px;padding-right: 15px;padding-left: 15px;
                        -ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;">
                        <div class="invoice-logo" style="font-size: 1.2rem;color: #074b9c;font-weight: 700; margin-left: 10px;">

                            @if(Auth::user()->hasRole('SuperAdmin'))
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{$log}}" style="width: 101px;" alt="{{$log}}">
                                @endforeach
                            @elseif(Auth::user()->hasRole('Admin'))
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{$log}}" style="width: 101px;" alt="">
                                @endforeach

                            @elseif(Auth::user()->hasRole('Employer'))
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{ $log }}" style="width: 101px;" alt="">
                                @endforeach
                                
                            @elseif(Auth::user()->hasRole('HOD'))
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{ $log }}" style="width: 101px;" alt="">
                                @endforeach

                            @elseif(Auth::user()->hasRole('Contact'))
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{ $log }}" style="width: 101px;" alt="">
                                @endforeach

                            @elseif(Auth::user()->hasRole('Client'))
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.com/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{ $log }}" style="width: 101px;" alt="">
                                @endforeach
 
                            @elseif(Auth::user()->hasRole('Supplier'))
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.com/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{ $log }}" style="width: 101px;" alt="">
                                @endforeach
                            @else
                                @foreach (getLogo($rfq->company_id) as $item)
                                    @php $log = 'https://scm.tagenergygroup.com/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                    <img src="{{ $log }}" style="width: 101px;" alt="">
                                @endforeach
                            @endif
                        </div> 
                        <br>
                        <div class="col-lg-12 col-md-12 col-sm-12" style="font-family: Calibri,sans-serif;margin-top: 1px;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;">
                                <p style="font-size: 5pt !important;font-family: Calibri,sans-serif;color:black;;margin-top: 0;margin-bottom: 3px;line-height: 180%;font-weight: 400;">
                                    <strong style="font-weight: bolder; font-weight: 400;"> <b>{{ $vendor->vendor_name ?? ' ' }} </b> </strong>
                                </p><br>
                                <p style="font-size: 5pt;margin-top: -29px;color:black;margin-bottom: 2px;widows: 1;font-weight: 400;line-height: 1.3;">
                                    {{ $vendor->address ?? ' ' }}
                                </p><br>


                            <div style="margin-top:-30px; color:black;">
                                <h6 style="font-size: 5pt !important;margin-top: 0px;margin-bottom: .2rem;font-weight: 700;line-height: 180%;font-weight: 400;">
                                    <b>Attn: {{ $vendor_contact->first_name . ' '. $vendor_contact->last_name ?? ' '}} </b>
                                </h6>
                                <h6 style="font-size: 5pt !important;margin-top: -5px;margin-bottom: .2rem;font-weight: 700;line-height: 180%;font-weight: 400;">
                                    <u style="color: blue;">{{ $vendor_contact->email ?? ' ' }}</u>
                                </h6>
                                <h6 style="font-size: 5pt !important;margin-top: -5px;margin-bottom: .2rem;font-weight: 700;line-height: 180%;font-weight: 400;">
                                    Tel: {{ $vendor_contact->office_tel ?? ' ' }} 
                                </h6><br>
                            </div>

                            <h6 style=" color:black; width:500px;font-family: 'Tw Cen MT Condensed', Arial, Helvetica, sans-serif;font-size: 5pt !important;margin-top: -20px;margin-bottom: .2rem;font-weight: 700;line-height: 180%;font-weight: 400;">
                               <strong> <b>

                                        </b></strong>
                                        </h6>
                                        <br/>
                                        <h6 class="producttag" style=" color:black; width:500px;font-size: 5pt !important;margin-top: -20px;margin-bottom: .2rem;font-weight: 700;line-height: 180%;font-weight: 400;">
                                        @foreach (comp($rfq->company_id) as $comp)
                                        
                                        <?php 
                                        if($comp->company_name == "TAG Energy Nigeria Limited"){
                                            $company_name = "TAG Energy";
                                        }else{
                                            $company_name = $comp->company_name; 
                                        }
                                        ?>
                                        {{ $company_name. ' Request for Quotation for the PURCHASE OF '. strtoupper($rfq->description)  ?? ' Rfx: '. $rfq->rfq_number}}
                                        
                                        @endforeach 

                				<br/>
                            </h6><br>
                        </div>
                    </div> 
                    <div class="col-lg-8 col-md-8 col-sm-8 offset-lg-4 offset-md-4 offset-sm-4" style="text-align: right !important; margin-bottom:-30px;">

                        <p style="font-size: 5pt;font-family: Calibri,sans-serif;margin-top: 0;widows: 1;line-height: 180%;font-weight: 400;"><strong style="font-weight: bolder;">Ref No: TE-{{ $rfq->client->short_code }}-RFQ{{ preg_replace('/[^0-9]/', '', $rfq->refrence_no ?? '') }} </strong></p>
                        <p style="font-size: 5pt;font-family: Calibri,sans-serif;margin-bottom: -6px;widows: 1;line-height: 10%;font-weight: 400;margin-top:6px;">{{ $rfq->company->company_name ?? ' ' }} </p>
                        <p style="font-size: 5pt;font-family: Calibri,sans-serif;margin-top: -32px;widows: 1;font-weight: 400;">{{$rfq->company->address }}</p><br/>
                        <!--<img src="https://scm.tagenergygroup.net/img/price.png" width="125" style="margin-top:-8.5px;vertical-align: middle;border-style: none;page-break-inside: avoid;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;margin-right:-2px;" alt="Certification">-->
                        <p style="font-size: 4.8pt;margin-top: -29px; margin-bottom:0px; color:black !important;">{{ date("l, d F Y") }} </p><br/>
                        
                        <div class="line" style="width: 150px;height: 0.7px;background-color: #000;float:right;margin-top:-40px;margin-right:0px;"></div>
                        <p style="font-family: Calibri,sans-serif; margin-top: -53px !important; font-size: 15pt;"> <b style="white-space: nowrap;">Request for Quotation</b></p><br/>

                    </div>

                </div><br/>
                <div class="row gutters" >

                    <div class="col-lg-12 col-md-12 col-sm-12" style="font-size: 4.5pt; margin-top:-100px;margin-left:30px;padding-right: 15px;">
                        <div class="table-responsive" style="font-size: 5pt;font-family: Calibri, sans-serif; display: block;overflow-x: auto;-webkit-overflow-scrolling: touch; margin-bottom:4px;">

                            <table class="tablex" style="font-size: 5pt !important; width:300px !important;font-family: Calibri, sans-serif;margin-bottom:opx;color: #000000;background: #ffffff;
                                border: 0;-webkit-print-color-adjust: exact;margin-left:15px;">
                                <thead class="text-white" style="font-size: 5pt;font-family: Calibri, sans-serif;color: #000000 !important;">
                                    <tr style="font-size: 5pt;font-family: Calibri, sans-serif;page-break-inside: auto;">
                                        <th class="" style="padding-top: 3px;width: 25px;background-color: #C4D79B !important;font-family: Calibri, sans-serif;
                                            font-size: 5pt;
                                            vertical-align: top;font-weight: 600;border: 0; text-align:center;">
                                            <strong style="font-weight: bolder; color: #000000;" >Item </strong>
                                        </th>
                                        
                                        <th class="" style="padding-top: 3px;text-align: left;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 5pt;
                                            padding: .15rem 0rem .10rem 0px; width: 60px;
                                            vertical-align: top;font-weight: 600;border: 0;">
                                            <b style="font-weight: bolder; color: black;"> Mesc Code </b>
                                        </th>
                                        
                                        <th class="" style="padding-top: 3px;width: 347px; max-width: 247px !important; color: black;background-color: #F0F3F4 !important;text-align: left;
                                            font-family: Calibri, sans-serif;font-size: 5pt;
                                            padding: .15rem 0rem .10rem 0rem;vertical-align: top;font-weight: 600;
                                            border: 0;">
                                            <b style="font-weight: bolder; color: black;"> Desc  </b>
                                        </th>

                                        <th class="" style="padding-top: 3px;text-align: center;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 5pt;
                                            padding: .15rem 0rem .10rem 0rem;
                                            vertical-align: top;font-weight: 600;border: 0;width: 38px;">
                                            <b style="font-weight: bolder; color: black;"> Qty </b>
                                        </th>
                                        <th class="" style="padding-top: 3px;text-align: center;color: black;background-color: #F0F3F4 !important;font-family: Calibri, sans-serif;font-size: 5pt;
                                            padding: .15rem 0rem .10rem 0rem;
                                            vertical-align: top;font-weight: 600;border: 0;width: 38px;">
                                            <b style="font-weight: bolder; color: black;"> UOM </b>
                                        </th>
                                    </tr>

                                </thead>
                                <tbody style="font-size: 5pt;font-family: Calibri, sans-serif;">

                                    <?php $num =1; $wej = array(); ?>
                                    @foreach ($line_items as $items)
                                        <tr style="font-size: 5.0pt; font-family: Calibri, sans-serif; font-weight: 400; border: none !important; margin-bottom:0px;page-break-inside: auto;">
                                            <td class="list" style="vertical-align: top;padding-top: 2px; background-color: #EBF1DE !important; text-align: center; font-family: Calibri, sans-serif;
                                                font-size: 5.0pt;">
                                                {{-- <b>{{ $num }}</b> --}}
                                                <p style="font-size: 9.0pt; font-family: Calibri, sans-serif;"> <b>{{ $items->item_serialno }} </b></p>
                                            </td>
                                            <td style="padding-top: 2px; vertical-align: top;">
                                        @if($items->mesc_code != '' && $items->mesc_code != 'N/A' && $items->mesc_code != '0')
                                                <p style="font-size: 9.0pt; font-family: Calibri, sans-serif;"> <b> {{ $items->mesc_code }} </b></p><br/>
                                        @endif
                                            </td>

                                            <td style="font-weight: 400; padding-top: 2px; text-align: left; font-size: 9.0pt; font-family: Calibri, sans-serif; vertical-align:top;">
                                                <b>                                                 
                                                    <p style="font-size: 9.0pt; font-weight: 400; text-align: justify;">
                                                        {!! $items->item_description ?? 'N/A' !!}
                                                    </p> 
                                                </b>
                                            </td>

                                            <td style="font-weight: 400; padding-top: 2px; text-align: center; font-size: 9.0pt; font-family: Calibri, sans-serif; vertical-align:top;"><b> {{$items->quantity ?? 0}} </b></td>

                                            <td style="font-weight: 400; padding-top: 2px; text-align: center; font-size: 9.0pt; font-family: Calibri, sans-serif; vertical-align:top;"><b> {{$items->uom ?? 0}} </b></td>
                                        </tr><?php $num++; ?>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9" style="margin-top:20px;">
                            <style>
                                .no-page-break {
                                    display: block;
                                    position: relative;
                                    page-break-inside: avoid !important;
                                }
                            </style>
                        <div style="page-break-inside: avoid;">
                            <p style="font-size: 5pt !important; font-family: Calibri, sans-serif !important; margin-left:0px; font-weight:400;">
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

