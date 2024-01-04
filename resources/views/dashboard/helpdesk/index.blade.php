<?php $title = 'Help Desk'; ?>
@extends('layouts.app')
@section('content')

  <div class="main-container">

    <div class="page-header"></div>

    <div class="content-wrapper">
      <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          @include('layouts.alert')
          <div class="table-container">
            <h5 class="table-title">Issues List <a class="btn btn-primary float-right" href="{{route('get-issue-create-page')}}"><i class="icon-plus"></i> Create Issue</a></h5>
            <div class="table-responsive">
              <table id="fixedHeader" class="table m-0" style="width:100%">
                <thead>
                  <tr>
                    <th>S/N</th>@php($i=0)
                    <th>Submitted By</th>
                    <th>Assigned To</th>
                    <th>Category</th>
                    <th>Issue/Task</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Creation Date</th>
                    <th>Completion Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($issues as $issue)
                    <tr>
                      <td>{{++$i}}</td>
                      <td>{{$issue->sender_name}}</td>
                      <td>{{$issue->assigned->first_name}} {{strtoupper($issue->assigned->last_name)}}</td>
                      <td>{{$issue->category}}</td>
                      <td>{!! substr((htmlspecialchars_decode($issue->message)), 0,50) !!}...</td>
                      <td><b>{{$issue->priority}}</b></td>
                      <td>
                        @if($issue->status == '0')
                          <span class="badge badge-pill badge-danger"> Open </span>
                        @elseif($issue->status == '1')
                          <span class="badge badge-pill badge-primary"> Ongoing </span>
                        @elseif($issue->status == '2')
                          <span class="badge badge-pill badge-warning"> Completed </span>
                        @elseif($issue->status == '3')
                          <span class="badge badge-pill badge-info"> Verified </span>
                        @elseif($issue->status == '4')
                          <span class="badge badge-pill badge-white"> Go Live </span>
                        @elseif($issue->status == '5')
                          <span class="badge badge-pill badge-gray"> Resolved </span>
                        @elseif($issue->status == '6')
                          <span class="badge badge-pill badge-secondary"> Suspended </span>
                        @elseif($issue->status == '7')
                          <span class="badge badge-pill badge-success"> Closed </span>
                        @else
                          <span class="badge badge-pill badge-success"> Not Available </span>
                        @endif
                      </td>
                      <td>{{$issue->created_at}}</td>
                      <td>{{ \Carbon\Carbon::parse($issue->completion_time)->format('jS M, Y') ?? 'N/A'}}</td>
                      <td><a href="{{route('get-issue-details', [$issue->id])}}" style="color: blue"><i class="icon-pencil"></i> View</a> | <a href="javascript:void(0);" onclick="setValue({{$issue->id}})" data-toggle="modal" data-target="#trashModal"><i class="icon-trash" style="color: red" title="Trash Issue"></i></a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="trashModal" tabindex="-1" role="dialog" aria-labelledby="customModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="customModalLabel">Delete Issue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form method="POST" action="{{ route('issue.delete')}}" onsubmit="$('#loader').show();">
              {{-- {!! method_field('delete') !!}   --}}
              {!! csrf_field() !!}
              <div class="modal-body">
                <div class="text-center">
                  <p id="trasher"></p>
                  <input type="hidden" name="issue_id" id="trash">
                </div>
              </div>
              <div class="modal-footer custom">
                <div class="left-side">
                <button type="button" class="btn btn-link danger" data-dismiss="modal">Cancel</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                <button type="submit" class="btn btn-link success">Yes, Delete</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection

@stack('scripts')
<script>
  function setValue(id) {
    $("#trasher").html("Are you sure you want to DELETE this issue?");
    $("#trash").val(id);
  }
</script>
