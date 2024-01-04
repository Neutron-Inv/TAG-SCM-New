<?php $title = 'Edit Shipper Quotation RFQ'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                @if (Auth::user()->hasRole('Shipper'))
                    <li class="breadcrumb-item active"><a href="{{ route('ship.quote.edit',$quo->quote_id) }}">Edit Quotation RFQ</a></li>
                @endif
                <li class="breadcrumb-item "><a href="{{ route('ship.quote.show', $rfq->rfq_id) }}">View Quotation</a></li>
                {{--  <a class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></a>  --}}

                <li class="breadcrumb-item">Edit Shipper Quote For The RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <div class="content-wrapper">
            <div class="row gutters">@include('layouts.alert')

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="card-title">Please fill the below form to update your Quotation for the rfq  </div>
                            </div>
                            <form action="{{ route('ship.quote.update',$quo->quote_id) }}" class="" method="POST" enctype="multipart/form-data">
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
                                                    <option value="{{ $quo->mode }}">{{ $quo->mode }} </option>
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
                                                    <option value="{{ $quo->currency  }}"> {{ $quo->currency ?? old('mode') }} </option>
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
                                            <label for="lastName">BMI Freight Cost</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-plus" style="color:#28a745"></i></span>
                                                </div>

                                                <input type="text" class="form-control" name="bmi_charges" value="{{$quo->bmi_charges ?? old('bmi_charges')}}" placeholder="BMI Seafreight Cost">
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

                                                <input type="text" class="form-control" name="soncap_charges" value="{{$quo->soncap_charges ?? old('soncap_charges')}}" placeholder="Soncap Charges">
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

                                                <input type="text" class="form-control" name="customs_duty" value="{{ $quo->customs_duty ?? old('customs_duty')}}" placeholder="Customs Duty">
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

                                                <input type="text" class="form-control" name="clearing_and_documentation" value="{{$quo->clearing_and_documentation ?? old('clearing_and_documentation')}}" placeholder="Clearing And Documentation">
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

                                                <input type="text" class="form-control" name="trucking_cost" value="{{$quo->trucking_cost ?? old('trucking_cost')}}" placeholder="Trucking Cost">
                                            </div>
                                            @if ($errors->has('trucking_cost'))
                                                <div class="" style="color:red">{{ $errors->first('trucking_cost') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create the RFQ">Update The Quotation </button>
                                        </div>
                                    </div>


                                </div>
                            </form>

                        </div>
                    </div>
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
                                    <thead class="bg-danger text-white">
                                        <tr>
                                            <th>S/N</th>
                                            <th>Item Name</th>
                                            <th>Item Number</th>
                                            <th>Description</th>

                                            <th>UOM</th>
                                            <th>Quantity</th>
                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR
                                                (Auth::user()->hasRole('HOD'))))
                                                <th>Supplier</th>
                                                <th>Unit Cost</th>
                                                <th>Total Cost</th>
                                                <th>Unit Margin </th>
                                                <th>Total Margin</th>
                                                <th>Unit Quote </th>
                                                <th>Total Quote</th>
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
                                                        <a href="{{ route('line.details',$items->line_id) }}" title="View Line Item Details" class="" onclick="return(confirmToDetails());">
                                                            <i class="icon-list" style="color:green"></i>
                                                        </a>
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
                                                    <td> {{$items->vendor->vendor_name ?? ''}} </td>
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
                                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR
                                                (Auth::user()->hasRole('HOD'))))
                                    <h3 style="color:green"><p align="center"><b>Shipper Quote :
                                    <?php $to = (array_sum($wex)+0);
                                        echo number_format($to, 2);
                                        ?></b></p></h3>
                                @endif
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
                                    <thead class="bg-warning text-white">
                                        <tr>
                                            <th> S/N </th>
                                            <th>Ref Nos</th>
                                            <th>Rfq No</th>
                                            <th>Rfq Date</th>
                                            <th>Product</th>
                                            <th>Weight</th>
                                            <th>Soncap Charges</th>
                                            <th>Customs Duty</th>
                                            <th>Clearing and Doc</th>
                                            <th>Trucking Cost</th>
                                            <th>BMI Charges</th>
                                            <th> Mode </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num =1; $wej = array(); ?>
                                        @foreach ($quote as $quotes)
                                            <tr>

                                                <td> {{ $num }}

                                                    @if (Auth::user()->hasRole('Shipper'))
                                                        <a href="{{ route('ship.quote.edit',$quotes->quote_id) }}" type="Edit Shipping Quote" class="" onclick="return(confirmToEdit());">
                                                            <i class="icon-edit" style="color:blue"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td> {{ $quotes->rfq->refrence_no ?? '' }}</td>
                                                <td> {{ $quotes->rfq->rfq_number ?? '' }}</td>
                                                <td> {{ $quotes->rfq->rfq_date ?? '' }}</td>
                                                <td> {{ $quotes->rfq->product ?? '' }}</td>
                                                <td> {{ $quotes->rfq->total_weight ?? ''}}</td>
                                                <td> {{ $quotes->soncap_charges ?? '' }} </td>
                                                <td> {{ $quotes->customs_duty ?? '' }} </td>
                                                <td> {{ $quotes->clearing_and_documentation  ?? ''}} </td>
                                                <td> {{ $quotes->trucking_cost ?? '' }} </td>
                                                <td> {{ $quotes->bmi_charges ?? '' }} </td>
                                                <td> {{ $quotes->mode ?? '' }} </td>
                                                {{--  <td> {{ $quotes->status ?? '' }}</td>
                                                <td>
                                                    @if ((Auth::user()->hasRole('Employer')) OR (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR  (Auth::user()->hasRole('HOD'))))
                                                        @if($quotes->status == 'Picked')
                                                            <a href="{{ route('ship.quote.unchose',$quotes->quote_id) }}" class="" onclick="return(pickUnShipper());">
                                                                <i class="icon-circle-with-cross" style="color:red">UnPick</i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('ship.quote.chose',$quotes->quote_id) }}" class="" onclick="return(pickShipper());">
                                                                <i class="icon-check" style="color:green">Pick</i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>  --}}
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

