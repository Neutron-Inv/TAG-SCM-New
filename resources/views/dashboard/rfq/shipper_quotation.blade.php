<?php $title = 'Shipper Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.shipper.quote',$rfq->rfq_id) }}">Create Quotation For RFQ</a></li>
                <li class="breadcrumb-item "><a href="{{ route('ship.quote.index') }}">View Quotation</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>
                <li class="breadcrumb-item">Create Shipper Quote For The RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">
                @include('layouts.alert')
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
                                            {{-- <th>Pick Up Location</th> --}}
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
                                                    <a href="" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $num }}">
                                                        {!! substr($items->line->item_description, 0, 70) ?? 'N/A' !!} ..
                                                    </a>
                                                    
                                                    <!--<br>-->
                                                    <!--<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $num }}"></a>-->

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
                                </table><?php
                                $deck = seeDelSupQuote($rfq->rfq_id); ?>
                                <h6 style="color:green">
                                    <p align="center"><b>Oversize : {{ $deck->oversize}}</b></p>
                                </h6>
                                <h6 style="color:green">
                                    <p align="center"><b>Pick Up Location : {{ $deck->location}}</b></p>

                                </h6>


                            </div>

                        </div>
                    @endif
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="card-title">Please fill the below form to submit your Quotation for the rfq  </div>
                            </div>
                            <form action="{{ route('rfq.shipper.store') }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row gutters">
                                    <input type="hidden" name="rfq_id" value="{{ $rfq->rfq_id}}" >
                                    <input type="hidden" name="refrence_no" value="{{ $rfq->refrence_no}}" >
                                    @php $weight = $rfq->total_weight;  @endphp

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Shipping Mode</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                </div>
                                                @php $mode = array('Air', 'Sea', 'Land'); @endphp
                                                <select class="form-control" name="mode" required>
                                                    <option value="{{ old('mode') }}"> {{ old('mode') ?? ' -- Select Mode --' }} </option>
                                                    <option value=""> </option>
                                                    @foreach ($mode as $modes)
                                                        <option value="{{$modes}}"> {{ $modes }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('mode'))
                                                <div class="" style="color:red">{{ $errors->first('mode') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Currency</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                </div>
                                                @php $mode = array('NGN', 'USD', 'EUR'); @endphp
                                                <select class="form-control" name="currency" required>
                                                    <option value="{{ old('currency') }}"> {{ old('currency') ?? ' -- Select Currency --' }} </option>
                                                    <option value=""> </option>
                                                    @foreach ($mode as $modes)
                                                        <option value="{{$modes}}"> {{ $modes }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('currency'))
                                                <div class="" style="color:red">{{ $errors->first('currency') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Freight Charges</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" required class="form-control" name="bmi_charges" value="{{old('bmi_charges')}}" placeholder="Enter Freight Cost">
                                            </div>
                                            @if ($errors->has('bmi_charges'))
                                                <div class="" style="color:red">{{ $errors->first('bmi_charges') }}</div>
                                            @endif


                                        </div>
                                    </div>

                                     <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Soncap Charges</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-calendar" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="number" required class="form-control" name="soncap_charges" value="{{old('soncap_charges')}}" placeholder="Soncap Charges">
                                            </div>
                                            @if ($errors->has('soncap_charges'))
                                                <div class="" style="color:red">{{ $errors->first('soncap_charges') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                     <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Customs Duty</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="number" class="form-control" required name="customs_duty" value="{{old('customs_duty')}}" placeholder="Customs Duty">
                                            </div>
                                            @if ($errors->has('customs_duty'))
                                                <div class="" style="color:red">{{ $errors->first('customs_duty') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                     <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Clearing And Documentation</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="number" class="form-control" required name="clearing_and_documentation" value="{{old('clearing_and_documentation')}}" placeholder="Clearing And Documentation">
                                            </div>
                                            @if ($errors->has('clearing_and_documentation'))
                                                <div class="" style="color:red">{{ $errors->first('clearing_and_documentation') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                     <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Trucking Cost</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="number" class="form-control" required name="trucking_cost" value="{{old('trucking_cost')}}" placeholder="Trucking Cost">
                                            </div>
                                            @if ($errors->has('trucking_cost'))
                                                <div class="" style="color:red">{{ $errors->first('trucking_cost') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create the RFQ">Submit The Quotation </button>
                                        </div>
                                    </div>


                                </div>
                            </form>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

