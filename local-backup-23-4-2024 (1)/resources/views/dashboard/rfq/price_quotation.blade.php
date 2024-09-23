<?php
// $title = 'Price Quotation';

$title = "TAG Energy Quotation " .$rfq->refrence_no . ", ". $rfq->description;
// dd($title);
?>
@extends('layouts.app')
<style type="">
    .table tbody tr:nth-of-type(even) {
    background-color: #FDFEFE; }
</style>
@section('content')

<div class="main-container">

    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">SCM Dashboard</li>
            <li class="breadcrumb-item active"><a href="{{ route('rfq.price',$rfq->refrence_no) }}">View Price Quotation</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View All RFQ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('line.preview', $rfq->rfq_id) }}">View Line Items</a></li>
            {{-- <li class="breadcrumb-item"><a href="{{ route('rfq.price', $rfq->refrence_no) }}"> Price Quotation</a></li> --}}
            <li class="breadcrumb-item"><a href="{{ route('rfq.edit', $rfq->refrence_no) }}">Edit RFQ </a></li>
            <li class="breadcrumb-item">View Price Quotation for RFQ</li>
        </ol>
        @include('layouts.logo')
    </div>


    <div class="content-wrapper">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts.alert')


                    <div class="row gutters">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($line_items) > 0)
                                <!--<button type="button" onclick="" class="btn btn-secondary btn-sm ml-4">-->
                                <!--    <i class="icon-printer"></i> Download-->
                                <!--</button>-->

                                <a href="{{ route('rfq.downloadQuote',$rfq->rfq_id) }}" class="btn btn-secondary btn-sm ml-4" target="_blank">
                                    <i class="icon-printer"></i>View PDF
                                </a>

                            @endif

                            <div class="card">

                                <div class="card-body p-0">

                                    @if(count($line_items) == 0)
                                        <h3><p style="color:red" align="center"> No Line Item was found for the RFQ </p></h3>
                                    @else

                                        <div class="invoice-container" id="printableArea" style="background-color: white !important; font-family: Calibri, sans-serif;">
                                            <p style="font-size: 8.0pt;font-family: Calibri,sans-serif; float: right">SCM 208 v1.0 </p><br>
                                            <div class="invoice-header" style="font-family: Calibri, sans-serif;">

                                                <div class="row gutters" >
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4" >
                                                        <div class="invoice-logo">
                                                            @if(Auth::user()->hasRole('SuperAdmin'))
                                                                @foreach (getLogo($rfq->company->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$rfq->company->company_id.'/'.$item->company_logo) }}" style="width: 50px; height:50px;" alt="{{$rfq->company->company_id}}">
                                                                @endforeach
                                                            @elseif(Auth::user()->hasRole('Admin'))
                                                                @foreach (getLogo($company->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$company->company_id.'/'.$item->company_logo) }}" style="width: 50px; height:50px;" alt="">
                                                                @endforeach
                                                                {{-- <img src="{{asset('document/company/'.$company->company_id.'/logo_picture_s.png')}}" alt="{{$company->company_id}}" style="height:40px;height:40px" /> --}}
                                                            @elseif(Auth::user()->hasRole('Employer'))
                                                                @foreach (getLogo($employee->company->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$employee->company->company_id.'/'.$item->company_logo) }}" style="width: 50px; height:50px;" alt="">
                                                                @endforeach
                                                                {{-- <img src="{{asset('document/company/'.$employee->company->company_id.'/logo_picture_s.png')}}" alt="{{$employee->company->company_id}}" style="height:40px;height:40px" /> --}}
                                                            @elseif(Auth::user()->hasRole('Contact'))
                                                                @foreach (getLogo($contact->client->company->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$contact->client->company->company_id.'/'.$item->company_logo) }}" style="width: 50px; height:50px;" alt="">
                                                                @endforeach
                                                                {{-- <img src="{{asset('document/company/'.$contact->client->company->company_id.'/logo_picture_s.png')}}" alt="{{$contact->client->company->company_id}}" style="height:40px;height:40px" /> --}}
                                                            @elseif(Auth::user()->hasRole('Client'))
                                                                @foreach (getLogo($client->company->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$client->company->company_id.'/'.$item->company_logo) }}" style="width: 50px; height:50px;" alt="">
                                                                @endforeach
                                                                {{-- <img src="{{asset('document/company/'.$client->company->company_id.'/logo_picture_s.png')}}" alt="{{$client->company->company_id}}" style="height:40px;height:40px" /> --}}
                                                            @elseif(Auth::user()->hasRole('Supplier'))
                                                                @foreach (getLogo($vendor->company->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$vendor->company->company_id.'/'.$item->company_logo) }}" style="width: 50px; height:50px;" alt="{{$vendor->company->company_id}}">
                                                                @endforeach
                                                            @else
                                                                <img src="{{asset('admin/img/img1.jpeg')}}" alt="SCM Solutions" style="height:40px;height:40px" />
                                                            @endif                                          
							</div>

                                                        <br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left: -12px; font-family: Calibri,sans-serif; margin-top: -10px">

                                                            <p style="font-size: 12.0pt;font-family: Calibri,sans-serif;"><strong> {{ $rfq->client->client_name ?? ' ' }} </strong></p><br>
                                                            <h6><p style="font-size: 9.9pt; margin-top: -27px;"> {{ $rfq->client->address ?? ' ' }} </p></h6><br>
                                                            <h6 style="font-size: 10.5pt;">Attn: {{ $rfq->contact->first_name . ' '. $rfq->contact->last_name ?? ' '}}</h6>
                                                            <h6 style="font-size: 9.5pt;"><u style="color: blue">{{ $rfq->contact->email ?? ' ' }} </u></h6>
                                                            <h6 style="font-size: 9.5pt;">Tel: {{ $rfq->contact->office_tel ?? ' ' }}</h6><br>
                                                            <h6 style="font-size: 9.5pt; margin-top: -10px;">Rfx: {{ $rfq->rfq_number ?? ' ' }} </h6><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8" style="margin-top: " align="right">

                                                        <p style="font-size: 9.5pt;font-family:Calibri,sans-serif;">{{ $rfq->client->client_name ?? ' ' }} </p>
                                                        <p  style="font-size: 9.5pt;font-family:Calibri,sans-serif;"><strong>REF No: {{ $rfq->refrence_no ?? ' ' }} </strong></p>
                                                        <hr style="width:260px; border: 1px solid black;" align="right">
                                                        <h2 style="font-size: 28pt; font-family: Tw Cen MT Condensed,sans-serif; margin-bottom:.0rem;">Price Quotation</h2>
                                                        <img src="{{asset('pat/ISO9001.png')}}" style="width: 150px; height: 80px; margin-top:-10px" alt="Certification" />
                                                        <br>
                                                        <p style="font-size: 9.5pt;font-family:Calibri,sans-serif;">{{ date("l, d F Y") }} </p>
                                                    </div>
                                                    <p style="font-size: 11.5pt;font-family:Calibri,sans-serif; margin-left:10px; margin-top: -10px">
                                                        <b> {{ $rfq->company->company_name  .' Quotation for '. $rfq->product ?? ' '}} </b>
                                                     </p>
                                                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left: 2px; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                        <div class="table-responsive" style="font-size: 10.0pt; font-family: Calibri, sans-serif;">

                                                            <table class="table" style="font-size: 10.0pt; font-family: Calibri, sans-serif;"
                                                                >
                                                                <thead class="text-white" style="font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                    <tr style="border-bottom: ridge; border-bottom-color: #000000; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                        <th class="" style="padding-top: 3px; width: 30px; color:black; background-color: #C4D79B !important; font-family: Calibri, sans-serif; font-size: 10.0pt;">
                                                                            <strong>Item </strong>
                                                                        </th>
                                                                        <th class="" style="padding-top: 3px; width: 70%; color: black; background-color: #F2F2F2 !important; text-align: left; font-family: Calibri, sans-serif;
                                                                            font-size: 10.0pt;"><b> Description </b>
                                                                        </th>
                                                                        <th class="" style="padding-top: 3px; color: black; background-color: #F2F2F2 !important; font-family: Calibri, sans-serif; font-size: 10.0pt;"><b>UOM </b></th>

                                                                        <th class="" style="padding-top: 3px; text-align:center; color: black; background-color: #F2F2F2 !important; font-family: Calibri, sans-serif;font-size: 10.0pt; "><b>Qty </b></th>

                                                                        <th style="padding-top: 3px; text-align: center; color: black; background-color: #F2F2F2 !important; font-family: Calibri, sans-serif;
                                                                            font-size: 10.0pt; width: 120px;"><b> Unit Price
                                                                             <br><span style="text-align: center"> ({{ $rfq->currency ?? 'USD' }}) </span></b>
                                                                        </th>

                                                                        <th style="padding-top: 3px; text-align: center; color: black; background-color: #F2F2F2 !important; font-family: Calibri, sans-serif;
                                                                            font-size: 10.0pt; width: 120px;"><b> Total Price
                                                                             <br><span style="text-align: center"> ({{ $rfq->currency ?? 'USD' }}) </span></b>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style="font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                    <?php $num =1; $wej = array(); ?>
                                                                    @foreach ($line_items as $items)
                                                                        @php
                                                                            $unit_cost = $items->unit_cost;
                                                                            $percent = $items->unit_frieght;
                                                                            $unitMargin = (($percent/100) * $items->unit_cost);
                                                                        @endphp
                                                                        <tr style="font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                            <td class="list" style="padding-top: 2px; background-color: #EBF1DE !important; text-align: center; font-family: Calibri, sans-serif; font-size: 10.0pt;">
                                                                                <b>{{ $num }}</b> </td>
                                                                            <td style="padding-top: 2px; text-align: justify; text-justify: inter-word;">
                                                                                <p style="margin-top:-5px; font-size: 10.0pt; font-family: Calibri, sans-serif;"> <b>{{ $items->item_name }} </b></p>
                                                                                <p style="font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                                    {!! htmlspecialchars_decode($items->item_description) ?? 'N/A' !!}
                                                                                </p>
                                                                            </td>
                                                                            @foreach (getUOM($items->uom) as $item)
                                                                                <td style="padding-top: 2px; font-size: 10.0pt; font-family: Calibri, sans-serif;"><b> {{$item->unit_name ?? ''}} </b></td>
                                                                            @endforeach

                                                                            <td style="padding-top: 2px; text-align: right; font-size: 10.0pt; font-family: Calibri, sans-serif;"><b > {{$items->quantity ?? 0}} </b></td>

                                                                            <td style="padding-top: 2px; font-size: 10.0pt; font-family: Calibri, sans-serif;" align="right"><b> {{number_format($items->unit_quote, 2) ?? 0}}</b> </td>

                                                                            <td style="padding-top: 2px; font-size: 10.0pt; font-family: Calibri, sans-serif;" align="right"><b> {{ number_format($items->total_quote, 2) }} </b></td>
                                                                            @php $tot = $items->quantity * $items->unit_quote;
                                                                            array_push($wej, $tot);  @endphp
                                                                        </tr><?php $num++; ?>
                                                                    @endforeach

                                                                    <tr style="font-size: 10.0pt; font-family: Calibri, sans-serif;">

                                                                        <td colspan="2" style="background-color:white; padding-top: 3px; border:#000000; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                            <p style="font-size: 10pt; font-family: Calibri, sans-serif; margin-left:-5px"><b style="color:red"><b>ESTIMATED PACKAGED WEIGHT: {{ $rfq->estimated_package_weight}} <br>
                                                                            ESTIMATED PACKAGED DIMENSION : {{ $rfq->estimated_package_dimension}}<br>
                                                                            HS CODE: {{ $rfq->hs_codes ?? 'N/A' }}</b> <br>
                                                                            @if($rfq->certificates_offered != NULL)
                                                                                <b>CERTIFICATE OFFERED: {{strtoupper($rfq->certificates_offered)}}</b>
                                                                            @endif
                                                                        </td>

                                                                        @php $sumTotalQuote = sumTotalQuote($rfq->rfq_id); $ship=0; @endphp
                                                                        <td style="background-color:white;"> </td> <td style="background-color:white;"> </td>

                                                                        <td colspan="3" style="background-color:white; font-size: 10.0pt; font-family: Calibri, sans-serif;" align="right">
                                                                            <p style="border-bottom: ridge; border-bottom-color: #000000; border-top: ridge;
                                                                                border-top-color: #000000; text-align: right; width: 95%; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                                <strong> Sub total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                <span style="text-align: ;"> {{ number_format($sumTotalQuote,2 )  }}</strong>
                                                                            </p>

                                                                            <p style="text-align: right; width: 95%; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                                <b> Total </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                <strong ><span style="">{{ number_format($sumTotalQuote + $ship, 2) ?? 0 }} </strong>
                                                                            </p>
                                                                            <p style="border-bottom: ridge; border-bottom-color: #000000; border-top: ridge; border-top-color: #000000; width: 95%;"></p>
                                                                            <p style="border-bottom: double; border-bottom-color: #000000; border-top-color: #000000; width: 95%;"></p>
                                                                        </td>
                                                                    </tr>
                                                                    @if($rfq->technical_note != NULL)
                                                                        <tr>
                                                                            <td colspan="4" style="background-color:white; font-size: 10.0pt; font-family: Calibri, sans-serif;">

                                                                                <p style="color:red; font-weight: bold; margin-left: -5px; font-size: 10.0pt; font-family: Calibri, sans-serif;"><b>Technical Notes: </b>
                                                                                {!! htmlspecialchars_decode($rfq->technical_note)!!}</p>
                                                                                <br>

                                                                            </td>
                                                                        </tr>
                                                                    @endif

                                                                    <tr>

                                                                        <td colspan="2" style="background-color:white; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                            <p style="font-size: 10.5pt; font-family: Calibri; margin-left:-5px"><b style="color:red">Notes to Pricing: </b><br>
                                                                            1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks after Confirmed Order' }} .<br>
                                                                            <b>2. Mode of transportation: <b>{{ $rfq->transport_mode}} </b></b>
                                                                            <br>
                                                                            <b>3. Delivery Location: <b>{{ $rfq->delivery_location}} </b></b>
                                                                            <br>
                                                                            4. Where Legalisation of C of O and/or invoices are required, additional cost will apply
                                                                                and will be charged at cost. <br>
                                                                            5. Validity: This quotation is valid for <b>{{ $rfq->validity}}. </b><br>
                                                                            6. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br>
                                                                            7. Pricing: Prices quoted are in <b>{{ $rfq->currency ?? 'USD' }} </b><br>
                                                                            8. Prices are based on quantity quoted <br>
                                                                            9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
                                                                            10. Oversized Cargo: <b>{{ $rfq->oversized ?? 'NO' }} </b><br>
                                                                            <b> Best Regards  <br>
                                                                            <img src="{{asset('pat/image017.png')}}" style="width:80px; height:80px; margin-left:0px" alt="SCM Solutions" /> <br>
                                                                            <p style="margin-top: -7px; margin-left:0px">
                                                                                <b>{{ $rfq->assigned_to->full_name ?? '' }} </b>
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
                                            <br><br><br><br>
                                            <div class="invoice-footer" align="center">
                                                <img src="{{asset('pat/---TAG Signature FOOTER.JPG')}}" style="width:1150px; height:45px"  alt="SCM" style="text-align: center" /><br>
                                                98b Mayfair Ave Eleganza Gardens, Lekki, Lagos | +234 1 295 6845, +234 906 243 5410  | sales@tagenergygroup.net
                                            </div>
                                            {{-- <div class="" align="center" style="margin-top: -15px">
                                                98b Mayfair Ave Eleganza Gardens, Lekki, Lagos | +234 1 295 6845, +234 906 243 5410  | sales@tagenergygroup.net
                                            </div><br> --}}

                                        </div>

                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

@endsection

