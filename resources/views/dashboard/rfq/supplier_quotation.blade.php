<?php $title = 'Supplier Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.supplier.quote', $rfq->rfq_id)}}">Create Quotation For RFQ</a></li>
                <li class="breadcrumb-item "><a href="{{ route('sup.quote.show', $rfq->rfq_id)}}">View Quotation</a></li>

                <li class="breadcrumb-item">Create Supplier Quote For The RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                @if (Auth::user()->hasRole('Supplier'))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @include('layouts.alert')

                        @if(count($line_items) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> No Line Items was found for the RFQ </p></h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">List of All Line Items</h5>

                                <div class="table-responsive">
                                    <form action="{{ route('rfq.supplier.store') }}" class="" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Item Number</th>
                                                    <th>Product</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <td>Unit Price  </td>
                                                    <td>Weight  </td>
                                                    <td>Dimension  </td>
                                                    <td>Note  </td>

                                                    <th> Action </td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($line_items as $items)

                                                    <tr>
                                                        <td> {{ $num }}</td>

                                                        <td> {{$items->item_number ?? ''}} </td>
                                                        <td> {{$items->item_name ?? 0}} </td>
                                                        <td>
                                                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $num }}">{!! substr($items->item_description, 0, 30) ?? 'N/A' !!} ..</a>

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
                                                        <td> {{$items->quantity ?? 0}} </td>
                                                        <td>
                                                            <input type="number" name="price{{$num}}" class="form-control" style="width:80px">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="weight{{$num}}" class="form-control" style="width:100px">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="dimension{{$num}}" class="form-control" style="width:100px">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="note{{$num}}" class="form-control" style="width:200px">
                                                        </td>

                                                        <td><input type="checkbox" name="topping{{$num}}" value="1"></td>
                                                        <input type="hidden" name="rfq_id{{$num}}" value="{{$items->rfq->rfq_id}}">
                                                        <input type="hidden" name="quantity{{$num}}" value="{{$items->quantity}}">
                                                        <input type="hidden" name="line_id{{$num}}" value="{{$items->line_id}}">
                                                        <input type="hidden" name="refrence_no{{$num}}" value="{{$items->rfq->refrence_no ?? 'Null'}}">
                                                        <input type="hidden" name="blank" value="YES">
                                                        <input type="hidden" name="id" value="{{$items->rfq->rfq_id}}">

                                                    </tr><?php $num++;?>

                                                @endforeach

                                            </tbody>
                                        </table>
                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="center">
                                            <div class="form-group">
                                                <input type="hidden" name="show" value="{{ $num }}" >
                                                <button class="btn btn-primary" type="submit" title="Click the button to Submit Quoatation for the RFQ">
                                                    Submit The Quotation for The RFQ</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        @endif
                    </div>
                @endif


            </div>
        </div>
    </div>

@endsection

