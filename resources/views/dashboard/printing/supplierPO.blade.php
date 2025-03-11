<?php
$cli_title = clis($rfq->client_id);
$result = json_decode($cli_title, true);

$title = 'TAG Energy Quotation TE-' . $result[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ', ' . $rfq->description;
set_time_limit(900);
?>
@extends('layouts.print')
@section('content')

    @if (count($line_items) == 0)
        <h3>
            <p style="color:red" align="center"> No Line Item was found for the RFQ </p>
        </h3>
    @else
        <div class="invoice-container" id="printableArea" style="background-color: white !important;width:600px; ">
            <p
                style="page-break-after:avoid; font-size: 4.1pt;font-family: Calibri,sans-serif;float: right;margin-top: -12px;margin-bottom: 2px; margin-right: -25px;font-weight: 400;">
                SCM 208 v1.0 </p><br>
            <div class="invoice-header" style="padding: .5rem 1.5rem;">

                <div class="row gutters" style="position: relative; margin-bottom:20px;">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4"
                        style="position: relative;margin-left:23px;padding-right: 15px;padding-left: 15px;">
                        <div class="invoice-logo"
                            style="font-size: 1.2rem;color: #074b9c;font-weight: 700; margin-left: 10px; margin-bottom:15px;">
                            @foreach (getLogo($rfq->company_id) as $item)
                                @php $log = config('app.url').'/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                <img src="{{ $log }}" style="width: 101px;" alt="{{ $log }}">
                            @endforeach
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12"
                            style="position: relative; width: 100%; padding-right: 15px; padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;">
                            <p style="color:black; line-height:7px; margin-bottom:18px;">
                                <span style="font-weight:bold; font-size:6pt;">{{ $vendor->vendor_name ?? ' ' }} </span><br>
                                {{ $vendor->address ?? ' ' }}
                            </p><br>



                            <div style="margin-top:-45px; color:black;">
                                <p>
                                    <b style="font-size:5pt;font-family: Calibri, sans-serif;">Attn:
                                        {{ $vendor_contact->first_name . ' ' . $vendor_contact->last_name ?? ' ' }} </b>
                                </p>
                                <h6 style="margin-top: -15px;">
                                    <u style="color: blue; font-size:5pt;">{{ $vendor_contact->email ?? ' ' }}</u>
                                </h6>
                                <h6
                                    style="font-size:5pt; margin-top: -13px;margin-bottom: .2rem;font-weight: 700;line-height: 180%;font-weight: 400;">
                                    Tel: {{ $vendor_contact->office_tel ?? ' ' }}
                                </h6><br>
                            </div>



                            <p
                                style=" color:black; width:500px; font-family: Calibri, sans-serif; font-size:7pt; margin-top: -35px; margin-bottom:1px; font-weight: 700; line-height: 180%; font-weight: 400;">
                                <b> {{ $vendor->short_code . ' Rfx: ' . $pricing->reference_number }} </b>
                            </p>

                            <br />

                            <p class="producttag"
                                style="color: black; margin-top: -25px; line-height: 80%; font-size:7px; width:330px !important">
                                We are pleased to issue this purchase order in response to the pricing in your quotation
                                {{ $pricing->reference_number }}<br />
                                By this letter, we request that you commence the immediate supply and ensure compliance as
                                per your quotation<br />
                                and the specification.
                                <br />
                            </p>

                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 offset-lg-4 offset-md-4 offset-sm-4"
                        style="position: absolute; top: 0; right: 0; text-align: right;">
                        <p
                            style="font-size:5pt;font-family: Calibri,sans-serif;margin-bottom: -5px;widows: 1;line-height: 10%;font-weight: 400;">
                            {{ $vendor->vendor_name ?? ' ' }} </p>
                        <p
                            style="font-size:5pt;font-family: Calibri,sans-serif;margin-top: 0;widows: 1;line-height: 180%;font-weight: 400;">
                            <strong style="font-weight: bolder;">Ref No:
                                TE-{{ $vendor->vendor_code }}-{{ preg_replace('/[^0-9]/', '', $rfq->refrence_no ?? '') }}
                            </strong>
                        </p><br />
                        <div class="line"
                            style="width: 170px;height: 0.7px;background-color: #000;float:right;margin-top:-27px;margin-right:-10px;">
                        </div>
                        <img src="https://scm.tagenergygroup.net/img/price_po.png" width="125"
                            style="margin-top:-15px;vertical-align: middle;border-style: none;page-break-inside: avoid;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;margin-right:-2px;"
                            alt="Certification">
                        <br>
                        <p style="font-size:5pt;margin-top: -8px;color:black !important;"> {{ date('l, d F Y') }} </p>
                    </div>
                </div>

                <div class="row gutters" style="margin-top:-15px;">

                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left:30px; padding-right: 15px;">
                        <div class="table-responsive" style="display: block;overflow-x: auto; margin-bottom:4px;">

                            <table class="tablex"
                                style="font-size: 1.5pt; font-family: Calibri, sans-serif; margin-bottom:opx;color: #000000;background: #ffffff;
                                border: 0;-webkit-print-color-adjust: exact;margin-left:15px;">
                                <thead class="text-white" style=" color: #000;">
                                    <tr style="page-break-inside: auto;">
                                        <th
                                            style="width: 5%; background-color: #C4D79B; vertical-align: top; font-weight: 600; 
                                            border: 0; text-align: center; padding-top: 3px;">
                                            <p
                                                style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">
                                                Item</p>
                                        </th>
                                        <th
                                            style="width: 63%; max-width: 265px; background-color: #F0F3F4; text-align: left; 
                                            padding: .15rem 0 .10rem 0; vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p
                                                style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">
                                                Description</p>
                                        </th>
                                        <th
                                            style="width: 8%; background-color: #F0F3F4; text-align: center; padding: .15rem 0 .10rem 0; 
                                            vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p
                                                style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">
                                                UOM</p>
                                        </th>
                                        <th
                                            style="width: 6%; background-color: #F0F3F4; text-align: center; padding: .15rem 0 .10rem 0; 
                                            vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p
                                                style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top;">
                                                Qty</p>
                                        </th>
                                        <th
                                            style="width: 8%; background-color: #F0F3F4; text-align: center;padding: .15rem 0 .10rem 0; 
                                            vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p
                                                style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top; line-height:1.3;">
                                                Unit Price
                                                <br>({{ $rfq->currency ?? 'USD' }})
                                            </p>
                                        </th>
                                        <th
                                            style="width: 10%; background-color: #F0F3F4; text-align: center; padding: .15rem 0 .10rem 0; 
                                            vertical-align: top; font-weight: 600; border: 0; padding-top: 3px;">
                                            <p
                                                style="color: #000; font-family: Calibri, sans-serif; font-weight:bold; vertical-align:top; line-height:1.3;">
                                                Total Amount
                                                <br> ({{ $rfq->currency ?? 'USD' }})
                                            </p>
                                        </th>
                                    </tr>
                                </thead>


                                <tbody style="font-family: Calibri, sans-serif;">
                                    @php
                                        $num = 1;
                                        $wej = [];
                                        $subtotal = 0;
                                    @endphp
                                    @foreach ($line_items as $items)
                                        <tr
                                            style="font-family: Calibri, sans-serif; font-weight: 400; border: none !important; margin-bottom:0px;page-break-inside: auto;">
                                            <td class="list"
                                                style="vertical-align: top;padding-top: 2px; background-color: #EBF1DE !important; text-align: center; font-family: Calibri, sans-serif;">
                                                <p style="font-family: Calibri, sans-serif;">
                                                    <b>{{ $items->item_serialno }} </b>
                                                </p>
                                            </td>
                                            <td style="padding-top: 2px; line-height:1.3;">

                                                @if ($items->mesc_code != '' and $items->mesc_code and 'N/A' or $items->mesc_code != '0')
                                                    <p style="font-family: Calibri, sans-serif;"> <b>PRODUCT NO:
                                                            {{ $items->mesc_code }} </b></p><br />
                                                @endif
                                                <p style="font-weight: 400; text-align: justify;">
                                                    {!! $items->item_description ?? 'N/A' !!}
                                                </p>
                                            </td>

                                            <td
                                                style="font-weight: 400; padding-top: 2px; text-align: center;font-family: Calibri, sans-serif; vertical-align:top;">
                                                <b> {{ $items->uom ?? '' }} </b>
                                            </td>
                                            <td
                                                style="font-weight: 400; padding-top: 2px; text-align: center; font-family: Calibri, sans-serif; vertical-align:top;">
                                                <b> {{ $items->quantity ?? 0 }} </b>
                                            </td>

                                            <td style="font-weight: 400; padding-top: 2px; font-family: Calibri, sans-serif; vertical-align:top;"
                                                align="center"><b> {{ number_format($items->unit_cost, 2) ?? 0 }}</b> </td>

                                            <td style="font-weight: 400; padding-top: 2px; font-family: Calibri, sans-serif; vertical-align:top;"
                                                align="center"><b> {{ number_format($items->total_cost, 2) }} </b></td>
                                            @php
                                                $tot = $items->quantity * $items->unit_cost;
                                                array_push($wej, $tot);
                                            @endphp
                                        </tr>
                                        @php
                                            $subtotal += $items->total_cost;
                                            $num++;
                                        @endphp
                                    @endforeach

                                    <tr style="font-family: Calibri, sans-serif; margin-bottom:0px;">

                                        <td colspan="2"
                                            style="background-color:white; padding-top: 6px; border:#000000; font-size: 9.0pt; font-family: Calibri, sans-serif;">

                                        </td>

                                        @php
                                            $other_cost = 0;
                                        @endphp
                                        <td style="background-color:white;"> </td>
                                        <td style="background-color:white;"> </td>

                                        <td colspan="3"
                                            style="background-color:white; font-family: Calibri, sans-serif; margin-left: 80px;"
                                            align="left">

                                            <table
                                                style="width: 100%; margin: 2px 0; font-size:7px; color:black; margin-right:20px !important;">
                                                <tr
                                                    style="border-top: solid; border-width:1px !important;border-top-color: #000000; ">
                                                    <td style="text-align: left;"><strong>Sub total</strong></td>
                                                    <td style="text-align: right;">
                                                        <strong>{{ number_format($subtotal, 2) }}</strong>
                                                    </td>
                                                </tr>

                                                <!-- Miscellaneous Costs -->
                                                @if ($pricing->misc_cost)
                                                    @foreach (json_decode($pricing->misc_cost) as $index => $misc)
                                                        <tr>
                                                            <td style="text-align: left;">
                                                                <strong>{{ $misc->desc }}</strong>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <strong>{{ number_format($misc->amount, 2) }}</strong>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $other_cost += $misc->amount;
                                                        @endphp
                                                    @endforeach
                                                @endif

                                                <!-- Total -->
                                                <tr
                                                    style="border-bottom: double; border-bottom-color: #000000; border-top: solid; border-bottom-width:1px; border-top-width:0.5px !important;border-top-color: #000000;">
                                                    <td style="text-align: left;"><strong>Total</strong></td>
                                                    <td style="text-align: right;">
                                                        <strong>{{ number_format($subtotal + $other_cost, 2) ?? 0 }}</strong>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-xl-8 col-lg-8col-md-8 col-sm-8" style="margin-top:-45px;">


                            <p
                                style="font-size: 5pt!important; font-family: Calibri, sans-serif; margin-left:0px; margin-top:0px; margin-bottom: 10px; color:red; font-weight:bold; line-height:11px;">
                                @foreach (explode(';', $pricing->weight ?? '') as $est_weight)
                                    @if (preg_replace('/\D/', '', $est_weight) != '')
                                        ESTIMATED PACKAGED WEIGHT: {{ trim($est_weight) }}<br />
                                    @endif
                                @endforeach
                                @foreach (explode(';', $pricing->dimension ?? '') as $est_dim)
                                    @if (preg_replace('/\D/', '', $est_dim) != '')
                                        ESTIMATED PACKAGED DIMENSION: {{ trim($est_dim) }}<br />
                                    @endif
                                @endforeach
                                @foreach (explode(';', $pricing->hs_codes ?? '') as $hs_code)
                                    @if ($hs_code != 'N/A')
                                        HS CODE: {{ trim($hs_code) }}<br />
                                    @endif
                                @endforeach
                            </p>
                            @if (!empty(strip_tags($pricing->general_terms)))
                                <p
                                    style="color:black; font-weight: bold; margin-left: 0px; margin-bottom: 10px; font-size: 5pt !important; font-family: Calibri, sans-serif;">
                                    <span style="font-size: 7px !important;">GENERAL TERMS & CONDITIONS</span><br />
                                    <span
                                        style="font-size: 5pt !important; font-family: Calibri, sans-serif; page-break-inside: avoid;">
                                        {!! htmlspecialchars_decode($pricing->general_terms) !!}</span>
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
                                <p
                                    style="font-size: 5pt !important; font-family: Calibri, sans-serif !important; margin-left:0px; font-weight:400; line-height:1.3; white-space:nowrap;">
                                    <b style="color:red;">Notes to Pricing: </b><br />
                                    @foreach (explode(';', $pricing->notes_to_pricing ?? '') as $notes)
                                        @if (trim($notes) != '')
                                            <span style="font-weight:bold; color:red;"> {{ $loop->iteration }}.
                                                {{ trim($notes) }}</span><br />
                                        @endif
                                        @php
                                            $sn++;
                                        @endphp
                                    @endforeach

                                    {{ $sn }}. <b>Delivery:</b> {{ $pricing->delivery_time ?? '' }}
                                    <br />
                                    @php $sn++ @endphp

                                    {{ $sn }}. <b>Delivery Location:</b> {{ $pricing->delivery_location }}
                                    <br />
                                    @php $sn++ @endphp

                                    {{ $sn }}. <b>Payment Terms:</b> {{ $pricing->payment_term ?? '' }}.
                                    <br />
                                    @php
                                        $sn++;
                                    @endphp
                                    @foreach (emps($rfq->employee_id) as $emp)
                                        @php
                                            $userDe = userEmail($emp->email);
                                        @endphp
                                    @endforeach

                                    {{ $sn }}. <b>Contact:</b>
                                    {{ $userDe->first_name . ' ' . strtoupper($userDe->last_name) ?? ' ' }}, +234 906 243
                                    5412,
                                    sales@tagenergygroup.net<br />
                                    @php $sn += 1 @endphp

                                <p style="font-size: 5pt !important; ">Please kindly endorse below with your signature and
                                    company stamp to accept this order.</p>
                                <div class="row flex">
                                    <div class="col-6" style="float:left;">
                                        <b>Best Regards </b> <br />
                                        </p>
                                        @foreach (getLogo($rfq->company_id) as $item)
                                            @php $logsign = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->signature; @endphp
                                            <img src="{{ $logsign }}" width="80"
                                                style="margin-left:0px; margin-top:5px;padding-bottom:10px;"
                                                alt="{{ config('app.name') }}">
                                        @endforeach
                                        <br /><br />
                                        <div class="line"
                                            style="width: 100px;height: 0.7px;background-color: #000;float:left;margin-top:-27px;margin-right:-10px;">
                                        </div>
                                        <div style="margin-top:-25px;">
                                            <p
                                                style="margin-top:0px; margin-left:0px; color:black; font-size:5pt !important;">
                                                @foreach (emps($rfq->employee_id) as $emp)
                                                    @php
                                                        $email = $emp->email;
                                                        $userDe = userEmail($email);
                                                    @endphp
                                                    <b>{{ $userDe->first_name . ' ' . strtoupper($userDe->last_name) ?? ' ' }}
                                                    </b>
                                                @endforeach
                                            </p>
                                            <p style="margin-top: -5px; font-size:5pt !important;"></p>
                                            <p style="margin-top: -8px; font-size:5pt !important;"><b>
                                                    @foreach (comp($rfq->company_id) as $comps)
                                                        {{ 'For: ' . $comps->company_name ?? ' Company Name' }}
                                                    @endforeach
                                                </b>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-6" style="float:right; margin-right:-190px;">
                                        <b>Accepted By; </b> <br />
                                        </p>
                                        <div style="height:85px; margin-top:5px;padding-bottom:10px;"></div>

                                        <div class="line"
                                            style="width: 100px;height: 0.7px;background-color: #000;float:left;margin-top:-27px;margin-right:-10px;">
                                        </div>
                                        <div style="margin-top:-25px;">
                                            <p
                                                style="margin-top:0px; margin-left:0px; color:black; font-size:5pt !important;">
                                                <b>Name/Title/Signature</b>
                                            </p>
                                            <p style="margin-top: -5px; font-size:5pt !important;"></p>
                                            <p style="margin-top: -8px; font-size:5pt !important;"><b>
                                                    @php $vendor = SupplierDetails($pricing->vendor_id); @endphp
                                                    {{ 'For: ' . $vendor->vendor_name ?? ' Company Name' }}
                                                </b>
                                            </p>
                                        </div>
                                    </div>
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
