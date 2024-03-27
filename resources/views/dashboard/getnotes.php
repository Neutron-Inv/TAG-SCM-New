<?php

$rfq_id = $_GET['rfq_id'];

            $query = DB::table('client_rfqs')
                ->select('note')
                ->where('rfq_id', $rfq_id)
                ->first();
    
            return $query;
            
?>