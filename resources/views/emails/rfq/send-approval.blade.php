@component('mail::message')
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="x-apple-disable-message-reformatting">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    </head>
    <body>
        <p style="color: #203864; font-size: 11pt;font-family: Calibri, sans-serif;">  Dear Madam,</p>
        <p style="color:#203864; font-size: 11pt;font-family: Calibri, sans-serif;"> Please see below cost breakdown and attached spreadsheet for your approval. <br></p>
        <p style="color:#203864; font-size: 11pt;font-family: Calibri, sans-serif;">
            Client:<b> {{ $rfq->client->client_name }} </b> <br><br>
            Buyer:  <b>{{ $rfq->contact->first_name . ' '. $rfq->contact->last_name ?? ' '}}</b>  <br><br>
            Supplier: <b> {{ $rfq->vendor->vendor_name }} </b>  <br>
            Description: <b> {!! $rfq->description !!}</b>  <br><br>
            Incoterm: <b> DDP </b> <br><br>
            Estimated Packaged Weight: <b>{{ $rfq->estimated_package_weight}} </b> <br><br>
            Estimated Package Dimension: <b>{{ $rfq->estimated_package_dimension}} </b> <br><br>
            Shipper: <b> {{ $rfq->shipper->shipper_name ?? '' }}</b>
        </p>@php
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
        <p>
        <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="533" style="width:400.0pt; margin-left:-.15pt; border-collapse:collapse">
            <tbody>
                <tr style="height:15.0pt">
                    <td width="164" nowrap="" valign="center" style="width:250.35pt; border:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                    <p class="MsoNormal" align="right" style="text-align:left"><b><span style="font-size:8.0pt"> Total Ex-Works
                        </span></b></p>
                    </td>

                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt;
                        border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">
                        {{number_format($rfq->supplier_quote_usd) ?? 0 }}
                        </span></b></p>
                    </td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:solid windowtext 1.0pt; border-left:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                </tr>

                <tr style="height:15.0pt">
                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:8.0pt; color:black">Packaging Cost
                        </span></b></p>
                    </td>

                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt;
                        border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">
                        {{ number_format($rfq->other_cost,2) ?? 0 }}
                        </span></b></p>
                    </td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:solid windowtext 1.0pt; border-left:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                </tr>

                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:17.25pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt">SONCAP CHARGES
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">

                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt">Customs duty
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:black">
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>

                </tr>
                    <tr style="height:17.25pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt">Clearing &amp; Documentation
                        </span></p></td>
                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:black">
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:17.25pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:16.5pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt">Trucking Cost
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:black">
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:16.5pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:14.25pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:14.25pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="bottom" style="width:123.35pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:8.0pt; color:black"> {{ $rfq->shipper->shipper_name }} Airfreight cost
                        </span></b></p>
                    </td>

                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt;
                        border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:red">
                        {{ round($rfq->freight_charges,2) ?? '0.00' }}
                        </span></b></p>
                    </td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border-top:solid windowtext 1.0pt; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:solid windowtext 1.0pt; border-left:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                </tr>

                <tr style="height:15.0pt">
                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:8.0pt; color:black">
                        Sub Total 1
                        </span></b></p>
                    </td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><b><span style="font-size:8.0pt; color:red"> {{ number_format(sumTotalQuote($rfq->rfq_id),2) ?? 0}}
                        </span></b></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:right"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b>
                        <span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>

                </tr>
                <tr style="height:25.0pt">
                    <td width="120" nowrap="" valign="center" style="width:120.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:"><span style="font-size:8.0pt; color:black">

                        Cost of funds <br> (Subtotal * 1.3% * 4 Months)
                        </span></p>
                    </td>
                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:red">
                        {{ round($rfq->cost_of_funds,2) ?? 0 }}

                        </span></p>
                    </td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal">
                        <span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt; color:red">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt; color:black">
                        Cost of Fund Transfer <br>(1 % of Total Ex- Works or $30 whichever is higher)
                        </span></p></td>
                    <td width="439" nowrap="" colspan="3" valign="center" style="width:329.35pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal">
                        <span style="font-size:8.0pt; color:red">&nbsp;
                        @php $cal = (7.5 * 100)/$rfq->cost_of_funds; @endphp {{ number_format($cal,2) ?? 0 }}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:left"><span style="font-size:8.0pt; color:black">
                            &nbsp;VAT on Transfer Cost(7.5% of Funds Transfer)
                        </span></p></td>
                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:red">
                        3.58
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:red">&nbsp;
                        </span></p></td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:left"><span style="font-size:8.0pt; color:black">

                        Offshore Charges (fixed @ $25)
                        </span></p></td>
                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:red">
                        25.00
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:left"><span style="font-size:8.0pt; color:black">

                                Swift Charges (fixed @ $25)
                        </span></p></td>
                    <td width="267" nowrap="" colspan="2" valign="center" style="width:200.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:red">

                        25.00
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt; color:red">&nbsp;
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>

                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="" style="text-align:left"><b><span style="font-size:8.0pt">

                                Total DDP Cost
                        </span></b></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><b><span style="font-size:8.0pt; color:red">
                            10,071.46
                        </span></b></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></b></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:8.0pt; color:black">&nbsp;</span><span style="font-size:8.0pt">
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; background: #F2F2F2; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><b><span style="font-size:8.0pt">
                            Total Quotation
                        </span></b></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><b><span style="font-size:8.0pt">
                        {{ number_format(sumTotalQuote($rfq->rfq_id)) }}
                        </span></b></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt">&nbsp;
                        </span></b></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt">&nbsp;
                        </span></b></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt">
                            VAT
                        </span></p></td>
                    <td width="164" nowrap="" valign="center" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt">-&nbsp;
                        </span></p></td>
                    <td width="103" nowrap="" valign="center" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt">&nbsp;
                        </span></b></p></td>
                    <td width="172" nowrap="" valign="center" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><b><span style="font-size:8.0pt">&nbsp;
                        </span></b></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">

                        <p class="MsoNormal" align="left" style="text-align:left"><span style="font-size:8.0pt">
                            WHT &amp; NCD ((Total Quote minus Sub Total 1 * 6%)
                        </span></p></td>
                    <td width="439" nowrap="" colspan="3" valign="center" style="width:329.35pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">
                        {{ round($newNcd + $newWht,2) ?? 0 }}
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="bottom" style="width:70.65pt; border-top:none; border-left:solid windowtext 1.0pt; border-bottom:solid windowtext 1.0pt; border-right:none; background: white; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal" align="right" style="text-align:left"><b>
                        <span style="font-size:8.0pt; color:black">Total TAXES
                        </span></b></p></td>
                    <td width="164" nowrap="" valign="bottom" style="width:123.35pt; border-top:none; border-left:solid windowtext 1.0pt; border-bottom:solid windowtext 1.0pt; border-right:none; background: #D9D9D9; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><b><span style="font-size:8.0pt; color:black">
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
                            <span style="font-size:8.0pt">Net Margin (Total Quote minus (Total DDP Cost + WHT))
                        </span></p>
                    </td>
                    <td width="439" nowrap="" colspan="3" valign="center" style="width:329.35pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt">
                        {{ number_format($net_margin,2) ?? '0'}}
                        </span></p>
                    </td>
                </tr>

                <tr style="height:15.0pt">
                    <td width="94" nowrap="" valign="center" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none;  padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><b><span style="font-size:8.0pt; color:black">
                        % Net Margin
                        </span></b><b><span style="font-size:8.0pt">
                        </span></b></p>
                    </td>
                    <td width="164" nowrap="" colspan="" valign="center" style="width:123.35pt; border:none; background: red; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt"> {{ number_format($comp,3) ?? 0 }}
                        </span></p>
                    </td>
                    <td width="103" nowrap="" valign="bottom" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="bottom" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>

                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt">
                            Gross Margin
                        </span></p>
                    </td>
                    <td width="164" nowrap="" colspan="" valign="bottom" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:black">{{ number_format($rfq->net_value,2,".","") ?? '0'}}
                        </span></p></td>
                    <td width="103" nowrap="" valign="bottom" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="bottom" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
                <tr style="height:15.0pt">
                    <td width="94" nowrap="" style="width:70.65pt; border:solid windowtext 1.0pt; border-top:none; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal" align="right" style="text-align:left"><span style="font-size:8.0pt">
                        % Gross Margin
                        </span></p>
                    </td>
                    <td width="164" nowrap="" valign="bottom" style="width:123.35pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt">
                        <p class="MsoNormal"><span style="font-size:8.0pt; color:black">{{ number_format($rfq->percent_margin * 100,4,".","") ?? '0'}}
                        </span></p></td>
                    <td width="103" nowrap="" valign="bottom" style="width:77.0pt; border:none; border-bottom:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p></td>
                    <td width="172" nowrap="" valign="bottom" style="width:129.0pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt; height:15.0pt"><p class="MsoNormal"><span style="font-size:8.0pt; color:black">&nbsp;
                        </span></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="font-size: 11pt; font-family: Calibri, sans-serif;"><b style="color:red">Notes to Pricing: </b><br> <br>
            1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }} after Confirmed Order. <br>
            2. Mode of transportation:  <b>{{ $rfq->transport_mode}} </b> <br>
            3. Delivery Location: <b>{{ $rfq->delivery_location}} </b><br>
            4. Where Legalisation of C of O and/or invoices are required, additional cost will apply and will be charged at cost. <br>
            5. Validity: This quotation is valid for <b>{{ $rfq->validity}} </b>. <br>
            6. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br>
            7. Pricing: Prices quoted are in <b>{{ $rfq->currency ?? 'USD' }} </b> <br>
            8. Prices are based on quantity quoted <br>
            9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
            10. Oversized Cargo: <b>{{ $rfq->oversized ?? 'NO' }} </b><br>
        </p>
        <p style="font-size: 7.5pt;font-family: Arial,sans-serif; color: #1F497D;">Best Regards,<br> {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, <br> SCM Specialist II <br>
            PHONE</span></b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                : +234 1 342 8420&nbsp;| </span>
                <span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                +234 906 243 5410&nbsp; </span><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
            </span><br><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864">EMAIL:
            </span></b><span style="color:#2F5496"><a href="mailto:sales@tagenergygroup.net"><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif">
                sales@tagenergygroup.net</span></b></a>
            </span>

        </p>
        <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
        </p>
    </body>
</html>


@endcomponent
