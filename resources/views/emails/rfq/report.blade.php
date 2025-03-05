
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
						                        <!-- @foreach (getLogo($rfq->company_id) as $item)
                                                    @php $log = 'https://scm.enabledjobs.com/company-logo'.'/'.$rfq->company_id.'/'.$item->company_logo; @endphp
                                                    <img src="{{$log}}" width="100" height="70" alt="SCM"style="height: 40px; margin-left: 3px;" 
                                                    >
                                                @endforeach -->
                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;"> 
                                                    Dear Sir/Madam,<br/>
                        							<br>Good day, I trust this mail finds you well.<br/>
                                                    <br/>Please see Report on {{ $reference_no }} for your use.
                                                </p><br/>

            <!-- Bootstrap Table with Caption -->
            <div class="card">
                <h4 class="card-header">{{$reference_no}} RFQ Details</h4><br/>
                <div class="table-responsive text-nowrap">
                  <table class="table" style="border-collapse: collapse; border: 0; width: 100%; background: white !important; padding-left:2px;">
                    <thead style="background:#28c76f !important;">
                      <tr>
                        <th style="text-align: left;">Details</th>
                        <th tyle="text-align: left !important; float: left">Information</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($po != "")
                      <tr>
                        <td>
                        <i class="fas fa-file-invoice-dollar ti-lg text-danger ml-1 me-3"></i> <strong>PO Number</strong>
                        </td>
                        <td>{{ $po->po_number ?? ' ' }}</td>
                      </tr>
                      @endif
                      <tr>
                        <td>
                          <i class="ti ti-building ti-lg text-danger me-3"></i> <strong>Client</strong>
                        </td>
                        <td>{{ $rfq->client->client_name ?? ' ' }}</td>
                      </tr>
                      <tr>
                        <td>
                          <i class="ti ti-user ti-lg text-info me-3"></i> <strong>Buyer</strong>
                        </td>
                        <td>{{ $rfq->contact->first_name . ' '. $rfq->contact->last_name ?? ' '}} </td>
                      </tr>
                      <tr>
                        <td>
                          <i class="ti ti-settings ti-lg text-primary me-3"></i>
                          <strong>Supplier</strong>
                        </td>
                        <td>{{ $rfq->vendor->vendor_name }}</td>
                      </tr>
                      <tr>
                        <td>
                          <i class="ti ti-note ti-lg text-secondary me-3"></i>
                          <strong>Description</strong>
                        </td>
                        <td>{!! $rfq->description !!} </td>
                      </tr>
                      <tr>
                        <td>
                          <i class="ti ti-ship ti-lg text-primary me-3"></i>
                          <strong>Incoterm</strong>
                        </td>
                        <td>{{ $rfq->incoterm ?? ''}} </td>
                      </tr>
                      <tr>
                        <td>
                          <i class="ti ti-coin ti-lg text-info me-3"></i>
                          <strong>Currency</strong>
                        </td>
                        <td>{{ $rfq->currency ?? ''}}</td>
                      </tr>
                      <tr>
                        <td>
                          <i class="ti ti-loader ti-lg text-danger me-3"></i>
                          <strong>Status</strong>
                        </td>
                        @if($po != "")
                        <td>{{ $po->status }}</td>
                        @else
                        <td>{{ $rfq->status }}</td>
                        @endif
                      </tr>
                      <tr>
                        <td>
                          <i class="fas fa-user-check ti-lg text-danger ml-1 me-2"></i>
                          <strong>Assigned To</strong>
                        </td>
                        @php
                            $employee = empDetails($rfq->employee_id);
                        @endphp
                        <td>{{ $employee->full_name ?? '' }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Bootstrap Table with Caption -->
              <hr>

                        <div class="table-responsive">
                                    <table style="width: 100%; background: white !important; padding-left:2px;" id="fixedHeader" class="table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;">S/N</th>
                                                <th style="text-align: left; padding: 5px 5px; border: 1px solid black;vertical-align: top;
                                                             font-size: 10.0pt;"> Item Name </th>
                                                <th style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;">Item Number</th>
                                                <th style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;">Description</th>
                                                <th style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;">Supplier</th>
                                                <th style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;">Quantity</th>
                                                <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;">Unit Price  </td>
                                                {{--  <th>Total Cost (NGN)</th>  --}}
                                                {{--  <th>Total Cost (NGN)</th>  --}}
                                                <th style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;">Total Price</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $num =1; ?>
                                            @foreach ($line_items as $items)
                                                    <tr>
                                                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{ $items->item_serialno ?? '' }}
                                                        </td>

                                                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{$items->item_name ?? ''}} </td>
                                                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{$items->item_number ?? ''}} </td>
                                                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt !important;"> {!! $items->item_description ?? 0 !!} </td>
                                                        @foreach(getVen($items->vendor_id) as $ven)
                                                            <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{$ven->vendor_name ?? 'Null'}} </td>
                                                        @endforeach
                                                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{$items->quantity ?? 0}} </td>

                                                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{ number_format($items->unit_price ?? 0, 2) }} </td>
                                                        {{--  <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{$items->total_cost ?? ''}} </td>  --}}
                                                        {{--  <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{$items->total_cost_naira ?? ''}} </td>  --}}
                                                        <td style="text-align: left; padding: 5px 5px; border: 1px solid black; vertical-align: top;
                                                             font-size: 10.0pt;"> {{number_format($items->quantity * $items->unit_price , 2) ?? ''}} </td>

                                                    </tr><?php $num++; ?>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
              <hr>

              <h4>Breakdown Analysis</h4>
                    <table style="border-collapse: collapse; border: 0; width: 50%; background: white !important; padding-left:2px;">
                                                <thead>
                                                    <tr>
                                                        <th  style=" width: 40%; text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </th>
                                                        <th  style="width: 60%; text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                            &nbsp;
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             {{number_format((float)$tq,2) ?? 0 }}
                                                            
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             Total Ex-Works
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $sumTotalMiscSupplier = 0;
                                                        $shipper = getSh($rfq->shipper_id);
                                                    @endphp
                                                    @if(!empty(json_decode($rfq->misc_cost_supplier, true) && array_key_exists('amount', json_decode($rfq->misc_cost_supplier, true))))
                                                    @foreach(json_decode($rfq->misc_cost_supplier, true) as $item)
                                                        <tr>
                                                            <td style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                            @if($iteml['amount'] != "" && $iteml['amount'] > 0)
                                                            {{number_format((float)$item['amount'] ,2) ?? 0 }}
                                                            @endif
                                                            </td>
                                                            <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                {{ $item['desc'] }}
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $sumTotalMiscSupplier += $item['amount'];
                                                        @endphp
                                                    @endforeach
                                                    @endif
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    @if($rfq->local_delivery > 0)
                                                        @if($rfq->is_lumpsum == 1)
                                                        <tr>
                                                            <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                {{number_format((float)$rfq->local_delivery ,2) ?? 0 }}
                                                            </td>
                                                            <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                {{ $shiname }} Lump Sum
                                                            </td>
                                                        </tr>
                                                        @else
                                                        @if($shi != null)
                                                        @if($shi->soncap_charges > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->soncap_charges ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Soncap Charges
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if($shi->trucking_cost > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->trucking_cost ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Trucking Cost
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @if($shi->clearing_and_documentation > 0)
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->clearing_and_documentation ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Clearing and Documentation
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            
                                                            @if($shi->customs_duty > 0 )
                                                            <tr>
                                                                <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                                    {{number_format((float)$shi->customs_duty ,2) ?? 0 }}
                                                                </td>
                                                                <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                                    font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                                    {{$shiname}} Customs Duty
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @php
                                                        $sumTotalMiscLogistics = 0;
                                                    @endphp
                                                    @if(!empty(json_decode($rfq->misc_cost_logistics, true) && array_key_exists('amount', json_decode($rfq->misc_cost_logistics, true))))
                                                    @foreach(json_decode($rfq->misc_cost_logistics, true) as $iteml)
                                                        <tr>
                                                            <td style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                            @if($iteml['amount'] != "" && $iteml['amount'] > 0)
                                                            {{number_format((float)$iteml['amount'] ,2) ?? 0 }}
                                                            @endif
                                                            </td>
                                                            <td style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top; font-size: 10.0pt; font-family: Calibri, sans-serif;">
                                                                {{ $iteml['desc'] }}
                                                            </td>
                                                        </tr>

                                                        @php
                                                            $sumTotalMiscLogistics += $iteml['amount'];
                                                        @endphp
                                                    @endforeach
                                                    @endif
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$tq + $sumTotalMiscLogistics + $sumTotalMiscSupplier + $rfq->local_delivery,2) ?? 0 }}</b> 
                                                        </td>
                                                        @php
                                                            $subtotal = $tq + $sumTotalMiscLogistics + $sumTotalMiscSupplier + $rfq->local_delivery;
                                                        @endphp
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            {{-- {{ number_format((float)sumTotalQuote($rfq->rfq_id),2) ?? 0}}  --}}
                                                            <b>Sub Total 1</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;color:red;">
                                                             {{ number_format((float)$rfq->cost_of_funds,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Cost of funds (Subtotal * 1.3% * 4 Months)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                            {{ number_format((float)$rfq->fund_transfer_charge,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Cost of Fund Transfer(0.5 % of Total Ex- Works) 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                            {{ number_format((float)$rfq->vat_transfer_charge,2) ?? 0 }} 
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             VAT on Transfer Cost (7.5% of Funds Transfer)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                             {{ number_format((float)$rfq->offshore_charges,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Offshore Charges
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; color:red;">
                                                             {{ number_format((float)$rfq->swift_charges,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Swift Charges (fixed @ $25)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 2px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             @php
                                                                $total_exworks = $subtotal + $rfq->swift_charges + $rfq->offshore_charges + $rfq->vat_transfer_charge + $rfq->fund_transfer_charge + $rfq->cost_of_funds
                                                             @endphp
                                                             {{ number_format((float)$total_exworks,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Total Ex-works Cost
                                                        </td>
                                                    </tr>
                                                    <tr style="background:#f2f2f2;">
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             &nbsp;
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->total_quote ,2) ?? 0 }}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            <b>Total Quotation</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                             -
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; ">
                                                             VAT
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        {{ number_format((float)$rfq->wht + $rfq->ncd,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            WHT &amp; NCD  <br> ((Total Quote minus Sub Total 1 * 6%)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        {{ number_format((float)$rfq->wht + $rfq->ncd,2) ?? 0 }}
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; background:#d9d9d9;">
                                                             Total TAXES
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->net_percentage,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            <b>Net Margin <br>(Total Quote minus (Total DDP Cost + WHT))</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif; background:#d9d9d9;">
                                                        <b>{{ number_format((float)$rfq->percent_net,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            % Net Margin
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->net_value,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            Gross Margin
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  style="text-align: right; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                        <b>{{ number_format((float)$rfq->percent_margin,2) ?? '0'}}</b>
                                                        </td>
                                                        <td  style="text-align: left; padding: 5px 5px; border: 1px solid black; white-space: nowrap; vertical-align: top;
                                                             font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                            % Gross Margin
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;">
                                                    <b style="color:red">Notes to Pricing: </b><br>
                                                    1. Delivery: {{ $rfq->estimated_delivery_time ?? '17-19 weeks' }}. <br>
                                                    2. Mode of transportation:  <b>{{ $rfq->transport_mode ?? ''}} </b> <br>
                                                    3. Delivery Location: <b>{{ $rfq->delivery_location ?? ''}} </b><br>
                                                    4. Where Legalisation of C of O and/or invoices are required, additional cost will apply and will be charged at cost. <br>
                                                    5. Validity: This quotation is valid for <b>{{ $rfq->validity ?? ''}} </b>. <br>
                                                    6. FORCE MAJEURE: On notification of any event with impact on delivery schedule,We will extend delivery schedule.<br>
                                                    7. Pricing: Prices quoted are in <b>{{ $rfq->currency ?? 'USD' }} </b> <br>
                                                    8. Prices are based on quantity quoted <br>
                                                    9. A revised quotation will be submitted for confirmation in the event of a partial order. <br>
                                                    10. Oversized Cargo: <b>{{ $rfq->oversized ?? 'NO' }} </b><br>
                                                    11. Payment Term: <b>{{ $rfq->payment_term ?? '' }} </b><br>
                                                </p>
                                                <hr>

                                                <div class="row">

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <p style="text-justify"><b>RFQ Note:  </b> <br/> {!! $rfq->note !!} </p>
                                                </div>

                                                @if($po != "")
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <p style="text-justify"><b>PO Note:  </b> <br/> {!! $po->note !!} </p>
                                                </div>
                                                @endif
                                                </div>
                                                <hr>


                                                <p style="font-size: 10.0pt;font-family: Calibri, sans-serif;">
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
                                                <img src="{{asset('admin/img/signature.jpg')}}" alt="SCM" style="width: 100%;">
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
            
