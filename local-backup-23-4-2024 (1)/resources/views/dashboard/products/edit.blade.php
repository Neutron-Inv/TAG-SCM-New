<?php $title = 'Edit UOM'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('product.edit',$prod->product_id) }}">Edit Product</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('product.index') }}">Products</a>
                </li>

                <li class="breadcrumb-item">Editing Product</li>

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
								<div class="card-title">Please fill the below form to update the Product details </div>
							</div>
                            <form action="{{ route('product.update',$prod->product_id) }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-6 col-sm-6 col-12">
                                        <div class="form-group"><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="product_name" required placeholder="Enter Product name" type="text"
                                                value="{{ $prod->product_name }}"aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('product_name'))
                                                <div class="" style="color:red">{{ $errors->first('product_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $prod->product_id }}" name="unit_id">
                                    <input type="hidden" value="{{ $prod->product_name }}" name="prev_name">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit" title="Click the button to update the Product">Update The Product</button>
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
                            @if(count($product) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Products</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-warning text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Product Name</th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($product as $products)
                                                    <tr>

                                                        <td>{{ $num }}</td>
                                                        <td>{{ $products->product_name }}</td>
                                                        <td>
                                                            <a href="{{ route('product.edit',$products->product_id) }}" title="Edit The Product" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            {{-- <a href="{{ route('unit.delete',$products->product_id) }}" title="Delete THe Product" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
                                                            </a> --}}
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
