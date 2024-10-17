<?php $title = ' Inventory Details'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('inventory.details',$inventory->inventory_id) }}">View Inventory Details</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">View Inventories</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.create') }}">Create Inventory</a></li>

                <li class="breadcrumb-item">view list if Inventories</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="row gutters">
						<div class="col-12">

							<!-- Card start -->
							<div class="card">
								<div class="card-header">
									<div class="card-title">Inventory Details
								</div>
								<div class="card-body">

									<!-- Row start -->
									<div class="row gutters">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">

											<!-- Card start -->
											<div class="card">
												<div class="card-body">

                                                    <div class="table-responsive">

                                                        <table class="table m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Entered By</td>
                                                                    <td>{{ ($inventory->user_email) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Approved By</td>
                                                                    <td>{{ ($inventory->approved_by) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Material Number</td>
                                                                    <td>{{ ($inventory->material_number) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>OEM</td>
                                                                    <td>{{ ($inventory->oem) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>OEM Part Number</td>
                                                                    <td>{{ ($inventory->oem_part_number) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Storage Location</td>
                                                                    <td>{{ ($inventory->storage_location) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Quantity</td>
                                                                    <td>{{ ($inventory->quantity_location) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Material Condition</td>
                                                                    <td>{{ ($inventory->material_condition) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

										</div>
                                        @php $rest = getWareHouse($inventory->warehouse_id); @endphp
										<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
											<!-- Card start -->
											<div class="card">
												<div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">

                                                            <tbody>
                                                                <tr>
                                                                    <td>Warehouse Name</td>
                                                                    <td>{{ ($rest->name) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Preservation Required</td>
                                                                    <td>{{ ($inventory->preservations_required) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Recommended Changes</td>
                                                                    <td>{{ ($inventory->recommended_changes) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>


                                                            <tbody>
                                                                <tr>
                                                                    <td>Short Description</td>
                                                                    <td>{{ ($inventory->short_description) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Complete Description</td>
                                                                    <td>{{ ($inventory->complete_description) ?? '' }}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td>Created On</td>
                                                                    <td>{{ $inventory->created_at ?? 'Null' }}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Modified On</td>
                                                                    <td>{{ $inventory->updated_at ?? 'Null' }}</td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->

                                        </div>
                                        {{-- <div class="row"> --}}
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            @foreach (getInventoryFile($inventory->inventory_id) as $item)
                                                <a href="{{ asset('inventory-file/'.$item->image) }}" title="" target="_blank">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12" style="margin-bottom: 5px">
                                                        <h6><small>{{ substr($item->image,0,15) }}</small>
                                                            {{-- <a href="" title="{{ 'Delete '.$item->image}}" onclick="return(confirmToDelete());">
                                                                <span class="icon-delete" style="color:red;"></span>
                                                            </a> --}}
                                                        </h6>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
{{--  --}}
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
