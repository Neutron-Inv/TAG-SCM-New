@if (!Auth::check())
    {{-- Redirect to login if user is not authenticated --}}
    <script>window.location.href = "{{ route('admin.login') }}";</script>
@endif
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Enabled Solutions">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{$title . ' | SCM'}} </title>
    <meta name="description" content="SCM">
    <meta name="author" content="Enabled Solutions">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/fonts/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/bs-select/bs-select.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datatables/dataTables.bs4.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datatables/dataTables.bs4-custom.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/summernote/summernote-bs4.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datepicker/css/classic.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/vendor/datepicker/css/classic.date.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css')}}">

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/swiper/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
        <!-- Page CSS -->
        <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/cards-advance.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/helpers.js')}}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/assets/js/config.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.5/bootstrap-tagsinput.min.css" integrity="sha512-QI3K41ZAT8rx+cti2oV948f32rX0qYP1jhR1/3N3jqW5UFBA3Hz5VEmEuPYl66I9tb6A9+HprKUHBxpzPkiaZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    
    {{-- @if($title == 'Price Quotation') --}}
    <!-- <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript">
        FusionCharts && FusionCharts.ready(function() {
            var trans = document.getElementById("controllers").getElementsByTagName("input");
            for (var i = 0, len = trans.length; i < len; i++) {
                if (trans[i].type == "radio") {
                    trans[i].onchange = function() {
                        changeChartType(this.value);
                    };
                }
            }
        });
        function changeChartType(chartType) {
            for (var k in FusionCharts.items) {
                if (FusionCharts.items.hasOwnProperty(k)) {
                    FusionCharts.items[k].chartType(chartType);
                }
            }
        };
    </script> -->
    <style>
        .bootstrap-tagsinput {
            width: 100%;
            min-height: 38px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            display: flex;
            flex-wrap: wrap;
        }
        
        .bootstrap-tagsinput .label-info {
            margin-right: 2px;
            color: #fff;
            background-color: #28c76f !important;
            padding: 3px;
            border-radius: 10px;
        }
    </style>
    @if (strpos($title, 'TAG Energy Quotation') !== false)
         <style type="">
            .table tbody tr:nth-of-type(even) {
            background-color: #F0F3F4; }
            .table td,.table th{ vertical-align:top;}

        </style>
    @else
        <style type="">
            .table tbody tr:nth-of-type(even) {
            background-color: #f7fafe; }
            .table td,.table th{padding:.75rem ; vertical-align:top;border-top:1px solid #dee2e6;}
        </style>
    @endif
    <style>
        select {
            z-index: 1001;
            overflow: hidden !important;
        }

        .page-header, .content-wrapper{
          width:96.6%;
          margin:auto;
        }

        .content-wrapper{
          padding-right:0.6%;
          padding-left:0.6%;
        }

        .table-container{
          width:100%;
        }
        
        /* Style for buttons container */
        .dataTables_wrapper .dt-buttons {
            margin-bottom: 10px;
        }
        
        /* Style for individual buttons */
        .dt-button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        
        /* Hover state for buttons */
        .dt-button:hover {
            background-color: #45a049; /* Darker green */
        }
      </style>
    {{-- <link rel="stylesheet" href="{{asset('admin/printer.css')}}" type="text/css" media="print" /> --}}
<head>

<body class="">
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <div class="container-fluid">
 
        <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="container-xxl">
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo">
                  <img src="{{asset('admin/assets/img/tag-flow.png')}}" class="mb-2 ml-2 mt-1" width="60">
                </span>
                <!-- <span class="app-brand-text demo menu-text fw-bold"></span> -->
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="ti ti-x ti-sm align-middle"></i>
              </a>
            </div>

            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                  <!-- User -->
                  <li class="nav-item navbar-dropdown dropdown">
                      <a class="nav-link dropdown-toggle hide-arrow" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <div class="avatar avatar-online">
                              <span class="avatar" style="font-size: 28px;">{{substr(Auth::user()->first_name, 0, 1)}}{{substr(Auth::user()->last_name, 0, 1)}}<span class="status online"></span></span>
                          </div>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-right" aria-labelledby="userDropdown" style="min-width:60px;">
                        <li>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <span class="avatar">{{substr(Auth::user()->first_name, 0, 1)}}{{substr(Auth::user()->last_name, 0, 1)}}<span class="status online"></span></span>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="fw-semibold d-block">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                                    <small class="text-muted">{{Auth::user()->role}}</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('get-issues')}}">
                                <i class="ti ti-lifebuoy me-2 ti-sm"></i>
                                <span class="align-middle">Help</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <i class="ti ti-logout me-2 ti-sm"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                  </li>
                  <!--/ User -->
              </ul>
          </div>

            <!-- Search Small Screens -->
          </div>
        </nav>
        </div> 

        @include('layouts.sidebar')
        <main>
            @yield('content')
            </main>
        <footer class="main-footer" style="background:#28c76f !important;">&copy; {{ date('Y') }} Enabled Business Solutions. All Rights Reserved</footer>
        </div>
            </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/js/moment.js')}}"></script>
    <script src="{{asset('admin/vendor/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('admin/vendor/rating/raty.js')}}"></script>
    <script src="{{asset('admin/vendor/rating/raty-custom.js')}}"></script>
    <script src="{{asset('admin/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{asset('admin/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="{{asset('admin/vendor/datatables/custom/custom-datatables.js')}}"></script>
    <script src="{{asset('admin/vendor/datatables/custom/fixedHeader.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="{{asset('admin/vendor/bs-select/bs-select.min.js')}}"></script>
    <script src="{{asset('admin/vendor/datepicker/js/picker.js')}}"></script>
    <script src="{{asset('admin/vendor/datepicker/js/picker.date.js')}}"></script>
    <script src="{{asset('admin/vendor/datepicker/js/custom-picker.js')}}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.5/bootstrap-tagsinput.min.js" integrity="sha512-JyFe+PZxgYZZz47TE0URAJ2mE25f4+fqs5DDkuMROc7bCF5uv7paD3irZxYv3VZKndILZX2qXWDOAzHo0N3Kkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('admin/assets/vendor/libs/popper/popper.js')}}"></script>
    <!-- <script src="{{asset('admin/assets/vendor/js/bootstrap.js')}}"></script> -->
    <!-- <script src="{{asset('admin/assets/vendor/libs/select2/select2.js')}}"></script> -->
    <!-- <script src="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script> -->
    <!--<script src="{{asset('admin/assets/vendor/libs/node-waves/node-waves.js')}}"></script>-->

    <!--<script src="{{asset('admin/assets/vendor/libs/hammer/hammer.js')}}"></script>-->
    <!--<script src="{{asset('admin/assets/vendor/libs/i18n/i18n.js')}}"></script>-->
    <!--<script src="{{asset('admin/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>-->

    <script src="{{asset('admin/assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('admin/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/swiper/swiper.js')}}"></script>
    <!-- <script src="{{asset('admin/assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/datatables-responsive/datatables.responsive.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js')}}"></script> -->

    <!-- Main JS -->
    <script src="{{asset('admin/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/dashboards-analytics.js')}}"></script>
    <script src="{{asset('admin/assets/js/dashboards-ecommerce.js')}}"></script>


    <script src="{{asset('admin/js/main.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 180,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                disableDragAndDrop: false, placeholder: 'write here...',

            });


            $('.summernote1').summernote({
                height: 180,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                disableDragAndDrop: false, placeholder: 'write here...',

            });

            
            $('.summernote2').summernote({
                height: 150,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                disableDragAndDrop: false, placeholder: 'write here...',

            });
	    $('.summernote3').summernote({
                height: 150,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                disableDragAndDrop: false, placeholder: 'write here...',

            });
        });

        $('#status').change(function() {
            var opval = $(this).val();
            if (opval == "Submit Quotation") {
                $('#customModalTwo').modal("show");
            }

            if (opval == "Request Approval") {
                $('#customModals').modal("show");
            }

            if (opval == "PO Issued to Supplier") {
                $('#customModalTwo-PO').modal("show");
            }
        });

        function confirmToDelete(){
            return confirm("Click Okay to Delete Details and Cancel to Stop");
        }

        function confirmToDeleteFile(){
            return confirm("Click Okay to Delete a File for the RFQ and Cancel to Stop");
        }

        function confirmToDeleteImage(){
            return confirm("Click Okay to Delete a Image for the RFQ and Cancel to Stop");
        }

        function confirmToDeleteCompanyImage(){
            return confirm("Click Okay to Delete an Image for the Company and Cancel to Stop");
        }

        function confirmToDeleteAll(){
            return confirm("Click Okay to Delete All Files for the RFQ and Cancel to Stop");
        }

        {{--  function confirmToEdit(){
            return confirm("Click Okay to Edit and Cancel to Stop");
        }  --}}

        function confirmToRestore(){
            return confirm("Click Okay to Restore The Deleted Data and Cancel to Stop");
        }

        function confirmToSuspend(){
            return confirm("Click Okay to Suspend the user and Cancel to Stop");
        }

        function confirmToUnSuspend(){
            return confirm("Click Okay to Un Suspend the user and Cancel to Stop");
        }

        {{--  function confirmToRFQ(){
            return confirm("Click Okay to Create RFQ and Cancel to Stop");
        }  --}}

        function sendEnq(){
            return confirm("Click Okay to Send Status Enq and Cancel to Stop");
        }

        function pickShipper(){
            return confirm("Click Okay to Pick Shipper Quotation and Cancel to Stop");
        }

        function pickUnShipper(){
            return confirm("Click Okay to Un Pick Shipper Quotation and Cancel to Stop");
        }

        function duplicate(){
            return confirm("Click Okay to Duplicate The Details and Cancel to Stop");
        }
    </script>

</body>
</html>
