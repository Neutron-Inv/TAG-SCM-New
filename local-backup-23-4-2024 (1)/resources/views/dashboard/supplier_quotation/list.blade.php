<?php $title = 'Shipper Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                {{--  <li class="breadcrumb-item"><a href="{{ route('ship.quote.index') }}">View Quotation for RFQ</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.index') }}">View RFQ</a></li>  --}}

                <li class="breadcrumb-item">List of Shipper Quote </li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">

            @include('layouts.alert')

            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    @if(count($sup) == 0)
                        <div class="card">
                            <div class="card-body">
                                <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            <h5 class="table-title">List of All Supplier Quotes</h5>

                            <div class="table-responsive">

                                <table id="fixedHeader" class="table">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Item Number</th>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Delivery Due Date</th>
                                            <th>Weight</th>
                                            <th>Dimension</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $num =1; ?>
                                        @foreach ($sup as $items)
                                            <tr>
                                                <td> {{ $num }}</td>
                                                <td> {{$items->rfq->rfq_number ?? ''}} </td>
                                                <td> {{$items->line->item_name ?? ''}} </td>
                                                <td>
                                                    {!! substr($items->line->item_description, 0, 70) ?? 'N/A' !!} ..
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
                                                <td> {{$items->rfq->shipper_submission_date ?? ''}} </td>
                                                <td> {{ $items->weight ?? '' }} </td>
                                                <td> {{ $items->dimension ?? '' }} </td>

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
                            <h5 class="table-title">List of Shipper Quote for RFQs </h5>

                            <div class="table-responsive">
                                <table id="fixedHeader" class="table">
                                    <thead>
                                        <tr>
                                            <th> S/N </th>
                                            <th>Ref Nos</th>
                                            {{--  <th>Rfq No</th>  --}}
                                            <th>Delivery Date</th>
                                            <th>Product</th>
                                            <th>Weight</th>
                                            <th>Soncap Charges</th>
                                            <th>Customs Duty</th>
                                            <th>Clearing and Doc</th>
                                            <th>Trucking Cost</th>
                                            <th>BMI Charges</th>
                                            <th>Mode</th>
                                            <th> Currency </th>
                                            {{--  <th>Status</th>  --}}
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
                                                {{--  <td>{{ $quotes->rfq->rfq_number ?? '' }}</td>  --}}
                                                <td>{{ $quotes->rfq->rfq_date ?? '' }}</td>
                                                <td>{{ $quotes->rfq->product ?? '' }}</td>
                                                <td>{{ $quotes->rfq->total_weight ?? ''}}</td>
                                                <td> {{ $quotes->soncap_charges ?? '' }} </td>
                                                <td> {{ $quotes->customs_duty ?? '' }} </td>
                                                <td> {{ $quotes->clearing_and_documentation  ?? ''}} </td>

                                                <td> {{ $quotes->trucking_cost ?? '' }} </td>
                                                <td> {{ $quotes->bmi_charges ?? '' }} </td>
                                                <td> {{ $quotes->mode ?? '' }} </td>
                                                <td> {{ $quotes->currency ?? '' }} </td>
                                                {{--  <td>{{ $quotes->status ?? '' }}</td>  --}}
                                            </tr><?php $num++;
                                            $tot = $quotes->soncap_charges + $quotes->customs_duty +  $quotes->clearing_and_documentation +  $quotes->trucking_cost
                                                + $quotes->bmi_charges;
                                                array_push($wej, $tot);
                                                        ?>
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
            </div>

        </div>
    </div>

@endsection

