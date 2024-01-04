<?php $title = 'RFQ Supplier Charts'; ?>
@extends('layouts.app')
@include('layouts.fussion-chart')
@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.chart.company') }}">Company RFQ Charts</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rfq.index') }}">View All RFQ</a></li>
                <li class="breadcrumb-item">RFQ Charts</li>
            </ol>
            @include('layouts.logo')
        </div>
        <!-- Page header end -->
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('layouts.alert')
                    <div class="row gutters">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><?php
                            $arrChartConfig = array(
                                "chart" => array(
                                    "caption" => strtoupper("SCM Companies RFQ Chart"),
                                    "subCaption" => "Powered by Enabled Solution",
                                    "xAxisName" => strtoupper("RFQ Month"),
                                    "yAxisName" => strtoupper("Total RFQ Recieved"),
                                    "numberSuffix" => "",
                                    "theme" =>"gammel",
                                    "exportEnabled" =>  "1",
                                    "exportFileName" => strtoupper("Company RFQ Chart"),
                                    "legendPosition" => "LEFT",
                                    "showLegend" => "1",
                                    "logoURL" =>  "https://scm.enabledjobs.com/pat/image019.png",
                                    "logoAlpha" =>  "40",
                                    "logoScale" =>  "45",
                                    "logoPosition" =>  "TL",
                                    "showLabels" => "1",
                                    "use3DLighting" => "1",
                                    "radius3D" =>"70",
                                    // "legendPosition" => "LEFT",
                                    "legendAllowDrag" => "0",
                                    "plotHighlightEffect" => "fadeout",
                                    // "height" => "1350",
                                )
                            );
                            $arrLabelValueData = array();
                            foreach ($company as $companies){
                                array_push($arrLabelValueData, array(
                                    "label" => strtoupper($companies->company_name), "value" => companyChart($companies->company_id)
                                ));
                            }
                            $arrChartConfig["data"] = $arrLabelValueData;
                            $jsonEncodedData = json_encode($arrChartConfig);
                            $Chart = new FusionCharts("pie2d", "BranchCustomer", "100%", 500, "chart-container", "json", $jsonEncodedData);
                            $Chart->render();?>
                            <div class="card">
								<div class="card-body" id="chart-container" style="position: relative; height: 530px;"></div>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination rounded info justify-content-center">
                                    {{ $company->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
