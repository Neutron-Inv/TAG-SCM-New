<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Enabled Solutions">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> SCM | {{$title}} </title>
    <meta name="description" content="TAG Flow">
    <meta name="author" content="Enabled Solutions">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Calibri">
    <link href="https://fonts.cdnfonts.com/css/tw-cen-mt-std" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/agency-fb" rel="stylesheet">     
    <style>
        @import url('https://fonts.cdnfonts.com/css/agency-fb');
        /* General styles for body */
        body {
            margin-bottom: 40px; /* Adjust the value as needed */
        }
        
        /* Typography settings for common elements */
        p, b {
            font-family: 'Calibri', sans-serif;
            font-size: 7pt;
        }
        
        .row.gutters::after {
            content: '';
            display: block;
            clear: both;
        }
        
        /* Table row styles */
        /*tr {*/
        /*    font-family: "Calibri", sans-serif;*/
        /*    font-size: 5.5pt;*/
        /*    color: black;*/
        /*}*/
        
        /* Table header styles */
        /*th {*/
            /* Border styles can be uncommented if needed */
            /* border-bottom: 1px solid; */
        /*    color: white;*/
            text-decoration-color: black; /* This property is rarely used; ensure it's intentional */
        /*}*/
        
        /* Importing custom font for specific elements */
        @import url('https://fonts.cdnfonts.com/css/tw-cen-mt-std');
        
                /* Class-specific styles for elements using custom fonts */
        .producttag {
            font-family: ,'Agency FB', sans-serif !important;
            font-weight:700;
        }
        
        .po {
            font-size: 28pt;
            font-family: 'Tw Cen MT Std', sans-serif;
            margin-bottom: 0; /* Removed unnecessary decimal */
            margin-top: 0;
            font-weight: 700;
            line-height: 1.2;
            orphans: 3;
            widows: 3;
            page-break-after: avoid;
        }
        
        /* Table styling */
        table {
            color: red;
        }
        
        /* Styling for table rows in tbody */
        .table tbody tr:nth-of-type(even) {
            /* Uncomment the line below to add alternating row colors */
            /* background-color: #F0F3F4; */
        }
        
        /* Styling for table rows in tbody */
        table p,b {
            font-size:5pt;
            line-height:1.2;
        }
        
        .tablex{
            width:510px;
        }
        
        /* General styles for table cells and headers */
        .table td, .table th {
            vertical-align: top;
        }
        
        /* Table header styles */
        thead {
            border-bottom: 2px solid black;
        }
        
        /* Uncomment to define specific page size (ensure this is required for print media) */
        /* .page { size: 10cm 50cm landscape; } */

        
        footer {
                position: fixed;
                left: 0px; 
                right: 0px;
                height: 50px; 
                font-size: 20px !important;
                
                /** Extra personal styles **/
                text-align: center;
                line-height: 35px;
            }

        #footer { position: fixed; left: 10px; bottom: 0px; right: 0px; height: 46px; }
        #footer .page:after { content: counter(page, upper-roman); }
    </style>
</head>
    <body class="po" style="border-box;line-height: 1.5;color: #333333;text-align: left;background-color: #fff;padding: 0;font: normal .875rem 'Open Sans', sans-serif;-webkit-print-color-adjust: exact;background: ;min-height: 100%;position: relative;min-width: 100%!important;">
        
    @foreach (getLogo($rfq->company_id) as $item)
    @php $logsign = 'https://scm.tagenergygroup.net/company-logo'.'/'.$rfq->company_id.'/'.$item->footer; @endphp
    <footer>
    <img id="fixedLogo" src="{{ $logsign }}" style="width: 80%; position: fixed; bottom: -20; left: 50%; transform: translateX(-55%); page-break-inside: avoid !important;" alt="{{config('app.name')}}">
    </footer>
@endforeach
        
        <main>
    <div class=" p-0">
        @yield('content')
    </div>
    </main>

    </div>

</body>
</html>
