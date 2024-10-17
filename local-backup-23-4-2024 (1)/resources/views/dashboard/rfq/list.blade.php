<?php $title = 'RFQs'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.list') }}">View All RFQ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>

                <li class="breadcrumb-item">List of RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        @if (Gate::allows('SuperAdmin', auth()->user()))
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                @if(count($rfq) == 0)
                                    <div class="card">
                                        <div class="card-body">
                                            <h4><p style="color:red" align="center"> No RFQ was found for

                                                    @if (Gate::allows('SuperAdmin', auth()->user()))
                                                        All Clients
                                                    @else

                                                    @endif
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                @else
                                    <div class="table-container">
                                        <h5 class="table-title">Active RFQs
                                        </h5>

                                        <div class="table-responsive">
                                            <table id="fixedHeader" class="table">
                                                <thead class="bg-warning text-white">
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Status</th>
                                                        <th>Client</th>
                                                        <th>Ref Nos</th>
                                                        <th>Rfq No</th>
                                                        <th>Assigned To</th>
                                                        <th>Buyer</th>
                                                        <th>Rfq Date</th>
                                                        <th>Product</th>
                                                        <th>Description</th>
                                                        {{--  <th>Total Quote (USD)</th>  --}}
                                                        <th>Total Quote (NGR)</th>
                                                        <th>Line Item</th>
                                                        <th>Files</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Status</th>
                                                        <th>Client</th>
                                                        <th>Ref Nos</th>
                                                        <th>Rfq No</th>
                                                        <th>Assigned To</th>
                                                        <th>Buyer</th>
                                                        <th>Rfq Date</th>
                                                        <th>Product</th>
                                                        <th>Description</th>
                                                        <th>Total Quote (USD)</th>
                                                        <th>Total Quote (NGR)</th>
                                                        <th>Line Item</th>
                                                        <th>Files</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php $num =1; ?>
                                                    @foreach ($rfq as $rfqs)
                                                        <tr>

                                                            <td>{{ $num }}
                                                                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                    <a href="{{ route('rfq.edit',$rfqs->refrence_no) }}" title="Edit The RFQ" class="" onclick="return(confirmToEdit());">
                                                                        <i class="icon-edit" style="color:blue"></i>
                                                                    </a>

                                                                @endif
                                                                <a href="{{ route('rfq.details',$rfqs->refrence_no) }}" title="View RFQ Details" class="" onclick="return(confirmToDetails());">
                                                                    <i class="icon-list" style="color:green"></i>
                                                                </a>
                                                                <a href="{{ route('rfq.price',$rfqs->rfq_id) }}" title="View RFQ Price Quotation" class="" onclick="">
                                                                    <i class="icon-book" style="color:green"></i>
                                                                </a>

                                                                {{-- <a href="{{ route('po.new.details',$rfqs->rfq_id) }}" class="">
                                                                    <i class="icon-book" style="color:green"></i>
                                                                </a> --}}
                                                            </td>
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
                                                            <td><a href="{{ route('rfq.details', $rfqs->refrence_no) }}" style="color:blue">
                                                                {{ $rfqs->refrence_no ?? '' }} </a>
                                                            </td>
                                                            <td>{{ $rfqs->rfq_number ?? '' }}</td>
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

                                                            <td>{{ $rfqs->rfq_date ?? '' }}</td>
                                                            <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                            <td>{{ $rfqs->product ?? '' }}</td>


                                                            @php
                                                            $local_delivery = $rfqs->local_delivery;
                                                            $fund_transfer = $rfqs->fund_transfer;
                                                            $cost_of_funds = $rfqs->cost_of_funds;
                                                            $other_cost = $rfqs->other_cost;
                                                            $net_percentage = $rfqs->net_percentage;
                                                            $net_value = $rfqs->net_value;
                                                            $wht= $rfqs->wht;
                                                            $ncd = $rfqs->ncd;
                                                            $freight = $rfqs->freight_charges;
                                                            $tots = $freight + $local_delivery + $fund_transfer + $cost_of_funds + $other_cost + $net_percentage + $net_value + $wht + $ncd + $rfqs->supplier_quote_usd;
                                                            @endphp
                                                            <td>
                                                                @if($rfqs->value_of_quote_ngn < 1)
                                                                    &#8358;{{ number_format($rfqs->supplier_quote_usd + $rfqs->freight_charges)  }}
                                                                @else
                                                                    &#8358;{{ number_format($tots,2) ?? '' }}
                                                                @endif
                                                            </td>
                                                            <td> @php $sup = countShipQuote($rfqs->rfq_id); @endphp
                                                                @if($sup < 1)
                                                                    0
                                                                @else
                                                                    <a href="{{ route('ship.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                                @endif
                                                            </td>
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


                                                                    <a href="{{ route('line.preview', $rfqs->rfq_id) }}" style="color:blue">{{ $co }}</a>
                                                                @else
                                                                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                        <a href="{{ route('line.create', $rfqs->rfq_id) }}" style="color:blue">{{ $co }} </a>
                                                                    @endif
                                                                @endif
                                                            </td>

                                                        </tr><?php $num++; ?>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        @endif


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
