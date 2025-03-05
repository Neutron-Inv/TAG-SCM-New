<?php $title = 'Pricing History'; ?>
@extends('layouts.app')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<style type="text/css">
body{
margin-top:20px;
background:#FDFDFF
}
.badge {
border-radius: 8px;
padding: 4px 8px;
text-transform: uppercase;
font-size: .7142em;
line-height: 12px;
background-color: transparent;
border: 1px solid;
margin-bottom: 5px;
border-radius: .875rem;
}
.bg-green {
background-color: #50d38a !important;
color: #fff;
}
.bg-blush {
background-color: #ff758e !important;
color: #fff;
}
.bg-amber {
background-color: #FFC107 !important;
color: #fff;
}
.bg-red {
background-color: #ec3b57 !important;
color: #fff;
}
.bg-blue {
background-color: #60bafd !important;
color: #fff;
}
.card {
background: #fff;
margin-bottom: 30px;
transition: .5s;
border: 0;
border-radius: .1875rem;
display: inline-block;
position: relative;
width: 100%;
box-shadow: none;
}
.inbox .action_bar .delete_all {
margin-bottom: 0;
margin-top: 8px
}

.inbox .action_bar .btn,
.inbox .action_bar .search {
margin: 0
}

.inbox .mail_list .list-group-item {
border: 0;
padding: 15px;
margin-bottom: 1px
}

.inbox .mail_list .list-group-item:hover {
background: #eceeef
}

.inbox .mail_list .list-group-item .media {
margin: 0;
width: 100%
}

.inbox .mail_list .list-group-item .controls {
display: inline-block;
margin-right: 10px;
vertical-align: top;
text-align: center;
margin-top: 11px
}

.inbox .mail_list .list-group-item .controls .checkbox {
display: inline-block
}

.inbox .mail_list .list-group-item .controls .checkbox label {
margin: 0;
padding: 10px
}

.inbox .mail_list .list-group-item .controls .favourite {
margin-left: 10px
}

.inbox .mail_list .list-group-item .thumb {
display: inline-block
}

.inbox .mail_list .list-group-item .thumb img {
width: 40px
}

.inbox .mail_list .list-group-item .media-heading a {
color: #555;
font-weight: normal
}

.inbox .mail_list .list-group-item .media-heading a:hover,
.inbox .mail_list .list-group-item .media-heading a:focus {
text-decoration: none
}

.inbox .mail_list .list-group-item .media-heading time {
font-size: 13px;
margin-right: 10px
}

.inbox .mail_list .list-group-item .media-heading .badge {
margin-bottom: 0;
border-radius: 50px;
font-weight: normal
}

.inbox .mail_list .list-group-item .msg {
margin-bottom: 0px
}

.inbox .mail_list .unread {
border-left: 2px solid
}

.inbox .mail_list .unread .media-heading a {
color: #333;
font-weight: 700
}

.inbox .btn-group {
box-shadow: none
}

.inbox .bg-gray {
background: #e6e6e6
}

@media only screen and (max-width: 767px) {
.inbox .mail_list .list-group-item .controls {
    margin-top: 3px
}
}

.content-wrapper{
background: #fff;
}

#mailDetails {
    position: fixed;
    top: 0;
    right: -100%;
    width: 80%;
    height: inherit;
    background: #fff;
    border-left: 1px solid #ddd;
    transition: right 0.3s ease-in-out;
    z-index: 1000;
}

#mailDetails.active {
    right: 0;
}

#closeMailView {
    display: block;
    margin: 10px;
    padding: 5px;
    cursor: pointer;
}

.modal-body .mail-header {
    margin-bottom: 10px;
}

.mail-subject {
    font-weight: bold;
    color: #333;
}

.mail-body {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}

tr td.mail_body{
    cursor: pointer;
}

    .green-dot {
        display: inline-block;
        width: 10px;  /* Adjust size as needed */
        height: 10px;
        background-color: green;
        border-radius: 50%;
    }
</style>
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item"><a href="{{ route('line.preview', $rfq->rfq_id) }}">Line Items</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pricing.index', $rfq->rfq_id) }}">Pricing History </a></li>
                <li class="breadcrumb-item active">Pricing History Correspondence</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">@include('layouts.alert')</div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <section class="content inbox">
                        <div class="container-fluid">
                            <table id="mailTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Mail</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $num = 1 @endphp
                                    @foreach($mails as $mail)
                                    @php
                                        if($mail->read == 0){
                                            $color = "#e5e5e5";
                                            $badge = '<span class="badge bg-blue">Unread</span>';
                                            $notification = '<span class="green-dot"></span>';
                                            $bold = "strong";
                                        }else{
                                            $color = "#fff";
                                            $badge = "";
                                            $notification ='';
                                            $bold = 'span';
                                        }
                                    @endphp
                                    <tr data-mail-id="{{$mail->id}}" style="background-color:{{$color}};">
                                        <td>{{$num}} &nbsp; {!!$notification!!}</td>
                                        <td class="mail_body">
                                            <div>
                                                <{{$bold}}>{{$mail->sent_from}}</{{$bold}}> {!!$badge!!}<br>
                                                <span>{{$mail->subject}}</span><br>
                                                <small>{{substr(strip_tags($mail->body), 0, 100)}}</small>
                                            </div>
                                        </td>
                                        <td>{{date('d-M-Y H:i', strtotime($mail->date_received))}}</td>
                                        @if(Auth::user()->hasRole('SuperAdmin'))
                                        <td><a style="z-index:1200;" href="{{route('mail.delete', $mail->id)}}" onclick="return confirm('Are you Sure you want to delete this mail?')"><i class="fas fa-trash-alt" style="cursor: pointer;"></i></a></td>
                                        @endif
                                    </tr>@php $num++ @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
<style>
    #mailDetailsModal .modal-body img {
        max-width: 100%; /* Constrain the image to the modal width */
        height: auto !important;    /* Maintain aspect ratio */
    }
</style>                    
                    <!-- Mail Details Modal -->
                    <div class="modal fade bd-example-modal-lg" id="mailDetailsModal" tabindex="-1" role="dialog" aria-labelledby="mailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mailModalLabel">Mail Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mail-header">
                                        <strong id="mailSender" class="text-muted">From: example@example.com</strong><br/>
                                        <span id="mailTo" class="text-muted">To: example@example.com</span><br/>
                                        <span id="mailCc" class="text-muted">CC: example@example.com</span><br/>
                                        <span id="mailDate" class="text-muted">Date: 2024-11-12</span>
                                        <h5 id="mailSubject" class="mail-subject">Subject</h5>
                                    </div>
                                    <hr>
                                    <div id="mailBody" class="mail-body">
                                        <!-- Email body content will be populated here -->
                                        Loading mail content...
                                    </div>
                                    <hr>

                                    <!-- Reply Section -->
                                    {{-- <form action="" class="" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="reply-section">
                                            <h5>Reply to this Mail:</h5>
                                            <textarea class="summernote" name="reply" placeholder="Type your reply here...">
                                            </textarea>
                                        </div>
                                        <div class="">
                                            <label for="additional-file" class="col-form-label">Additional File</label>
                                            <input type="file" class="form-control" id="additional-file" name="additional_file[]" multiple>
                                            <input type="hidden" class="form-control" id="rfq_id" name="rfq_id" value="{{$rfq->rfq_id}}"/>
                                            <input type="hidden" class="form-control" id="pricing_id" name="pricing_id" value="{{$history->id}}"/>
                                            <input type="hidden" class="form-control" id="mail_id" name="mail_id" value=""/>
                                        </div>
                                        <br/>
                                        <button type="submit" class="btn btn-link success" id="sendReply">Send Reply</button>
                                    </form> --}}
                                </div>
                                <div class="modal-footer custom d-flex justify-content-end align-items-center">
                                    <button type="button" class="btn btn-link danger mr-3" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
$(document).ready(function() {
    $('#mailTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": [3] } // Disable ordering for the Actions column
        ]
    });

    // Event listener for row click
    $('#mailTable tbody').on('click', 'tr td.mail_body', function(event) {
        var mailId = $(this).closest('tr').data('mail-id');
        
        if (mailId) {
            // Make AJAX request to get full mail details
            $.ajax({
                url: `/api/get-mail-details/${mailId}`, 
                method: 'GET',
                success: function(response) {
                    // Populate mail details
                    $('#mailSender').text(`Sender: ${response.sent_from}`);
                    $('#mailTo').text(`To: ${response.recipient_email}`);
                    $('#mailCc').text(`Cc: ${response.cc_email}`);
                    $('#mailDate').text(`Date: ${response.date_received}`);
                    $('#mailSubject').text(`Subject: ${response.subject}`);
                    $('#mailBody').html(response.body);

                    // Show the mail details modal
                    $('#mailDetailsModal').modal('show');
                },
                error: function() {
                    alert('Error fetching mail details');
                }
            });
        }
    });
});

    </script>
    
        
@endsection
