<?php $title = 'Supplier Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                @if (Auth::user()->hasRole('Supplier'))
                    <li class="breadcrumb-item active"><a href="{{ route('sup.quote.edit', $quote->supplier_quote_id)}}">Edit Quotation For RFQ</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ route('rfq.supplier.quote', $rfq->rfq_id)}}">Create Quotation For RFQ</a></li>
                <li class="breadcrumb-item">Edit Supplier Quote For The RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                @if (Auth::user()->hasRole('Supplier'))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="card-title">Please fill the below form to update the supplier quote </div>
                                </div>
                                @include('layouts.alert')

                                <form action="{{ route('sup.quote.update',$quote->supplier_quote_id) }}" class="" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="row gutters">
                                        @foreach ($line_items as $items)


                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Item Number</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="first_name" id="inputName" value="{{$items->item_number ?? ''}}" readonly placeholder="Enter First Name" type="text"
                                                    aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Product name</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="item_name" id="inputName" value="{{$items->item_name ?? 'N/A'}}" readonly placeholder="Enter First Name" type="text"
                                                    aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Description</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea class="form-control" name="item_description" id="inputName" 
							 readonly placeholder="" type="text"
                                                    aria-describedby="basic-addon1">{!! $items->item_description ?? 'N/A' !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Quantity</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="quantity" id="inputName" value="{{$items->quantity ?? 0}}" readonly placeholder="Enter First Name" type="text"
                                                    aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Unit Price</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="price" id="inputName" value="{{$quote->price ?? 0}}" required placeholder="Enter First Name" type="text"
                                                    aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Weight</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="weight" id="inputName" value="{{$quote->weight ?? "N/A"}}" required placeholder="Enter Weight" type="text"
                                                    aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Dimension</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="dimension" id="inputName" value="{{$quote->dimension ?? "N/A"}}" required placeholder="Enter Dimension" type="text"
                                                    aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Oversize Cargo</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control" name="oversize" required>
                                                        <option value="{{$quote->oversize ?? "N/A"}}">{{$quote->oversize ?? "N/A"}} </option>
                                                        <option value=""> </option>
                                                        <option value="No">No </option>
                                                        <option value="Yes">Yes </option>
                                                    </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Pick up Location</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-map" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea class="form-control" name="location" id="inputName" required placeholder="Enter Address"
                                                    aria-describedby="basic-addon1">{{$quote->location ?? $shipper->address}} </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="inputName">Quotation Note</label><div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea class="form-control" name="note" id="inputName" required placeholder="Enter Quotation Note" type="text"
                                                    aria-describedby="basic-addon1">{{$quote->note ?? 'N/A'}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="rfq_id" value="{{$items->rfq->rfq_id}}">

                                            <input type="hidden" name="line_id" value="{{$items->line_id}}">
                                            <input type="hidden" name="supplier_quote_id" value="{{$items->supplier_quote_id}}">
                                            <input type="hidden" name="refrence_no" value="{{$items->rfq->refrence_no ?? 'N/A'}}">
                                        @endforeach
                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                            <div class="form-group">

                                                <button class="btn btn-primary " type="submit" title="Click the button to Submit Quoatation for the RFQ">
                                                    Update The Quotation for The RFQ</button>
                                            </div>
                                        </div>
                                    </
                                </form>
                            </div>

                        </div>

                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @include('layouts.alert')

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
                                        <thead class="bg-warning text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Item Number</th>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th>Quantity</th>

                                                <th>Unit Price  </th>
                                                <th> Total </th>
                                                {{--  <th>Client</th>  --}}
                                                <th>Delivery Due Date</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $num =1; $lol =array(); ?>
                                            @foreach ($sup as $item)
                                                <tr>
                                                    <td> {{ $num }}

                                                        <a href="{{ route('sup.quote.edit',$item->supplier_quote_id) }}" title="Edit Quotation Details" class="" onclick="return(confirmToEdit());">
                                                            <i class="icon-edit" style="color:blue"></i>
                                                        </a>
                                                    </td>

                                                    <td> {{$item->rfq->rfq_number ?? ''}} </td>
                                                    <td> {{$item->line->item_name ?? ''}} </td>
                                                    <td>
                                                        {!! substr($items->item_description, 0, 30) ?? 'N/A' !!} ..
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
                                                    <td> {{ $s = number_format($item->quantity) ?? 0}} </td>
                                                    <td> {{ $t =number_format($item->price) ?? 0}} </td>
                                                    <td> {{number_format($item->quantity * $item->price) ?? 0}} </td>
                                                    {{--  <td> {{$item->rfq->client->client_name ?? ''}} </td>  --}}
                                                    <td> {{$item->rfq->delivery_due_date ?? ''}} </td>

                                                </tr><?php $num++;
                                                $tot = $item->quantity * $item->price;
                                                array_push($lol, $tot);?>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <h3 style="color:green"><p align="center"><b>Supplier Quote :
                                        <?php $to = (array_sum($lol)+0);
                                        echo number_format($to, 2);
                                        ?></b></p>
                                    </h3>

                                </div>

                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection

