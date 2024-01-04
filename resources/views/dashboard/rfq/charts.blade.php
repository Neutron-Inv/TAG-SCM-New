<?php $title = 'RFQ Charts'; ?>
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
                                    "caption" => strtoupper("SCM Monthly RFQ Chart"),
                                    "subCaption" => "Powered by Enabled Solution",
                                    "xAxisName" => strtoupper("RFQ Month"),
                                    "yAxisName" => strtoupper("Total RFQ Recieved"),
                                    "numberSuffix" => "",
                                    "theme" =>"fussion",
                                    "exportEnabled" =>  "1",
                                    "exportFileName" => strtoupper("Monthly RFQ Chart"),
                                    "legendPosition" => "BOTTOM",
                                    "showLegend" => "1",
                                    "palettecolors" => "#FF6633, #FFB399, #FF33FF, #FFFF99, #00B3E6,#E6B333, #3366E6, #999966, #99FF99, #B34D4D,
                                        #80B300, #809900, #E6B3B3, #6680B3, #66991A, #FF99E6, #CCFF1A, #FF1A66, #E6331A, #33FFCC,
                                        #66994D, #B366CC, #4D8000, #B33300, #CC80CC,#66664D, #991AFF, #E666FF, #4DB3FF, #1AB399,
                                        #E666B3, #33991A, #CC9999, #B3B31A, #00E680, #4D8066, #809980, #E6FF80, #1AFF33, #999933,
                                        #FF3380, #CCCC00, #66E64D, #4D80CC, #9900B3, #E64D66, #4DB380, #FF4D4D, #99E6E6, #6666FF",
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
                                )
                            );
                            $arrLabelValueData = array();
                            $months = array(1,2,3,4,5,6,7,8,9,10,11,12);
                            foreach ($months as $month){
                                if($month == 1){
                                    $name = 'January';
                                }elseif($month == 2){
                                    $name = 'Febuary';
                                }elseif($month == 3){
                                    $name = 'March';
                                }elseif($month == 4){
                                    $name = 'April';
                                }elseif($month == 5){
                                    $name = 'May';
                                }elseif($month == 6){
                                    $name = 'June';
                                }elseif($month == 7){
                                    $name = 'July';
                                }elseif($month == 8){
                                    $name = 'August';
                                }elseif($month == 9){
                                    $name = 'September';
                                }elseif($month == 10){
                                    $name = 'October';
                                }elseif($month == 11){
                                    $name = 'November';
                                }else{
                                    $name= 'December';
                                }
                                array_push($arrLabelValueData, array(
                                    "label" => strtoupper($name), "value" => monthChart($month)
                                ));
                            }
                            $arrChartConfig["data"] = $arrLabelValueData;
                            $jsonEncodedData = json_encode($arrChartConfig);
                            $Chart = new FusionCharts("bar2D", "BranchCustomer", "100%", 520, "chart-container", "json", $jsonEncodedData);
                            $Chart->render();?>
                            <div class="tab-content no-padding">
                                <div class="chart tab-pane active" id="chart-container" style="position: relative; height: 530px;"></div>
                                <div id="controllers" align="center" style="font-family:'Helvetica Neue', Arial; font-size: 13px;">

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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
