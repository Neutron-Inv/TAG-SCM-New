<?php $title = 'Edit Industry'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">


        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('industry.edit',$indust->industry_id) }}">Edit Industry</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('industry.index') }}">Industries</a>
                </li>

                <li class="breadcrumb-item">Editing Industry</li>

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
								<div class="card-title">Please fill the below form to update the industry details </div>
							</div>
                            <form action="{{ route('industry.update',$indust->industry_id) }}" class="" method="POST">
                                {{ csrf_field() }}
                                @include('layouts.alert')
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-6 col-sm-6 col-12">
                                        <div class="form-group"><div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="icon-home" style="color:#28a745"></i></span>
                                                </div>
                                                <input class="form-control" name="industry_name" required placeholder="Enter Industry" type="text"
                                                value="{{ $indust->industry_name }}"aria-describedby="basic-addon1">
                                            </div>

                                            @if ($errors->has('industry_name'))
                                                <div class="" style="color:red">{{ $errors->first('industry_name') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $indust->industry_id }}" name="industry_id">
                                    <input type="hidden" value="{{ $indust->industry_name }}" name="prev_name">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit" title="Click the button to update the industry">Update The Industry</button>
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
                            @if(count($industry) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Industries</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead class="bg-danger text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Industry Name</th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($industry as $industries)
                                                    <tr>

                                                        <td>{{ $num }}</td>
                                                        <td>{{ $industries->industry_name }}</td>
                                                        <td>
                                                            <a href="{{ route('industry.edit',$industries->industry_id) }}" title="Edit The Industry" class="" onclick="return(confirmToEdit());">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                            <a href="{{ route('industry.delete',$industries->industry_id) }}" title="Delete THe Industry" class="" onclick="return(confirmToDelete());">
                                                                <i class="icon-delete" style="color:red"></i>
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
