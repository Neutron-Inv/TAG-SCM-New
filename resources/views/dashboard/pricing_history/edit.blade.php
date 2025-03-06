<?php $title = 'Rate Vendor Pricing'; ?>
@extends('layouts.app')
<style>
    fieldset{
        border: 1px dashed #28c76f !important;
        padding: 2.5% !important;
        width: 96.6% !important;
        margin-left: 1.5% !important;
        margin-right: 1% !important;
        margin-bottom: 2% !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
    }
    
    legend {
     font-size: 18px !important;
     color:#000 !important;
     font-weight: 600;
    }
</style>
@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item"><a href="{{ route('line.preview', $rfq->rfq_id) }}">Line Items</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pricing.index', $rfq->rfq_id) }}">Pricing History</a></li>
                <li class="breadcrumb-item active">Rate Vendor's Pricing</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to Rate <b> {{ $pricing->vendor->vendor_name }} </b> on this Request<b> ({{$pricing->rfq_code}}) </b></div>
							</div>
                            <form action="{{ route('pricing.update', $pricing->id) }}" class="" method="POST">
                                {{ csrf_field() }}
                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <fieldset class="row" style="background: #ffd1d1; padding:10px;">
                                            <legend> <i class="icon-history mt-6" style="color:#000"></i> Supplier RFQ Rating </legend>
                                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Response Time</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="response_time">
                                                    <option value="">Select Ratings</option>
                                                    <option value="5" @selected($pricing->response_time == 5)>5 - Instant response (<12hrs) </option>
                                                    <option value="4" @selected($pricing->response_time == 4)>4 - 	Quick response (12-24hrs) </option>
                                                    <option value="3" @selected($pricing->response_time == 3)>3 - Could be faster (24-48hrs)</option>
                                                    <option value="2" @selected($pricing->response_time == 2)>2 - Slow response (48-72hrs)</option>
                                                    <option value="1" @selected($pricing->response_time == 1)>1 - Very slow or no response (>72hrs)</option>
												</select>
                                            </div>

                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Pricing Competitiveness</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="pricing">
                                                    <option value="">Select Ratings</option>
                                                    <option value="5" @selected($pricing->pricing == 5)>5 - Lowest cost, best value for quality.</option>
                                                    <option value="4" @selected($pricing->pricing == 4)>4 - Slightly higher but still reasonable.</option>
                                                    <option value="3" @selected($pricing->pricing == 3)>3 - Fair, could be better</option>
                                                    <option value="2" @selected($pricing->pricing == 2)>2 - Expensive, with limited justification</option>
                                                    <option value="1" @selected($pricing->pricing == 1)>1 - Overpriced, not competitive</option>
												</select>
                                            </div>

                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Conformity and Compliance</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="conformity">
                                                    <option value="">Select Ratings</option>
                                                    <option value="5" @selected($pricing->conformity == 5)>5 - 100% matches specs</option>
                                                    <option value="4" @selected($pricing->conformity == 4)>4 - Minor deviations (<5%)</option>
                                                    <option value="3" @selected($pricing->conformity == 3)>3 - Some deviations (5-10%)</option>
                                                    <option value="2" @selected($pricing->conformity == 2)>2 - Significant deviations (10-20%)</option>
                                                    <option value="1" @selected($pricing->conformity == 1)>1 - Non-compliant</option>
												</select>
                                            </div>

                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Completeness & Accuracy</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="accuracy">
                                                    <option value="">Select Ratings</option>
                                                    <option value="5" @selected($pricing->accuracy == 5)>5 - Quote includes all specs, costs, terms.</option>
                                                    <option value="4" @selected($pricing->accuracy == 4)>4 - Mostly complete, minor clarifications needed</option>
                                                    <option value="3" @selected($pricing->accuracy == 3)>3 - Acceptable but requires follow-up.</option>
                                                    <option value="2" @selected($pricing->accuracy == 2)>2 - Requires significant revision.</option>
                                                    <option value="1" @selected($pricing->accuracy == 1)>1 - Quote lacks key details or is incorrect.</option>
												</select>
                                            </div>

                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Willingness to Negotiate</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="negotiation">
                                                    <option value="">Select Ratings</option>
                                                    <option value="5" @selected($pricing->negotiation == 5)>5 - Highly flexible</option>
                                                    <option value="4" @selected($pricing->negotiation == 4)>4 - Moderately flexible</option>
                                                    <option value="3" @selected($pricing->negotiation == 3)>3 - Slightly flexible</option>
                                                    <option value="2" @selected($pricing->negotiation == 2)>2 - Not flexible</option>
                                                    <option value="1" @selected($pricing->negotiation == 1)>1 - Completely inflexible</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </fieldset>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <fieldset class="row" style="background: #d5eaf9;">
                                    <legend> <i class="icon-history mt-6" style="color:#000"></i> Quote Information and Miscellaneous </legend>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Total Quote</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" type="number" name="total_quote" step="0.01" min="0" placeholder="Enter Total Quote" value="{{ $pricing->total_quote ? $pricing->total_quote : ''}}" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Supplier Reference Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" type="text" name="reference_number" placeholder="Enter Supplier Reference Number" value="{{ $pricing->reference_number ? $pricing->reference_number : ''}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lead_time">Lead Time</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" type="text" name="lead_time" placeholder="Enter Lead Time" value="{{ $pricing->lead_time ? $pricing->lead_time : ''}}" />
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                    $counters=1;
                                    @endphp
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                        @php
                                            $misc_costs = json_decode($pricing->misc_cost, true) ?? [];
                                            if (empty($misc_costs)) {
                                                $misc_costs = [['title' => '', 'amount' => '']]; // Ensure at least one empty row
                                            }
                                        @endphp
                                    
                                        @foreach($misc_costs as $index => $misc)
                                            <div class="row gutters" id="formSet3">
                                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="misc_cost_supplier_{{ $index }}">Misc Cost Description</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control" name="misc_cost_title[]" value="{{ $misc['desc'] ?? '' }}" id="misc_cost_supplier_{{ $index }}" placeholder="Enter Misc Cost" type="text" aria-describedby="basic-addon3">
                                                    </div>
                                                </div>
                                    
                                                <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-12 form-group">
                                                    <label for="misc_amount_supplier_{{ $index }}">Misc Amount</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon3"><i class="icon-sound-mix" style="color:#28a745"></i></span>
                                                        </div>
                                                        <input class="form-control misc_amount_supplier" name="misc_cost_amount[]" value="{{ $misc['amount'] ?? '' }}" id="misc_amount_supplier_{{ $index }}" placeholder="Enter Misc Amount" type="number" step="0.01" aria-describedby="basic-addon3">
                                                    </div>
                                                </div>
                                    
                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 form-group align-self-center">
                                                    <label for="duration">.</label>
                                                    <div class="input-group">
                                                        @if ($index === 0)
                                                            <button type="button" class="btn btn-primary" id="addForm3">+</button> 
                                                        @else
                                                            <button type="button" class="btn btn-danger remove-form3">-</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    </fieldset>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <fieldset class="row" style="background: #f8f9d5;">
                                        <legend> <i class="icon-history mt-6" style="color:#000"></i>Notes to Pricing</legend>
                                        
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="general_terms">General Terms</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea id="general_terms" name="general_terms" class="form-control" placeholder="Enter General Terms (if applicable)"> {{ $pricing->general_terms ? $pricing->general_terms : ''}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="notes_to_pricing">Notes to Pricing</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea id="notes_to_pricing" name="notes_to_pricing" class="form-control" placeholder="Enter Notes to Pricing (if applicable)"> {{ $pricing->notes_to_pricing ? $pricing->notes_to_pricing : ''}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="weight">Estimated Weight</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-package" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input id="weight" class="form-control" type="text" name="weight" placeholder="Enter Estimated Weight" value="{{ $pricing->weight ? $pricing->weight : ''}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="dimension">Estimated Dimension</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-box" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input id="dimension" class="form-control" type="text" name="dimension" placeholder="Enter Estimated Dimension" value="{{ $pricing->dimension ? $pricing->dimension : ''}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="hs_code">HS Codes</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-clipboard" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input id="hs_code" class="form-control" type="text" name="hs_codes" placeholder="Enter HS Codes" value="{{ $pricing->hs_codes ? $pricing->hs_codes : ''}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="delivery_time">Delivery Time</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-clock" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input id="delivery_time" class="form-control" type="text" name="delivery_time" placeholder="Enter Estimated Time" value="{{ $pricing->delivery_time ? $pricing->delivery_time : ''}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="delivery_location">Delivery Location</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-location" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input id="delivery_location" class="form-control" type="text" name="delivery_location" placeholder="Enter Delivery Location" value="{{ $pricing->delivery_location ? $pricing->delivery_location : ''}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="payment_term">Payment Terms</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-wallet" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input id="payment_term" class="form-control" type="text" name="payment_term" placeholder="Enter Payment Terms" value="{{ $pricing->payment_term ? $pricing->payment_term : ''}}" />
                                                </div>
                                            </div>
                                        </div>

                                        
                                        </fieldset>
                                    </div>

                                    {{-- <input type="hidden" name="contact_id" value="{{$conc->contact_id}}"> --}}
                                    
                                </div>
                            
                            <div>
                                <p>Rated By: {{ $pricing->rater ? $pricing->rater->first_name . ' ' . $pricing->rater->last_name : 'Not Rated Yet' }}</p>
                            </div>
                            
                            <div>
                                <p>Final Rating for this RFQ: <span class="badge bg-label-{{rating_badge($pricing->finalRating())}} p-2">{{$pricing->finalRating() }}</span></p>
                            </div>
                            <div class="flex" align="right" style="position:absolute; right: 20; bottom: 10px;">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" title="Click the button to update the client contact">Update</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($histories) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">Pricing Request History</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Supplier Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Contact Email</th>
                                                    <th>Date Requested</th>
                                                    <th>Requested by</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($histories as $history)
                                                    <tr>
                                                        @php
                                                            $contact = getVendorContact($history->contact_id);
                                                        @endphp
                                                        <td>{{ $num }}

                                                            <a href="{{ route('pricing.edit',$history->id) }}" title="Rate Vendor Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:rgb(255, 145, 0)"></i>
                                                            </a>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                {{-- <a href="{{ route('vendor.delete',$shippers->vendor_id) }}" title="Delete Vendor Details" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a> --}}
                                                            @endif
                                                        </td>
                                                        <td>{{ $history->vendor->vendor_name ?? '' }}</td>
                                                        <td>{{ $history->vendor->contact_name ?? '' }} <br/> {{$contact->first_name.' '.$contact->last_name ?? ''}} </td>
                                                        <td>{{ $history->vendor->contact_phone ?? '' }} <br/> {{$contact->office_tel ?? ''}}</td>
                                                        <td>{{ $history->vendor->contact_email ?? '' }} <br/> {{$contact->email ?? ''}}</td>
                                                        <td>{{ date('d-M-Y H:i:s', strtotime($history->created_at)) ?? '' }} </td>
                                                        <td>{{ $history->user->first_name.' '.$history->user->last_name ?? '' }} </td>
                                                        <td>{{ $history->status ?? '' }} </td>
                                                        <td><a href="{{route('pricing.correspondence', $history->id)}}"> Correspondence </a> </td>
                                                        {{-- <td>{{ $shippers->country_code ?? '' }} </td> --}}
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

    <script>
        $(document).ready(function() {
            // Initialize the clone cou

            $("#addForm3").click(function() {
                var miscSupplier = document.getElementsByClassName("form-control misc_amount_supplier");

                var supplierCloneCount = miscSupplier.length;
                supplierCloneCount++;

                var clonedForm = $("#formSet3").clone();
                clonedForm.find('input').val('');
                clonedForm.find('input').removeAttr('required');

                // Append the clone count to input names and ids
                //clonedForm.find("[name^='misc_cost_supplier']").attr('name', 'misc_cost_supplier[' + supplierCloneCount + ']');
                clonedForm.find("[id^='misc_cost_supplier']").attr('id', 'misc_cost_supplier_' + supplierCloneCount);

                //clonedForm.find("[name^='misc_amount_supplier']").attr('name', 'misc_amount_supplier[' + supplierCloneCount + ']');
                clonedForm.find("[id^='misc_amount_supplier']").attr('id', 'misc_amount_supplier_' + supplierCloneCount);

                clonedForm.find('.btn-primary').replaceWith('<button class="btn btn-danger remove-form3" type="button">-</button>');
                $("#formSet3").after(clonedForm);
            });

            $(document).on('click', '.remove-form3', function() {
                $(this).closest('.row').remove();
            });
        });
    </script>
@endsection
