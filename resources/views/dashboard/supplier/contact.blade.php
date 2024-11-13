<?php $title = 'Supplier Contact'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                @if (auth()->user()->hasRole('SuperAdmin'))
                    <li class="breadcrumb-item active"><a href="{{ route('vcontact.index',$ven->vendor_id)}}">Supplier Contacts</a></li>
                @elseif(auth()->user()->hasRole('Client'))
                    <li class="breadcrumb-item active"><a href="{{ route('vcontact.index',$ven->email)}}">Supplier Contacts</a></li>
                @else
                @endif

                <li class="breadcrumb-item"><a href="{{ route('vendor.index') }}">View all Supplier</a></li>

                <li class="breadcrumb-item">Supplier Contact</li>
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
								<div class="card-title">Please fill the below form to add contact for {{ $ven->vendor_name }} </div>
							</div>
                            <form action="{{ route('vcontact.save') }}" class="" method="POST">
                                {{ csrf_field() }}

                                <div class="row gutters">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Supplier Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="vendor_id" style="">
                                                    <option data-tokens="{{ $ven->vendor_id }}" value="{{ $ven->vendor_id }}">
                                                        {{ $ven->vendor_name }}
                                                    </option>
												</select>
                                            </div>

                                            @if ($errors->has('client_id'))
                                                <div class="" style="color:red">{{ $errors->first('client_id') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputName">First Name</label><div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                            </div>
                                            <input class="form-control" name="first_name" id="inputName" value="{{old('first_name')}}" required placeholder="Enter First Name" type="text"
                                            aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('first_name'))
                                                <div class="" style="color:red">{{ $errors->first('first_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="last_name" value="{{old('last_name')}}" id="lastName" required placeholder="Enter Last Name" type="text"
                                                aria-describedby="basic-addon2">
                                            </div>
                                            @if ($errors->has('last_name'))
                                                <div class="" style="color:red">{{ $errors->first('last_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Job Title</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="job_title" required placeholder="Enter Job Title" type="text"
                                                value="{{old('job_title')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('job_title'))
                                                <div class="" style="color:red">{{ $errors->first('job_title') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Office Phone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="office_tel" required placeholder="Enter Office Phone" type="number" value="{{old('office_tel')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('office_tel'))
                                                <div class="" style="color:red">{{ $errors->first('office_tel') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Phone Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="mobile_tel" placeholder="Enter Phone Number" type="number" value="{{old('mobile_tel')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('mobile_tel'))
                                                <div class="" style="color:red">{{ $errors->first('mobile_tel') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label for="nameOnCard">Login Email</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="email" placeholder="Enter Email" type="email" value="{{old('email')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('email'))
                                                <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label for="nameOnCard">Other Email (Optional)</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-mail" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="email_other" placeholder="Enter  Email" type="email" value="{{old('email_other')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('email_other'))
                                                <div class="" style="color:red">{{ $errors->first('email_other') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-document-landscape" style="color:#28a745"></i></span>
                                                </div>
                                                @php
                                                $countries = getCountries();
                                                @endphp
                                                <select id="country" class="form-control selectpicker" data-live-search="true" name="country" onchange="fetchStates(this)">
                                                    <option value="">Select a country</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->name}}" data-name="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="country-error" style="color:red"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- State Dropdown -->
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-creative-commons" style="color:#28a745"></i></span>
                                                </div>
                                                <select id="state" class="form-control selectpicker" data-live-search="true" name="state" onchange="fetchCities(this)">
                                                    <option value="">Select a state</option>
                                                    <!-- State options will be populated here -->
                                                </select>
                                            </div>
                                            <div id="state-error" style="color:red"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- City Dropdown -->
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-location" style="color:#28a745"></i></span>
                                                </div>
                                                <select id="city" class="form-control selectpicker" name="city">
                                                    <option value="">Select a city</option>
                                                    <!-- City options will be populated here -->
                                                </select>
                                            </div>
                                            <div id="city-error" style="color:red"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Contact Address Field -->
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="address">Contact Address</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-my_location" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" id="address" name="address" required placeholder="Enter address"></textarea>
                                            </div>
                                            <div id="address-error" style="color:red"></div>
                                        </div>
                                    </div>
                                    

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to create the client vcontact">Add Contact Details</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($contact) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Client Contacts
                                        {{-- <a href="{{ route('vcontact.loading') }}" class="btn btn-primary">Upload Contact Details to user table</a> --}}
                                    </h5>
                                    @php
                                    if (auth()->user()->hasRole('SuperAdmin') OR auth()->user()->hasRole('Admin')){
                                    $hidden = "";
                                    }else{
                                    $hidden = "hidden";
                                    }
                                    @endphp
                                    <div class="table-responsive">
                                        <table id="basicExample" class="table">
                                            <thead class="bg-danger text-white">
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

                                                            <a href="{{ route('vcontact.edit',$contacts->contact_id) }}" title="Edit Client Contact" onclick="return confirm('Want to Edit Client Contact?');">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                {{-- <a href="{{ route('vcontact.delete',$contacts->contact_id) }}" title="Delete The Client ContactC" class="" onclick="return confirm('Want to Edit Client Contact?');">
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
    
                                    <script>
                                        // Function to populate the Country dropdown (called when page loads)
                                        function populateCountries() {
                                            $.ajax({
                                                url: '/api/countries', // Replace with your actual endpoint for countries
                                                method: 'GET',
                                                success: function(data) {
                                                    const countryDropdown = $('#country');
                                                    countryDropdown.empty(); // Clear existing options
                                                    countryDropdown.append('<option value="">Select a country</option>');
                                                    
                                                    // Loop through the countries and append them to the dropdown
                                                    data.forEach(country => {
                                                        countryDropdown.append(`<option value="${country.id}" data-name="${country.name}">${country.name}</option>`);
                                                    });
                                    
                                                    // Re-initialize the selectpicker for new options
                                                    countryDropdown.selectpicker('refresh');
                                                },
                                                error: function(error) {
                                                    console.error('Error fetching countries:', error);
                                                }
                                            });
                                        }
                                    
                                        // Function to fetch states based on selected country
                                        function fetchStates(countryElement) {
                                            const countryName = countryElement.value;
                                            const countryId = countryElement.options[countryElement.selectedIndex].getAttribute('data-name');
                                            
                                            const stateDropdown = $('#state');
                                            const cityDropdown = $('#city');
                                            stateDropdown.empty(); // Clear previous states
                                            cityDropdown.empty(); // Clear previous cities
                                            stateDropdown.append('<option value="">Select a state</option>');
                                            cityDropdown.append('<option value="">Select a city</option>');
                                    
                                            if (!countryId) return; // If no country is selected, return
                                    
                                            // Log country data (ID and Name)
                                            console.log("Selected Country ID: ", countryId);
                                            console.log("Selected Country Name: ", countryName);
                                    
                                            $.ajax({
                                                url: `/api/get-states/${countryId}`, // Replace with your actual endpoint for states
                                                method: 'GET',
                                                success: function(data) {
                                                    data.forEach(state => {
                                                        stateDropdown.append(`<option value="${state.name}" data-id="${state.id}">${state.name}</option>`);
                                                    });
                                    
                                                    // Re-initialize the selectpicker for new options
                                                    stateDropdown.selectpicker('refresh');
                                                    stateDropdown.prop('disabled', false); // Enable the state dropdown
                                                },
                                                error: function(error) {
                                                    console.error('Error fetching states:', error);
                                                }
                                            });
                                        }
                                    
                                        // Function to fetch cities based on selected state
                                        function fetchCities(stateElement) {
                                            const stateName = stateElement.value;
                                            const stateId = stateElement.options[stateElement.selectedIndex].getAttribute('data-id');
                                            const cityDropdown = $('#city');
                                            cityDropdown.empty(); // Clear previous cities
                                            cityDropdown.append('<option value="">Select a city</option>');
                                    
                                            if (!stateId) return; // If no state is selected, return
                                    
                                            $.ajax({
                                                url: `/api/get-cities/${stateId}`, // Replace with your actual endpoint for cities
                                                method: 'GET',
                                                success: function(data) {
                                                    data.forEach(city => {
                                                        cityDropdown.append(`<option value="${city.name}">${city.name}</option>`);
                                                    });
                                    
                                                    // Re-initialize the selectpicker for new options
                                                    cityDropdown.selectpicker('refresh');
                                                    cityDropdown.prop('disabled', false); // Enable the city dropdown
                                                },
                                                error: function(error) {
                                                    console.error('Error fetching cities:', error);
                                                }
                                            });
                                        }
                                    
                                    </script>

@endsection
