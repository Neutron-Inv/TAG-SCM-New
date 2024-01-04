
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/design.css')}}">
<style>
hr {
    margin-top: 25px;
    margin-bottom: 25px;
}
</style>    
</head>
    <body background-color="white" style="background: white !important;">
        
        <div class="row" style="background: white !important;margin-left:3% !important;">
            
            <div class="col-lg-12" style="background: white !important;">
                <div class="mb-0" style="background: white !important;">
                    <div style="width: 100%; background: white !important; color: black;">
                        <div style="max-width: 90%; font-size: 14px; background: white !important;">
                                                   
                            
                            <div style="background: white !important;">
                                                <p style="font-size: 9.0pt;font-family: Calibri, sans-serif;"> 
                                                    Dear Sir/Madam,<br/>
                        							<br>Good day, I trust this mail finds you well.<br/>
                                                    <br/>Please see {{ $clients_det->client_name}} PO Report for your use.
                                                </p><br/>

            <!-- Bootstrap Table with Caption -->
            <div class="main-container">
 <div class="content-wrapper">
    <div class="row gutters">

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="table-container">
                    <div class="table-responsive">
                                <h6 class="table-title" style="text-align:center; vertical-align:center; padding:1%;"><b> {{ $clients_det->client_name}} PO Status update for <?php echo date('Y'); ?> </b></h6>
                        <table class="table m-0" style="border-collapse: collapse; width: 100%;color:black !important;">
                            <thead class="bg-success text-white">
                                <tr>
                                <th style="width: 10%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">S/N</th>
                                <th style="width: 30%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"> PO No </th>
                                <th style="width: 30%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"> Delivery Date </th>
                                <th style="width: 30%; text-align: center; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num =1; ?>
                                @foreach ($client as $client_detail)
                                    <tr> 
                                    <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $num++ }} </td>
                                    <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;">{{ $client_detail->po_number }} </td>
                                    <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"> {{ $client_detail->delivery_due_date}}</td>
                                    <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 9.0pt; font-family: Calibri, sans-serif;"> {{ $client_detail->status}} <br/> 
                                        @php
                                            $notesArray = explode('.', $client_detail->note);
                                            $firstParagraphContent = strip_tags($notesArray[0]);
                                        @endphp
                                        {!! $firstParagraphContent !!}.
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<br/>
                                                <hr>
                                                <p style="font-size: 9.0pt;font-family: Calibri, sans-serif;">
                                                Thank you. <br/>
                                                </p><br><br>
                                                <p style="font-size: 8.5pt;font-family: Arial,sans-serif; color: #1F497D;">Best Regards,<br> {{ Auth::user()->first_name . ' '. strtoupper(Auth::user()->last_name) }}, <br> SCM Associate <br>
                                                    PHONE</span></b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                        : +234 1 342 8420&nbsp;| </span>
                                                        <span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F4E79; mso-fareast-language:EN-GB">
                                                        +234 906 243 5410&nbsp; </span><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864; mso-fareast-language:ZH-CN">
                                                    </span><br><b><span style="font-size:7.5pt; font-family:&quot;Arial&quot;,sans-serif; color:#1F3864">
                                                        </span></b></a>
                                                    </span>

                                                </p>
                                                <img src="https://scm.enabledjobs.com/admin/img/signature.jpg" alt="SCM" style="width: 100%;">
                                                <div style="text-align: center; font-size: 9px; color: #ffffff; background-color: white;" >
                                                    <p style="color: black; font-size: 9px;">
                                                        &copy; Enabled Business Solution - All rights reserved.
                                                    </p>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    </td>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
</body>
</html>
            
