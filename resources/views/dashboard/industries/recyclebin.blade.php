<?php $title = 'Deleted Industries'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('industry.restore') }}">Bin</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('industry.index') }}">Industries</a></li>
                <li class="breadcrumb-item">List of Deleted Industries</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->


        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            @if(count($industry) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h6><p style="color:red" align="center"> The List is Empty </p></h6>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of deleted Industries</h5>

                                    <div class="table-responsive">
                                        <table id="fixedHeader" class="table">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Industry Name</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($industry as $industries)
                                                    <tr>

                                                        <td>{{ $num }}
                                                            <a href="{{ route('industry.undelete',$industries->industry_id) }}" class="btn btn-outline-danger"
                                                            onclick="return(confirmToRestore());" title="Restore the deleted details">
                                                                <i class="icon-delete" style=""></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $industries->industry_name }}</td>
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
