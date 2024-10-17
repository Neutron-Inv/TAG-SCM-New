<?php $title = 'Shipper Quotation Details'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item"><a href="{{ route('ship.quote.show',$quo->rfq_id) }}">View Quotations</a></li>
                {{-- <li class="breadcrumb-item active"><a href="{{ route('rfq.index') }}">View RFQ</a></li> --}}

                <li class="breadcrumb-item">View Shipper Quote For The RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($quote) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of Shipper Quote for RFQs </h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead>
                                                <tr>
                                                    <th> S/N </th>
                                                    <th>Ref Nos</th>

                                                    <th>Sub Due Date</th>
                                                    <th>Product</th>
                                                    <th>Weight</th>
                                                    <th>Soncap Charges</th>
                                                    <th>Customs Duty</th>
                                                    <th>Clearing and Doc</th>
                                                    <th>Trucking Cost</th>
                                                    <th>BMI Charges</th>
                                                    <th>Mode</th>
                                                    <th>Currency</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; $wej = array(); ?>
                                                @foreach ($quote as $quotes)
                                                    <tr>

                                                        <td>{{ $num }}
                                                            @if (Auth::user()->hasRole('Shipper'))
                                                                <a href="{{ route('ship.quote.edit',$quotes->quote_id) }}" type="Edit Shipping Quote" class="" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                            @endif

                                                        </td>
                                                        <td>{{ $quotes->rfq->refrence_no ?? '' }}</td>

                                                        <td>{{ $quotes->rfq->shipper_submission_date ?? '' }}</td>
                                                        <td>{{ $quotes->rfq->product ?? '' }}</td>
                                                        <td>{{ $quotes->rfq->total_weight ?? ''}}</td>
                                                        <td> {{ number_format($quotes->soncap_charges,2) ?? '' }} </td>
                                                        <td> {{ number_format($quotes->customs_duty,2) ?? '' }} </td>
                                                        <td> {{ number_format($quotes->clearing_and_documentation,2)  ?? ''}} </td>

                                                        <td> {{ number_format($quotes->trucking_cost,2) ?? '' }} </td>
                                                        <td> {{ number_format($quotes->bmi_charges,2) ?? '' }} </td>
                                                        <td> {{ $quotes->mode ?? '' }} </td>
                                                        <td> {{ $quotes->currency ?? '' }} </td>

                                                    </tr><?php $num++;
                                                    $tot = $quotes->soncap_charges + $quotes->customs_duty +  $quotes->clearing_and_documentation +  $quotes->trucking_cost
                                                    + $quotes->bmi_charges;
                                                    array_push($wej, $tot); ?>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        <h3 style="color:green"><p align="center"><b>Total Price :
                                            <?php $to = (array_sum($wej)+0);
                                                echo number_format($to, 2);
                                                ?></b></p></h3>
                                    </div>

                                </div>
                            @endif
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            @if(count($req) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> No RFQ was found
                                            </p>
                                        </h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">
                                    </h5>

                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead class="bg-danger text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))
                                                    OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())
                                                    ))
                                                        <th>Status</th>
                                                        <th>Client</th>
                                                        <th>Assigned To</th>
                                                        <th>Buyer</th>
                                                        <th>Total Quote </th>
                                                    @endif
                                                    <th>Ref Nos</th>

                                                    <th>Submission Date</th>
                                                    <th>Product</th>

                                                    <th> Shipper Quote </th>
                                                    @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))
                                                        OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())
                                                        ))
                                                        <th> Supplier Quote </th>
                                                        <th>Line Item</th>
                                                    @endif

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($req as $rfqs)
                                                    <tr>

                                                        <td>{{ $num }}</td>
                                                        @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))
                                                        OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())
                                                        ))
                                                            <td>
                                                                @if($rfqs->status == 'Quotation Submitted')
                                                                    <span class="badge badge-pill badge-info"> {{ $rfqs->status ?? '' }} </span>
                                                                    @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                                                        <b><a href="{{ route('rfq.send',$rfqs->refrence_no) }}" class="" onclick="return(sendEnq());">
                                                                            Send Status Enq
                                                                        </a></b>
                                                                    @endif
                                                                @elseif($rfqs->status == 'Received RFQ')
                                                                    <span class="badge badge-pill badge-success"> {{ $rfqs->status ?? '' }} </span>

                                                                @elseif($rfqs->status == 'RFQ Acknowledged')
                                                                    <span class="badge badge-pill badge-secondary"> {{ $rfqs->status ?? '' }} </span>

                                                                @elseif($rfqs->status == 'Awaiting Pricing')
                                                                    <span class="badge badge-pill badge-gray"> {{ $rfqs->status ?? '' }} </span>

                                                                @elseif($rfqs->status == 'Awaiting Shipping')
                                                                    <span class="badge badge-pill badge-danger"> {{ $rfqs->status ?? '' }} </span>

                                                                @elseif($rfqs->status == 'Awaiting Approval')
                                                                    <span class="badge badge-pill badge-warning"> {{ $rfqs->status ?? '' }} </span>

                                                                @elseif($rfqs->status == 'Approved')
                                                                    <span class="badge badge-pill badge-orange"> {{ $rfqs->status ?? '' }} </span>

                                                                @elseif($rfqs->status == 'No Bid')
                                                                    <span class="badge badge-pill badge-primary"> {{ $rfqs->status ?? '' }} </span>

                                                                @else
                                                                    <span class="badge badge-pill badge-success">{{ $rfqs->status ?? '' }} </span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $rfqs->client->client_name ?? '' }}</td>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                <td>
                                                                    @foreach (employ($rfqs->employee_id) as $item)
                                                                        <a href="mailto:{{ $item->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? ''   }}</a>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    @foreach (buyers($rfqs->contact_id) as $items)
                                                                        <a href="mailto:{{ $items->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'Null' }}</a>
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                <td><a href="mailto:{{ $rfqs->employee->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->employee->full_name ?? ''   }}</a></td>
                                                                <td>
                                                                    <a href="mailto:{{ $rfqs->contact->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->contact->last_name ?? ''   }}</a>
                                                                </td>
                                                            @endif
                                                            <td>
                                                                @if($rfqs->value_of_quote_ngn < 2)
                                                                    &#8358;{{ number_format($rfqs->supplier_quote_usd + $rfqs->freight_charges)  }}
                                                                @else <?php
                                                                    $local_delivery = $rfqs->local_delivery;
                                                                    $fund_transfer = $rfqs->fund_transfer;
                                                                    $cost_of_funds = $rfqs->cost_of_funds;
                                                                    $other_cost = $rfqs->other_cost;
                                                                    $net_percentage = $rfqs->net_percentage;
                                                                    $net_value = $rfqs->net_value;
                                                                    $wht= $rfqs->wht;
                                                                    $ncd = $rfqs->ncd;
                                                                    $grossMargin = $rfqs->freight_charges + $local_delivery + $fund_transfer + $cost_of_funds + $other_cost + $net_percentage + $wht + $ncd;
                                                                    $tots = $grossMargin + $rfqs->supplier_quote_usd; ?>
                                                                    &#8358;{{ number_format($rfqs->value_of_quote_ngn,2) ?? '' }}
                                                                @endif
                                                            </td>
                                                        @endif

                                                        <td>
                                                            {{--  <a href="{{ route('rfq.details', $rfqs->refrence_no) }}" style="color:blue">  --}}
                                                            {{ $rfqs->refrence_no ?? '' }}
                                                            {{--  </a>  --}}
                                                        </td>
                                                        {{--  <td>{{ $rfqs->rfq_number ?? '' }}</td>  --}}

                                                        <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                        <td>{{ $rfqs->product ?? '' }}</td>

                                                        {{--  <td><span class="icon-dollar-sign"></span>{{ ($rfqs->value_of_quote_usd) ?? '' }}</td>  --}}

                                                        <td> @php $sup = countShipQuote($rfqs->rfq_id); @endphp
                                                                @if($sup < 1)
                                                                    0
                                                                @else
                                                                    <a href="{{ route('ship.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                                @endif
                                                        </td>
                                                        @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))
                                                        OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())
                                                        ))
                                                            <td> @php $sup = countSupQuote($rfqs->rfq_id); @endphp
                                                                @if($sup < 1)
                                                                    0
                                                                @else
                                                                    <a href="{{ route('sup.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <?php $co = countLineItems($rfqs->rfq_id) ?>
                                                                @if($co > 0 )
                                                                    {{-- @foreach (editLineItems($rfqs->rfq_id) as $item)
                                                                        <a href="{{ route('line.details', $item->line_id) }}" style="color:blue">{{ $co }} </a>
                                                                    @endforeach --}}

                                                                    <a href="{{ route('line.preview', $rfqs->rfq_id) }}" style="color:blue">{{ $co }}</a>
                                                                @else
                                                                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                        <a href="{{ route('line.create', $rfqs->rfq_id) }}" style="color:blue">{{ $co }} </a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @endif

                                                    </tr><?php $num++; ?>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endif
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            @if(count($line_items) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> No RFQ was found
                                            </p>
                                        </h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">
                                    </h5>

                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Item Name</th>
                                                    <th>Item Number</th>
                                                    <th>Description</th>

                                                    <th>UOM</th>
                                                    <th>Quantity</th>
                                                    @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR
                                                        (Auth::user()->hasRole('HOD'))))

                                                        <th>Unit Cost
                                                            @php $sumUnitCost = sumUnitCost($rfqs->rfq_id); @endphp

                                                        </th>
                                                        <th>Total Cost

                                                            @php $sumTotalCost = sumTotalCost($rfqs->rfq_id); @endphp
                                                            @if($sumTotalCost > 0 )
                                                                {{ number_format($sumTotalCost, 2) ?? 0}}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                        <th>Unit Margin
                                                            @php $sumUnitMargin = sumUnitMargin($rfqs->rfq_id); @endphp

                                                        </th>
                                                        <th>Total Margin
                                                            @php $sumTotalMargin = sumTotalMargin($rfqs->rfq_id); @endphp
                                                            @if($sumTotalMargin > 0 )
                                                                {{ number_format($sumTotalMargin, 2) ?? 0 }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                        <th>Unit Quote

                                                        </th>
                                                        <th>Total Quote
                                                            @php $sumTotalQuote = sumTotalQuote($rfqs->rfq_id); @endphp
                                                            @if($sumTotalQuote > 0 )
                                                                {{ number_format($sumTotalQuote, 2) ?? 0 }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>

                                                    @endif

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $num =1; $wex = array(); ?>
                                                @foreach ($line_items as $items)
                                                    <tr>
                                                        <td> {{ $num }}
                                                            @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                <a href="{{ route('line.edit',$items->line_id) }}" title="Edit Line Items" class="" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                                {{--  <a href="{{ route('line.details',$items->line_id) }}" title="View Line Item Details" class="" onclick="return(confirmToDetails());">
                                                                    <i class="icon-list" style="color:green"></i>
                                                                </a>  --}}
                                                            @endif

                                                        </td>

                                                        <td> {{$items->item_name ?? ''}} </td>
                                                        <td> {{$items->item_number ?? ''}} </td>
                                                        <td>
                                                            {!! substr($items->item_description, 0, 70) ?? 'N/A' !!} ..
                                                            <br>
                                                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $num }}">view more</a>

                                                            <div class="modal fade bd-example-modal-lg-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg-{{ $num }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="myLargeModalLabel-{{ $num }}">Line Item Description</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {!! $items->item_description ?? 'N/A' !!}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            @foreach (UOM($items->uom) as $uom)
                                                                {{ $uom->unit_name }}
                                                            @endforeach
                                                        </td>
                                                        <td>

                                                            {{$items->quantity ?? 0}}
                                                        </td>
                                                        @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR
                                                        (Auth::user()->hasRole('HOD'))))

                                                            <td> {{number_format($items->unit_cost,2) ?? 0}} </td>
                                                            <td> {{number_format($items->total_cost ,2) ?? ''}} </td>

                                                            <td> {{number_format($items->unit_margin, 2) ?? 0}} </td>
                                                            <td> {{number_format($items->total_margin, 2) ?? ''}} </td>

                                                            <td> {{number_format($items->unit_quote, 2) ?? 0}} </td>

                                                            <td> {{number_format($items->total_quote, 2) ?? ''}} </td>

                                                            @php $tot = $items->total_quote;
                                                            array_push($wex, $tot);  @endphp
                                                        @endif

                                                    </tr><?php $num++; ?>
                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
