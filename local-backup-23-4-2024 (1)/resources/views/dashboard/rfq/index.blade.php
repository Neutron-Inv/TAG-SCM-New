<?php $title = 'RFQs'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.index') }}">View RFQ</a></li>
                {{-- <li class="breadcrumb-item active"><a href="{{ route('line.index') }}">All Line Items</a></li> --}}

                <li class="breadcrumb-item">List of RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="row gutters">

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
                                        <h5 class="table-title">Active RFQs
                                        </h5>

                                        <div class="table-responsive">
                                            <table id="fixedHeader" class="table" style="width:100%">
                                                <thead class="bg-success text-white">
                                                    <tr>

                                                        <th>#</th>
                                                        <th>Status</th>
                                                        <th>Client</th>
                                                        <th >Client RFQ No</th>
                                                        <th>Our Ref No</th>
                                                        <th>Description</th>
                                                        <th>Total Quote (USD) <br />
                                                            @if(Auth::user()->hasRole('SuperAdmin'))
                                                            (${{ number_format(sumNgnClientRFQ(),2) ?? 0.00 }})
                                                            @else
                                                            (${{ number_format(sumNgnClientRFQCompany($company->company_id),2) ?? 0.00 }})
                                                            @endif

                                                        </th>
                                                        <th>Total Quote (NGN) <br />
                                                            @if(Auth::user()->hasRole('SuperAdmin'))
                                                                (${{ number_format(sumNgnClientRFQNgn(),2) ?? 0.00 }})
                                                            @else
                                                                (${{ number_format(sumNgnClientRFQCompanyNgn($company->company_id),2) ?? 0.00 }})
                                                            @endif
                                                        </th>
                                                        <th>Buyer</th>
                                                        <th>Assigned To</th>
                                                        <th>Date</th>
                                                        <th>Due Date</th>
                                                        <th>Files</th>
                                                        <th>Line Items</th>

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $num =1; ?>
                                                    @foreach ($rfq as $rfqs)
                                                        <tr>

                                                            <td>{{ $num }}

                                                                 <a href="{{ route('rfq.price',$rfqs->refrence_no) }}" title="View RFQ Price Quotation" class="" onclick="">
                                                                    <i class="icon-book" style="color:green"></i>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @if($rfqs->status == 'Quotation Submitted')
                                                                    <span class="badge badge-pill badge-info"> {{ $rfqs->status ?? '' }} </span><br>
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

                                                            <td>{{ substr($rfqs->client->client_name, 0,22 ) ?? '' }}</td>
                                                            <td style="width: 50px">{{ $rfqs->rfq_number ?? '' }}</td>
                                                            <td style="width: 50px"><a href="{{ route('rfq.edit', $rfqs->refrence_no) }}" style="color:blue">
                                                                {{ $rfqs->refrence_no ?? '' }} </a>
                                                            </td>
                                                            <td> {{ substr($rfqs->description,0, 50) ?? '' }} </td>
                                                            <td style="width: 50px">
                                                                @if($rfqs->value_of_quote_usd < 2)

                                                                    {{ 'TBD' ?? '0.00'}}
                                                                @else
                                                                    ${{ number_format((int) $rfqs->value_of_quote_usd,2) ?? '' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($rfqs->value_of_quote_ngn < 2)

                                                                    {{ 'TBD' ?? '0.00'}}
                                                                @else
                                                                    &#36;{{ number_format((int) $rfqs->value_of_quote_ngn,2) ?? '' }}
                                                                @endif
                                                            </td>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))

                                                                <td>
                                                                    @foreach (buyers($rfqs->contact_id) as $items)
                                                                        <a href="mailto:{{ $items->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'N/A' }}</a>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    @foreach (employ($rfqs->employee_id) as $item)
                                                                        <a href="mailto:{{ $item->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? 'N/A'   }}</a>
                                                                    @endforeach
                                                                </td>
                                                            @else
                                                                <td>
                                                                    @foreach (buyers($rfqs->contact_id) as $it)
                                                                        <a href="mailto:{{ $it->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue">  {{ $it->first_name . ' '. $it->last_name ?? '' }}</a>
                                                                    @endforeach
                                                                    {{-- <a href="mailto:{{ $rfqs->contact->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->contact->last_name ?? 'N/A'   }}</a> --}}
                                                                </td>
                                                                <td>
                                                                    @foreach (employ($rfqs->employee_id) as $item)

                                                                        <a href="mailto:{{ $item->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue">  {{ $item->full_name ?? '' }}</a>
                                                                    @endforeach
                                                                    {{-- <a href="mailto:{{ $rfqs->employee->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->employee->full_name ?? 'N/A'   }}</a> --}}
                                                                </td>
                                                            @endif
                                                            <td>{{ isset($rfqs->rfq_date) ? date('d-M-Y, H:i', strtotime($rfqs->rfq_date)) : '' }}</td>
                                                            <td style=" {{ (date('Y-m-d', strtotime($rfqs->delivery_due_date)) === now()->format('Y-m-d')) ? 'color:red;' : '' }}">
    {{ isset($rfqs->delivery_due_date) ? date('d-M-Y, H:i', strtotime($rfqs->delivery_due_date)) : '' }}
                                                </td>
                                                <td>
                                                                @if (file_exists('document/rfq/'.$rfqs->rfq_id.'/'))
                                                                    <?php
                                                                    $dir = 'document/rfq/'.$rfqs->rfq_id.'/';
                                                                    $files = scandir($dir);
                                                                    $total = count($files) - 2; ?>
                                                                    {{ $total ?? 0 }}

                                                                @else
                                                                    0
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
                        @elseif(Auth::user()->hasRole('Shipper'))
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                @if(count($rfq) == 0)
                                    <div class="card">
                                        <div class="card-body">
                                            <h4><p style="color:red" align="center"> No Active RFQ was found
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                @else
                                    <div class="table-container">
                                        <h5 class="table-title">List of Active RFQs
                                        </h5>
                                        <div class="table-responsive">
                                            <table id="fixedHeader" class="table">
                                                <thead class="bg-warning text-white">
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Ref Nos</th>
                                                        <th>Product</th>
                                                        <th>Sumbission Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $num =1; ?>
                                                    @foreach ($rfq as $rfqs)
                                                        <tr>
                                                            @php $sh = gettingShipQuote($rfqs->rfq_id, $shipper->shipper_id)    @endphp
                                                            <td>{{ $num }}</td>

                                                            <td>{{ $rfqs->refrence_no ?? '' }}</td>
                                                            <td>{{ $rfqs->product ?? '' }}</td>
                                                            <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                            <td>
                                                                @if(count($sh) < 1)
                                                                    <a href="{{ route('rfq.shipper.quote',$rfqs->rfq_id) }}" class="btn btn-success" onclick="return(confirmToDetails());">
                                                                        <i class="icon-list" style="color:green"></i> Submit Quote
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('ship.quote.show',$rfqs->rfq_id)}}" class="btn btn-primary" onclick="return(confirmToDetails());">
                                                                        Preview Quote
                                                                    </a>

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
                        @elseif(Auth::user()->hasRole('Supplier'))
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                @if(count($line_item) == 0)
                                    <div class="card">
                                        <div class="card-body">
                                            <h4><p style="color:red" align="center"> No RFQ was found
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                @else
                                    <div class="table-container">
                                        <h5 class="table-title">List of Active RFQs
                                        </h5>
                                        <div class="table-responsive">
                                            <table id="fixedHeader" class="table">
                                                <thead class="bg-danger text-white">
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Product</th>
                                                        <th>Ref Nos</th>
                                                        <th>Sumbission Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $num =1; ?>
                                                    @foreach ($line_item as $line)
                                                        @foreach (gettingRFQ($line->rfq_id) as $rfqs)
                                                            <?php $see = countinfLineItems($rfqs->rfq_id, $vendor->vendor_id);
                                                            if($see > 0 ){ ?>
                                                                <tr>
                                                                    <td>{{ $num }}</td>
                                                                    @php
                                                                    $co = gettingSupQuote($rfqs->rfq_id, $vendor->vendor_id)    @endphp
                                                                    <td>{{ $rfqs->product ?? '' }}</td>
                                                                    <td>
                                                                        {{ $rfqs->refrence_no ?? '' }}
                                                                    </td>
                                                                    <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                                    <td>
                                                                        @if(count($co) > 0)

                                                                            <a href="{{ route('line.list', $rfqs->rfq_id)}}" class="btn btn-primary" onclick="return(confirmToDetails());">
                                                                                Preview Quote
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ route('rfq.supplier.quote', $rfqs->rfq_id)}}" class="btn btn-success" onclick="return(confirmToDetails());">
                                                                                Submit Quote
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                </tr><?php $num++;
                                                            }else{

                                                            } ?>
                                                        @endforeach
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
