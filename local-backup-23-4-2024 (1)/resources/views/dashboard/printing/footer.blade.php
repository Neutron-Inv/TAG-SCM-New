<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <style>
        /* Add your custom styling for the footer here */
        body {
            margin: 0;
            padding: 0;
        }

        .footer {
            width: 100%;
            height: 100px;
            position: fixed;
            bottom: 0;
            left: 50;
            transform: translateX(-55%);
            background-color: #f1f1f1;
            text-align: center;
            line-height: 100px;
        }
    </style>
</head>
<body>
    <div class="footer">
        @foreach (getLogo($rfq->company_id) as $item)
            @php $logsign = 'https://scm.enabledjobs.com/company-logo'.'/'.$rfq->company_id.'/'.$item->footer; @endphp
            <img style="width: 80%;" src="{{ $logsign }}" alt="SCM Solutions">
        @endforeach
    </div>
</body>
</html>