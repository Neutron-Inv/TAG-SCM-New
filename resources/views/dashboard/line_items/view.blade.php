<?php $title = 'Preview Line Items' ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">
        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('line.preview', $rfqs->rfq_id) }}">View Line Items</a></li>
                <li class="breadcrumb-item "><a href="{{ route('rfq.price', $rfqs->refrence_no) }}"> Price Quotation</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.edit', $rfqs->refrence_no) }}">Edit RFQ </a></li>
                <li class="breadcrumb-item"><a href="{{ route('line.create', $rfqs->rfq_id) }}">Create New Line Item</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>
                <li class="breadcrumb-item">List of line item</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                </div>

                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR
                    (Auth::user()->hasRole('HOD'))))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        @if(count($rfq) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> No RFQ was found for

                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                All Clients
                                            @else
                                                {{ $company->company_name ?? ' Your' }} company
                                            @endif
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
                                                <th>Status</th>
                                                <th>Client</th>
                                                <th>Ref Nos</th>
                                                <th>Rfq No</th>
                                                <th>Assigned To</th>
                                                <th>Buyer</th>
                                                <th>Submission Due Date</th>
                                                <th>Product</th>
                                                <th>Total Quote </th>
                                                <th> Shipper Quote </th>
                                                <th> Supplier Quote </th>
                                                <th>Line Item</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($rfq as $rfqs)
                                                <tr>

                                                    <td>
                                                        <a href="{{ route('rfq.price',$rfqs->refrence_no) }}" title="View RFQ Price Quotation" class="" onclick="">
                                                            <i class="icon-book" style="color:green"></i>
                                                        </a>

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
                                                    <td><a href="{{ route('rfq.edit', $rfqs->refrence_no) }}" style="color:blue">
                                                        {{ $rfqs->refrence_no ?? '' }} </a>
                                                    </td>
                                                    <td>{{ $rfqs->rfq_number ?? '' }}</td>
                                                    @if (Gate::allows('SuperAdmin', auth()->user()))
                                                        <td>
                                                            @foreach (employ($rfqs->employee_id) as $item)
                                                                <a href="mailto:{{ $item->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? ' Null'   }}</a>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach (buyers($rfqs->contact_id) as $items)
                                                                <a href="mailto:{{ $items->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'Null' }}</a>
                                                            @endforeach
                                                        </td>
                                                    @else
                                                        <td>
                                                            @foreach (employ($rfqs->employee_id) as $item)
                                                                <a href="mailto:{{ $item->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? 'Null'   }}</a>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach (buyers($rfqs->contact_id) as $items)
                                                                <a href="mailto:{{ $items->email}}?subject='Re: Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'Null' }}</a>
                                                            @endforeach
                                                        </td>
                                                    @endif
                                                    <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                    <td>{{ $rfqs->product ?? '' }}</td>
                                                    <td>
                                                        @if($rfqs->value_of_quote_ngn < 2)
                                                            &#36;{{ ($rfqs->supplier_quote_usd + $rfqs->freight_charges)  }}
                                                        @else
                                                            &#36;{{ number_format($rfqs->value_of_quote_ngn,2) ?? '' }}
                                                        @endif
                                                        
                                                    </td>
                                                    <td style="text-align: right"> @php $sup = countShipQuote($rfqs->rfq_id); @endphp
                                                            @if($sup < 1)
                                                                0
                                                            @else
                                                                <a href="{{ route('ship.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                            @endif
                                                    </td>
                                                    <td style="text-align: right"> @php $sup = countSupQuote($rfqs->rfq_id); @endphp
                                                        @if($sup < 1)
                                                            0
                                                        @else
                                                            <a href="{{ route('sup.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: right">
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
                @elseif(Auth::user()->hasRole('Shipper'))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @if(count($rfq) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> No RFQ was found for

                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                All Clients
                                            @else
                                                {{ $company->company_name ?? ' Your' }} company
                                            @endif
                                        </p>
                                    </h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">List of Client RFQs for
                                    @if (Gate::allows('SuperAdmin', auth()->user()))
                                        All Clients
                                    @else
                                        {{ $company->company_name ?? ' Your' }} company
                                    @endif
                                </h5>

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-danger text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Status</th>
                                                <th>Product</th>
                                                <th>Weight</th>
                                                <th>Ref Nos</th>
                                                <th>Delivery Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($rfq as $rfqs)
                                                <tr>
                                                    <td>{{ $num }}</td>
                                                    <td>
                                                        Status

                                                    </td>
                                                    <td>{{ $rfqs->product ?? '' }}</td>
                                                    <td>{{ $rfqs->total_weight ?? '' }}</td>
                                                    <td>
                                                        {{ $rfqs->refrence_no ?? '' }}
                                                    </td>

                                                    <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                    <td>
                                                        <a href="{{ route('rfq.shipper.quote',$rfqs->rfq_id) }}" class="" onclick="return(confirmToDetails());">
                                                            <i class="icon-list" style="color:green"></i>Quote
                                                        </a>
                                                    </td>
                                                </tr><?php $num++; ?>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endif

                    </div>
                @elseif(Auth::user()->hasRole('Supplier'))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        @if(count($rfq) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4><p style="color:red" align="center"> No RFQ was found
                                        </p>
                                    </h4>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">List of RFQs for
                                    {{ $vendor->vendor_name ?? ' ' }}
                                </h5>

                                <div class="table-responsive">
                                    <table id="fixedHeader" class="table">
                                        <thead class="bg-danger text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Status</th>
                                                <th>Product</th>
                                                <th>Weight</th>
                                                <th>Ref Nos</th>
                                                <th>Delivery Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($rfq as $rfqs)
                                                <tr>
                                                    <td>{{ $num }}</td>
                                                    <td>
                                                        Status
                                                    </td>
                                                    <td>{{ $rfqs->product ?? '' }}</td>
                                                    <td>{{ $rfqs->total_weight ?? '' }}</td>
                                                    <td>
                                                        {{ $rfqs->refrence_no ?? '' }}
                                                    </td>
                                                    <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                    <td>
                                                        <a href="{{ route('rfq.supplier.quote', $rfqs->rfq_id)}}" class="" onclick="return(confirmToDetails());">
                                                            Submit Quote
                                                        </a>
                                                    </td>
                                                </tr><?php $num++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    </div>
                @endif
    
                

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @if(count($line_items) == 0)
                        <div class="card">
                            <div class="card-body">
                                <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            {{--  <h5 class="table-title">List of All Line Items</h5>  --}}

                            <div class="table-responsive">
                                <table id="basicExample" class="table">
                                    <thead>
                                        <tr>
                                            <th hidden>S/N</th>
                                            <th>Item S/N</th>
                                            <th>Item Description</th>
                                            <th>Item Nos</th>
                                            <th>Item Specification</th>
                                            <th>Supplier</th>
                                            <th>Qty</th>
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
                                            </th>
                                            <th>Unit Quote </th>
                                            <th>Total Quote
                                                @php $sumTotalQuote = sumTotalQuote($rfqs->rfq_id); @endphp
                                                @if($sumTotalQuote > 0 )
                                                    {{ number_format($sumTotalQuote, 2) ?? 0 }}
                                                @else
                                                    0
                                                @endif
                                            </th>
                                            <th>Mesc Code</th>
                                            <th> Action </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num =1; $wej = array(); ?>
                                        @foreach ($line_items as $items)
                                            <tr>
                                                <td hidden> {{ $num ?? '0' }}
                                                </td>
                                                <td style=""> {{ $items->item_serialno ?? '0' }}
                                                    @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                        <a href="{{ route('line.edit',$items->line_id) }}" title="Edit Line Items" class="" onclick="return(confirmToEdit());">
                                                            <i class="icon-edit" style="color:blue"></i>
                                                        </a>
                                                        <a href="{{ route('line.delete',$items->line_id) }}" title="Edit Line Items" class="" onclick="return(confirmToDelete());">
                                                            <i class="icon-trash" style="color:red"></i>
                                                        </a>
                                                    @endif

                                                </td>

                                                <td> {{$items->item_name ?? 'N/A'}} </td>
                                                <td> {{$items->item_number ?? 'N/A'}} </td>
                                                <td>
                                                    <a href="" data-toggle="modal" data-target=".bd-example-modal-lx-{{ $num }}">
                                                    {!! substr(strip_tags($items->item_description), 0, 100) ?? 'N/A' !!}...
                                                    </a>

                                                    
                                                </td>
                                                <td> {{$rfqs->vendor->vendor_name ?? 'N/A'}} </td>
                                                <td style="text-align: right"> {{$items->quantity ?? 0}} </td>
                                                @php
                                                    $unit_cost = $items->unit_cost;
                                                    $percent = $rfqs->percent_margin;
                                                    $unitMargin = ($percent * $items->unit_cost);
                                                @endphp
                                                <td style="text-align: right"> {{number_format($items->unit_cost,2) ?? 0}} </td>
                                                <td style="text-align: right"> {{number_format($items->total_cost ,2) ?? 0}} </td>

                                                <td style="text-align: right"> {{number_format($items->unit_margin, 2) ?? 0}} </td>

                                                <td style="text-align: right"> {{number_format($items->total_margin, 2) ?? 0}} </td>
                                                <td style="text-align: right"> {{number_format($items->unit_quote, 2) ?? 0}} </td>
                                                <td style="text-align: right"> {{number_format($items->total_quote, 2) ?? 0}} </td>
                                                <td style="text-align: right"> {{$items->mesc_code ?? 'N/A' }} </td>
                                                <td>
                                                                    <a href="#" title="Duplicate Line Items" class="duplicate-link" data-line-id="{{ $items->line_id }}" data-toggle="modal" data-target="#duplicateModal">
                                                                        Duplicate
                                                                    </a>
                                                                </td>
                                                                <div class="modal fade" id="duplicateModal" tabindex="-1" role="dialog" aria-labelledby="duplicateModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="duplicateModalLabel">Duplicate Line Item</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p>How many times do you want to duplicate this line item?</p>
                                                                                <input type="number" id="duplicateCount" class="form-control" value="1">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                                <button type="button" class="btn btn-primary" id="confirmDuplicate">Duplicate</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $(".duplicate-link").on("click", function () {
                                                                            // Get the line ID and set it in the modal's data attribute
                                                                            var lineId = $(this).data("line-id");
                                                                            $("#duplicateModal").data("line-id", lineId);
                                                                        });

                                                                        $("#confirmDuplicate").on("click", function () {
                                                                            // Get the line ID and duplication count from modal data
                                                                            var lineId = $("#duplicateModal").data("line-id");
                                                                            var duplicateCount = $("#duplicateCount").val();

                                                                            // Construct the URL with the line ID and duplication count
                                                                            var url = "{{ route('line.duplicate', ':lineId') }}";
                                                                            url = url.replace(':lineId', lineId) + '?count=' + duplicateCount;

                                                                            // Redirect to the duplicated URL
                                                                            window.location.href = url;

                                                                            // Close the modal
                                                                            $("#duplicateModal").modal("hide");
                                                                        });
                                                                    });
                                                                </script>@php $tot = $items->total_quote;
                                                array_push($wej, $tot);  @endphp
                                                <div class="modal fade bd-example-modal-lx-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lx-{{ $num }}">
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
                                            </tr><?php $num++; ?>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                <div class="form-group">
                                        <button type="button" class="btn btn-primary" style="float: left; margin-bottom:1%;" data-toggle="modal" data-target="#UploadLineItems">Upload LineItems</button>                             
                                </div>
                                @if(count($line_items) > 0)
                                <div class="form-group">
                                        <button type="button" class="btn btn-primary" style="float: left; margin-bottom:1%; margin:0 10px;" data-toggle="modal" data-target="#UpdateLineItems">Update LineItems Cost</button>                             
                                </div>
                                @endif
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                @if(count(getPricingHistory($rfqs->rfq_id ))>0)
                                <div class="form-group">
                                    <a class="btn btn-primary" style="float: right; margin-bottom:1%; margin:0 10px;" href="{{route('pricing.index', $rfqs->rfq_id)}}">View Pricing History</a>                             
                                </div>
                                @endif
                                @if(hasPo($rfqs->rfq_id ))
                                <div class="form-group">
                                        <button type="button" class="btn btn-primary" style="float: right; margin-bottom:1%;" data-toggle="modal" data-target="#IssuePo">Issue PO To Supplier</button>                             
                                </div>
                                @else
                                <div class="form-group">
                                        <button type="button" class="btn btn-primary" style="float: right; margin-bottom:1%;" data-toggle="modal" data-target="#supplierRfq">Send RFQ To Supplier</button>                             
                                </div>
                                @endif
                            </div>
                        </div>
                    @endif
                        
                </div>
            </div>
        </div>
    </div>
    
    
@php
$selected_supplier = $rfq[0]->vendor->vendor_name;
$recommended_suppliers = getRecommendedSuppliers($rfqs->product ?? '');
$other_suppliers = getOtherSuppliers();
@endphp
    
    <!-- Modal for RFQ to supplier -->
        <div class="modal fade bd-example-modal-lg" id="supplierRfq" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Request Quote from Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('rfq.toVendor')}}" class="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="row gutters">
                        <div class="col-md-4 col-sm-4 col-4">
                            <label for="recipient-name" class="col-form-label">Supplier:</label>
                            <select class="form-control selectpicker" data-live-search="true" required name="vendor_id" onchange="fetchContacts(this.value)">
                                <optgroup label="Chosen Supplier">
                                    <option value="{{$rfq[0]->vendor_id}}">{{$selected_supplier}} </option>
                                </optgroup>
                                @if(count($recommended_suppliers) > 0)
                                <optgroup label="Recommended Suppliers">
                                    @foreach($recommended_suppliers as $recommended_supplier)
                                    <option value="{{$recommended_supplier->vendor_id}}"> {{$recommended_supplier->vendor_name}}</option>
                                    @endforeach
                                </optgroup>
                                @endif
                                <optgroup label="Other Suppliers">
                                    @foreach($other_suppliers as $other_supplier)
                                    <option value="{{$other_supplier->vendor_id}}"> {{$other_supplier->vendor_name}}</option>
                                    @endforeach
                                </optgroup>
                                <option value="">-- Select Supplier --</option>
                            </select>
                            @if ($errors->has('rec_email'))
                                <div class="" style="color:red">{{ $errors->first('rec_email') }}</div>
                            @endif
                        </div>
                        
                        <div class="col-md-8 col-sm-8 col-8">
                            <label for="recipient-name" class="col-form-label">CC Email:</label>
                            <input type="text" class="form-control" id="recipient-email" name="report_recipient" value="sales@tagenergygroup.net; mary.nwaogwugwu@tagenergygroup.net">
                            @if ($errors->has('report_recipient'))
                                <div class="" style="color:red">{{ $errors->first('quotation_recipient') }}</div>
                            @endif
                        </div>
                        
                        <div class="col-md-5 col-sm-5 col-5">
                            <label for="recipient-name" class="col-form-label">Contact:</label>
                            <select id="contact" class="form-control selectpicker" data-live-search="true" required name="contact_id">
                                <option value="">-- Select Contact --</option>
                            </select>
                        </div>
                        
                        <div class="col-md-7 col-sm-7 col-7">
                            <label for="recipient-name" class="col-form-label">Line Items:</label>
                            <input type="text" class="form-control" id="line_items" name="line_items" data-role="tagsinput" value="" placeholder="Enter a value such as 1-3, 5-7 signifying their serial number">
                            @if ($errors->has('line_items'))
                                <div class="" style="color:red">{{ $errors->first('line_items') }}</div>
                            @endif
                        </div>
                        <input type="text" value="{{ $rfq[0]->rfq_id }}" name="rfq_id" hidden>
                        <div class="col-md-7 col-sm-7 col-7" style="margin-top:5px;">
                            <br/>
                            <div class="form-check" style="margin-left:10px;">
                                <input type="checkbox" class="form-check-input" id="send_all" name="send_all" value="1">
                                <label for="send_all" class="form-check-label">Send all line items to supplier?</label>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">

                                <div class="card m-0"><label for="extra_note">Extra Note:</label>
                                    <textarea class="summernote" name="extra_note" placeholder="Please enter Extra Note Here">
                                    </textarea>
                                    @if ($errors->has('extra_note'))
                                        <div class="" style="color:red">{{ $errors->first('extra_note') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                         <div class="col-md-12 col-sm-12 col-12">
                            <label for="additional-file" class="col-form-label">Additional File</label>

                            <input type="file" class="form-control" id="additional-file" name="quotation_file[]" multiple>

                        </div>
                    </div>
                </div>
                <div class="modal-footer custom d-flex justify-content-end align-items-center">
                    <button type="submit" name="preview" value="yes" target="blank" class="btn btn-link primary mr-3">View PDF</button>
                    <button type="button" class="btn btn-link danger mr-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-link success mr-2">Send RFQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Modal for PO to supplier -->
        <div class="modal fade bd-example-modal-lg" id="IssuePo" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Issue PO Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('po.toVendor')}}" class="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="row gutters">
                        <div class="col-md-4 col-sm-4 col-4">
                            <label for="recipient-name" class="col-form-label">Supplier:</label>
                            <select class="form-control selectpicker" data-live-search="true" required name="vendor_id" onchange="fetchContactsPo(this.value)">
                                <optgroup label="Chosen Supplier">
                                    <option value="{{$rfq[0]->vendor_id}}">{{$selected_supplier}} </option>
                                </optgroup>
                                @if(count($recommended_suppliers) > 0)
                                <optgroup label="Recommended Suppliers">
                                    @foreach($recommended_suppliers as $recommended_supplier)
                                    <option value="{{$recommended_supplier->vendor_id}}"> {{$recommended_supplier->vendor_name}}</option>
                                    @endforeach
                                </optgroup>
                                @endif
                                <optgroup label="Other Suppliers">
                                    @foreach($other_suppliers as $other_supplier)
                                    <option value="{{$other_supplier->vendor_id}}"> {{$other_supplier->vendor_name}}</option>
                                    @endforeach
                                </optgroup>
                                <option value="">-- Select Supplier --</option>
                            </select>
                            @if ($errors->has('rec_email'))
                                <div class="" style="color:red">{{ $errors->first('rec_email') }}</div>
                            @endif
                        </div>
                        
                        <div class="col-md-8 col-sm-8 col-8">
                            <label for="recipient-name" class="col-form-label">CC Email:</label>
                            <input type="text" class="form-control" id="recipient-email" name="report_recipient" value="sales@tagenergygroup.net; mary.nwaogwugwu@tagenergygroup.net">
                            @if ($errors->has('report_recipient'))
                                <div class="" style="color:red">{{ $errors->first('quotation_recipient') }}</div>
                            @endif
                        </div>
                        
                        <div class="col-md-5 col-sm-5 col-5">
                            <label for="recipient-name" class="col-form-label">Contact:</label>
                            <select id="PoContact" class="form-control selectpicker" data-live-search="true" required name="contact_id">
                                <option value="">-- Select Contact --</option>
                            </select>
                        </div>
                        
                        <div class="col-md-7 col-sm-7 col-7">
                            <label for="SupplierRFQ" class="col-form-label">RFQ Number</label>
                            <select id="SupplierRFQ" class="form-control selectpicker" data-live-search="true" required name="supplier_rfq">
                                <option value="">-- Select Contact --</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-12">
                            <label for="recipient-name" class="col-form-label">Line Items:</label>
                            <input type="text" class="form-control" id="line_items" name="line_items" data-role="tagsinput" value="" placeholder="Enter a value such as 1-3, 5-7 signifying their serial number">
                            @if ($errors->has('line_items'))
                                <div class="" style="color:red">{{ $errors->first('line_items') }}</div>
                            @endif
                        </div>
                        <input type="text" value="{{ $rfq[0]->rfq_id }}" name="rfq_id" hidden>
                        <div class="col-md-7 col-sm-7 col-7" style="margin-top:5px;">
                            <br/>
                            <div class="form-check" style="margin-left:10px;">
                                <input type="checkbox" class="form-check-input" id="send_all" name="send_all" value="1">
                                <label for="send_all" class="form-check-label">Send all line items to supplier?</label>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">

                                <div class="card m-0"><label for="extra_note">Extra Note:</label>
                                    <textarea class="summernote" name="extra_note" placeholder="Please enter Extra Note Here">
                                    </textarea>
                                    @if ($errors->has('extra_note'))
                                        <div class="" style="color:red">{{ $errors->first('extra_note') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                         <div class="col-md-12 col-sm-12 col-12">
                            <label for="additional-file" class="col-form-label">Additional File</label>

                            <input type="file" class="form-control" id="additional-file" name="quotation_file[]" multiple>

                        </div>
                    </div>
                </div>
                <div class="modal-footer custom d-flex justify-content-end align-items-center">
                    <button type="submit" name="preview" value="yes" target="blank" class="btn btn-link primary mr-3">View PDF</button>
                    <button type="button" class="btn btn-link danger mr-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-link success mr-2">Issue PO</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Modal for Uploading Document for Line Items-->
        <div class="modal fade bd-example-modal-lg" id="UploadLineItems" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Upload LineItem Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('line.upload')}}" class="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row gutters">
                         <div class="col-md-12 col-sm-12 col-12">
                            <label for="additional-file" class="col-form-label">Line Items File</label>
                            <input type="file" class="form-control" id="additional-file" name="document" accept=".csv, .xlsx, .xls">
                            <input type="hidden" name="rfq_id" value="{{$rfqs->rfq_id}}">
                        </div>
                        <div class="col-md-12 col-sm-12 col-12">
                            <h5 style="margin-top:10px;">Instructions</h5>
                            <ol>
                                <li>Download the <a href="/storage/app/public/templates/Import_Line_Items.xlsx">template</a> file to use for uploading data.</li>
                                <li>Enter your data in each column under the provided headers. <span style="color:red;">**Do not delete or modify the headers.**</span></li>
                                <li>Save your completed file on your device.</li>
                                <li>Upload the saved file here.</li>
                            </ol>
                            <p>Acceptable formats are: <strong>CSV, XLSX, XLS</strong> (Excel)</p>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer custom d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-link danger mr-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-link success mr-2">Upload RFQ</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Modal for Uploading Document to Update Line Items-->
        <div class="modal fade bd-example-modal-lg" id="UpdateLineItems" tabindex="-1" role="dialog" aria-labelledby="customModalTwoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalTwoLabel">Upload Cost for LineItems</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('line.cost_upload')}}" class="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row gutters">
                         <div class="col-md-12 col-sm-12 col-12">
                            <label for="additional-file" class="col-form-label">Updated Line Items Cost File</label>
                            <input type="file" class="form-control" id="additional-file" name="document" accept=".csv, .xlsx, .xls">
                            <input type="hidden" name="rfq_id" value="{{$rfqs->rfq_id}}">
                        </div>
                        <div class="col-md-12 col-sm-12 col-12">
                            <h5 style="margin-top:10px;">Instructions</h5>
                            <ol>
                                <li>Download this <a href="{{route('line.excel_export', $rfqs->rfq_id)}}">LineItems</a> file to update unit cost price.</li>
                                <li>Enter your data in the column under the provided headers. <span style="color:red;">**Do not delete or modify the headers.**</span></li>
                                <li>Save your completed file on your device.</li>
                                <li>Upload the saved file here.</li>
                            </ol>
                            <p>Acceptable formats are: <strong>CSV, XLSX, XLS</strong> (Excel)</p>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer custom d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-link danger mr-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-link success mr-2">Upload RFQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Function to fetch contacts based on selected supplier
function fetchContacts(vendorId) {
    const contactDropdown = $('#contact');
    contactDropdown.empty(); // Clear previous contacts
    contactDropdown.append('<option value="">-- Select Contact --</option>');

    if (!vendorId) return; 

    $.ajax({
        url: `/api/get-vendor-contact/${vendorId}`, 
        method: 'GET',
        success: function(data) {
            // Loop through each contact and add it to the dropdown
            data.forEach(contact => {
                contactDropdown.append(`<option value="${contact.contact_id}">${contact.first_name} ${contact.last_name}</option>`);
            });

            // Refresh the selectpicker for new options
            contactDropdown.selectpicker('refresh');
            contactDropdown.prop('disabled', false); 
        },
        error: function(error) {
            console.error('Error fetching contacts:', error);
        }
    });
}

function fetchContactsPo(vendorId, rfqId) {
    const contactDropdown = $('#PoContact');
    contactDropdown.empty(); // Clear previous contacts
    contactDropdown.append('<option value="">-- Select Contact --</option>');
    var rfqId = {{ $rfqs->rfq_id }};
    if (!vendorId) return; 

    $.ajax({
        url: `/api/get-vendor-contact/${vendorId}`, 
        method: 'GET',
        success: function(data) {
            // Loop through each contact and add it to the dropdown
            data.forEach(contact => {
                contactDropdown.append(`<option value="${contact.contact_id}">${contact.first_name} ${contact.last_name}</option>`);
            });

            // Refresh the selectpicker for new options
            contactDropdown.selectpicker('refresh');
            contactDropdown.prop('disabled', false); 

            //Call fetchSupplierRFQs after fetching contacts
            fetchSupplierRFQs(rfqId, vendorId);
        },
        error: function(error) {
            console.error('Error fetching contacts:', error);
        }
    });
}

function fetchSupplierRFQs(rfqId, vendorId) {
    const rfqDropdown = $('#supplierRFQ');
    rfqDropdown.empty(); // Clear previous contacts
    rfqDropdown.append('<option value="">-- Select Contact --</option>');

    if (!vendorId || !rfqId) return; 

    $.ajax({
        url: `/api/get-vendor-pricing/${rfqId}/${vendorId}`, 
        method: 'GET',
        success: function(data) {
            // Loop through each contact and add it to the dropdown
            data.forEach(pricing => {
                contactDropdown.append(`<option value="${pricing.id}">${pricing.reference_number}</option>`);
            });

            // Refresh the selectpicker for new options
            contactDropdown.selectpicker('refresh');
            contactDropdown.prop('disabled', false); 
        },
        error: function(error) {
            console.error('Error fetching contacts:', error);
        }
    });
}
</script>



@endsection
