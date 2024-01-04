<?php $title = 'Warehouse'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('warehouse.edit',$ware->warehouse_id) }}">Edit Warehouse</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('warehouse.index') }}">Warehouse</a></li>

                <li class="breadcrumb-item">Edit a Warehouse</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to update the warehouse details </div>
							</div>
                            <form action="{{ route('warehouse.update',$ware->warehouse_id) }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="name" required placeholder="Enter Warehouse Name" type="text" value="{{ $ware->name ?? old('name')}}"
                                                aria-describedby="basic-addon1">
                                            </div>
                                            <input type="hidden" name="prev_name"  value="{{ $ware->name }}">

                                            @if ($errors->has('name'))
                                                <div class="" style="color:red">{{ $errors->first('name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit" title="Click the button to add industry">Update The Warehouse</button>
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
                            @if(count($warehouse) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Warehouses</h5>

                                    <div class="table-responsive">
                                        <table id="basicExample" class="table">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Warehouse Name</th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($warehouse as $warehouses)
                                                    <tr>

                                                        <td>{{ $num }}</td>
                                                        <td>{{ $warehouses->name }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('warehouse.edit',$warehouses->warehouse_id) }}" title="Edit The Warehouse" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            <a href="{{ route('warehouse.delete',$warehouses->warehouse_id) }}" title="Delete THe Warehouse" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a>
                                                            <a href="{{ route('warehouse.inventory',$warehouses->warehouse_id) }}" title="Warehouse Inventory" class="">
                                                                <i class="icon-shopping-cart" style="color:green"></i>
                                                            </a>
                                                            <a href="{{ route('warehouse.users',$warehouses->warehouse_id) }}" title="Warehouse Staff" class="">
                                                                <i class="icon-users" style="color: orange"></i>
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
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
