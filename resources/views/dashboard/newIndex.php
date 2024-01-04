<?php $title = 'Dashboard'; ?>
@extends('layouts.app')

@section('content')

<div class="main-container">


    <!-- Page header start -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">SCM Dashboard</li>
        </ol>
        @include('layouts.logo')
    </div>

    <div class="content-wrapper">
        @include('layouts.alert')
        <!-- Row start -->
        <div class="row gutters">
            @if(( Auth::user()->email_verified_at) == "")

                <div class="col-xl-12 col-lg-12 col-md-4 col-sm-4 col-12">

                    <div class="card">
                        <div class="card-body">
                            <h6><p style="color:red" align="center">You Have Not Verify Your Account Please Kindly Visit
                                <b>{{Auth::user()->email}}</b> for the verification link </p>
                            </h6>
                        </div>
                    </div>

                </div>
            @else
                @if (Gate::allows('SuperAdmin', auth()->user()))

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('company.index') }}'">
                        <div class="icon-tiles red" style="background:#17a2b8">
                            <h2 align="left">{{ count($company) ?? 0 }}</h2>
                            <b><p style="margin-top:-20px"> Companies</p></b>
                            <img src="{{asset('admin/img/icons/organization.svg')}}" style="height:250px; width:250px" alt="Companies" />
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('vendor.index') }}'">
                        <div class="icon-tiles cyan" style="background:#d5ad2a">
                            <h2 align="left">{{ count($vendor) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Suppliers</p></b>
                            <img src="{{asset('admin/img/icons/supplier2.svg')}}" style="height:300px; width:450px" alt="Suppliers" />
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('client.index') }}'">
                        <div class="icon-tiles indigo" style="background:#20c997">
                            <h2 align="left">{{ count($client) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Clients</p></b>
                            <img src="{{asset('admin/img/icons/crm.svg')}}" alt="Clients" style="color:white" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background: purple">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('shipper.index') }}'">

                        <div class="icon-tiles teal" style="background:#6610f2">
                            <h2 align="left">{{ count($shipper) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Shippers</p></b>
                            <img src="{{asset('admin/img/icons/staff.svg')}}" alt="Shippers" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12"  onclick="location.href='{{ route('po.index') }}'" >
                        <div class="icon-tiles blue" style="background:#007bff">
                            <h2 align="left">{{ count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> PO</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client POs" />

                        </div>
                    </div>
                @elseif(Auth::user()->hasRole('Admin'))
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('client.index') }}'">
                        <div class="icon-tiles indigo" style="background:#299e33">
                            <h2 align="left">{{ count($client) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Clients</p></b>
                            <img src="{{asset('admin/img/icons/crm.svg')}}" alt="Clients" style="color:purple" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('employer.create') }}'">
                        <div class="icon-tiles info" style="background:#007bff">
                            <h2 align="left">{{ count($employee) ?? 0 }}</h2>
                            <b><p style="margin-top:-20px">Staffs</p></b>
                            <img src="{{asset('admin/img/icons/revenue.svg')}}" alt="Employers" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('vendor.index') }}'">
                        <div class="icon-tiles cyan" style="background:#d5ad2a">
                            <h2 align="left">{{ count($vendor) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Suppliers</p></b>
                            <img src="{{asset('admin/img/icons/supplier2.svg')}}" alt="Suppliers" />
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('shipper.index') }}'">

                        <div class="icon-tiles teal" style="background: #6610f2">
                            <h2 align="left">{{ count($shipper) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> Shippers</p></b>
                            <img src="{{asset('admin/img/icons/staff.svg')}}" alt="Shippers" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background:#20c997">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12"  onclick="location.href='{{ route('po.index') }}'" >
                        <div class="icon-tiles blue" style="background:#e83e8c">
                            <h2 align="left">{{ count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> PO</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client POs" />

                        </div>
                    </div>
                @elseif(Auth::user()->hasRole('Client'))

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('client.index') }}'">
                        <div class="icon-tiles indigo" style="background:red">
                            <h2 align="left">1</h2>
                            <b><p style="margin-top:-20px"> Details</p></b>
                            <img src="{{asset('admin/img/icons/staff.svg')}}" alt="Clients" style="color:white" />

                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12"  onclick="location.href='{{ route('contact.index',Auth::user()->email)}}'">
                        <div class="icon-tiles blue" style="background:blue">
                            <h2 align="left">{{ count($contact) }}</h2>
                            <b><p style="margin-top:-20px">Contact</p>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client Contact" />
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background:#17a2b8">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-4 col-12"  onclick="location.href='{{ route('po.index') }}'" >
                        <div class="icon-tiles blue" style="background:#e76b25">
                            <h2 align="left">{{ count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> PO</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="Client POs" />

                        </div>
                    </div>
                @elseif (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')))

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('employer.create') }}'">
                        <div class="icon-tiles info" style="background:#299e33">
                            <h2 align="left">1</h2>
                            <b><p style="margin-top:-20px">My Details</p></b>
                            <img src="{{asset('admin/img/icons/patient.svg')}}" alt="My Details" />

                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('rfq.index') }}'">
                        <div class="icon-tiles primary" style="background:#9d063b">
                            <h2 align="left">{{ count($rfq) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> RFQs</p></b>
                            <img src="{{asset('admin/img/icons/appointment.svg')}}" alt="Client RFQs" />

                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('po.index') }}'">
                        <div class="icon-tiles blue" style="background:#e76b25">


                            <h2 align="left">{{count($po) ?? 0}}</h2>
                            <b><p style="margin-top:-20px"> POs</p></b>

                            <img src="{{asset('admin/img/icons/revenue.svg')}}" alt="Purchase Order" />

                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12" onclick="location.href='{{ route('get-issues') }}'">
                        <div class="icon-tiles teal" style="background:#54bae2">

                            <h2 align="left">{{\App\Issue::where('assigned_to', Auth::id())->count()}}</h2><b><p style="margin-top:-20px">Help Desk</p></b>
                            <img src="{{asset('admin/img/icons/open-email.svg')}}" alt="Help Desk" />
                        </div>
                    </div>

                @endif

                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')) OR
                    (Auth::user()->hasRole('HOD'))))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        @if(count($rfq) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <h5><p style="color:red" align="center"> No RFQ was found for

                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                All Clients
                                            @else
                                                {{ $company->company_name ?? ' Your Company' }}
                                            @endif
                                        </p>
                                    </h5>
                                </div>
                            </div>
                        @else
                            <div class="table-container">
                                <h5 class="table-title">Active RFQs
                                </h5>

                                <div class="table-responsive">
                                    <table id="basicExample" class="table" style="width:100%">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>S/N</th>
                                                <th>Status</th>
                                                <th>Client</th>
                                                <th>Ref Nos</th>
                                                <th >Client RFQ No</th>
                                                <th>RFQ Date</th>
                                                <th>Sub Due Date</th>
                                                <th>Product</th>
                                                <th>Total Quote</th>
                                                <th>Shipper Quote </th>
                                                <th>Supplier Quote </th>
                                                <th>Line Item</th>
                                                <th>Assigned To</th>
                                                <th>Buyer</th>
                                                {{-- 'yes', '','','','','','','','','','','','','','','','','','','','','','','','','','',''),
                                                'no', '','','','','','','','','','','','','','','','','','','','','','','','','','',''),

                                                , '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' , '', '', '', '', '', '', '','','','USD','NULL','No'),

                                                --}}
                                                {{-- UPDATE `client_rfqs` SET `fund_transfer` = 0 WHERE  `fund_transfer` IS NULL;
                                                UPDATE `client_rfqs` SET `fund_transfer` = 0 WHERE  `fund_transfer` = '';
                                                UPDATE `client_rfqs` SET `freight_charges` = 0 WHERE  `freight_charges`= '';
                                                UPDATE `client_rfqs` SET `local_delivery` = 0 WHERE  `local_delivery` = '';
                                                UPDATE `client_rfqs` SET `cost_of_funds` = 0 WHERE  `cost_of_funds` = '';
                                                UPDATE `client_rfqs` SET `wht` = 0 WHERE  `wht` = '';
                                                UPDATE `client_rfqs` SET `ncd` = 0 WHERE  `ncd` = '';
                                                UPDATE `client_rfqs` SET `other_cost` = 0 WHERE  `other_cost` = '';
                                                UPDATE `client_rfqs` SET `net_value` = 0 WHERE  `net_value` = '';
                                                UPDATE `client_rfqs` SET `net_percentage` = 0 WHERE  `net_percentage` = '';
                                                UPDATE `client_rfqs` SET `percent_margin` = 0 WHERE  `percent_margin` = '';
                                                UPDATE `client_rfqs` SET `net_value` = 0 WHERE  `net_value` = '';
                                                UPDATE `client_rfqs` SET `intrest_rate` = 0 WHERE  `intrest_rate` = '';
                                                UPDATE `client_rfqs` SET `fund_transfer_charge` = 0 WHERE  `fund_transfer_charge` = '';
                                                UPDATE `client_rfqs` SET `vat_transfer_charge` = 0 WHERE  `vat_transfer_charge` = '';
                                                UPDATE `client_rfqs` SET `offshore_charges` = 0 WHERE  `offshore_charges` = '';
                                                UPDATE `client_rfqs` SET `swift_charges` = 0 WHERE  `swift_charges` = '';
                                                UPDATE `client_rfqs` SET `currency` = 'USD' WHERE  `currency` = '';
                                                UPDATE `client_rfqs` SET `duration` = '1' WHERE  `duration` = '';

                                                UPDATE `client_rfqs` SET `value_of_quote_usd` = '1' WHERE  `value_of_quote_usd` = '';
                                                UPDATE `client_rfqs` SET `value_of_quote_ngn` = '1' WHERE  `value_of_quote_ngn` = '';
                                                UPDATE `client_rfqs` SET `contract_po_value_usd` = '1' WHERE  `contract_po_value_usd` = '';
                                                UPDATE `client_rfqs` SET `supplier_quote_usd` = '1' WHERE  `supplier_quote_usd` = '';
                                                UPDATE `client_rfqs` SET `intrest_logistics` = '1' WHERE  `intrest_logistics` = '';
                                                UPDATE `client_rfqs` SET `duration_logistics` = '1' WHERE  `duration_logistics` = '';
                                                UPDATE `client_rfqs` SET `oversized` = 'No' WHERE  `oversized` = '';
                                                UPDATE `client_rfqs` SET `transport_mode` = 'Air' WHERE  `transport_mode` = '';
                                                UPDATE `client_rfqs` SET `shipper_mail` = 'No' WHERE  `shipper_mail` = '';
                                                UPDATE `client_rfqs` SET `send_image` = 'No' WHERE  `send_image` = '';
                                                UPDATE `client_rfqs` SET `online_submission` = 'No' WHERE  `online_submission` = '';
                                                UPDATE `client_rfqs` SET `deleted_at` = NULL;
                                                UPDATE `client_pos` SET `deleted_at` = NULL;
                                                UPDATE `client_rfqs` SET `vendor_id` = '89' WHERE  `vendor_id` = '';
                                                UPDATE `client_rfqs` SET `vendor_id` = '89' WHERE vendor_id = 0;

                                                UPDATE `client_rfqs` SET `shipper_id` = '37' WHERE  `shipper_id` = '';
                                                UPDATE `client_rfqs` SET `shipper_id` = '37' WHERE shipper_id = 0;
                                                --}}

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

                                                        {{-- <a href="{{ route('po.new.details',$rfqs->rfq_id) }}" class="">
                                                            <i class="icon-book" style="color:green"></i>
                                                        </a> --}}
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
                                                    <td><a href="{{ route('rfq.edit', $rfqs->refrence_no) }}" style="color:blue">
                                                        {{ $rfqs->refrence_no ?? '' }} </a>
                                                    </td>
                                                    <td style="width: 50px">{{ $rfqs->rfq_number ?? '' }}</td>
                                                    <td>{{ $rfqs->rfq_date ?? '' }}</td>
                                                    <td>{{ $rfqs->shipper_submission_date ?? '' }}</td>
                                                    <td><a href="{{ route('rfq.details',$rfqs->refrence_no) }}" title="View RFQ Details" class="" onclick="return(confirmToDetails());">

                                                    {{ substr($rfqs->product,0, 50) ?? '' }}...</a></td>
                                                    <td>
                                                        @if($rfqs->value_of_quote_ngn < 2)
                                                            @php $tot_tapas = ((int) $rfqs->supplier_quote_usd)  + ((int)$rfqs->freight_charges); @endphp
                                                            &#8358;{{ number_format($tot_tapas,2) ?? '0.00'}}
                                                        @else
                                                            &#36;{{ number_format((int) $rfqs->value_of_quote_ngn,2) ?? '' }}
                                                        @endif
                                                    </td>
                                                    <td> @php $sup = countShipQuote($rfqs->rfq_id); @endphp
                                                        @if($sup < 1)
                                                            0
                                                        @else
                                                            <a href="{{ route('ship.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
                                                        @endif
                                                    </td>
                                                    <td> @php $sup = countSupQuote($rfqs->rfq_id); @endphp
                                                        @if($sup < 1)
                                                            0
                                                        @else
                                                            <a href="{{ route('sup.quote.show', $rfqs->rfq_id) }}" style="color:blue">{{ $sup }} </a>
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
                                                    @if (Gate::allows('SuperAdmin', auth()->user()))
                                                        <td>
                                                            @foreach (employ($rfqs->employee_id) as $item)
                                                                <a href="mailto:{{ $item->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $item->full_name ?? 'N/A'   }}</a>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach (buyers($rfqs->contact_id) as $items)
                                                                <a href="mailto:{{ $items->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $items->first_name . ' '. $items->last_name ?? 'N/A' }}</a>
                                                            @endforeach
                                                        </td>
                                                    @else
                                                        <td><a href="mailto:{{ $rfqs->employee->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->employee->full_name ?? 'N/A'   }}</a></td>
                                                        <td>
                                                            <a href="mailto:{{ $rfqs->contact->email}}?subject='Status Of Inquiry For RFQ'" target="_blank" style="color:blue"> {{ $rfqs->contact->last_name ?? 'N/A'   }}</a>
                                                        </td>
                                                    @endif

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
                                                    <td><a href="{{ route('rfq.details',$rfqs->refrence_no) }}" title="View RFQ Details" class="" onclick="return(confirmToDetails());">

                                                        {{ substr($rfqs->product,0, 40) ?? '' }}...</a></td>
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
                                        <thead class="bg-success text-white">
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
                                                            <td><a href="{{ route('rfq.details',$rfqs->refrence_no) }}" title="View RFQ Details" class="" onclick="return(confirmToDetails());">
                                                                {{ substr($rfqs->product,0, 40) ?? '' }}...</a></td>
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
                @elseif(Auth::user()->hasRole('Warehouse User'))
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @if(count($inventory) == 0)
                        <div class="card">
                            <div class="card-body">
                                <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            <h5 class="table-title">
                                @if(AUth::user()->hasRole('Warehouse User'))
                                    List of all Inventories for {{ $rest->name }}
                                @else

                                @endif
                            </h5>

                            <div class="table-responsive">
                                <table id="basicExample" class="table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>S/N</th>
                                            <th>Material Number </th>
                                            <th> OEM </th>
                                            <th> OEM Part Number</th>
                                            <th> Storage Location </th>
                                            <th> Quantity </th>
                                            <th> Material Condition </th>
                                            <th> Entered By </th>
                                            <th> Approved By </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num =1; ?>
                                        @foreach ($inventory as $inventories)
                                            <tr>

                                                <td>{{ $num }}</td>
                                                <td>{{ $inventories->material_number ?? '' }}</td>
                                                <td>{{ $inventories->oem ?? '' }}</td>
                                                <td>{{ $inventories->oem_part_number ?? '' }}</td>
                                                <td>{{ $inventories->storage_location ?? '' }}</td>
                                                <td>{{ $inventories->quantity_location ?? '' }}</td>
                                                <td>{{ $inventories->material_condition ?? '' }}</td>
                                                <td>
                                                    {{ $inventories->user_email ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $inventories->approved_by ?? '' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('inventory.edit',$inventories->inventory_id) }}" title="Edit The Industry" class="" onclick="return(confirmToEdit());">
                                                        <i class="icon-edit" style="color:blue"></i>
                                                    </a>
                                                    <a href="{{ route('inventory.delete',$inventories->inventory_id) }}" title="View The Inventory" class="">
                                                        <i class="icon-delete" style="color:red"></i>
                                                    </a>

                                                    <a href="{{ route('inventory.details',$inventories->inventory_id) }}" title="View The Inventory" class="">
                                                        <i class="icon-list" style="color:green"></i>
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

            @endif

        </div>
        <!-- Row end -->

    </div>

@endsection
