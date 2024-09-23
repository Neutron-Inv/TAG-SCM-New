<?php $title = 'Client Projects'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>

                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>

                <li class="breadcrumb-item">{{$client->client_name}} Projects</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
								<div class="card-title">Please fill the below form to add Project for {{ $client->client_name }} </div>
							</div>
                            <form action="{{ route('project.save') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        
                            <div class="row gutters">
                                <!-- Client Name -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nameOnCard">Client Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon6">
                                                    <i class="icon-list" style="color:#28a745"></i>
                                                </span>
                                            </div>
                                            <select class="form-control selectpicker" data-live-search="true" required name="client_id">
                                                <option data-tokens="{{ $client->client_id }}" value="{{ $client->client_id }}">
                                                    {{ $client->client_name }}
                                                </option>
                                            </select>
                                        </div>
                                        @if ($errors->has('client_id'))
                                            <div style="color:red">{{ $errors->first('client_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                        
                                <!-- Project Name -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ProjectName">Project Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="icon-user" style="color:#28a745"></i>
                                                </span>
                                            </div>
                                            <input class="form-control" name="project_name" id="ProjectName" value="{{ old('project_name') }}" required placeholder="Enter Project Name" type="text" aria-describedby="basic-addon1">
                                        </div>
                                        @if ($errors->has('project_name'))
                                            <div style="color:red">{{ $errors->first('project_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                        
                                <!-- File Upload Section -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="total_file">Upload Files</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon3">
                                                    <i class="icon-folder" style="color:#28a745"></i>
                                                </span>
                                            </div>
                                            <input type="file" class="form-control" name="document[]" id="document" multiple aria-describedby="basic-addon3">
                                        </div>
                                        @if ($errors->has('document'))
                                            <div style="color:red">{{ $errors->first('document') }}</div>
                                        @endif
                                    </div>
                        
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" align="right">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" title="Click the button to create the client contact">Add Project</button>
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
                            @if(count($project) == 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                                    </div>
                                </div>
                            @else
                                <div class="table-container">
                                    <h5 class="table-title">List of all Client Projects
                                        {{-- <a href="{{ route('contact.loading') }}" class="btn btn-primary">Upload Contact Details to user table</a> --}}
                                    </h5>

                                    <div class="table-responsive">
                                        <table id="basicExample" class="table">
                                            <thead class="bg-danger text-white">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Project Name</th>
                                                    <th>AVL</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $num =1; ?>
                                                @foreach ($project as $projects)
                                                    <tr>

                                                        <td>{{ $num }}

                                                            <a href="{{ route('project.edit',$projects->id) }}" title="Update Project" onClick="return confirm('Want to Edit Project?');">
                                                                <i class="icon-edit" style="color:blue"></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $projects->project_name ?? '' }}</td>
                                                        <td>
            @if (file_exists('document/client/' . $client->client_id . '/'. $projects->id . '/'))
                <a class="open-file-modal" data-pid="{{ $projects->id }}" data-cid="{{ $client->client_id }}" href="#">
                    {{ count(scandir('document/client/' . $client->client_id . '/'. $projects->id . '/')) - 2 }}
                </a>
            @else
                0
            @endif
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
    
<div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="fileModalBody">
                <!-- Content will be dynamically updated here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait for the document to be ready 
    $(document).ready(function() {
        // Attach a click event handler to elements with the class 'open-file-modal'
        $('.open-file-modal').on('click', function(e) {
            // Prevent the default click behavior
            e.preventDefault();
    
            // Get the value of 'pid' and 'cid' attributes from the clicked element
            var pid = $(this).data('pid');
            var cid = $(this).data('cid');
            
            // Get a reference to the modal element with the ID 'fileModal'
            var modal = $('#fileModal');
    
            // Specify the URL for the Ajax request
            var getFilesUrl = 'https://scm.tagenergygroup.net/getfile.php?source=project';
    
            // Make an Ajax request to fetch the files content from the endpoint
            $.ajax({
                url: getFilesUrl,
                type: 'POST',
                data: { 
                        p_id: pid,
                        c_id: cid
                      },
                dataType: 'json', // Specify the expected data type
                success: function(response) {
                    // Clear modal body and add the directory information
                    modal.find('.modal-body').html('');
                    modal.find('.modal-body').append('<p>Directory: ' + response.directory + '</p><ul>');
                    
                    // Iterate through the 'files' array in the response and append links with delete buttons
                    $.each(response.files, function(index, file) {
                        modal.find('.modal-body').append(
                            '<li style="display: flex; justify-content: space-between; align-items: center; word-wrap: break-word; list-style-type: disc; list-style-position: inside;">' +
                                '<a href="/' + response.directory + file + '" target="_blank" style="flex: 1; word-wrap: break-word; max-width: calc(100% - 100px); margin-right: 10px;">' + file + '</a>' +
                                '<button class="btn btn-danger btn-sm delete-file" data-file="' + file + '" data-directory="' + response.directory + '" style="white-space: nowrap;">Delete</button>' +
                            '</li>'
                        );
                    });
                    
                    modal.find('.modal-body').append('</ul>');
                },
                error: function() {
                    // Handle error if needed
                },
                complete: function() {
                    // Open the modal after content is loaded
                    modal.modal('show');
                }
            });
        });

        // Event delegation to handle delete button click
        $(document).on('click', '.delete-file', function(e) {
            e.preventDefault();

            // Get the file name and directory from the button data attributes
            var file = $(this).data('file');
            var directory = $(this).data('directory');

            // Show confirmation before deleting the file
            if (confirm('Are you sure you want to delete this file?')) {
                // Specify the URL for deleting the file
                var deleteFileUrl = 'https://scm.tagenergygroup.net/deletefile.php';

                // Make an Ajax request to delete the file
                $.ajax({
                    url: deleteFileUrl,
                    type: 'POST',
                    dataType: 'json', 
                    data: {
                        file: file,
                        directory: directory
                    },
                    success: function(response) {
                        // If the file is successfully deleted, remove the file entry from the list
                        console.log(response);
                        console.log(response.success);
                        if (response.success === true) {
                            alert('File deleted successfully.');
                            $(e.target).closest('li').remove();
                        } else {
                            alert('Failed to delete the file.');
                        }
                    },
                    error: function() {
                        alert('Error occurred while deleting the file.');
                    }
                });
            }
        });
    });
</script>
@endsection
