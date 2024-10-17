<?php $title = 'Edit an Inventory'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('inventory.edit',$inven->inventory_id) }}"> Edit an Inventory</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.create') }}">Create Inventory</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">View Inventories</a></li>
                <li class="breadcrumb-item">Edit inventory</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to add inventory details </div>
							</div>
                            <form action="{{ route('inventory.update',$inven->inventory_id) }}" class="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> Inventory File </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-file" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="image[]" placeholder="" type="file"
                                                multiple
                                                aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            @php
                                                $deed = getUserWareHouse(Auth::user()->user_id);
                                                $warehouse_id = $deed->warehouse_id;
                                                $rest = getWareHouse($warehouse_id);
                                            @endphp
                                            <label> Warehouse Name </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="material_number" readonly placeholder="" type="text" value="{{ $rest->name }}"
                                                aria-describedby="basic-addon1">
                                                <input type="hidden" name="warehouse_id" value="{{ $warehouse_id }}">
                                            </div>

                                            @if ($errors->has('material_number'))
                                                <div class="" style="color:red">{{ $errors->first('material_number') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> Entered By Name </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="entered_by" readonly placeholder="" type="text"
                                                value="{{ $inven->user_email ?? Auth::user()->first_name .' '. Auth::user()->last_name}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('entered_by'))
                                                <div class="" style="color:red">{{ $errors->first('entered_by') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> Approved By Name </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-user" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="approved_by" required placeholder="" type="text" value="{{  $inven->approved_by ?? old('approved_by')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('approved_by'))
                                                <div class="" style="color:red">{{ $errors->first('approved_by') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> Material Number </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="material_number" required placeholder="" type="text" value="{{  $inven->material_number ?? old('material_number')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('material_number'))
                                                <div class="" style="color:red">{{ $errors->first('material_number') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label> OEM </label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="oem" required placeholder="" type="text" value="{{  $inven->oem ?? old('oem')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('oem'))
                                                <div class="" style="color:red">{{ $errors->first('oem') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label> OEM Part Number </label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="oem_number" required placeholder="" type="text" value="{{  $inven->oem_part_number ?? old('oem_number')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('oem_number'))
                                                <div class="" style="color:red">{{ $errors->first('oem_number') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label> Storage Location </label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="storage_location" required placeholder="" type="text" value="{{  $inven->storage_location ?? old('storage_location')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('storage_location'))
                                                <div class="" style="color:red">{{ $errors->first('storage_location') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <label> Quantity in Location </label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="quantity" required placeholder="" type="number" value="{{  $inven->quantity_location ?? old('quantity')}}"
                                                aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('quantity'))
                                                <div class="" style="color:red">{{ $errors->first('quantity') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12">
                                        <label> Material Condition </label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <select class="form-control selectpicker" data-live-search="true" required name="material_condition">
                                                    <option value="{{ $inven->material_condition ?? old('material_condition') }}"> {{ $inven->material_condition ?? old('material_condition')  ??   '-- Select condition --' }}</option>
                                                    <option value=""> </option>
                                                    <option data-tokens="Fit for Purpose" value="Fit for Purpose"> Fit for Purpose</option>
                                                    <option data-tokens="Damaged" value="Damaged"> Damaged</option>
                                                    <option data-tokens="Others" value="Others"> Others</option>
												</select>
                                            </div>

                                            @if ($errors->has('material_condition'))
                                                <div class="" style="color:red">{{ $errors->first('material_condition') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label> Preservation Required </label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" name="preservation_required" required placeholder="" type="text"
                                                aria-describedby="basic-addon1"> {{  $inven->preservations_required ?? old('preservation_required') }} </textarea>
                                            </div>
                                            @if ($errors->has('preservation_required'))
                                                <div class="" style="color:red">{{ $errors->first('preservation_required') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label> Recommended  Changes </label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <textarea class="form-control" name="recommended_changes" required placeholder="" type="text" value=""
                                                aria-describedby="basic-addon1">{{ $inven->recommended_changes ?? old('recommended_changes')}} </textarea>
                                            </div>

                                            @if ($errors->has('recommended_changes'))
                                                <div class="" style="color:red">{{ $errors->first('recommended_changes') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <label> Short descriptions </label>
                                        <div class="form-group">
                                            <div class="input-group">

                                                <textarea class="form-control" name="short_description" required placeholder="" required aria-describedby="basic-addon1">{{ $inven->short_description ?? old('short_description')}} </textarea>
                                            </div>

                                            @if ($errors->has('short_description'))
                                                <div class="" style="color:red">{{ $errors->first('short_description') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <label> Complete description (full specification)</label>
                                        <div class="form-group">
                                            <div class="input-group">

                                                <textarea class="form-control" name="complete_description" required placeholder="" required aria-describedby="basic-addon1">{{ $inven->complete_description ?? old('complete_description')}} </textarea>
                                            </div>

                                            @if ($errors->has('complete_description'))
                                                <div class="" style="color:red">{{ $errors->first('complete_description') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" style="float: right" type="submit" title="Click the button to add industry">Update Inventory</button>
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
