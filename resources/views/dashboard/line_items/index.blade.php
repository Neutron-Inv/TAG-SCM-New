<?php $title = 'View Line Items' ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">
        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('line.index') }}">Line Items</a></li>
                <li class="breadcrumb-item">List of line item</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    @include('layouts.alert')
                    @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')))
                        @if(count($client) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> No Line Items was found for any of your clients </p></h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">List of All Line Items</h5>

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th> Item Name </th>
                                                <th>Item Number</th>
                                                <th>Description</th>
                                                <th>Supplier</th>
                                                <th>Quantity</th>
                                                <td>Unit Price  </td>
                                                {{--  <th>Total Cost (NGN)</th>  --}}
                                                {{--  <th>Total Cost (NGN)</th>  --}}
                                                <th>Total Price</th>

                                                <th> Action </td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($client as $item)
                                                @foreach (getLine($item->client_id) as $items)
                                                    <tr>
                                                        <td> {{ $num }}

                                                            <a href="{{ route('line.edit',$items->line_id) }}" title="Edit Line Items" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>

                                                            <a href="{{ route('line.details',$items->line_id) }}" title="View Line Item Details" class="" onclick="return(confirmToDetails());">
                                                                <i class="icon-list" style="color:green"></i>
                                                            </a>
                                                        </td>

                                                        <td> {{$items->item_name ?? ''}} </td>
                                                        <td> {{$items->item_number ?? ''}} </td>
                                                        <td> {{$items->item_description ?? 0}} </td>
                                                        @foreach(getVen($items->vendor_id) as $ven)
                                                            <td> {{$ven->vendor_name ?? 'Null'}} </td>
                                                        @endforeach
                                                        <td> {{$items->quantity ?? 0}} </td>

                                                        <td> {{$items->unit_price ?? 0}} </td>
                                                        {{--  <td> {{$items->total_cost ?? ''}} </td>  --}}
                                                        {{--  <td> {{$items->total_cost_naira ?? ''}} </td>  --}}
                                                        <td> {{number_format($items->quantity * $items->unit_price) ?? ''}} </td>
                                                        @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                            <td>
                                                                <a href="{{ route('line.duplicate',$items->line_id) }}" title="Duplicate Line Items" class="" onclick="return(duplicate());">
                                                                    Duplicate
                                                                </a>
                                                            </td>
                                                        @endif

                                                    </tr><?php $num++; ?>
                                                @endforeach
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endif
                    @else
                        @if(count($line_items) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">List of All Line Items</h5>

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead>
                                            <tr>
                                                <th>S/N</th><th>Item Name</th>
                                                <th>Item Number</th>
                                                <th>Description</th>
                                                <th>Supplier</th>
                                                <th>Quantity</th>
                                                <td>Unit Price  </td>
                                                {{--  <th>Total Cost (NGN)</th>  --}}
                                                {{--  <th>Total Cost (USD)</th>  --}}
                                                <th>Total Price</th>

                                                <th> Action </td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($line_items as $items)
                                                <tr>
                                                    <td> {{ $num }}
                                                        <a href="{{ route('line.edit',$items->line_id) }}" title="Edit Line Items" class="" onclick="return(confirmToEdit());">
                                                            <i class="icon-edit" style="color:blue"></i>
                                                        </a>

                                                        <a href="{{ route('line.details',$items->line_id) }}" title="View Line Item Details" class="" onclick="return(confirmToDetails());">
                                                            <i class="icon-list" style="color:green"></i>
                                                        </a>
                                                    </td>

                                                    <td> {{$items->item_number ?? ''}} </td><td> {{$items->item_name ?? ''}} </td>
                                                    <td> {{$items->item_description ?? 0}} </td>
                                                    <td> {{$items->vendor->vendor_name ?? 'Null'}} </td>
                                                    <td> {{$items->quantity ?? 0}} </td>

                                                    <td> {{$items->unit_price ?? 0}} </td>
                                                    {{--  <td> {{$items->total_cost ?? ''}} </td>  --}}
                                                    {{--  <td> {{$items->total_cost_naira ?? ''}} </td>  --}}
                                                    <td> {{number_format($items->quantity * $items->unit_price) ?? ''}} </td>
                                                    <td>
                                                        <a href="{{ route('line.duplicate',$items->line_id) }}" title="Duplicate Line Items" class="" onclick="return(duplicate());">
                                                            Duplicate
                                                        </a>
                                                    </td>

                                                </tr><?php $num++; ?>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
