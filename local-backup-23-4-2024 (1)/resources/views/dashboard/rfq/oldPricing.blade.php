<?php $title = 'Price Quotation'; ?>
@extends('layouts.app')

@section('content')

<div class="main-container">

    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">SCM Dashboard</li>
            <li class="breadcrumb-item active"><a href="{{ route('rfq.price',$rfq->refrence_no) }}">View Price Quotation</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>
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
                        {{-- <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"></div> --}}
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="card">
                                <div class="card-body p-0">
                                    {{--  @if(count($check) == 0)
                                        <h3><p style="color:red" align="center"> No Supplier Quote has been picked with this RFQ </p></h3>  --}}

                                    @if(count($line_items) == 0)
                                        <h3><p style="color:red" align="center"> No Line Item was found for the RFQ </p></h3>
                                    @else
                                        <div class="invoice-container" id="printableArea">

                                            <div class="invoice-header">
                                                <!-- Row start -->
                                                <div class="row gutters">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                                        <div class="invoice-logo">
                                                            <img src="{{asset('pat/tag.png')}}" style="width:150px; height:100px" alt="SCM Solutions" />

                                                        </div>

                                                        <br>
                                                        <div class="col-lg-12 col-md-12 col-sm-6" align="left">
                                                            {{ date("D, d M Y") }}
                                                            <h6> {{ $rfq->client->client_name ?? ' ' }} </h6><br>
                                                            <h6>Attn: {{ $rfq->company->contact }}</h6>
                                                            <h6><u style="color: blue">{{ $rfq->company->email }} </u></h6>
                                                            <h6>Tel: {{ $rfq->company->contact_phone }}</h6><br>
                                                            <h6>Rfx: {{ $rfq->rfq_number ?? ' ' }} </h6><br>
                                                            <h6>{{ $rfq->company->company_name ?? ' ' }} Quotation for {{ $rfq->product }} </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8" align="right">
                                                        <button type="button" onclick="printDiv('printableArea')" class="btn btn-secondary btn-sm ml-4">
                                                            <i class="icon-printer"></i> Print
                                                        </button>
                                                        <p>{{ $rfq->client->client_name ?? ' ' }} </p>
                                                        <p>Ref No: {{ $rfq->refrence_no ?? ' ' }} </p>
                                                        <hr style="width:300px" align="right">
                                                        <h4>Price Quotation</h4>
                                                        <img src="{{asset('pat/cer.jpg')}}" style="width:150px; height:100px" alt="Certification" />

                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead class=" text-white" >
                                                                <tr  style="border-bottom: ridge; border-bottom-color: #000000;">
                                                                    <th class="bg-success">Item</th>
                                                                    <th class="bg-light" style="color: black"> Description</th>
                                                                    <th class="bg-light" style="color: black">UOM</th>
                                                                    <th class="bg-light" style="color: black">  </th>
                                                                    <th class="bg-light" style="color: black">Quantity</th>
                                                                    <th class="bg-light" style="color: black">  </th>
                                                                    <th class="bg-light" style="color: black">Unit Quote  </th>
                                                                    <th class="bg-light" style="color: black">  </th>
                                                                    <th class="bg-light" style="color: black">Total Quote</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody >
                                                                <?php $num =1; $wej = array(); ?>
                                                                @foreach ($line_items as $items)
                                                                    @php
                                                                        $unit_cost = $items->unit_cost;
                                                                        $percent = $items->unit_frieght;
                                                                        $unitMargin = (($percent/100) * $items->unit_cost);
                                                                    @endphp
                                                                    <tr>
                                                                        <td style="position: absolute;"> <p>{{ $num }}</p> </td>

                                                                        <td>
                                                                            <p style="text-align: justify; text-justify: inter-word;">{{ $items->item_name }}</p>

                                                                            <p style="text-align: justify; text-justify: inter-word;">{!! $items->item_description ?? 'N/A' !!}  </p>

                                                                        </td>

                                                                        @foreach (getUOM($items->uom) as $item)
                                                                            <td style="position: absolute;"> {{$item->unit_name ?? ''}} </td>
                                                                        @endforeach
                                                                        <td>  </td>
                                                                        <td style="position: absolute;"><p > {{$items->quantity ?? 0}} </p></td>
                                                                        <td>  </td>
                                                                        <td style="position: absolute;"> {{number_format($items->unit_quote, 2) ?? 0}} </td>
                                                                        <td>  </td>
                                                                        <td style="position: absolute;"> {{ number_format($items->total_quote, 2) }}
                                                                        @php $tot = $items->quantity * $items->unit_quote;
                                                                        array_push($wej, $tot);  @endphp
                                                                    </tr><?php $num++; ?>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-12" align="left">
                                                        <p style="color:red"><b>ESTIMATED PACKAGED WEIGHT: {{ $rfq->estimated_package_weight}} <br>
                                                        ESTIMATED PACKAGED DIMENSION : {{ $rfq->estimated_package_dimension}}<br>
                                                        HS CODE: {{ $rfq->hs_codes ?? 'N/A' }}</b> <br>
                                                        @if($rfq->certificates_offered != NULL)
                                                            <b>CERTIFICATE OFFERED: {{strtoupper($rfq->certificates_offered)}}</b>
                                                        @endif
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 order-last">
                                                        {{-- style="border: 3px solid black;" --}}
                                                        <table class="table m-0">
                                                            <tbody>
                                                                @php $sumTotalQuote = sumTotalQuote($rfq->rfq_id); $ship=0; @endphp
                                                                <tr  style="border-bottom: double; border-bottom-color: #000000; border-top: ridge; border-bottom-color: #000000;">
                                                                    <td >
                                                                        <p >
                                                                            <strong> Sub total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#36;{{ number_format($sumTotalQuote,2 )  }}<strong>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr  style="border-bottom: double; border-bottom-color: #000000; border-top: ridge; border-bottom-color: #000000;">
                                                                    <td >
                                                                        <p> -- </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-bottom: double; border-bottom-color: #000000; border-top: ridge; border-bottom-color: #000000;">
                                                                        <p ><strong>  TOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                                                        <strong>&#36;{{ number_format($sumTotalQuote + $ship, 2) ?? 0 }} </p>
                                                                    </td>
                                                                    <td> </td>
                                                                    <td> </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                                @if($rfq->technical_note != NULL)
                                                            <div class="col-lg-6 col-md-6 col-sm-12" align="left" style="color:red; font-weight: bold">
                                                                <p><b>Technical Notes: </b></p>
                                                                {!! htmlspecialchars_decode($rfq->technical_note)!!}
                                                                <br>
                                                            </div>
                                                        @endif

                                                        <div class="col-lg-12 col-md-12 col-sm-12" align="left">
                                                            <p style="color:red"><b>Notes to Pricing: </b></p>
                                                            1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }} after Confirmed Order.<br>
                                                            <b>2. Mode of transportation: {{ $rfq->transport_mode}}
                                                                {{-- @if(count($shipQuote) == 0)
                                                                    Check Shipper Quote to Pick the Shipper
                                                                @else

                                                                    @php $mod = getRfqShipQuote($rfq->rfq_id) @endphp
                                                                    {{ $mod->mode ?? 'Please Pick a Shipper'}}
                                                                @endif --}}
                                                            </b>
                                                            <br>
                                                            <b>3. Delivery Location:
                                                                {{-- @if(count(poEdit($rfq->rfq_id)) == 0)
                                                                    No PO Has been Issue for the RFQ
                                                                @else

                                                                    @php $add = poSee($rfq->rfq_id) @endphp
                                                                    {{ $add->delivery_location }}
                                                                @endif --}}
                                                                {{ $rfq->delivery_location}}
                                                            </b>
                                                            <br>
                                                            4. Where Legalisation of C of O and/or invoices are required, additional cost will apply
                                                                and will be charged at cost. <br>
                                                            5. Validity: This quotation is valid for {{ $rfq->validity}}. <br>
                                                            6. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br>
                                                            7. Pricing: Prices quoted are in USD <br>
                                                            8. Prices are based on quantity quoted <br>
                                                            9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
                                                            10. Oversized Cargo: NO <br><br>
                                                            Best Regards <br><br>

                                                            <img src="{{asset('admin/img/signature.png')}}" style="width:100px; height:100px" alt="SCM Solutions" /> <br>

                                                            {{ $rfq->assigned_to->full_name ?? '' }} <br>
                                                            For: TAG Energy Nigeria
                                                        </div>
                                                <!-- Row end -->
                                            </div>

                                            {{-- <div class="invoice-address"> --}}

                                               {{-- <br><br> --}}
                                                {{-- <div class="row gutters">
                                                    <div class="col-lg-4 col-md-4 col-sm-4">

                                                        <h6>{{ $rfq->company->company_name ?? 'Company Name' }}</h6>
                                                        <address>
                                                            {{ $rfq->company->address ?? 'Address' }}<br>
                                                            Phone: {{ $rfq->client->phone ?? '000-000-0000' }}<br>
                                                            Email: {{ $rfq->company->email ?? 'Email' }}<br>
                                                            Website: {{ $rfq->company->webadd ?? 'www.company-name.com' }}<br>
                                                        </address>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4">

                                                        <h6>{{ $rfq->client->client_name ?? 'Client Name' }}</h6>
                                                        <address>
                                                            {{ $rfq->client->address ?? 'Address' }}<br>
                                                            {{ $rfq->client->city . ' '. $rfq->client->state ?? '000-000-0000' }}<br>
                                                            Phone: {{ $rfq->client->phone ?? '000-000-0000' }}<br>
                                                            Email: {{ $rfq->client->email ?? 'Email' }}
                                                        </address>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <div class="invoice-details">
                                                            <small>Invoice No - <span class="badge badge-info">{{$number }}</span></small><br>
                                                            <small>Delivery Due Date: {{$rfq->delivery_due_date ?? ''}}</small><br>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                            {{-- </div> --}}

                                            <div class="invoice-body">

                                                {{-- <div class="row gutters">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">

                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class=" text-white" >
                                                                    <tr  style="border-bottom: ridge; border-bottom-color: #000000;">
                                                                        <th class="bg-success">Item</th>
                                                                        <th class="bg-light" style="color: black"> Description</th>
                                                                        <th class="bg-light" style="color: black">UOM</th>
                                                                        <th class="bg-light" style="color: black">  </th>
                                                                        <th class="bg-light" style="color: black">Quantity</th>
                                                                        <th class="bg-light" style="color: black">  </th>
                                                                        <th class="bg-light" style="color: black">Unit Quote  </th>
                                                                        <th class="bg-light" style="color: black">  </th>
                                                                        <th class="bg-light" style="color: black">Total Quote</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody >
                                                                    <?php $num =1; $wej = array(); ?>
                                                                    @foreach ($line_items as $items)
                                                                        @php
                                                                            $unit_cost = $items->unit_cost;
                                                                            $percent = $items->unit_frieght;
                                                                            $unitMargin = (($percent/100) * $items->unit_cost);
                                                                        @endphp
                                                                        <tr>
                                                                            <td style="position: absolute;"> <p>{{ $num }}</p> </td>

                                                                            <td>
                                                                                <p style="text-align: justify; text-justify: inter-word;">{{ $items->item_name }}</p>

                                                                                <p style="text-align: justify; text-justify: inter-word;">{!! $items->item_description ?? 'N/A' !!}  </p>

                                                                            </td>

                                                                            @foreach (getUOM($items->uom) as $item)
                                                                                <td style="position: absolute;"> {{$item->unit_name ?? ''}} </td>
                                                                            @endforeach
                                                                            <td>  </td>
                                                                            <td style="position: absolute;"><p > {{$items->quantity ?? 0}} </p></td>
                                                                            <td>  </td>
                                                                            <td style="position: absolute;"> {{number_format($items->unit_quote, 2) ?? 0}} </td>
                                                                            <td>  </td>
                                                                            <td style="position: absolute;"> {{ number_format($items->total_quote, 2) }}
                                                                            @php $tot = $items->quantity * $items->unit_quote;
                                                                            array_push($wej, $tot);  @endphp
                                                                        </tr><?php $num++; ?>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="invoice-payment">
                                                    <div class="row gutters">
                                                        {{-- <div class="col-lg-9 col-md-9 col-sm-12" align="left">
                                                            <p style="color:red"><b>ESTIMATED PACKAGED WEIGHT: {{ $rfq->estimated_package_weight}} <br>
                                                            ESTIMATED PACKAGED DIMENSION : {{ $rfq->estimated_package_dimension}}<br>
                                                            HS CODE: {{ $rfq->hs_codes ?? 'N/A' }}</b> <br>
                                                            @if($rfq->certificates_offered != NULL)
                                                                <b>CERTIFICATE OFFERED: {{strtoupper($rfq->certificates_offered)}}</b>
                                                            @endif
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 order-last">
                                                            {{-- style="border: 3px solid black;" --}}
                                                            <table class="table m-0">
                                                                <tbody>
                                                                    @php $sumTotalQuote = sumTotalQuote($rfq->rfq_id); $ship=0; @endphp
                                                                    <tr  style="border-bottom: double; border-bottom-color: #000000; border-top: ridge; border-bottom-color: #000000;">
                                                                        <td >
                                                                            <p >
                                                                                <strong> Sub total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#36;{{ number_format($sumTotalQuote,2 )  }}<strong>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr  style="border-bottom: double; border-bottom-color: #000000; border-top: ridge; border-bottom-color: #000000;">
                                                                        <td >
                                                                            <p> -- </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border-bottom: double; border-bottom-color: #000000; border-top: ridge; border-bottom-color: #000000;">
                                                                            <p ><strong>  TOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                                                            <strong>&#36;{{ number_format($sumTotalQuote + $ship, 2) ?? 0 }} </p>
                                                                        </td>
                                                                        <td> </td>
                                                                        <td> </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div> --}}


                                                    </div>
                                                    <br>

                                                    <div class="row gutters">
                                                        @if($rfq->technical_note != NULL)
                                                            <div class="col-lg-6 col-md-6 col-sm-12" align="left" style="color:red; font-weight: bold">
                                                                <p><b>Technical Notes: </b></p>
                                                                {!! htmlspecialchars_decode($rfq->technical_note)!!}
                                                                <br>
                                                            </div>
                                                        @endif

                                                        <div class="col-lg-12 col-md-12 col-sm-12" align="left">
                                                            <p style="color:red"><b>Notes to Pricing: </b></p>
                                                            1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }} after Confirmed Order.<br>
                                                            <b>2. Mode of transportation: {{ $rfq->transport_mode}}
                                                                {{-- @if(count($shipQuote) == 0)
                                                                    Check Shipper Quote to Pick the Shipper
                                                                @else

                                                                    @php $mod = getRfqShipQuote($rfq->rfq_id) @endphp
                                                                    {{ $mod->mode ?? 'Please Pick a Shipper'}}
                                                                @endif --}}
                                                            </b>
                                                            <br>
                                                            <b>3. Delivery Location:
                                                                {{-- @if(count(poEdit($rfq->rfq_id)) == 0)
                                                                    No PO Has been Issue for the RFQ
                                                                @else

                                                                    @php $add = poSee($rfq->rfq_id) @endphp
                                                                    {{ $add->delivery_location }}
                                                                @endif --}}
                                                                {{ $rfq->delivery_location}}
                                                            </b>
                                                            <br>
                                                            4. Where Legalisation of C of O and/or invoices are required, additional cost will apply
                                                                and will be charged at cost. <br>
                                                            5. Validity: This quotation is valid for {{ $rfq->validity}}. <br>
                                                            6. FORCE MAJEURE: On notification of any event with impact on delivery schedule, We will extend delivery schedule.<br>
                                                            7. Pricing: Prices quoted are in USD <br>
                                                            8. Prices are based on quantity quoted <br>
                                                            9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
                                                            10. Oversized Cargo: NO <br><br>
                                                            Best Regards <br><br>

                                                            <img src="{{asset('admin/img/signature.png')}}" style="width:100px; height:100px" alt="SCM Solutions" /> <br>

                                                            {{ $rfq->assigned_to->full_name ?? '' }} <br>
                                                            For: TAG Energy Nigeria
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row gutters">
                                                <div class="col-lg-12 col-md-12 col-sm-12" >
                                                    <img src="{{asset('pat/quote-footer.png')}}" style="width:1200px"  alt="Rockwool" />
                                                </div>
                                                {{-- <div class="col-lg-2 col-md-2 col-sm-2" align="center">
                                                    <img src="{{asset('pat/EnserveLogo-R.png')}}" style="width:90px; height:70px" alt="Enserve" />
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2" align="center">
                                                    <img src="{{asset('pat/james-walker.png')}}" style="width:100px; height:80px" alt="James Walker" />
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2" align="center">
                                                    <img src="{{asset('pat/DHV-Industries.png')}}" style="width:50px; height:50px" alt="DHV" />
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2" align="center">
                                                    <img src="{{asset('admin/img/img1.jpeg')}}" style="width:50px; height:50px" alt="SCM Solutions" />
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2" align="center">
                                                    <img src="{{asset('pat/guan.png')}}" style="width:120px; height:55px" alt="Gyan" />
                                                </div> --}}
                                            </div>
                                            <div class="invoice-footer">
                                                98b Mayfair Ave Eleganza Gardens, Lekki, Lagos | +234 1 295 6845, +234 807 259 7039 | contact@tagenergygroup.net
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"></div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

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

