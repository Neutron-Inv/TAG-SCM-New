<?php $title = 'Supplier Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{route("sup.quote.index")}}">View Quotation</a></li>
                <li class="breadcrumb-item">List of Supplier Quote </li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')

                    @if(count($quote) == 0)
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
                                            <th>Quantity</th>

                                            <th>Unit Price  </th>
                                            <th> Total </th>
                                            <th>Delivery Due Date</th>
                                            <th>Weight</th>
                                            <th>Dimension</th>
                                            <th>Note</th>
                                            <th>Overside</th>
                                            {{--  <th> Status </th>  --}}

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $num =1; ?>
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
                                                {{-- <td> {{$items->line->item_description ?? 0}} </td> --}}
                                                <td> {{number_format($items->quantity) ?? 0}} </td>
                                                <td> {{number_format($items->price) ?? 0}} </td>
                                                <td> {{number_format($items->quantity * $items->price) ?? 0}} </td>

                                                <td> {{$items->rfq->shipper_submission_date ?? ''}} </td>
                                                <td> {{ $items->weight ?? '' }} </td>
                                                <td> {{ $items->dimension ?? '' }} </td>
                                                <td> {{ $items->note ?? '' }} </td>
                                                <td> {{ $items->oversize ?? '' }} </td>
                                                {{--  <td> {{ $items->status ?? '' }} </td>  --}}

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

@endsection

