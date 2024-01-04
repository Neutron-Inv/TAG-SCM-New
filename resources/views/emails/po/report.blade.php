
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="x-apple-disable-message-reformatting">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <style type="text/css">
            #invoice{
                padding: 30px;
            }

            .invoice {
                position: relative;
                background-color: white;
                min-height: 680px;
                padding: 15px
            }

            .invoice header {
                padding: 10px 0;
                margin-bottom: 20px;
                border-bottom: 1px solid #3989c6
            }

            .invoice .company-details {
                text-align: right
            }

            .invoice .company-details .name {
                margin-top: 0;
                margin-bottom: 0
            }

            .invoice .contacts {
                margin-bottom: 20px
            }

            .invoice .invoice-to {
                text-align: left
            }

            .invoice .invoice-to .to {
                margin-top: 0;
                margin-bottom: 0
            }

            .invoice .invoice-details {
                text-align: left
            }

            .invoice .invoice-details .invoice-id {
                margin-top: 0;
                color: #3989c6
            }

            .invoice main {
                padding-bottom: 50px
            }

            .invoice main .thanks {
                margin-top: -100px;
                font-size: 2em;
                margin-bottom: 50px
            }

            .invoice main .notices {
                padding-left: 6px;
                border-left: 6px solid #3989c6
            }

            .invoice main .notices .notice {
                font-size: 1.2em
            }

            .invoice table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px
            }

            .invoice table td,.invoice table th {
                padding: 15px;
                background: #eee;
                border-bottom: 1px solid #000000
            }

            .invoice table th {
                white-space: nowrap;
                font-weight: 400;
                font-size: 16px
            }

            .invoice table td h3 {
                margin: 0;
                font-weight: 400;
                color: #3989c6;
                font-size: 1.2em
            }

            .invoice table .qty,.invoice table .total,.invoice table .unit {
                text-align: right;
                font-size: 1.2em
            }

            .invoice table .no {
                color: #fff;
                font-size: 1.6em;
                background: #3989c6
            }

            .invoice table .unit {
                background: #ddd
            }

            .invoice table .total {
                background: #3989c6;
                color: #fff
            }

            .invoice table tbody tr:last-child td {
                border: none
            }

            .invoice table tfoot td {
                background: 0 0;
                border-bottom: none;
                white-space: nowrap;
                text-align: right;
                padding: 10px 20px;
                font-size: 1.2em;
                border-top: 1px solid black
            }

            .invoice table tfoot tr:first-child td {
                border-top: none
            }

            .invoice table tfoot tr:last-child td {
                color: #3989c6;
                font-size: 1.4em;
                border-top: 1px solid #3989c6
            }

            .invoice table tfoot tr td:first-child {
                border: none
            }

            .invoice footer {
                width: 100%;
                text-align: center;
                color: #777;
                border-top: 1px solid #aaa;
                padding: 8px 0
            }

            @media print {
                .invoice {
                    font-size: 11px!important;
                    overflow: hidden!important
                }

                .invoice footer {
                    position: absolute;
                    bottom: 10px;
                    page-break-after: always
                }

                .invoice>div:last-child {
                    page-break-before: always
                }
            }
            .center, img {
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body>
        <div id="invoice">
            <div class="invoice overflow-auto">
                <div style="min-width: 600px">
                    <header>
                        <div class="row">
                            <div class="col" align="center">
                                <a target="_blank" href="https://scm.enabledjobs.com/dashboard">
                                    <img src="https://scm.enabledjobs.com/admin/img/TAG%20Energy%20Logo.png" style="width: 120px; height:90px;" data-holder-rendered="true" />
                                </a>
                            </div>

                        </div>
                    </header>
                    <main>
                        <div class="row contacts">
                            <div class="col invoice-details">
                                <div class="text-gray-light">
                                    <h5 class="invoice-id"> Dear Sir/Madam, <br>
                                        Good Afternoon, I trust this mail meets you well.  <br>
                                        Please see the below update as requested
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <table border="1" cellspacing="0" cellpadding="0" class="center">
                            <thead style="background-color: pink; color:black" class="text-black">
                                <tr style="font-size: 9.5pt;font-family: Arial,sans-serif; background-color: pink;">
                                    <th>S/N</th>
                                    <th>PO Number</th>
                                    <th>Vendor</th>
                                    <th>Incoterm</th>
                                    <th>PO Delivery Date</th>
                                    <th>TAG's Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $num =1; @endphp
                                @foreach ($po as $item)
                                    @php
                                        if((strpos($item->tag_comment, 'production') !== false) OR (strpos($item->tag_comment, 'Production') !== false)){
                                            $color = 'yellow';
                                        }elseif((strpos($item->tag_comment, 'ongoing') !== false) OR (strpos($item->tag_comment, 'Ongoing') !== false)){
                                            $color = 'red';
                                        }elseif((strpos($item->tag_comment, 'delivered') !== false) OR (strpos($item->tag_comment, 'Delivered') !== false)){
                                            $color = 'green';
                                        } else{
                                            $color = 'orange';
                                        }
                                    @endphp
                                    <tr style="font-size: 9.5pt;font-family: Arial,sans-serif;">
                                        <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $num }}</span></td>
                                        <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $item->po_number ?? 'PO Number' }} </span></td>
                                        <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $item->rfq->vendor->vendor_name ?? '' }} </span></td>
                                        <td><span style="color:black; background-color: <?php echo $color; ?>">DDP </span></td>
                                        <td><span style="color:black; background-color: <?php echo $color; ?>">{{ $item->delivery_due_date ?? '' }} </span></td>
                                        <td><span style="color:black; background-color: <?php echo $color; ?>">{!! $item->tag_comment ?? 'PO Note' !!} </span></td>
                                    </tr>
                                    <?php $num++; ?>
                                @endforeach
                            </tbody>

                        </table>
                        <br>
                        <div class="notices">

                            <p style="font-size: 7.5pt;font-family: Arial,sans-serif; color: #1F497D;">Best Regards,<br> {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, <br> SCM Specialist II <br>
                                PHONE</span></b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                    : +234 1 342 8420&nbsp;| </span>
                                    <span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                                    +234 906 243 5410&nbsp; </span><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                </span><br><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864">EMAIL:
                                </span></b><span style="color:#2F5496"><a href="mailto:sales@tagenergygroup.net"><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif">
                                    sales@tagenergygroup.net</span></b></a>
                                </span>

                            </p>
                            <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
                        </div>
                    </main>

                </div>

                <div></div>
            </div>
        </div>
    </body>
</html>
