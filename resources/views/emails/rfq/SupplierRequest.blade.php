<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style type="text/css">
        .container {
            background: white;
            color: black !important;
            font-size:9pt !important;
        }

        .email-text {
            color: #1F497D !important;
            font-size:9pt !important;
        }

        p {
            font-size:9pt !important;
            line-height: 200;
            margin-bottom:0px;
        }

        .footey {
            color: #1F497D !important;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body style="background-color:white !important;">
    <div class="container" style="color:black;">
        <p class="email-text" style="color:black !important;">Dear {{$vendor_contact->first_name}},</p>
        <p class="email-text" style="color:black !important;">Good day, I trust you are well..</p>
        <p class="email-text" style="color:black !important;">Please provide us with <b>pricing, taxes (if any),  total package weight, dimensions, lead time, HS codes, and pickup address</b> for items stated in the attached document. 
 
        <br/>
        Kindly acknowledge receipt of this request and let us know if you have any questions and/or require clarifications about this. 
        <br/>
        @if($extra_note != "")
        {!! $extra_note !!}
        <br/>
        @endif
        Thank you and looking forward to hearing from you soon.
        </p>
        </div>
        <br/>
        <div class="email-text" style="margin-bottom: 40px;">
            <p class="footey">Best Regards,</p>
            <p class="footey">{{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }},</p>
            <p class="footey">@if(Auth::user()->role == 'HOD' ) 
                                        {{ 'SCM Lead' }} 
                                        @elseif(Auth::user()->role == 'Employer' )
                                        {{ 'Procurement Associate' }} 
                                        @elseif(Auth::user()->role == 'SuperAdmin' )
                                        {{ 'SCM Admin' }}
                                        @else
                                        {{ 'Procurement Associate' }}
                                        @endif</p>
            <p class="footey">PHONE: +234 1 342 8420 | +234 906 243 5410</p>
            <p class="footey">EMAIL: <a href="mailto:sales@tagenergygroup.net">sales@tagenergygroup.net</a></p>
            <img src="{{asset('admin/img/signature.jpg')}}" alt="SCM" style="width: 100%; max-width:550px;">
        </div>
    </div>
</body>
</html>