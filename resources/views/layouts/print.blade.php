<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Enabled Solutions">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> SCM | {{$title}} </title>
    <meta name="description" content="SCM">
    <meta name="author" content="Enabled Solutions">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/css/main.css')}}" />
    <link href="https://fonts.cdnfonts.com/css/tw-cen-mt" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Calibri">
         --}}
         <style>
        
        </style>
<head>


    <style>
        body {
            font-family: "Calibri", sans-serif;
        }
        h4,p,h6,b,td {
            font-family: "Calibri", sans-serif;
            font-size: 10.5pt;
        }
        tr{
            font-family: "Calibri", sans-serif;
            font-size: 9.5pt;
            color: black;
        }

        th{
            /*border-bottom: 1px solid; */
            color: white;
            text-decoration-color: black;
        }

        @import url('https://fonts.cdnfonts.com/css/tw-cen-mt');

        .producttag{
            font-family: 'Tw Cen MT', sans-serif !important;
        }

        .po{
            font-size: 28pt;
            font-family: Tw Cen MT Condensed,sans-serif;
            margin-bottom: .0rem;
            border-box;
            margin-top: 0;
            font-weight: 700;
            line-height: 1.2;
            orphans: 3;
            widows: 3;
            page-break-after: avoid;
        }

        table {
            color: red;
        }

        .table tbody tr:nth-of-type(even)
        {
            /* background-color: #F0F3F4; */
        }
        .table td,.table th{ vertical-align:top; font-family: "Calibri", sans-serif; }

        thead {
            border-bottom: 2px solid black; 
            border-width: 2px; border-bottom-color: black !important;
            font-family: "Calibri", sans-serif;
        }
        /*.page { size: 10cm 50cm landscape; }*/
        
        footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                font-size: 20px !important;

                /** Extra personal styles **/
                text-align: center;
                line-height: 35px;
            }
        
        #footer { position: fixed; left: 20px; bottom: 30px; right: 0px; height: 46px; }
        #footer .page:after { content: counter(page, upper-roman); }
    </style>
    <body class="po" style="border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #333333;text-align: left;background-color: #fff;padding: 0;font: normal .875rem 'Open Sans', sans-serif;-webkit-print-color-adjust: exact;background: ;min-height: 100%;position: relative;min-width: 992px!important;">
        
    @foreach (getLogo($rfq->company_id) as $item)
    @php $logsign = 'https://scm.enabledjobs.com/company-logo'.'/'.$rfq->company_id.'/'.$item->footer; @endphp
    <footer>
    <img id="fixedLogo" src="{{ $logsign }}" style="width: 80%; position: fixed; bottom: 0; left: 50%; transform: translateX(-55%); page-break-inside: avoid !important;" alt="SCM Solutions">
    </footer>
@endforeach
        
        <main>
    <div class="card-body p-0">
        @yield('content')
    </div>
    </main>

    </div>

</body>
</html>
