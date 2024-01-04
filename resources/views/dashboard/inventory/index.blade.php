<?php $title = ' Inventories'; ?>
@extends('layouts.app')

@section('content')
    <div class="main-container">

        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('inventory.index') }}">View Inventories</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.create') }}">Create Inventory</a></li>

                <li class="breadcrumb-item">view list if Inventories</li>
            </ol>
            @include('layouts.logo')
        </div>

        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @if(count($inventory) == 0)
                        <div class="card">
                            <div class="card-body">
                                <h4><p style="color:red" align="center"> The List is Empty </p></h4>
                            </div>
                        </div>
                    @else
                        <div class="table-container">
                            <h5 class="table-title">
                                @if(AUth::user()->hasRole('Warehouse User'))
                                    List of all Inventories for {{ $rest->name }}
                                @else

                                @endif
                            </h5>

                            <div class="table-responsive">
                                <table id="fixedHeader" class="table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>S/N</th>
                                            <th>Material Number </th>
                                            <th> OEM </th>
                                            <th> OEM Part Number</th>
                                            <th> Storage Location </th>
                                            <th> Quantity </th>
                                            <th> Material Condition </th>
                                            <th> Entered By </th>
                                            <th> Approved By </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num =1; ?>
                                        @foreach ($inventory as $inventories)
                                            <tr>

                                                <td>{{ $num }}</td>
                                                <td>{{ $inventories->material_number ?? '' }}</td>
                                                <td>{{ $inventories->oem ?? '' }}</td>
                                                <td>{{ $inventories->oem_part_number ?? '' }}</td>
                                                <td>{{ $inventories->storage_location ?? '' }}</td>
                                                <td>{{ $inventories->quantity_location ?? '' }}</td>
                                                <td>{{ $inventories->material_condition ?? '' }}</td>
                                                <td>
                                                    {{ $inventories->user_email ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $inventories->approved_by ?? '' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('inventory.edit',$inventories->inventory_id) }}" title="Edit The Inventory" class="" onclick="return(confirmToEdit());">
                                                        <i class="icon-edit" style="color:blue"></i>
                                                    </a>

                                                    {{-- <a href="{{ route('inventory.delete',$inventories->inventory_id) }}" title="View The Inventory" class="">
                                                        <i class="icon-delete" style="color:red"></i>
                                                    </a> --}}

                                                    <a href="{{ route('inventory.details',$inventories->inventory_id) }}" title="View The Inventory" class="">
                                                        <i class="icon-list" style="color:green"></i>
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
@endsection
