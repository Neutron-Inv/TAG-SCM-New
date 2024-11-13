<?php $title = 'List of all Client Contact'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('client.index') }}"> Client Contact</a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}"> Clients</a></li>

                <li class="breadcrumb-item">Client Contact</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @include('layouts.alert')
                            @if(count($contact) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Client Contact
                                    {{-- <a href="{{ route('contact.loading') }}" class="btn btn-primary">Upload Contact Details to user table</a> </h5> --}}

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Contact Name</th>
                                                    <th>Client Name</th>

                                                    <th>Email</th>
                                                    <th>Job Title</th>
                                                    <th>Phone Number</th>
                                                    <th>Country Code</th>
                                                    <th>Address</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($contact as $contacts)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            <a href="{{ route('contact.edit',$contacts->contact_id) }}" title="Edit Client Contact" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            @if(Gate::allows('SuperAdmin', auth()->user()))
                                                                {{-- <a href="{{ route('contact.delete',$contacts->contact_id) }}" class="" title="Delete The Client Contact" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a> --}}
                                                            @endif
                                                        </td>
                                                        <td>{{ $contacts->first_name . ' '. $contacts->last_name ?? '' }}</td>
                                                        <td>{{ $contacts->client->client_name ?? '' }}</td>


                                                        <td>{{ $contacts->email. ', '. $contacts->email_other ?? '' }} </td>
                                                        <td>{{ $contacts->job_title ?? '' }} </td>
                                                        <td>{{ $contacts->office_tel . ', '. $contacts->mobile_tel ?? '' }} </td>
                                                        <td>{{ $contacts->country_code ?? '' }} </td>
                                                        <td>{{ $contacts->city . ', ' . $contacts->state. ', '. $contacts->address .'.' ?? '' }} </td>
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
        </div>
    </div>
@endsection
