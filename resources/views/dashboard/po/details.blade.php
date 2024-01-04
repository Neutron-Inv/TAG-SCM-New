<?php $title = 'Purchase Order Details'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('po.details',$details->po_id) }}"> PO Details</a></li>
                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD'))  OR(Auth::user()->hasRole('Admin')) OR (Gate::allows('SuperAdmin', auth()->user())))
                    <li class="breadcrumb-item"><a href="{{ route('po.edit',$details->po_id) }}">Edit PO Details</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ route('po.index') }}">View All PO</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.edit',$details->rfq->refrence_no) }}">Edit RFQ</a></li>
                <li class="breadcrumb-item">PO Details</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="row gutters">
						<div class="col-12">
                            @include('layouts.alert')
							<!-- Card start -->
							<div class="card">
								<div class="card-header">
									<div class="card-title">Purchase Order Details
								</div>
								<div class="card-body">

									<!-- Row start -->
									<div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

											<!-- Card start -->
											<div class="card">
												<div class="card-body">

                                                    <div class="table-responsive">

                                                        <table class="table m-0">


                                                            <tbody>
                                                                <tr>
                                                                    <td>Status</td>
                                                                    <td><span class="badge badge-pill badge-secondary"> {{ $details->status ?? '' }} </span></td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Client</td>
                                                                    <td>{{ $details->client->client_name ?? 'Null' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>RFQ Ref No</td>
                                                                    <td>{{ $details->rfq->refrence_no ?? "" }}</td>

                                                                </tr>
                                                                 <tr>
                                                                    <td>Supplier Ref Number</td>
                                                                    <td>{{ $details->supplier_ref_number ?? "" }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>PO Number</td>
                                                                    <td>{{ $details->po_number ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Product</td>
                                                                    <td>{{ $details->rfq->product ?? '' }}</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Decription</td>
                                                                    <td>{{ $details->description ?? '' }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Buyer </td>
                                                                    <td>{{ $details->rfq->client->client_name ?? '' }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Supplier </td>
                                                                    <td>{{ $details->rfq->vendor->vendor_name ?? '' }}</td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Assigned To</td>
                                                                    <td>{{ $details->rfq->employee->full_name ?? '' }}</td>

                                                                </tr>


                                                            </tbody>

                                                        </table>
                                                    </div>
												</div>
											</div>
											<!-- Card end -->
                            <hr style="margin-top: 20px; margin-botton:20px;">
										</div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row gutters">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" >
                                            <b>PO Note:</b>
                                            <div style="max-height: 500px; overflow-y: auto;">
                                            <p style="text-justify"> {!! $details->note !!} </p>
                                            </div>
                                        </div>

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <b>RFQ Note:  </b>
                                        <div style="max-height: 500px; overflow-y: auto;">
                                            <p style="text-justify">{!! $details->rfq->note !!} </p>
                                                </div>
                                                </div>
                                                <hr style="margin-top: 20px; margin-botton:20px;">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <p style="text-justify"><b>Tag Comment:  </b>{!! $details->tag_comment !!} </p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <p style="text-justify">
                                               <style>
                                                .file-table {
                                                    width: 100%;
                                                    border-collapse: collapse;
                                                    margin-top: 20px;
                                                    max-height: 300px;
                                                    overflow-y: auto;
                                                }
                                            
                                                .file-table th, .file-table td {
                                                    border: 1px solid #ddd;
                                                    padding: 8px;
                                                    text-align: left;
                                                }
                                            
                                                .file-table th {
                                                    background-color: #f2f2f2; /* Striped table header */
                                                }
                                            
                                                .file-menu {
                                                    position: relative;
                                                    display: inline-block;
                                                }
                                            
                                                .file-menu-content {
                                                    display: none;
                                                    position: absolute;
                                                    background-color: #f9f9f9;
                                                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                                                    z-index: 1;
                                                    padding: 10px;
                                                    min-width: 150px;
                                                }
                                            
                                                .file-menu:hover .file-menu-content,
                                                .file-menu.active .file-menu-content {
                                                    display: block;
                                                }
                                            </style>
                                            
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const fileMenus = document.querySelectorAll('.file-menu');
                                            
                                                    fileMenus.forEach(fileMenu => {
                                                        fileMenu.addEventListener('click', function() {
                                                            this.classList.toggle('active');
                                                        });
                                            
                                                        document.addEventListener('click', function(event) {
                                                            if (!fileMenu.contains(event.target)) {
                                                                fileMenu.classList.remove('active');
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                            
                                            @if (file_exists('document/po/'.$details->po_id.'/'))
                                                <table class="table" id="fixedHeader">
                                            <h3>Files</h3>
                                                    <thead>
                                                        <tr>
                                                            <th>File Name</th>
                                                            <th>Date Created</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $dir = 'document/po/'.$details->po_id.'/';
                                                        $files = scandir($dir);
                                                        $total = count($files) - 2;
                                            
                                                        if (is_dir($dir) && $total > 0) {
                                                            if ($opendirectory = opendir($dir)) {
                                                                while (($file = readdir($opendirectory)) !== false) {
                                                                    $len = strlen($file);
                                            
                                                                    if ($len > 2) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>{{ substr($file, 0, 40) }}</td>
                                                                            <td>{{ date("Y-m-d H:i:s", filectime($dir . $file)) }}</td>
                                                                            <td class="file-menu">
                                                                                    <a href="{{ asset('document/po/'.$details->po_id.'/'.$file) }}" target="_blank">View</a> &nbsp | &nbsp
                                                                                    <a href="{{ route('remove.po.file', [$details->po_id, $file]) }}" title="{{ 'Delete '.$file }}" onclick="return(confirmToDeleteFile());">Delete</a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                closedir($opendirectory);
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='3'>No files available.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            @else
                                                No files available.
                                            @endif
                                            </p>
                                        </div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
