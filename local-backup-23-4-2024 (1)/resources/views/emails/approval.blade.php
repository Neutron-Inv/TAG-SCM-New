
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="x-apple-disable-message-reformatting">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <style type="text/css">
            a { text-decoration: none; outline: none; }
            @media (max-width: 649px) {
                .o_col-full { max-width: 100% !important; }
                .o_col-half { max-width: 50% !important; }
                .o_hide-lg { display: inline-block !important; font-size: inherit !important; max-height: none !important; line-height: inherit !important; overflow: visible !important; width: auto !important; visibility: visible !important; }
                .o_hide-xs, .o_hide-xs.o_col_i { display: none !important; font-size: 0 !important; max-height: 0 !important; width: 0 !important; line-height: 0 !important; overflow: hidden !important; visibility: hidden !important; height: 0 !important; }
                .o_xs-center { text-align: center !important; }
                .o_xs-left { text-align: left !important; }
                .o_xs-right { text-align: left !important; }
                table.o_xs-left { margin-left: 0 !important; margin-right: auto !important; float: none !important; }
                table.o_xs-right { margin-left: auto !important; margin-right: 0 !important; float: none !important; }
                table.o_xs-center { margin-left: auto !important; margin-right: auto !important; float: none !important; }
                h1.o_heading { font-size: 32px !important; line-height: 41px !important; }
                h2.o_heading { font-size: 26px !important; line-height: 37px !important; }
                h3.o_heading { font-size: 20px !important; line-height: 30px !important; }
                .o_xs-py-md { padding-top: 24px !important; padding-bottom: 24px !important; }
                .o_xs-pt-xs { padding-top: 8px !important; }
                .o_xs-pb-xs { padding-bottom: 8px !important; }
            }
            @media screen {
                @font-face {
                  font-family: 'Roboto';
                  font-style: normal;
                  font-weight: 400;
                  src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu7GxKOzY.woff2) format("woff2");
                  unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
                @font-face {
                  font-family: 'Roboto';
                  font-style: normal;
                  font-weight: 400;
                  src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu4mxK.woff2) format("woff2");
                  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
                @font-face {
                  font-family: 'Roboto';
                  font-style: normal;
                  font-weight: 700;
                  src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfChc4EsA.woff2) format("woff2");
                  unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
                @font-face {
                  font-family: 'Roboto';
                  font-style: normal;
                  font-weight: 700;
                  src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfBBc4.woff2) format("woff2");
                  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
                .o_sans, .o_heading { font-family: "Roboto", sans-serif !important; }
                .o_heading, strong, b { font-weight: 700 !important; }
                a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; }
            }
              #canvas td.o_hide, #canvas td.o_hide div { display: block!important; font-family: "Roboto", sans-serif; font-size: 16px!important;
              color: #000; font-size: inherit!important; max-height: none!important; width: auto!important; line-height: inherit!important; visibility: visible!important;}
              .CodeMirror { line-height: 1.4; font-size: 12px; font-family: sans-serif; }
        </style>
        @php
        $tq =0;
        $subTotalCost = $rfq->supplier_quote + $rfq->freight_charges + $rfq->other_cost + $rfq->local_delivery;
        if($rfq->client_id == 114){
            $newWht = (0.05 * (sumTotalQuote($rfq->rfq_id) - $subTotalCost));
            $newNcd = (0.01 * (sumTotalQuote($rfq->rfq_id) - $subTotalCost));
        }else{
            $newWht = (0.05 * (sumTotalQuote($rfq->rfq_id)));
            $newNcd = (0.01 * (sumTotalQuote($rfq->rfq_id)));
        }
        $sumTotalQuotes = sumTotalQuote($rfq->rfq_id);
        if($sumTotalQuotes < 1){ $sumTotalQuote = 1; }else { $sumTotalQuote = $sumTotalQuotes; }
        $tot_quo = sumTotalQuote($rfq->rfq_id);
        $tot_ddp = $tq + $rfq->freight_charges + $rfq->local_delivery + $rfq->cost_of_funds + $rfq->fund_transfer + $rfq->other_cost + $rfq->ncd + $rfq->wht;
        $net_margin = $sumTotalQuotes - $tot_ddp;
        $comp = ($net_margin / sumTotalQuote($rfq->rfq_id)) * 100; @endphp

    </head>
    <body marginwidth="0" marginheight="0" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%; background-color: #dbe5ea;" offset="0" topmargin="0" leftmargin="0">

        <table data-module="header-primary-link" data-visible="false" data-thumb="https://scm.enabledjobs.com/admin/img/img1.jpeg"
            width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
                <tr>
                    <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" data-bgcolor="Bg Light" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-top: 32px;">
                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                            <tbody>
                                <tr>
                                    <td class="o_re o_bg-primary o_px o_pb-md o_br-t" align="center" data-bgcolor="Bg Primary" style="font-size: 0;vertical-align: top;background-color: #007bff;
                                    border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;padding-bottom: 24px;">

                                        <div class="o_col o_col-2" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                                            <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                                            <div class="o_px-xs o_sans o_text o_left o_xs-center" data-size="Text Default" data-min="12" data-max="20" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;
                                                line-height: 24px;text-align: left;padding-left: 8px;padding-right: 8px;">
                                                <p style="margin-top: 0px;margin-bottom: 0px;">
                                                    <a class="o_text-white" href="https://scm.tagenergygroup.net/dashboard" data-color="White" style="text-decoration: none;outline: none;color: #ffffff;">
                                                        <!--<img src="https://scm.enabledjobs.com/admin/img/img1.jpeg" width="46" height="26" alt="SCM"-->
                                                        <!--style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;-->
                                                        <!--outline: none;text-decoration: none;" data-crop="false">-->
                                                        @if(Auth::user()->hasRole('SuperAdmin') OR Auth::user()->hasRole('HOD'))
                                                            @foreach (getLogo($rfq->company_id) as $item)
                                                                @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                                <img src="{{$log}}" width="46" height="26" alt="SCM"
                                                                style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;
                                                                outline: none;text-decoration: none;" data-crop="false" alt="" 
                                                                >
                                                            @endforeach
                                                        @elseif(Auth::user()->hasRole('Admin'))
                                                            @foreach (getLogo($rfq->company_id) as $item)
                                                                @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                                <img src="{{$log}}" width="46" height="26" alt="SCM"
                                                                style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;
                                                                outline: none;text-decoration: none;" data-crop="false" alt="">
                                                            @endforeach
                            
                                                        @elseif(Auth::user()->hasRole('Employer'))
                                                            @foreach (getLogo($rfq->company_id) as $item)
                                                                @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                                <img src="{{ $log }}" width="46" height="26" alt="SCM"
                                                                style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;
                                                                outline: none;text-decoration: none;" data-crop="false" alt="">
                                                            @endforeach
                            
                                                        @elseif(Auth::user()->hasRole('Contact'))
                                                            @foreach (getLogo($rfq->company_id) as $item)
                                                                @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                                <img src="{{ $log }}" width="46" height="26" alt="SCM"
                                                                style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;
                                                                outline: none;text-decoration: none;" data-crop="false" alt="">
                                                            @endforeach
                            
                                                        @elseif(Auth::user()->hasRole('Client'))
                                                            @foreach (getLogo($rfq->company_id) as $item)
                                                                @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                                <img src="{{ $log }}" width="46" height="26" alt="SCM"
                                                                style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;
                                                                outline: none;text-decoration: none;" data-crop="false" alt="">
                                                            @endforeach
                            
                                                        @elseif(Auth::user()->hasRole('Supplier'))
                                                            @foreach (getLogo($rfq->company_id) as $item)
                                                                @php $log = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                                <img src="{{ $log }}" width="46" height="26" alt="SCM"
                                                                style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;
                                                                outline: none;text-decoration: none;" data-crop="false"alt="Logo">
                                                            @endforeach
                                                        @else
                                                            <img src="{{asset('admin/img/img1.jpeg')}}" alt="SCM Solutions" style="height:40px;height:40px" />
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                                            <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                                            <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                                                <!--<table class="o_right o_xs-center" cellspacing="0" cellpadding="0" border="0" role="presentation" style="text-align: right;margin-left: auto;margin-right: 0;">-->
                                                <!--    <tbody>-->
                                                <!--        <tr>-->
                                                <!--            <td class="o_btn-xs o_bg-primary o_br o_heading o_text-xs" align="center" data-bgcolor="Bg Primary" data-size="Text XS" data-min="10" data-max="18"-->
                                                <!--            style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;mso-padding-alt: 7px 16px;background-color: #242b3d;border-radius: 4px;">-->
                                                <!--                <a class="o_text-white" href="https://scm.enabledjobs.com/" data-color="White" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 7px 16px;mso-text-raise: 3px;">-->
                                                <!--                    Visit Website-->
                                                <!--                </a>-->
                                                <!--            </td>-->
                                                <!--        </tr>-->
                                                <!--    </tbody>-->
                                                <!--</table>-->
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table data-module="spacer0" data-thumb="http://www.stampready.net/dashboard/editor/user_uploads/zip_uploads/2018/11/19/uRdwfpZ0XIMDsFv8rCVTaOcb/account_temporary_password/thumbnails/spacer.png" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
            <tbody>
                <tr>
                    <td class="o_bg-light o_px-xs" align="center" data-bgcolor="Bg Light" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">

                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                            <tbody>
                                <tr>
                                    <td class="o_bg-white" style="font-size: 24px;line-height: 24px;height: 24px;background-color: #ffffff;" data-bgcolor="Bg White">&nbsp; </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
        <table data-module="content0" data-thumb="http://www.stampready.net/dashboard/editor/user_uploads/zip_uploads/2018/11/19/uRdwfpZ0XIMDsFv8rCVTaOcb/account_temporary_password/thumbnails/content.png"
            width="100%" cellspacing="0" style="" cellpadding="0" border="0" role="presentation">
            <tbody>
                <tr>
                    <td class="o_bg-light o_px-xs" align="center" data-bgcolor="Bg Light" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">

                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                            <tbody>
                                <tr>
                                    <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="left" data-bgcolor="Bg White" data-color="Secondary" data-size="Text Default" data-min="12"
                                        data-max="20" style="font-family: Calibri, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 9.0px;
                                        background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: -20px;">
                                        <p style="color:; font-size: 11pt;font-family: Calibri, sans-serif;">Dear Madam, <br>Please see below cost breakdown and attached spreadsheet for your approval.  </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="left" data-bgcolor="Bg White" data-color="Secondary" data-size="Text Default" data-min="12"
                                        data-max="20" style="font-family: Calibri, sans-serif; margin-top: 0px;margin-bottom: 0px;font-size: 11px;line-height: 24px;
                                        background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: -150px;padding-bottom: 16px;">
                                        <p style="color:#203864; font-size: 9.0pt;font-family: Calibri, sans-serif;">
                                            Client:<b> {{ $rfq->client->client_name ?? ' ' }} </b> <br>
                                            Buyer:  <b>{{ $rfq->contact->first_name . ' '. $rfq->contact->last_name ?? ' '}}</b>  <br>
                                            Supplier: <b> {{ $rfq->vendor->vendor_name }} </b>  <br>
                                            Description: <b> {!! $rfq->description !!}</b>  <br>
                                            Incoterm: <b> DDP </b> <br>
                                            Estimated Packaged Weight: <b>{{ $rfq->estimated_package_weight ?? ''}} </b> <br>
                                            Estimated Package Dimension: <b>{{ $rfq->estimated_package_dimension ?? ''}} </b> <br>
                                            Shipper: <b> {{ $rfq->shipper->shipper_name ?? '' }}</b>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="o_block" border="0" cellspacing="0" cellpadding="0" width="100%" style="max-width:100.0pt; margin-left:-.15pt; border-collapse:collapse; background-color: #ffffff;">
                            <tbody>
                                <tr style="height:15.0pt;  background-color: #ffffff;">
                                    <td width="164" nowrap="" valign="center" style="width:145.35pt; border:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><b><span style="font-size:9.0pt"> Total Ex-Works
                                        </span></b></p>
                                    </td>

                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt;
                                        border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">
                                        {{number_format($rfq->supplier_quote_usd) ?? 0 }}
                                        </span></b></p>
                                    </td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:solid windowtext 1.0pt; border-left:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                </tr>

                                <tr style="height:15.0pt">
                                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:9.0pt; color:black">Packaging Cost
                                        </span></b></p>
                                    </td>

                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt;
                                        border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">
                                        {{ number_format($rfq->other_cost,2) ?? 0 }}
                                        </span></b></p>
                                    </td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:solid windowtext 1.0pt; border-left:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                </tr>

                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>@php
                                if(count(getttingRfqShipQuote($rfq->rfq_id))> 0){
                                    $data = getRfqShipQuote($rfq->rfq_id);
                                    $soncap = $data->soncap_charges;
                                    $customs = $data->customs_duty;
                                    $clearing = $data->clearing_and_documentation;
                                    $trucking = $data->trucking_cost;
                                }else{
                                    $soncap = 0; $trucking =0;
                                    $customs = 0; $clearing = 0;
                                } @endphp
                                <tr style="height:17.25pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt">SONCAP CHARGES
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:black">{{number_format($soncap,2) ?? 0 }}

                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt">Customs duty
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:black">{{number_format($customs,2) ?? 0 }}
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>

                                </tr>
                                    <tr style="height:17.25pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt">Clearing &amp; Documentation
                                        </span></p></td>
                                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:black">{{number_format($clearing,2) ?? 0 }}
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:16.5pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt">Trucking Cost
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:black">
                                            {{number_format($trucking,2) ?? 0 }}
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:14.25pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="bottom" style="width:123.35pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:9.0pt; color:black"> {{ $rfq->shipper->shipper_name }} Airfreight cost
                                        </span></b></p>
                                    </td>

                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt;
                                        border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:red">
                                        {{ round($rfq->freight_charges,2) ?? '0.00' }}
                                        </span></b></p>
                                    </td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:solid windowtext 1.0pt; border-left:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                </tr>

                                <tr style="height:15.0pt">
                                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:9.0pt; color:black">
                                        Sub Total 1
                                        </span></b></p>
                                    </td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><b><span style="font-size:9.0pt; color:red"> {{ number_format(sumTotalQuote($rfq->rfq_id),2) ?? 0}}
                                        </span></b></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:right"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b>
                                        <span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>

                                </tr>
                                <tr style="height:25.0pt">
                                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:9.0pt; color:black">

                                        Cost of funds <br> (Subtotal * 1.3% * 4 Months)
                                        </span></p>
                                    </td>
                                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:red">
                                        {{ round($rfq->cost_of_funds,2) ?? 0 }}

                                        </span></p>
                                    </td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal">
                                        <span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt; color:red">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt; color:black">
                                        Cost of Fund Transfer <br>(1 % of Total Ex- Works or $30 whichever is higher)
                                        </span></p></td>
                                    <td width="439" nowrap="" colspan="3" valign="center" style="width:329.35pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal">
                                        <span style="font-size:9.0pt; color:red">&nbsp;
                                        @php $cal = (7.5 * 100)/$rfq->cost_of_funds; @endphp {{ number_format($cal,2) ?? 0 }}
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:left"><span style="font-size:9.0pt; color:black">
                                            &nbsp;VAT on Transfer Cost(7.5% of Funds Transfer)
                                        </span></p></td>
                                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:red">
                                        3.58
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:red">&nbsp;
                                        </span></p></td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:left"><span style="font-size:9.0pt; color:black">

                                        Offshore Charges (fixed @ $25)
                                        </span></p></td>
                                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:red">
                                        25.00
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:left"><span style="font-size:9.0pt; color:black">

                                                Swift Charges (fixed @ $25)
                                        </span></p></td>
                                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:red">

                                        25.00
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt; color:red">&nbsp;
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>

                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="" style="text-align:left"><b><span style="font-size:9.0pt">

                                                Total DDP Cost
                                        </span></b></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><b><span style="font-size:9.0pt; color:red">
                                            10,071.46
                                        </span></b></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></b></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:9.0pt; color:black">&nbsp;</span><span style="font-size:9.0pt">
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><b><span style="font-size:9.0pt">
                                            Total Quotation
                                        </span></b></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><b><span style="font-size:9.0pt">
                                        {{ round(sumTotalQuote($rfq->rfq_id)) ?? 0 }}
                                        </span></b></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt">&nbsp;
                                        </span></b></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt">&nbsp;
                                        </span></b></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt">
                                            VAT
                                        </span></p></td>
                                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt">-&nbsp;
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt">&nbsp;
                                        </span></b></p></td>
                                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:9.0pt">&nbsp;
                                        </span></b></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">

                                        <p class="MsoNormal" align="left" style="text-align:left"><span style="font-size:9.0pt">
                                            WHT &amp; NCD ((Total Quote minus Sub Total 1 * 6%)
                                        </span></p></td>
                                    <td width="439" nowrap="" colspan="3" valign="center" style="width:329.35pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">
                                        {{ round($newNcd + $newWht,2) ?? 0 }}
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="bottom" style="width:70.65pt; border-top:none; border-left:solid windowtext 1.0pt; border-bottom:solid windowtext 1.0pt; border-right:none; background: white; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:left"><b>
                                        <span style="font-size:9.0pt; color:black">Total TAXES
                                        </span></b></p></td>
                                    <td width="164" nowrap="" valign="bottom" style="width:123.35pt; border-top:none; border-left:solid windowtext 1.0pt; border-bottom:solid windowtext 1.0pt; border-right:none; background: #D9D9D9; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><b><span style="font-size:9.0pt; color:black">
                                            {{ round($newNcd + $newWht,2) ?? 0 }}
                                        </span></b></p></td>
                                    <td width="103" nowrap="" valign="bottom" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; background: #D9D9D9; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:10.0pt; font-family:&quot;Arial&quot;,sans-serif; color:black">&nbsp;</span><span style="font-size:10.0pt; font-family:&quot;Arial&quot;,sans-serif">
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="bottom" style="width:129.0pt; border:none; border-bottom:solid windowtext 1.0pt; background: #D9D9D9; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:10.0pt; font-family:&quot;Arial&quot;,sans-serif; color:black">&nbsp;</span><span style="font-size:10.0pt; font-family:&quot;Arial&quot;,sans-serif">
                                        </span></p>
                                    </td>
                                </tr>

                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left">
                                            <span style="font-size:9.0pt">Net Margin (Total Quote minus (Total DDP Cost + WHT))
                                        </span></p>
                                    </td>
                                    <td width="439" nowrap="" colspan="3" valign="center" style="width:329.35pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt">
                                        {{ number_format($net_margin,2) ?? '0'}}
                                        </span></p>
                                    </td>
                                </tr>

                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none;  padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><b><span style="font-size:9.0pt; color:black">
                                        % Net Margin
                                        </span></b><b><span style="font-size:9.0pt">
                                        </span></b></p>
                                    </td>
                                    <td width="164" nowrap="" colspan="" valign="center" style="width:123.35pt; border:none; background: red; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt"> {{ number_format($comp,3) ?? 0 }}
                                        </span></p>
                                    </td>
                                    <td width="103" nowrap="" valign="bottom" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="bottom" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>

                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt">
                                            Gross Margin
                                        </span></p>
                                    </td>
                                    <td width="164" nowrap="" colspan="" valign="bottom" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:black">{{ number_format($rfq->net_value,2,".","") ?? '0'}}
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="bottom" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="bottom" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                                <tr style="height:15.0pt">
                                    <td width="94" nowrap="" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:9.0pt">
                                        % Gross Margin
                                        </span></p>
                                    </td>
                                    <td width="164" nowrap="" valign="bottom" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                                        <p class="MsoNormal"><span style="font-size:9.0pt; color:black">{{ number_format($rfq->percent_margin,4,".","") ?? '0'}}
                                        </span></p></td>
                                    <td width="103" nowrap="" valign="bottom" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p></td>
                                    <td width="172" nowrap="" valign="bottom" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:9.0pt; color:black">&nbsp;
                                        </span></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                            <tbody>

                                <tr>
                                    <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="left" data-bgcolor="Bg White" data-color="Secondary" data-size="Text Default" data-min="12"
                                        data-max="20" style="font-family: Calibri, sans-serif; margin-top: 0px;margin-bottom: 0px;font-size: 11px;line-height: 24px;
                                        background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: -150px;padding-bottom: 16px;">
                                        <p style="font-size: 11pt; font-family: Calibri, sans-serif;"><b style="color:red">Notes to Pricing: </b><br> <br>
                                            1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }} after Confirmed Order. <br>
                                            2. Mode of transportation:  <b>{{ $rfq->transport_mode ?? ''}} </b> <br>
                                            3. Delivery Location: <b>{{ $rfq->delivery_location ?? ''}} </b><br>
                                            4. Where Legalisation of C of O and/or invoices are required, additional cost will apply and will be charged at cost. <br>
                                            5. Validity: This quotation is valid for <b>{{ $rfq->validity ?? ''}} </b>. <br>
                                            6. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br>
                                            7. Pricing: Prices quoted are in <b>{{ $rfq->currency ?? 'USD' }} </b> <br>
                                            8. Prices are based on quantity quoted <br>
                                            9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
                                            10. Oversized Cargo: <b>{{ $rfq->oversized ?? 'NO' }} </b><br>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <table data-module="buttons0" data-thumb="http://www.stampready.net/dashboard/editor/user_uploads/zip_uploads/2018/11/19/uRdwfpZ0XIMDsFv8rCVTaOcb/account_temporary_password/thumbnails/buttons.png" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                            <tbody>
                                <tr>
                                    <td class="o_bg-light o_px-xs" align="center" data-bgcolor="Bg Light" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">

                                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                                            <tbody>
                                                <tr>
                                                    <td class="o_bg-white o_px o_pb-md" align="center" data-bgcolor="Bg White" style="background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-bottom: 24px;">

                                                        <div class="o_col_i" style="display: inline-block;vertical-align: top;">
                                                            <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                                                            <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                                                                <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="o_btn o_bg-primary o_br o_heading o_text" align="center" data-bgcolor="Bg Primary" data-size="Text Default" data-min="12" data-max="20"
                                                                                style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;
                                                                                background-color: #28a745;border-radius: 4px;">
                                                                                <?php $url = 'https://test.ebsl.enabledjobs.com/dashboard/request-for-quotation/approve-breakdown/'.$rfq->refrence_no; ?>
                                                                                <a class="o_text-white" href="{{ $url }}" data-color="White" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;">
                                                                                    Approve Breakdown</a>
                                                                            </td>
                                                                            <?php $url2 = 'https://test.ebsl.enabledjobs.com/dashboard/request-for-quotation/decline-breakdown/'.$rfq->refrence_no; ?>
                                                                            <td class="o_btn o_bg-dark o_br o_heading o_text" align="center" data-bgcolor="Bg Dark" data-size="Text Default" data-min="12" data-max="20" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;
                                                                                margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #242b3d;border-radius: 4px;">
                                                                                <a class="o_text-white" href="{{ $url2 }}" data-color="White" style="background-color: #dc3545;text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px; padding-left; -10px">
                                                                                    Decline Breakdown
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="o_col_i" style="display: inline-block;vertical-align: top;">
                                                            <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                                                            <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                                                                <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                                    <tbody>
                                                                        <tr>
                                                                            <p style="font-size: 7.5pt;font-family: Arial,sans-serif; color: #1F497D;">Best Regards,<br> {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, <br> @if(Auth::user()->role == 'HOD' ) 
                                        {{ 'SCM Lead' }} 
                                        @elseif(Auth::user()->role == 'Employer' )
                                        {{ 'Procurement Associate' }} 
                                        @elseif(Auth::user()->role == 'SuperAdmin' )
                                        {{ 'SCM Admin' }}
                                        @else
                                        {{ 'Procurement Associate' }}
                                        @endif<br>
                                                                                PHONE</span></b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                                                    : +234 1 342 8420&nbsp;| </span>
                                                                                    <span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                                                                                    +234 906 243 5410&nbsp; </span><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                                                </span><br><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864">EMAIL:
                                                                                </span></b><span style="color:#2F5496"><a href="mailto:sales@tagenergygroup.net"><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif">
                                                                                    {{ $sender }}</span></b></a>
                                                                                </span>

                                                                            </p>
                                                                            <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table data-module="footer-light-2cols0" data-thumb="http://www.stampready.net/dashboard/editor/user_uploads/zip_uploads/2018/11/19/uRdwfpZ0XIMDsFv8rCVTaOcb/account_temporary_password/thumbnails/footer-light-2cols.png" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                            <tbody>
                                <tr>
                                    <td class="o_bg-light o_px-xs o_pb-lg o_xs-pb-xs" align="center" data-bgcolor="Bg Light" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-bottom: 32px;">

                                        <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                                            <tbody>
                                                <tr>
                                                    <td class="o_bg-white o_br-b o_sans" style="font-size: 8px;line-height: 8px;height: 8px;font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;background-color: #ffffff;border-radius: 0px 0px 4px 4px;" data-bgcolor="Bg White">&nbsp; </td>
                                                </tr>
                                                <tr>
                                                    <td class="o_re o_bg-dark o_px o_pb-lg" align="center" data-bgcolor="Bg Dark" style="font-size: 0;vertical-align: top;background-color: #242b3d;padding-left: 16px;padding-right: 16px;padding-bottom: 32px;">

                                                        <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                                                            <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
                                                            <div class="o_px-xs o_sans o_text-xs o_text-light o_left o_xs-center" data-color="Light" data-size="Text XS" data-min="10" data-max="18" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;">
                                                                <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px; color: white"">©{{ date('Y') }} SCM. All rights reserved.</p>

                                                                <p style="margin-top: 0px;margin-bottom: 0px;">

                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="o_col o_col-2" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                                                        <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
                                                            <div class="o_px-xs o_sans o_text-xs o_text-light o_right o_xs-center" data-size="Text XS" data-min="10" data-max="18" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #82899a;text-align: right;padding-left: 8px;padding-right: 8px;">

                                                                </p>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </body>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>

