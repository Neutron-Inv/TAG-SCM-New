<?php $title = 'Send Client PO Report'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('po.reports.client',$client->client_id) }}"> Client PO Report</a></li>
                <li class="breadcrumb-item"><a href="{{ route('po.reports') }}"> Create PO Report</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">View Client</a></li>
                <li class="breadcrumb-item"> List of Clients</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header" align="center">
								<div class="card-title"><b>Please fill the below form to send the report to the client </b></div>
							</div>
                            <form action="{{ route('po.send.reports.client') }}" class="" method="POST">
                                {{ csrf_field() }}
                                @php $cli = clits($client->client_id); $cop = cops($client->company_id); $cont = buyersContact($client->client_id); @endphp
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Company Name:</label><div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                            </div>
                                            <input class="form-control" name="company_name" id="inputName" value="{{$client->company->company_name ?? 'Company Name'}}" readonly placeholder="Enter Client Name" type="text"
                                            aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('company_name'))
                                                <div class="" style="color:red">{{ $errors->first('company_name') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <input class="form-control" name="company_id" id="inputName" value="{{$client->company->company_id ?? 'Company Name'}}" type="hidden">

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">Client Name:</label><div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                            </div>
                                            <input class="form-control" name="client_name" id="inputName" value="{{$client->client_name ?? 'Client Name'}}" readonly placeholder="Enter Client Name" type="text"
                                            aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('client_name'))
                                                <div class="" style="color:red">{{ $errors->first('client_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">To:</label><div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-message" style="color:#28a745"></i></span>
                                            </div>
                                            <input class="form-control" name="email" id="inputName" value="{{old('email')}}" required placeholder="Enter email" type="email"
                                            aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    @php $list = array(); @endphp
                                    @foreach ($cont as $item)
                                        @php $list[] = $item->email; @endphp
                                    @endforeach
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="recipient-name" >CC: {{ count($cont) ?? 0 }} <br> <b>Reciepients: </b> {{ implode('; ', $list) }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="receipients" value="{{ old('receipients') }}" required type="text"
                                                aria-describedby="basic-addon2">
                                            </div>
                                            @if ($errors->has('receipients'))
                                                <div class="" style="color:red">{{ $errors->first('receipients') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="table-container">
                                                <div class="table-responsive">
                                                    <table id="fixedHeader" class="table" style="width:100%">
                                                        <thead style="background-color: pink; color:black" class="">
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>PO Number</th>
                                                                <th>Vendor</th>
                                                                <th>Incoterm</th>
                                                                <th>PO Delivery Date</th>
                                                                <th>TAG's Comment</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $num =1; @endphp
                                                            @forelse ($po as $item)
                                                                {{--$rfq = getRf($item->rfq_id);  --}}
                                                                @php
                                                                    if((strpos($item->tag_comment, 'production') !== false) OR (strpos($item->tag_comment, 'Production') !== false)){
                                                                        $color = 'yellow';
                                                                    }elseif((strpos($item->tag_comment, 'ongoing') !== false) OR (strpos($item->tag_comment, 'Ongoing') !== false)){
                                                                        $color = 'red';
                                                                    }elseif((strpos($item->tag_comment, 'delivered') !== false) OR (strpos($item->tag_comment, 'Delivered') !== false)){
                                                                        $color = 'green';
                                                                    } else{
                                                                        $color = 'orange';
                                                                    }
                                                                @endphp
                                                                <tr >
                                                                    <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $num }}</span></td>
                                                                    <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $item->po_number ?? 'PO Number' }} </span></td>
                                                                    <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $item->rfq->vendor->vendor_name ?? '' }} </span></td>
                                                                    <td><span style="color:black; background-color: <?php echo $color; ?>">DDP </span></td>
                                                                    <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $item->delivery_due_date ?? '' }} </span></td>
                                                                    <td><span style="color:black; background-color: <?php echo $color; ?>">{!! substr($item->tag_comment,0, 550) ?? 'PO Note' !!} </span>
                                                                        {{-- <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-{{ $num }}">view more</a> --}}

                                                                        <div class="modal fade bd-example-modal-lg-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg-{{ $num }}">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="myLargeModalLabel-{{ $num }}">{{ $item->po_number  }} Note</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        {!! $item->tag_comment ?? 'N/A' !!}
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                                <?php $num++; ?>
                                                            @empty

                                                            @endforelse


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="client_id" value="{{ $client->client_id }}">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary " type="submit" title="Click Send the Report" style="float: right">Send Report</button>
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
