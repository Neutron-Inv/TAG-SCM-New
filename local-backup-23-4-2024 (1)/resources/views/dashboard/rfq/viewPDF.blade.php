<?php

$title = "TAG Energy Quotation " .$rfq->refrence_no . ", ". $rfq->description;

?>
@extends('layouts.app')

@section('content')

<div class="main-container">

    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">SCM Dashboard</li>
            <li class="breadcrumb-item active"><a href="{{ route('rfq.downloadQuote',$rfq->rfq_id) }}">View PDF</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View All RFQ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('line.preview', $rfq->rfq_id) }}">View Line Items</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rfq.price', $rfq->refrence_no) }}"> Price Quotation</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rfq.edit', $rfq->refrence_no) }}">Edit RFQ </a></li>
            <li class="breadcrumb-item">View Price Quotation for RFQ</li>
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
                    $fileName = "$name->company_name Quotation " .$rfq->refrence_no . ", ". $rfq->description.'.pdf'; @endphp
                   <iframe src="{{asset('email/rfq/'.$rfq->refrence_no.'/'.$fileName) }}" width='1200' height='550' frameborder='1'> </iframe>
                </div>
            </div>
        </div>

    </div>
    
@endsection

