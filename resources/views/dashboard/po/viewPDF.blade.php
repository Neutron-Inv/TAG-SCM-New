<?php

$title = "TAG Energy Quotation " .$rfq->refrence_no . ", ". $rfq->description;

?>
@extends('layouts.app')

@section('content')

<div class="main-container">

    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">SCM Dashboard</li>
            <li class="breadcrumb-item active"><a href="{{ route('rfq.downloadQuote',$po->po_id) }}">View PDF</a></li>
            @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item active"><a href="{{ route('po.edit',$po->po_id) }}">Edit PO</a></li>
                @endif
            <li class="breadcrumb-item "><a href="{{ route('po.details',$po->po_id) }}"> PO Details</a></li>
            <li class="breadcrumb-item"><a href="{{ route('po.index') }}">View PO</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rfq.edit',$po->rfq->refrence_no) }}">Edit RFQ</a></li>
            <li class="breadcrumb-item">View Quotation for PO</li>
        </ol>
        @include('layouts.logo')
    </div>


    <div class="content-wrapper">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts.alert')
                    @php 
                    $name = cops($rfq->company_id); 
                    $fileName = "Purchase Order " .$rfq->refrence_no . ", ". $rfq->product.'.pdf'; @endphp
                   <iframe src="{{asset('email/po/'.$rfq->refrence_no.'/'.$fileName) }}" width='1200' height='550' frameborder='1'> </iframe>
                </div>
            </div>
        </div>

    </div>
    
@endsection

