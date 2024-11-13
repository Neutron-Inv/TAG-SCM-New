<?php $title = 'Edit A Supplier'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('vendor.edit',$ven->vendor_id) }}">Edit a Supplier</a></li>
                <li class="breadcrumb-item"><a href="{{ route('vendor.index') }}">Add a Supplier</a></li>

                <li class="breadcrumb-item">Edit a Supplier</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <div class="card-title">Please fill the below form to update the supplier details </div>
                            </div>
                            <form action="{{ route('vendor.update',$ven->vendor_id) }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Company Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="company_id">
                                                    @if (Gate::allows('SuperAdmin', auth()->user()))
                                                        <option data-tokens="{{ $ven->company->company_id }}" value="{{ $ven->company->company_id }}">
                                                            {{ $ven->company->company_name }}
                                                        </option>
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
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Supplier Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="vendor_name" required placeholder="Enter Supplier Name" type="text"
                                                value="{{ $ven->vendor_name ?? ''}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('supplier_name'))
                                                <div class="" style="color:red">{{ $errors->first('vendor_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Supplier Code</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-add-to-list" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="vendor_code" required placeholder="Enter Supplier Code" type="text"
                                                value="{{  $ven->vendor_code ?? old('vendor_code')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('vendor_code'))
                                                <div class="" style="color:red">{{ $errors->first('vendor_code') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="eMail">Category</label><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-edit" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="industry_id">
                                                    <option data-tokens="{{ $ven->industry_id }}" value="{{ $ven->industry_id }}">{{ $ven->industry->industry_name ?? '' }}</option>
                                                    @foreach ($industry as $industries)
                                                        <option data-tokens="{{ $industries->industry_id  }}" value="{{ $industries->industry_id }}">{{ $industries->industry_name ?? '' }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            @if ($errors->has('category'))
                                                <div class="" style="color:red">{{ $errors->first('category') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Contact Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="contact_name" required placeholder="Enter Name" type="text" value="{{ $ven->contact_name ?? ''}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('contact_name'))
                                                <div class="" style="color:red">{{ $errors->first('contact_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Contact Phone Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-phone" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="contact_phone" placeholder="Enter Phone" type="text" value="{{ $ven->contact_phone ?? '' }}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('contact_phone'))
                                                <div class="" style="color:red">{{ $errors->first('contact_phone') }}</div>
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
                                                <input class="form-control" name="contact_email" placeholder="Enter Email" type="email" value="{{ $ven->contact_email ?? '' }}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('contact_email'))
                                                <div class="" style="color:red">{{ $errors->first('contact_email') }}</div>
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
                                        <select class="form-control selectpicker" data-live-search="true" name="country_code">
                                            <option value="{{ $ven->country_code ?? old('country_code') }}">{{ $ven->country_code ?? old('country_code') }}</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->name}}" data-name="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    @if ($errors->has('country_code'))
                                                <div class="" style="color:red">{{ $errors->first('tamap') }}</div>
                                            @endif
                                </div>
                            </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Tamap</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-edit" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="tamap">
                                                    <option data-tokens="{{ $ven->tamap }}" value="{{ $ven->tamap }}">{{ $ven->tamap ?? '' }}</option>
                                                    <option value=""> </option>
                                                    <option value="No"> No </option>
                                                    <option value="Yes"> Yes </option>
                                                </select>

                                            </div>

                                            @if ($errors->has('tamap'))
                                                <div class="" style="color:red">{{ $errors->first('tamap') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Agency Letter</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-edit" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="agency">
                                                    <option data-tokens="{{ $ven->agency }}" value="{{ $ven->agency }}">{{ $ven->agency ?? '' }}</option>
                                                    <option value=""> </option>
                                                    <option value="No"> No </option>
                                                    <option value="Yes"> Yes </option>
                                                </select>

                                            </div>

                                            @if ($errors->has('agency'))
                                                <div class="" style="color:red">{{ $errors->first('agency') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Supplier Description</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-list" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" id="nameOnCard" name="description" required placeholder="Enter description">{{ $ven->description ?? '' }}</textarea>
                                            </div>

                                            @if ($errors->has('description'))
                                                <div class="" style="color:red">{{ $errors->first('description') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nameOnCard">Supplier Address</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6"><i class="icon-my_location" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" id="nameOnCard" name="address" required placeholder="Enter address">{{ $ven->address ?? '' }}</textarea>
                                            </div>

                                            @if ($errors->has('address'))
                                                <div class="" style="color:red">{{ $errors->first('address') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="company_name">Products</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon6">
                                                        <i class="icon-home" style="color:#28a745"></i>
                                                    </span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" 
                                                                                        data-actions-box="true" 
                                                                                        data-deselect-all-text="Deselect All" 
                                                                                        data-live-search-placeholder="Search products..."  multiple required name="product[]">
                                                    <option value="">-- Select Products --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12" align="right">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" title="Click the button to update the Supplier details">Update a Supplier Details</button>
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
                            @if(count($vendor) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    @if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')))
                                        <h5 class="table-title">List of all Suppliers</h5>
                                    @else
                                        <h5 class="table-title">My Details</h5>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-danger text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Company Name</th>
                                                    <th>Supplier Name</th>
                                                    <th>Supplier Code</th>
                                                    <th>Industry</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Phone</th>
                                                    <th>Contact Email</th>
                                                    <th>Desc</th>
                                                    <th>Tamap</th>
                                                    <th>Agency Letter</th>
                                                    <th>Address</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($vendor as $shippers)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            <a href="{{ route('vendor.edit',$shippers->vendor_id) }}" title="Edit Vendor Details" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            @if (Gate::allows('SuperAdmin', auth()->user()))
                                                                <a href="{{ route('vendor.delete',$shippers->vendor_id) }}" title="Delete Vendor Details" class="" onclick="return(confirmToDelete());">
                                                                    <i class="icon-delete" style="color:red"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $shippers->company->company_name ?? '' }}</td>
                                                        <td>{{ $shippers->vendor_name ?? '' }} </td>
                                                        <td>{{ $shippers->vendor_code ?? '' }} </td>
                                                        <td>{{ $shippers->industry->industry_name ?? '' }} </td>
                                                        <td>{{ $shippers->contact_name ?? '' }} </td>
                                                        <td>{{ $shippers->contact_phone ?? '' }} </td>
                                                        <td>{{ $shippers->contact_email ?? '' }} </td>
                                                        <td>
                                                            <a href="" data-toggle="modal" data-target=".bd-example-modal-lx-{{ $num }}">
                                                                {{ substr($shippers->description, 0, 30) ?? 'N/A' }}
                                                            </a>

                                                            <div class="modal fade bd-example-modal-lx-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lx-{{ $num }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="myLargeModalLabel-{{ $num }}">{{ $shippers->vendor_name ?? '' }} Description</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ $shippers->description ?? '' }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>{{ $shippers->tamap ?? '' }} </td>
                                                        <td>{{ $shippers->agency ?? '' }} </td>
                                                        <td>
                                                            <a href="" data-toggle="modal" data-target=".bd-example-modals-lx-{{ $num }}">
                                                                {{ substr($shippers->address, 0, 30) ?? 'N/A' }}
                                                            </a>

                                                            <div class="modal fade bd-example-modals-lx-{{ $num }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-{{ $num }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lx-{{ $num }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-success">
                                                                            <h5 class="modal-title" id="myLargeModalLabel-{{ $num }}">{{ $shippers->vendor_name ?? '' }} Address</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ $shippers->address ?? '' }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>

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
    
        let selectedProducts = @json($ven->products);

        // Once the product options are loaded (for example after an AJAX call)
        // Loop through each option and mark as selected if it's in the selectedProducts array
        function setSelectedProducts() {
            let productSelect = document.querySelector("select[name='product[]']");

            Array.from(productSelect.options).forEach(option => {
                if (selectedProducts.includes(option.value)) {
                    option.selected = true;
                }
            });

            // Refresh the selectpicker (if using Bootstrap Select)
            $('.selectpicker').selectpicker('refresh');
        }

        // Call the function after the select options are populated
        // If options are loaded dynamically, call this function after your AJAX completes
        setSelectedProducts();
        
    // Function to fetch products based on the selected company
    function fetchProducts(companyId) {
        if (companyId) {
            $.ajax({
                url: `/get-company-product/${companyId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let productDropdown = $('select[name="product[]"]');
                    productDropdown.empty();
                    //productDropdown.append('<option value="">-- Select Products --</option>');
                    
                    $.each(data, function(index, product) {
                        productDropdown.append(`<option value="${product.product_name}">${product.product_name}</option>`);
                    });
                    
                    productDropdown.selectpicker('refresh'); // Refresh the selectpicker UI
                    setSelectedProducts();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching products:', error);
                }
            });
        } else {
            $('select[name="product[]"]').empty().append('<option value="">-- Select Products --</option>').selectpicker('refresh');
            setSelectedProducts();
        }
    }

    // Fetch products on initial page load based on the selected company
    let initialCompanyId = $('select[name="company_id"]').val();
    fetchProducts(initialCompanyId);

    // Fetch products dynamically when the company selection changes
    $('select[name="company_id"]').on('change', function() {
        let companyId = $(this).val();
        fetchProducts(companyId);
    });
});
</script>

@endsection
