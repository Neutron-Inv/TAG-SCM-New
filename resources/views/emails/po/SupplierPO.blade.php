<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style type="text/css">
        .container {
            background: white;
            color: black !important;
            font-size: 9pt !important;
        }

        .email-text {
            color: #1F497D !important;
            font-size: 9pt !important;
        }

        p {
            font-size: 9pt !important;
            line-height: 200;
            margin-bottom: 0px;
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
        <p class="email-text" style="color:black !important;">Dear Sir/Madam,</p>
        <p class="email-text" style="color:black !important;">Good day, I trust you are well.</p>
        <p class="email-text" style="color:black !important;">Please acknowledge receipt (sign, stamp, and revert with a
            scanned copy) of our attached Purchase Order with regards to your quotation (see below correspondences) for
            the purchase of {{ $pricing->description }}
            <br /><br />
            @if ($extra_note != '')
                {!! $extra_note !!}
                <br /><br />
            @endif
            Kindly acknowledge receipt of this request and let us know if you have any questions and/or require
            clarifications about this.
            <br /><br />
            Please let us know if you have any questions and/or require clarifications concerning this.<br />
            Hope to hear from you soonest.
        </p>
    </div>
    <br />
    <div class="email-text" style="margin-bottom: 40px;">
        <p class="footey">Best Regards,</p>
        <p class="footey">{{ $user->first_name . ' ' . strtoupper($user->last_name) }},</p>
        <p class="footey">
            @if ($user->role == 'HOD')
                {{ 'SCM Lead' }}
            @elseif($user->role == 'Employer')
                {{ 'Procurement Associate' }}
            @elseif($user->role == 'SuperAdmin')
                {{ 'SCM Admin' }}
            @else
                {{ 'Procurement Associate' }}
            @endif
        </p>
        <p class="footey">PHONE: +234 1 342 8420 | +234 906 243 5410</p>
        <p class="footey">EMAIL: <a href="mailto:sales@tagenergygroup.net">sales@tagenergygroup.net</a></p>
        <img src="{{ asset('admin/img/signature.jpg') }}" alt="SCM" style="width: 100%; max-width:550px;">
    </div>
    </div>
</body>

</html>
