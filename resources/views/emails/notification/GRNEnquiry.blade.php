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
        
        .email-text{
        margin-bottom:10px;
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
    @if($type == 'Reminder')
    <div class="container" style="color:black;">
        <p class="email-text" style="color:black !important;">Good Day Sir/Ma,</p>
        <p class="email-text" style="color:black !important;">I trust this mail meets you well.</p>
        <p class="email-text" style="color:black !important;">Sequel to the delivery of subject order, kindly provide us with GRN to enable us proceed with invoicing. </p>
        <p class="email-text" style="color:black !important;">Thank you and hope to hear from you soon.
        </p>
        </div>
        <br/>
        <div class="email-text" style="margin-bottom: 40px;">
            <p class="footey">Best Regards,</p>
            <p class="footey">{{ $assigned }},</p>
            <p class="footey">@if($assigned == 'Mary ERENGWA' ) 
                                        {{ 'SCM Lead' }} 
                                        @else
                                        {{ 'Procurement Associate' }}
                                        @endif</p>
            <p class="footey">PHONE: +234 1 342 8420 | +234 906 243 5410</p>
            <p class="footey">EMAIL: <a href="mailto:sales@tagenergygroup.net">sales@tagenergygroup.net</a></p>
            <img src="https://scm.tagenergygroup.net/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
        </div>
    @elseif($type == '14-Day Follow-up')
    <div class="container" style="color:black;">
        <p class="email-text" style="color:black !important;">Dear {{$assigned}},
        <br/></p>
        <p class="email-text" style="color:black !important;">I trust this mail meets you well.
        <br/></p>
        <p class="email-text" style="color:black !important;">This is a reminder that it's been more than 14 days since the last reminder for the collection of the GRN for above subject, and it's yet to be collected,<br/> </p>
        <p class="email-text" style="color:black !important;">Kindly ensure to follow up as needed. <br/></p>
       <p class="email-text" style="color:black !important;"> Should incase it has been collected, kindly ensure to update the portal accordingly to stop seeing this message.
        <br/>
        Thank you.
        
        <br/>
        <br/>
        <span style="font-style:italic; color: blue;">This is an auto-generated mail to serve as a reminder. do not reply</span>
        </p>
        </div>
        <br/>
        <div class="email-text" style="margin-bottom: 40px;">
            <p class="footey">Best Regards,</p>
            <p class="footey">TAG Sourcing,</p>
            <p class="footey">PHONE: +234 1 342 8420 | +234 906 243 5410</p>
            <p class="footey">EMAIL: <a href="mailto:sales@tagenergygroup.net">sales@tagenergygroup.net</a></p>
            <img src="https://scm.tagenergygroup.net/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
        </div>
    @endif
        
    </div>
</body>
</html>