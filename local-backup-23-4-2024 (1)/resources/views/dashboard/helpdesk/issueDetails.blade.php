<?php $title = 'Issue Details'; ?>
@extends('layouts.app')
@section('content')
  <div class="main-container">
    <div class="page-header"></div>

    <div class="content-wrapper">
      <div class="row gutters justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
          <div id="loader"></div>
          @include('layouts.alert')

          <div class="row gutters">
						<div class="col-12">
              <div class="card">
								<div class="card-header">
									<div class="card-title">Update Issue</div>
								</div>
								<div class="card-body">
                  <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      @if ($errors->any())
                        <div class="alert alert-danger alert-dismissable" style="background: red; color:white">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                           Whoops! Issue not updated
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif
											<!-- Card start -->
											<div class="card">
												<div class="card-body">
                          <div class="table-responsive">
                            <table class="table m-0">
                              <tbody>
                                <tr>
                                  <td style="width: 30%"><b>Issue/Task Submission Date</b>:</td>
                                  <td>{{$issue->created_at}}</td>
                                </tr>
                              </tbody>
                              <tbody>
                                <tr>
                                  <td><b>Issue/Task Submitted By</b>:</td>
                                  <td>{{$issue->sender_name}}</td>
                                </tr>
                              </tbody>
                              <tbody>
                                <tr>
                                  <td><b>Sender Email</b>:</td>
                                  <td>{{$issue->sender_email}}</td>
                                </tr>
                              </tbody>
                              <tbody>
                                <tr>
                                  <td><b>Issue/Task Category</b>:</td>
                                  <td>{{$issue->category}}</td>
                                </tr>
                              </tbody>
                              <tbody>
                                <tr>
                                  <td><b>Issue/Task Assigned To</b>:</td>
                                  <td>{{$issue->assigned->first_name}} {{$issue->assigned->last_name}} ({{$issue->assigned->email}})</td>
                                </tr>
                              </tbody>
                              <tbody>
                                <tr>
                                  <td><b>Issue/Task</b>:</td>
                                  <td>{!! (htmlspecialchars_decode($issue->message)) !!}</td>
                                </tr>
                              </tbody>
                              <tbody>
                                <tr>
                                  <td><b>Completion Date</b>:</td>
                                  <td>{{ \Carbon\Carbon::parse($issue->completion_time)->format('jS M, Y') ?? 'N/A'}}</td>
                                </tr>
                              </tbody>
                              <tbody>
                                <tr>
                                  <td></td>
                                  <td></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <br>
                          <form method="POST" action="{{ route('issue.update', [$issue->id]) }}" onsubmit="$('#loader').show();">
                            {{ csrf_field() }}
                            <input type="hidden" name="issue_id" value="{{$issue->id}}" />
                            <div class="row gutters">
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">                        
                                <div class="card m-0">
                                  <label for="comment">Comment:</label>
                                  <textarea class="summernote" name="comment" maxlength="2000" minlength="10">{{$issue->comment}}</textarea>
                                  {{-- <textarea class="form-control" rows="4" name="comment" maxlength="2000" minlength="10" required>{{$issue->comment}}</textarea> --}}
                                </div>
                                @if ($errors->has('comment'))
                                  <div class="" style="color:red">{{ $errors->first('comment') }}</div>
                                @endif
                                <div class="row gutters">
                                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                    <div class="form-group">
                                      <label for="status">Status:</label>
                                      <select class="form-control selectpicker" name="status">
                                        <option value="0" {{ $issue->status == '0' ? 'selected="selected"' : '' }}>Open</option>
                                        <option value="1" {{ $issue->status == '1' ? 'selected="selected"' : '' }}>Ongoing</option>
                                        <option value="2" {{ $issue->status == '2' ? 'selected="selected"' : '' }}>Completed</option>
                                        <option value="3" {{ $issue->status == '3' ? 'selected="selected"' : '' }}>Verified</option>
                                        <option value="4" {{ $issue->status == '4' ? 'selected="selected"' : '' }}>Go Live</option>
                                        <option value="5" {{ $issue->status == '5' ? 'selected="selected"' : '' }}>Resolved</option>
                                        <option value="6" {{ $issue->status == '6' ? 'selected="selected"' : '' }}>Suspended</option>
                                        <option value="7" {{ $issue->status == '7' ? 'selected="selected"' : '' }}>Closed</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                    <div class="form-group">
                                      <label for="reassign_issue">Re-assign Issue to <font color="red">(optional)</font>:</label>
                                      <select class="form-control selectpicker" name="reassign">
                                        <option value="">Select Reassignment</option>
                                        @foreach ($staffs as $staff)
                                          <option value="{{$staff->email}}">{{$staff->full_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                    <div class="form-group">
                                      <label for="priority">Priority:</label>
                                      <select class="form-control selectpicker" name="priority">
                                        <option value="Priority 1" {{ $issue->priority == 'Priority 1' ? 'selected="selected"' : '' }}>Priority 1</option>
                                        <option value="Immediate" {{ $issue->priority == 'Immediate' ? 'selected="selected"' : '' }}>Immediate</option>
                                        <option value="Urgent" {{ $issue->priority == 'Urgent' ? 'selected="selected"' : '' }}>Urgent</option>
                                        <option value="High" {{ $issue->priority == 'High' ? 'selected="selected"' : '' }}>High</option>
                                        <option value="Medium" {{ $issue->priority == 'Medium' ? 'selected="selected"' : '' }}>Medium</option>
                                        <option value="Low" {{ $issue->priority == 'Low' ? 'selected="selected"' : '' }}>Low</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                                    <div class="form-group">
                                      <label for="send_email">Send Email?</label>
                                      <div class="input-group">
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" id="customRadioInline1" value="Yes" name="send_mail" checked>
                                          <label class="custom-control-label" for="customRadioInline1">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" id="customRadioInline2" name="send_mail" value="No" >
                                          <label class="custom-control-label" for="customRadioInline2">No</label>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                    <div class="form-group">
                                      <label for="send_email">Completion Date:</label>
                                      <input type="date" class="form-control" name="completion_time" value="" />
                                    </div>
                                  </div>
                                </div><br>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                  <div class="text-right">
                                    <a class="btn btn-secondary" href="{{route('get-issues')}}"><i class="icon-reply"></i> Return to Issues</a>
                                    <button type="submit" class="btn btn-primary"><i class="icon-check"></i> Update Issue</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        
											</div>
											<!-- Card end -->
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