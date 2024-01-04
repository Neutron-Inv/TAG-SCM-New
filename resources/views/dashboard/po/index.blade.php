<?php $title = 'List of Purchase Order'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View RFQ</a></li>

                <li class="breadcrumb-item">List of Purchase Order for RFQ</li>
            </ol>
            @include('layouts.logo')
        </div>

         <!-- Content wrapper start -->
         <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">



										<div class="invoice-body">


                                            @if(count($po) < 1)
                                                <div class="row gutters">

                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            @else

                                                <div class="row gutters">

                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table id="fixedHeader" class="table">
                                                                <thead class="bg-warning text-white">
                                                                    <tr>
                                                                        <th>S/N</th>
                                                                        <th>Status</th>
                                                                        <th>Client Ref No</th>
                                                                        <th>Our Ref No</th>
                                                                        <th>Client</th>
                                                                        <th>PO Number</th>

                                                                        <th>Total PO (USD)
                                                                            @if(Auth::user()->hasRole('SuperAdmin'))
                                                                                (${{ number_format(sumForeignClient(),2) ?? 0.00 }})
                                                                            @else
                                                                                (${{ number_format(sumForeignCompany($company->company_id),2) ?? 0.00 }})
                                                                            @endif
                                                                        </th>
                                                                        <th>Total PO (NGN)
                                                                            @if(Auth::user()->hasRole('SuperAdmin'))
                                                                                    (₦{{ number_format(sumNgnClient(),2) ?? 0.00 }})
                                                                            @else
                                                                                (₦{{ number_format(sumNgnCompany($company->company_id),2) ?? 0.00 }})
                                                                            @endif
                                                                        </th>
                                                                        <th>Buyer</th>
                                                                        <th>PO Date</th>
                                                                        <th>Delivery Date</th>
                                                                        <th>Assigned To</th>
                                                                        <th>Line Items</th>
                                                                        <th>Files</th>

                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <?php $num =1; ?>
                                                                    @foreach ($po as $rfqs)
                                                                        @if(count(checkRFQ($rfqs->rfq_id)) > 0)
                                                                            @php
                                                                                $item = getClientRfq($rfqs->rfq_id);
                                                                                updateContact($item->contact_id, $rfqs->po_id);
                                                                            @endphp
                                                                        @else
                                                                            @foreach (gettingRFQ($rfqs->rfq_id) as $item)
                                                                                @php updateContact($item->contact_id, $rfqs->po_id); @endphp

                                                                            @endforeach
                                                                        @endif
                                                                        <tr>
                                                                            <td>{{ $num }}
                                                                                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                                                                                <a href="{{ route('po.edit',$rfqs->po_id) }}" title="Edit The PO" class="" onclick="return(confirmToEdit());">
                                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                                </a>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if($rfqs->status == 'Quotation Submitted')
                                                                                    <span class="badge badge-pill badge-warning"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'Acknowledge')
                                                                                <span class="badge badge-pill badge-secondary"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'PO Issued')
                                                                                    <span class="badge badge-pill badge-info"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'Bid Closed')
                                                                                    <span class="badge badge-pill badge-danger"> {{ $rfqs->status ?? '' }} </span>
                                                                                @elseif($rfqs->status == 'Awaiting Pricing')
                                                                                    <span class="badge badge-pill badge-danger"> {{ $rfqs->status ?? '' }} </span>
                                                                                @else

                                                                                    <span class="badge badge-pill badge-success"> {{ $rfqs->status ?? '' }} </span>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $rfqs->rfq_number }}</td>
                                                                            <td>{{ $rfqs->refrence_no }}</td>

                                                                            <td>{{ $rfqs->client->client_name ?? 'Null' }}</td>
                                                                            <td>
                                                                                <a href="{{ route('po.details',$rfqs->po_id) }}" title="View PO Details" style="color: green">
                                                                                    {{ $rfqs->po_number }}
                                                                                </a>
                                                                            </td>
                                                                            <td><span class="icon-dollar-sign"></span> {{ number_format($rfqs->po_value_foreign,2) ?? '0.00'}}</td>
                                                                            <td>&#8358;{{ number_format($rfqs->po_value_naira,2) ?? '0.00'}}</td>


                                                                            <td>
                                                                                @foreach (buyers($rfqs->contact_id) as $it)
                                                                                    {{ $it->first_name . ' '. $it->last_name ?? ' N/A' }}
                                                                                @endforeach
                                                                            </td>
                                                                            <td>{{ $rfqs->po_date }}</td>
                                                                            <td>{{ $rfqs->delivery_due_date }}</td>

                                                                            <td>
                                                                                {{-- @foreach (employ($rfqs->employee_id) as $item)
                                                                                    {{ $item->full_name ?? 'Empty' }}
                                                                                @endforeach --}}
                                                                                {{ $rfqs->rfq->employee->full_name ?? 'N/A' }}
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
                                                                            <td>
                                                                                @if (file_exists('document/po/'.$rfqs->po_id.'/'))
                                                                                    <?php
                                                                                    $dir = 'document/po/'.$rfqs->po_id.'/';
                                                                                    $files = scandir($dir);
                                                                                    $total = count($files) - 2; ?>
                                                                                    <a href="{{ route('po.details', $rfqs->po_id) }}" style="color:blue">
                                                                                    {{ $total ?? 0 }} </a>

                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </td>
                                                                        </tr><?php $num++; ?>
                                                                    @endforeach


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

										</div>


									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
         </div>
    </div>
@endsection
