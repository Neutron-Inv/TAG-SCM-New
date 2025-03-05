<?php $title = 'Clients'; ?>
@extends('layouts.app')
<?php
if(Auth::user()->hasRole('SuperAdmin')){
    $hidden = "";
}else{
    $hidden = "hidden";
}
?>

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">View Client</a></li>

                {{-- @if (Gate::allows('SuperAdmin', auth()->user()))
                    <li class="breadcrumb-item"><a href="{{ route('client.restore') }}">Bin</a></li>
                @endif --}}

                <li class="breadcrumb-item"> List of Clients</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                </div>
                @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Employer')))
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <div class="card-title">Please fill the below form to add client details </div>
                                </div>
                                <form action="{{ route('client.save') }}" class="" method="POST"  enctype="multipart/form-data">
                                    {{ csrf_field() }}
                            
                                    <div class="row gutters">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12" {{ $hidden }}>
                                            <div class="form-group">
                                                <label for="nameOnCard">Company Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <select class="form-control selectpicker" data-live-search="true" required name="company_id">
                                                        @if (Gate::allows('SuperAdmin', auth()->user()))
                                                            <option value="">Select Company</option>
                                                            @foreach ($company as $companies)
                                                                <option data-tokens="{{ $companies->company_id }}" value="{{ $companies->company_id }}">
                                                                    {{ $companies->company_name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option data-tokens="{{ $company->company_id }}" value="{{ $company->company_id }}">
                                                                {{ $company->company_name }}
                                                            </option>
                                                        @endif

                                                    </select>
                                                </div>

                                                @if ($errors->has('company_id'))
                                                    <div class="" style="color:red">{{ $errors->first('company_id') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Company Vendor Code</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="company_vendor_code" required placeholder="Enter Company Vendor Code" type="text"
                                                    value="{{old('company_vendor_code')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('company_vendor_code'))
                                                    <div class="" style="color:red">{{ $errors->first('company_vendor_code') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Client Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="client_name" required placeholder="Enter Client Name" type="text"
                                                    value="{{old('client_name')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('client_name'))
                                                    <div class="" style="color:red">{{ $errors->first('client_name') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Short Code</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="short_code" required placeholder="Enter Code" type="text"
                                                    value="{{ old('short_code') }}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('short_code'))
                                                    <div class="" style="color:red">{{ $errors->first('short_code') }}</div>
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
                                                    <input class="form-control" name="phone" required placeholder="Enter Phone" type="number" value="{{old('phone')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('phone'))
                                                    <div class="" style="color:red">{{ $errors->first('phone') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <label for="nameOnCard">Email</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-mail" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="email" required placeholder="Enter Email" type="email" value="{{old('email')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('email'))
                                                    <div class="" style="color:red">{{ $errors->first('email') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Country</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-document-landscape" style="color:#28a745"></i></span>
                                                    </div>
                                                    
                                                    @php
                                                    $countries = getCountries();
                                                    @endphp
                                                    <select id="country" class="form-control selectpicker" data-live-search="true" name="country_code" onchange="fetchStates(this)">
                                                        <option value="">Select a country</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{$country->name}}" data-name="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                @if ($errors->has('country_code'))
                                                    <div class="" style="color:red">{{ $errors->first('country_code') }}</div>
                                                @endif

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
                                        
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">URL</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="login_url" placeholder="Enter URL" type="url"
                                                    value="{{old('login_url')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('login_url'))
                                                    <div class="" style="color:red">{{ $errors->first('login_url') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12" {{$hidden}}>
                                            <div class="form-group">
                                                <label for="nameOnCard">Vendor Username</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="vendor_username" placeholder="Enter Vendor Username" type="text"
                                                    value="{{old('vendor_username')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('vendor_username'))
                                                    <div class="" style="color:red">{{ $errors->first('vendor_username') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12" {{$hidden}}>
                                            <div class="form-group">
                                                <label for="nameOnCard">Vendor Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="vendor_password" placeholder="Enter Vendor Password" type="text"
                                                    value="{{old('vendor_password')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('vendor_password'))
                                                    <div class="" style="color:red">{{ $errors->first('vendor_password') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Client Files</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                    </div>
                                                    <input class="form-control" name="client_file[]" multiple placeholder="Enter Vendor Password" type="file"
                                                    value="{{old('file')}}"
                                                    aria-describedby="basic-addon1">
                                                </div>

                                                @if ($errors->has('file'))
                                                    <div class="" style="color:red">{{ $errors->first('file') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="nameOnCard">Client Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon6"><i class="icon-my_location" style="color:#28a745"></i></span>
                                                    </div>
                                                    <textarea class="form-control" id="nameOnCard" name="address" required placeholder="Enter address">{{ old('address') }}</textarea>
                                                </div>

                                                @if ($errors->has('address'))
                                                    <div class="" style="color:red">{{ $errors->first('address') }}</div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit">Add Client Details</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($client) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Clients
                                    {{-- <a href="{{ route('client.load') }}" class="btn btn-primary">Upload Client Details to user table</a></h5> --}}
                                    <div class="table-responsive">
                                        <table id="basicExample" class="table">
                                            <thead class="bg-danger text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company</th>
                                                    <th> Company Vendor Code </th>
                                                    <th>Client Name</th>
                                                    <th>Short Code</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th> Contact(s) </th>
                                                    <th> RFQ(s) </th>
                                                    <th>PO(s) </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($client as $clients)
                                                    <tr>

                                                        <td>{{ $num }}


                                                            @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))

                                                                <a href="{{ route('client.edit',$clients->client_id) }}" title="Edit Client"class="" title="Edit The CLient" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                                <a href="{{ route('contact.index',$clients->client_id) }}" title="View or Create Client Contact" class="" title="Client Contact" onclick="return(());">
                                                                    <i class="icon-user" style="color:green"></i>
                                                                </a>

                                                                <a href="{{ route('report.index',$clients->client_id) }}" title="Client Report" class="" onclick="return(());">
                                                                    <i class="icon-layers" style="color:orange"></i>
                                                                </a>

                                                            @endif
                                                            @if(Auth::user()->hasPermissionTo('Edit Client'))
                                                                <a href="{{ route('client.edit',$clients->client_id) }}" title="Edit Client"class="" title="Edit The CLient" onclick="return(confirmToEdit());">
                                                                    <i class="icon-edit" style="color:blue"></i>
                                                                </a>
                                                                <a href="{{ route('contact.index',$clients->client_id) }}" title="View or Create Client Contact" class="" title="Client Contact" onclick="return(());">
                                                                    <i class="icon-user" style="color:green"></i>
                                                                </a>
                                                            @endif
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                {{-- <a href="{{ route('client.delete',$clients->client_id) }}" title="Delete The Client" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a> --}}
                                                            @endif

                                                            <a href="{{ route('rfq.create',$clients->client_id) }}" title="Create Client RFQ" class="text-nowrap" onclick="return(confirmToRFQ());">
                                                                <i class="icon-book" style="color:#6610f2"></i> Create RFQ
                                                            </a><br>
                                                            <a href="{{ route('client.details',$clients->client_id) }}" title="View Client" class="">
                                                                <i class="icon-list" style="color:#6610f2"></i> View
                                                            </a><br>
                                                            <a href="{{ route('client.projects',$clients->client_id) }}" title="View Projects" class="">
                                                                <i class="icon-list" style="color:#9510f2"></i> Projects
                                                            </a>


                                                        </td>
                                                        <td>{{ $clients->company->company_name ?? '' }}</td>
                                                        <td>{{ $clients->company_vendor_code ?? '' }} </td>
                                                        <td>{{ $clients->client_name ?? '' }} </td>
                                                        <td>{{ $clients->short_code ?? '' }} </td>
                                                        <td>{{ $clients->email ?? '' }} </td>
                                                        <td>{{ $clients->phone ?? '' }} </td>

                                                        <td>
                                                            <?php echo $co = countContact($clients->client_id) ?>

                                                        </td>
                                                        <td>  <?php echo $co = countClientRFQ($clients->client_id) ?> </td>
                                                        <td>  <?php echo $co = countClientPO($clients->client_id) ?> </td>

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
