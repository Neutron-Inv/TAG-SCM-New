<?php $title = 'Supplier Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{route("sup.quote.show",$rfq->rfq_id)}}">View Quotation</a></li>
                <li class="breadcrumb-item">List of Supplier Quote </li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
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

                            <div class="table-responsive" >
                                <table class="table m-0" >
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

                                            <th>Sumission Due Date</th>
                                            <th>Product</th>

                                            <th> Supplier Quote </th>
                                            @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))
                                                OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())
                                                ))
                                                <th> Shipper Quote </th>
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


                                                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))
                                                OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())
                                                ))
                                                    <td><a href="{{ route('rfq.details', $rfqs->refrence_no) }}" style="color:blue">
                                                        {{ $rfqs->refrence_no ?? '' }} </a>
                                                    </td>
                                                @else
                                                    <td>
                                                        {{ $rfqs->refrence_no ?? '' }}
                                                    </td>
                                                @endif
                                                {{--  <td>{{ $rfqs->rfq_number ?? '' }}</td>  --}}

                                                <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                <td>{{ $rfqs->product ?? '' }}</td>

                                                <td> @php $sup = countSupQuote($rfqs->rfq_id); @endphp
                                                    @if($sup < 1)
                                                        0
                                                    @else
                                                        <a href="{{ route('sup.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                    @endif
                                                </td>

                                                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))
                                                        OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())
                                                        ))
                                                    <td> @php $sup = countShipQuote($rfqs->rfq_id); @endphp
                                                        @if($sup < 1)
                                                            0
                                                        @else
                                                            <a href="{{ route('ship.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
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


                    @if(count($quote) == 0)
                        <div class="card">
                            <div class="card-body">
                                <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            {{--  <h5 class="table-title">List of All Supplier Quotes</h5>  --}}

                            <div class="table-responsive">

                                <table id="fixedHeader" class="table">
                                    <thead class="bg-warning text-white ">
                                        <tr>
                                            <th>S/N</th>
                                            <th>Item Number</th>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Quantity</th>

                                            <th>Unit Price
                                                @php $sumUnitCost = sumUnitCost($rfq->rfq_id); @endphp
                                                @if($sumUnitCost > 0 )
                                                    {{ number_format($sumUnitCost, 2) ?? 0}}
                                                @else
                                                    0
                                                @endif
                                            </th>
                                            <th> Total
                                                @php $hope=array(); @endphp
                                                @foreach ($quote as $its)<?php
                                                    $glow = $its->quantity * $its->price;
                                                    array_push($hope, $glow); ?>
                                                @endforeach
                                                <?php
                                                if($hope > 0){

                                                    $rol = array_sum($hope)+0;
                                                    echo number_format($rol, 2);
                                                }else{
                                                    echo 0;
                                                } ?>


                                            </th>
                                            @if ((Auth::user()->hasRole('Employer')) OR (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD'))))
                                                <th>Client</th>
                                            @endif
                                            <th>Delivery Due Date</th>

                                            <th>Note</th>


                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $num =1; $wej = array(); ?>
                                        @foreach ($quote as $items)
                                            <tr>
                                                <td> {{ $num }}

                                                    @if (Auth::user()->hasRole('Supplier'))
                                                        <a href="{{ route('sup.quote.edit',$items->supplier_quote_id) }}" title="Edit Quotation Details" class="" onclick="return(confirmToEdit());">
                                                            <i class="icon-edit" style="color:blue"></i>
                                                        </a>
                                                    @endif
                                                </td>

                                                <td> {{$items->rfq->rfq_number ?? ''}} </td>
                                                <td> {{$items->line->item_name ?? ''}} </td>
                                                <td>
                                                    {!! substr($items->line->item_description, 0, 30) ?? 'N/A' !!} ..
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
                                                                    {!! $items->line->item_description ?? 'N/A' !!}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td> {{number_format($items->line->quantity) ?? 0}} </td>
                                                <td> {{number_format($items->price) ?? 0}} </td>
                                                <td> {{number_format($items->quantity * $items->price) ?? 0}} </td>
                                                @if ((Auth::user()->hasRole('Employer')) OR (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD'))))
                                                    <td> {{$items->rfq->client->client_name ?? ''}} </td>
                                                @endif
                                                <td> {{$items->rfq->delivery_due_date ?? ''}} </td>

                                                <td> {{ $items->note ?? '' }} </td>

                                                @php $tot = $items->quantity * $items->price;
                                                array_push($wej, $tot);  @endphp

                                            </tr><?php $num++; ?>
                                        @endforeach

                                    </tbody>
                                </table><?php
                                $deck = getDelSupQuote($items->rfq_id, $items->vendor_id); ?>
                                {{-- <h6 style="color:green">
                                    <p align="center"><b>Oversize :{{ $deck->oversize }}</b></p>
                                </h6> --}}
                                <h6 style="color:green">
                                    <p align="center"><b>Pick Up Location : {{ $deck->location }}</b></p>

                                </h6>
                            </div>

                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>

@endsection

