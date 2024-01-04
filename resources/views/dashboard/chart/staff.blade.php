<?php $title = 'RFQ Supplier Charts'; ?>
@extends('layouts.app')
@include('layouts.fussion-chart')
@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard </a></li>
                <li class="breadcrumb-item active"><a href="{{ route('rfq.chart') }}"> RFQ Charts</a></li>
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
                                    "caption" => strtoupper("SCM Supplier RFQ Chart"),
                                    "subCaption" => "Powered by Enabled Solution",
                                    "xAxisName" => strtoupper("RFQ Month"),
                                    "yAxisName" => strtoupper("Total RFQ Recieved"),
                                    "numberSuffix" => "",
                                    "theme" =>"gammel",
                                    "exportEnabled" =>  "1",
                                    "exportFileName" => strtoupper("Supplier RFQ Chart"),
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
                            foreach ($supplier as $suppliers){
                                array_push($arrLabelValueData, array(
                                    "label" => strtoupper($suppliers->vendor_name), "value" => vendorChart($suppliers->vendor_id)
                                ));
                            }
                            $arrChartConfig["data"] = $arrLabelValueData;
                            $jsonEncodedData = json_encode($arrChartConfig);
                            $Chart = new FusionCharts("pie2d", "BranchCustomer", "100%", 700, "chart-container", "json", $jsonEncodedData);
                            $Chart->render();?>
                            <div class="tab-content no-padding">
                                <div class="chart tab-pane active" id="chart-container" style="position: relative; height: 730px;"></div>
                                {{-- <div id="controllers" align="center" style="font-family:'Helvetica Neue', Arial; font-size: 13px;">

                                    <label style="padding: 0px 5px !important;">
                                        <input type="radio" class="" name="div-size" checked value="bar2D" /> Bar Chart
                                    </label>
                                    <label style="padding: 0px 5px !important;">
                                        <input type="radio" class="" name="div-size" value="pie2d" /> Pie Chart
                                    </label>

                                    <label style="padding: 0px 5px !important;">
                                        <input type="radio"  class="" name="div-size" value="doughnut2D" /> Doughnut Chart
                                    </label>
                                    <label style="padding: 0px 5px !important;">
                                        <input type="radio" class="" name="div-size" value="pyramid" /> Pyramid Chart
                                    </label>

                                </div> --}}
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination rounded info justify-content-center">
                                    {{ $supplier->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
