@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// $local_delivery = $rfqs->local_delivery;
// $fund_transfer = $rfqs->fund_transfer;
// // $cost_of_funds = $rfqs->cost_of_funds;
// $cost_of_funds = ($rfqs->cost_of_funds > 0) ? "$rfqs->cost_of_funds" : "0";
// $other_cost = $rfqs->other_cost;
// $net_percentage = $rfqs->net_percentage;
// $net_value = $rfqs->net_value;
// $wht= $rfqs->wht;
// $ncd = $rfqs->ncd;
// $grossMargin = $rfqs->freight_charges + $local_delivery + $fund_transfer + $cost_of_funds + $other_cost + $net_percentage + $wht + $ncd;
// $tots = $grossMargin + $rfqs->supplier_quote_usd;
?>
@endsection
