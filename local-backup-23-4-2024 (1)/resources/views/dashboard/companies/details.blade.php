<?php $title = 'Companies'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('company.details',$comp->email) }}">Company Details</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.edit',$comp->email) }}">Edit Company</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.index') }}">View Companies</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.create') }}">Add Company</a></li>

                <li class="breadcrumb-item">View Company Details</li>
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
						<div class="col-12">

							<!-- Card start -->
							<div class="card">
								<div class="card-header">
									<div class="card-title">{{ $comp->company_name }} Details
								</div>
								<div class="card-body">

									<!-- Row start -->
									<div class="row gutters">
                                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">

											<!-- Card start -->
											<div class="card">
												<div class="card-body">

                                                    <div class="table-responsive">
                                                        <div class="user-profile">
                                                            <div class="user-avatar">

                                                                @foreach (getLogo($comp->company_id) as $item)
                                                                    <img src="{{ asset('company-logo/'.$comp->company_id.'/'.$item->company_logo) }}" style="width: 101px; padding-right:20px; margin-bottom: 15px;" alt="">
                                                                    <img src="{{ asset('company-logo/'.$comp->company_id.'/'.$item->signature) }}" style="width: 101px; padding-right:20px; margin-bottom: 15px;" alt="">
                                                                @endforeach
                                                            </div>


                                                        </div><br><br>
                                                        <table class="table m-0">

                                                             <tbody>
                                                                <tr>
                                                                    <td>Company Name</td>
                                                                    <td>{{ $comp->company_name ?? '' }}</td>

                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Company Code</td>
                                                                    <td>{{ $comp->company_code ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Industry</td>
                                                                    <td>{{ $comp->industry->industry_name ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Address</td>
                                                                    <td>{{ $comp->address ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>LGA</td>
                                                                    <td>{{ $comp->lgaId ?? '' }}</td>

                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

										</div>
										<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">

											<!-- Card start -->
											<div class="card">
												<div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">

                                                            <tbody>
                                                                <tr>
                                                                    <td>Description</td>
                                                                    <td>{{ $comp->company_description ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Company E-Mail</td>
                                                                    <td>{{ $comp->email ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Company Phone</td>
                                                                    <td>{{ $comp->phone ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Contact Name</td>
                                                                    <td>{{ $comp->contact ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Contact E-Mail</td>
                                                                    <td>{{ $comp->contact_email ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Contact Phone</td>
                                                                    <td>{{ $comp->contact_phone ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Company Website</td>
                                                                    <td>{{ $comp->webadd ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

										</div>
										<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
											<!-- Card start -->
											<div class="card">
												<div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">



                                                            <tbody>
                                                                <tr>
                                                                    <td>No Agents</td>
                                                                    <td>{{ $comp->no_agents ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>No Cust</td>
                                                                    <td>{{ $comp->no_cust ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Inactive</td>
                                                                    <td>{{ $comp->inactive ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Activation Count</td>
                                                                    <td>{{ $comp->activation_count ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Status DT</td>
                                                                    <td>{{ $comp->status_dt ?? '' }}</td>

                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Lang Year</td>
                                                                    <td>{{ $comp->lang_yr ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Serve Plan Allowed</td>
                                                                    <td>{{ $comp->servplan_allowed ?? '' }}</td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

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
