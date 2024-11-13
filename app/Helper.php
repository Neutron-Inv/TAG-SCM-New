<?php
    function users($email)
    {
        return \DB::table('users')->where([
            "email" => $email
        ])->get();
    }

    function usersId($user_id)
    {
        return \DB::table('users')->where([
            "user_id" => $user_id
        ])->get();
    }
    
    function empDet($email)
    {
        return \DB::table('employers')->where([
            "email" => $email
        ])->get();
    }

    function empDetails($id)
    {
        return \DB::table('employers')->where([
            "employee_id" => $id
        ])->first();
    }

    function Totalrfqs()
    {
        return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->count();
    }

    function TotalrfqsAwaitingApproval()
    {
        return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('status', "Awaiting Approval")
        ->count();
    }

    function TotalrfqsBidClosed()
    {
        return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('status', "Bid Closed")
        ->count();
    }

    function TotalrfqsApproved()
    {
        return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('status', "Approved")
        ->count();
    }

    function totalActiveRfqs()
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->whereNotIn('status', ["approved", "PO Issued", "Quotation Submitted"])
        ->count();
    }

    function TotalActivePos()
    {
    return \DB::table('client_pos')
        ->whereYear('po_date', date('Y'))
        ->whereNotIn('status', ["Declined", "PO On Hold", "PO Cancelled", ])
        ->count();
    }

    function TotalposInTransit()
    {
        return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('status', "In Transit")
        ->count();
    }

    function TotalposDelivered()
    {
        return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('status', "Delivered")
        ->count();
    }

    function TotalposGRN()
    {
        return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('status', "Awaiting GRN")
        ->count();
    }

    function totalEmpRfqs($emp_id)
    {
    return \DB::table('client_rfqs')
        ->where([
            "employee_id" => $emp_id,
        ])
        ->whereYear('rfq_date', date('Y'))
        ->whereNotIn('status', ["approved", "PO Issued", "Quotation Submitted"])
        ->count();
    }
    

    function totalEmpPoMnth($emp_id)
    {
    return \DB::table('client_rfqs')
        ->where([
            "employee_id" => $emp_id,
        ])
        ->whereYear('rfq_date', date('Y'))
        ->whereMonth('rfq_date', date('m'))
        ->where('status', ["PO Issued"])
        ->count();
    }
    function Totalpos()
    {
        return \DB::table('client_pos')
        ->whereYear('po_date', date('Y'))
        ->count();
    }

    function TotalrfqQuoteUSD()
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'USD')
        ->sum('total_quote');
    }
    
    function TotalrfqQuoteGBP()
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'GBP')
        ->sum('total_quote');
    }
    
    function TotalrfqQuoteEUR()
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'EUR')
        ->sum('total_quote');
    }
    
    function TotalrfqQuoteNGN()
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'NGN')
        ->sum('total_quote');
    }
    
    function TotalrfqQuoteUSDEMP($company_id)
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'USD')
        ->where('company_id', $company_id)
        ->sum('total_quote');
    }
    
    function TotalrfqQuoteGBPEMP($company_id)
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'GBP')
        ->where('company_id', $company_id)
        ->sum('total_quote');
    }
    
    function TotalrfqQuoteEUREMP($company_id)
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'EUR')
        ->where('company_id', $company_id)
        ->sum('total_quote');
    }
    
    function TotalrfqQuoteNGNEMP($company_id)
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('currency', 'NGN')
        ->where('company_id', $company_id)
        ->sum('total_quote');
    }
    
    function TopPerformer($company_id)
    {
    return \DB::table('client_rfqs')
        ->join('employers', 'client_rfqs.employee_id', '=', 'employers.employee_id')
        ->whereYear('client_rfqs.rfq_date', date('Y'))
        ->where('client_rfqs.company_id', $company_id)
        ->where('client_rfqs.status', 'PO Issued')
        ->groupBy('client_rfqs.employee_id', 'employers.full_name')
        ->orderByRaw('COUNT(*) DESC')
        ->value('employers.full_name');
    }
    
    function TopPerformerCount($company_id)
    {
    return \DB::table('client_rfqs')
        ->whereYear('rfq_date', date('Y'))
        ->where('company_id', $company_id)
        ->where('status', 'PO Issued')
        ->groupBy('employee_id')
        ->selectRaw('COUNT(*) as count')
        ->orderByRaw('COUNT(*) DESC')
        ->value('count');
    }

    function TotalpoQuoteForeign()
    {
    return \DB::table('client_pos')
        ->whereYear('po_date', date('Y'))
        ->sum('po_value_foreign');
    }

    function TotalpoQuoteNaira()
    {
    return \DB::table('client_pos')
        ->whereYear('po_date', date('Y'))
        ->sum('po_value_naira');
    }



    function getWordCounts($words)
    {
        // Assuming the "client_rfqs" table has a "description" column
        $rows = DB::table('client_rfqs')
            ->select(DB::raw('LOWER(description) as description'))
            ->get();
    
        // Create an array to store the total counts for the specified words
        $result = [];
    
        // Iterate over each row and accumulate the counts for the specified words
        foreach ($rows as $row) {
            $descriptions = strtolower($row->description);
    
            foreach ($words as $word) {
                $lowerWord = strtolower($word);
    
                // Check if the word appears in the row
                if (strpos($descriptions, $lowerWord) !== false) {
                    // Increment the total count for the word
                    $result[$word] = isset($result[$word]) ? $result[$word] + 1 : 1;
                }
            }
        }
    
        // Sort the result array in descending order based on counts
        arsort($result);
    
        return $result;
    }

    function getSupplierFiles($rfq_id, $vendor_id)
    {
        return \DB::table('supplier_documents')->where([
            "rfq_id" => $rfq_id, 'vendor_id' => $vendor_id
        ])->get();
    }

    function getNewRfqs()
    {
        return \DB::table('client_rfqs')
            ->where('status', "RFQ Received")
            ->orderBy('rfq_date', 'desc') // Assuming there is a 'created_at' column
            ->take(2)
            ->get();
    }

    function getAwaitingRfqs()
    {
        return \DB::table('client_rfqs')
            ->where('status', "Awaiting Approval")
            ->orderBy('rfq_date', 'desc') // Assuming there is a 'created_at' column
            ->take(2)
            ->get();
    }

    function getPOIssuedRfqs()
    {
        return \DB::table('client_rfqs')
            ->where('status', "PO Issued")
            ->orderBy('rfq_date', 'desc') // Assuming there is a 'created_at' column
            ->take(2)
            ->get();
    }
    
    function empDe($email)
    {
        return \DB::table('employers')->where([
            "email" => $email
        ])->first();
    }

    function getLogo($company_id)
    {
        return \DB::table('company_logos')->where([
            "company_id" => $company_id
        ])->get();
    }


    function userEmployers($email)
    {
        return \DB::table('users')->where([
            "email" => $email, 'role' => 'Employer'
        ])->orWhere('role', 'HOD')->get();
    }


    function userId($user_id)
    {
        return \DB::table('users')->where([
            "user_id" => $user_id
        ])->first();
    }

    function userEmail($email)
    {
        return \DB::table('users')->where([
            "email" => $email
        ])->first();
    }


    function buyers($contact_id)
    {
        return \DB::table('client_contacts')->where([
            "contact_id" => $contact_id
        ])->get();
    }

    function fbuyers($contact_id)
    {
        return \DB::table('client_contacts')->where([
            "contact_id" => $contact_id
        ])->first();
    }

    function contactDetails($email)
    {
        return \DB::table('client_contacts')->where([
            "email" => $email
        ])->first();
    }

    function buyersContact($client_id)
    {
        return \DB::table('client_contacts')->where([
            "client_id" => $client_id
        ])->get();
    }

    function comp($company_id)
    {
        return \DB::table('companies')->where([
            "company_id" => $company_id
        ])->get();
    }

    function cops($company_id)
    {
        return \DB::table('companies')->where([
            "company_id" => $company_id
        ])->first();
    }

    function emps($employee_id)
    {
        return \DB::table('employers')->where([
            "employee_id" => $employee_id
        ])->get();
    }

    function clis($client_id)
    {
        return \DB::table('clients')->where([
            "client_id" => $client_id
        ])->get();
    }

    function clits($client_id)
    {
        return \DB::table('clients')->where([
            "client_id" => $client_id
        ])->first();
    }

    function SupplierDetails($vendor_id)
    {
        return \DB::table('vendors')->where([
            "vendor_id" => $vendor_id
        ])->first();
    }

    function employ($employee_id)
    {
        return \DB::table('employers')->where([
            "employee_id" => $employee_id
        ])->get();
    }

    function lineItems($client_id)
    {
        return \DB::table('line_items')->where([
            "client_id" => $client_id
        ])->get();
    }

    function editLineItems($rfq_id)
    {
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id
        ])->get();
    }

    function getRf($rfq_id)
    {
        return \DB::table('client_pos')->where([
            "rfq_id" => $rfq_id
        ])->first();
    }

    function countContact($client_id){
        return \DB::table('client_contacts')->where([
            "client_id" => $client_id
        ])->count();

    }

    function countClientRFQ($client_id){
        return \DB::table('client_rfqs')->where([
            "client_id" => $client_id
        ])->count();

    }

    function countinInformation($table, $column, $parameter){
        return \DB::table($table)->where([
            "$column" => $parameter
        ])->get();

    }

    function countCLientPO($client_id){
        return \DB::table('client_pos')->where([
            "client_id" => $client_id
        ])->count();

    }


    function countLineItems($rfq_id){
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id
        ])->count();

    }

    function getMescCodes($rfq_id){
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id
        ])->get();

    }

    function countinfLineItems($rfq_id, $vendor_id){
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id, "vendor_id" => $vendor_id
        ])->count();

    }

    function countFiles($directory){
       return Storage::allFiles($directory);
    }

    function countingRFQ($rfq_id){
        return \DB::table('client_pos')->where([
            "rfq_id" => $rfq_id
        ])->count();
    }

    function poEdit($rfq_id)
    {
        return \DB::table('client_pos')->where([
            "rfq_id" => $rfq_id
        ])->get();
    }

    function po($rfq_id)
    {
        return \DB::table('client_pos')->where([
            "rfq_id" => $rfq_id
        ])->get();
    }

    function poSee($rfq_id)
    {
        return \DB::table('client_pos')->where([
            "rfq_id" => $rfq_id
        ])->first();
    }


    function countShipQuote($rfq_id)
    {
        return \DB::table('shipper_quotes')->where([
            "rfq_id" => $rfq_id
        ])->count();
    }

    function countingShipQuote($rfq_id)
    {
        return \DB::table('shipper_quotes')->where([
            "rfq_id" => $rfq_id,
        ])->count();
    }

    function getRfqShipQuote($rfq_id)
    {
        return \DB::table('shipper_quotes')->where([
            "rfq_id" => $rfq_id,
        ])->first();
    }

    function getttingRfqShipQuote($rfq_id)
    {
        return \DB::table('shipper_quotes')->where([
            "rfq_id" => $rfq_id,
        ])->get();
    }

    function countSupQuote($rfq_id)
    {
        return \DB::table('supplier_quotes')->where([
            "rfq_id" => $rfq_id
        ])->count();
    }

    function countLineSupQuote($line_id)
    {
        return \DB::table('supplier_quotes')->where([
            "line_id" => $line_id,
            "status" => 'Picked'
        ])->count();
    }

    function monthChart($month)
    {
        return \DB::table('client_rfqs')->whereMonth('created_at', $month)->count();
    }

    function employeeChart($employee_id)
    {
        return \DB::table('client_rfqs')->where('employee_id', $employee_id)->count();
    }

    function vendorChart($vendor_id)
    {
        return \DB::table('client_rfqs')->where('vendor_id', $vendor_id)->count();
    }

    function shipperChart($shipper_id)
    {
        return \DB::table('client_rfqs')->where('shipper_id', $shipper_id)->count();
    }

    function companyChart($company_id)
    {
        return \DB::table('client_rfqs')->where('company_id', $company_id)->count();
    }

    function clientsChart($client_id)
    {
        return \DB::table('client_rfqs')->where('client_id', $client_id)->count();
    }

    function getLineSupQuote($line_id)
    {
        return \DB::table('supplier_quotes')->where([
            "line_id" => $line_id,
        ])->first();
    }

    function getSupQuote($line_id)
    {
        return \DB::table('supplier_quotes')->where([
            "line_id" => $line_id,
            "status" => 'Picked'
        ])->get();
    }

    function getLine($client_id)
    {
        return \DB::table('line_items')->where([
            "client_id" => $client_id,

        ])->get();
    }

    function getVen($vendor_id)
    {
        return \DB::table('vendors')->where([
            "vendor_id" => $vendor_id,

        ])->get();
    }

    function getSh($shipper_id)
    {
        return \DB::table('shippers')->where([
            "shipper_id" => $shipper_id,

        ])->get();
    }


    function getUOM($unit_id)
    {
        return \DB::table('rfq_measurements')->where([
            "unit_id" => $unit_id,
        ])->get();
    }

    function checkSupQuote($rfq_id, $vendor_id)
    {
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id, "vendor_id" => $vendor_id
        ])->count();
    }

    function gettingSupQuote($rfq_id, $vendor_id)
    {
        return \DB::table('supplier_quotes')->where([
            "rfq_id" => $rfq_id, "vendor_id" => $vendor_id
        ])->get();
    }

    function gettingShipQuote($rfq_id, $shipper_id)
    {
        return \DB::table('shipper_quotes')->where([
            "rfq_id" => $rfq_id, "shipper_id" => $shipper_id
        ])->get();
    }

    function gettingRFQ($rfq_id)
    {
        return \DB::table('client_rfqs')->where([
            "rfq_id" => $rfq_id,
        ])->get();
    }

    function employeeDetails($employee_id)
    {
        return \DB::table('employers')->where([
            "employee_id" => $employee_id,
        ])->get();
    }

    function contactDetail($contact_id)
    {
        return \DB::table('client_contacts')->where([
            "contact_id" => $contact_id,
        ])->get();
    }


    function UOM($unit_id)
    {
        return \DB::table('rfq_measurements')->where([
            "unit_id" => $unit_id
        ])->get();
    }

    function sumSupQuote($rfq_id)
    {
        return \DB::table('supplier_quotes')->where([
            "rfq_id" => $rfq_id, "vendor_id" => $vendor_id
        ])->get();
    }


    function getDelSupQuote($rfq_id, $vendor_id)
    {
        return \DB::table('supplier_quotes')->where([
            "rfq_id" => $rfq_id, "vendor_id" => $vendor_id
        ])->first();
    }

    function seeDelSupQuote($rfq_id)
    {
        return \DB::table('supplier_quotes')->where([
            "rfq_id" => $rfq_id
        ])->first();
    }


    function getSupPrice($line_id)
    {
        return \DB::table('supplier_quotes')->where([
            "line_id" => $line_id
        ])->get();
    }

    function EditSupQuote($rfq_id)
    {
        return \DB::table('supplier_quotes')->where([
            "rfq_id" => $rfq_id
        ])->get();
    }

    function sumUnitCost($rfq_id)
    {
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id
        ])->sum('unit_cost');
    }

    function sumTotalCost($rfq_id)
    {
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id
        ])->sum('total_cost');
    }

    function sumUnitMargin($rfq_id)
    {
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id
        ])->sum('unit_margin');
    }

    function sumTotalMargin($rfq_id)
    {
        return \DB::table('line_items')->where([
            "rfq_id" => $rfq_id
        ])->sum('total_margin');
    }

    function sumTotalQuote($rfq_id)
    {
        return \DB::table('line_items')->where(["rfq_id" => $rfq_id])->sum('total_quote');
    }

    function getUserWareHouse($user_id)
    {
        return \DB::table('user_warehouses')->where([
            "user_id" => $user_id
        ])->first();
    }

    function getWareHouse($warehouse_id)
    {
        return \DB::table('warehouses')->where([
            "warehouse_id" => $warehouse_id
        ])->first();
    }

    function getInventoryFile($inventory_id)
    {
        return \DB::table('inventory_images')->where([
            "inventory_id" => $inventory_id
        ])->get();
    }

    function getClientDocument($client_id)
    {
        return \DB::table('client_documents')->where([
            "client_id" => $client_id
        ])->get();
    }

    function sumForeignClient()
    {
        return \DB::table('client_pos')->sum('po_value_foreign');
    }

    function sumNgnClient()
    {
        return \DB::table('client_pos')->sum('po_value_naira');
    }

    function sumNgnClientRFQ()
    {
        return \DB::table('client_rfqs')->sum('value_of_quote_usd');
    }

    function sumNgnClientRFQCompany($company_id)
    {
        return \DB::table('client_rfqs')->where('company_id', $company_id)->where('currency', 'NGN')->sum('total_quote');;
    }
    
    function sumUsdClientRFQCompany($company_id)
    {
        return \DB::table('client_rfqs')->where('company_id', $company_id)->where('currency', 'USD')->sum('total_quote');
    }

    function sumNgnClientRFQNgn()
    {
        return \DB::table('client_rfqs')->sum('value_of_quote_ngn');
    }

    function sumNgnClientRFQCompanyNgn($company_id)
    {
        return \DB::table('client_rfqs')->where('company_id', $company_id)->sum('value_of_quote_ngn');
    }


    function sumForeignCompany($company_id)
    {
        return \DB::table('client_pos')->where([
            "company_id" => $company_id
        ])->sum('po_value_foreign');
    }

    function sumNgnCompany($company_id)
    {
        return \DB::table('client_pos')->where([
            "company_id" => $company_id
        ])->sum('po_value_naira');
    }

    function getClientRfq($rfq_id)
    {
        return \DB::table('client_rfqs')->where([
            "rfq_id" => $rfq_id
        ])->first();
    }

    function updateContact($contact_id, $po_id)
    {
        return \DB::table('client_pos')->where('po_id', $po_id)->update([
            "contact_id" => $contact_id
        ]);
    }

    function checkRFQ($rfq_id)
    {
        return \DB::table('client_rfqs')->where([
            "rfq_id" => $rfq_id
        ])->get();
    }

    function getRRQShipQuote($rfq_id, $action)
    {
        return \DB::table('shipper_quotes')->where([
            "rfq_id" => $rfq_id
        ])->$action();
    }

    function getPOInfo()
    {
        return \DB::table('client_pos')->get();
    }
    
    function getyearPOInfo()
    {
        return \DB::table('client_pos')
        ->whereYear('actual_delivery_date', date('Y'))
        ->whereIn('status',['Delivered', 'Partial Delivery', 'Awaiting GRN', 'Invoicing', 'Invoiced', 'Paid'])
        ->get();
    }

    function getPOInfoCon($condition)
    {
        return \DB::table('client_pos')->where([
            "timely_delivery" => $condition
        ])->get();
    }
    
    function getyearPOInfoCon($condition)
    {
        return \DB::table('client_pos')->where([
            "timely_delivery" => $condition
        ])
        ->whereYear('actual_delivery_date', date('Y'))
        ->whereIn('status',['Delivered', 'Partial Delivery', 'Awaiting GRN', 'Invoicing', 'Invoiced', 'Paid'])
        ->get();
    }

    function countShipperPO($shipper_id)
    {
        return \DB::table('client_pos')->where([
            "shipper_id" => $shipper_id
        ])->get();
    }
    
    function countShipperPOyearly($shipper_id)
    {
        return \DB::table('client_pos')
        ->join('client_rfqs', 'client_pos.rfq_id', '=','client_rfqs.rfq_id')
        ->where([
            "client_pos.shipper_id" => $shipper_id
        ])
        ->whereYear('client_pos.actual_delivery_date', date('Y'))
        ->where('client_rfqs.incoterm', '!=', 'Ex Works')
        ->whereIn('client_pos.status',['Delivered', 'Partial Delivery', 'Awaiting GRN', 'Invoicing', 'Invoiced', 'Paid'])
        ->get();
    }

    function countShipperPOCon($shipper_id, $condition)
    {
        return \DB::table('client_pos')->where([
            "shipper_id" => $shipper_id, "timely_delivery" => $condition
        ])
        ->whereIn('status',['Delivered', 'Partial Delivery', 'Awaiting GRN', 'Invoicing', 'Invoiced', 'Paid'])
        ->whereYear('actual_delivery_date', date('Y'))
        ->get();
    }
    
    function getProductRfq($client_id, $product_name)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('product', $product_name)
        ->whereYear('rfq_date', now()->year)
        ->get();
    }
    
    function getProductPo($client_id, $product_name)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('product', $product_name)
        ->whereYear('po_date', now()->year)
        ->get();
    }


    function getValveRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%Valve%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getValvePo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%Valve%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getGasketRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%gasket%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getGasketPo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%gasket%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getBoltAndNutRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%bolt%')
        ->where('description', 'like', '%nut%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getBoltAndNutPo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%bolt%')
        ->where('description', 'like', '%nut%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getFlangesRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getFlangesPo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getPipeRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%pipe%')
        ->where('description', 'like', '%fitting%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getPipePo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%pipe%')
        ->where('description', 'like', '%fitting%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getRotorkRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%rotork%')
        ->orwhere('description', 'like', '%actuator%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getRotorkPo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%rotork%')
        ->orwhere('description', 'like', '%actuator%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getOtherRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description','not like','%valve%')
        ->where('description','not like', '%gasket%')
        ->where('description','not like', '%bolt%')
        ->where('description','not like', '%nut%')
        ->where('description','not like', '%flange%')
        ->where('description','not like', '%pipe%')
        ->where('description','not like', '%fitting%')
        ->where('description','not like', '%rotork%')
        ->where('description','not like', '%actuator%')
        ->where('description','not like', '%flange management service%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getOtherPo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'not like', '%valve%')
        ->where('description', 'not like', '%gasket%')
        ->where('description','not like', '%bolt%')
        ->where('description','not like', '%nut%')
        ->where('description', 'not like', '%flange%')
        ->where('description', 'not like', '%pipe%')
        ->where('description', 'not like', '%fitting%')
        ->where('description', 'not like', '%rotork%')
        ->where('description', 'not like', '%actuator%')
        ->where('description', 'not like', '%flange management service%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getFMSRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange management service%')
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getFMSPo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange management service%')
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getTotalRfq($client_id)
    {
        return \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->whereYear('rfq_date', now()->year)
        ->get();
    }

    function getTotalPo($client_id)
    {
        return \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->whereYear('po_date', now()->year)
        ->get();
    }

    function getValveRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%Valve%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getValvePoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%Valve%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getGasketRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%gasket%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getGasketPoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%gasket%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getBoltAndNutRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%bolts and nuts%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getBoltAndNutPoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%bolts and nuts%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getFlangesRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getFlangesPoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getPipeRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%pipe%')
        ->where('description', 'like', '%fitting%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getPipePoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%pipe%')
        ->where('description', 'like', '%fitting%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getRotorkRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%rotork%')
        ->where('description', 'like', '%actuator%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getRotorkPoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%rotork%')
        ->where('description', 'like', '%actuator%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getOtherRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'not like','%valve%')
        ->where('description', 'not like', '%gasket%')
        ->where('description','not like', '%bolts and nuts%')
        ->where('description','not like', '%flange%')
        ->where('description','not like', '%pipe fittings%')
        ->where('description','not like', '%rotork%')
        ->where('description','not like', '%actuator%')
        ->where('description','not like', '%flange management service%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getOtherPoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'not like', '%valve%')
        ->where('description', 'not like', '%gasket%')
        ->where('description', 'not like', '%bolts and nuts%')
        ->where('description', 'not like', '%flange%')
        ->where('description', 'not like', '%pipe fittings%')
        ->where('description', 'not like', '%rotork%')
        ->where('description', 'not like', '%actuator%')
        ->where('description', 'not like', '%flange management service%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getFMSRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange management service%');

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getFMSPoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id])
        ->where('description', 'like', '%flange management service%');

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getTotalRfqc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id]);

    if ($start_date && $end_date) {
        $query->whereBetween('rfq_date', [$start_date, $end_date]);
    }

    return $query->get();
}

function getTotalPoc($client_id, $start_date = null, $end_date = null)
{
    $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id]);

    if ($start_date && $end_date) {
        $query->whereBetween('po_date', [$start_date, $end_date]);
    }

    return $query->get();
}
    function allclientrfq($client_id,  $start_date = null, $end_date = null) {
        $query = \DB::table('client_rfqs')
        ->where(["client_id" => $client_id]);

        if ($start_date && $end_date) {
            $query->whereBetween('rfq_date', [$start_date, $end_date]);
        }

        return $query->get();
        }
    function allclientpo($client_id,  $start_date = null, $end_date = null) {
        $query = \DB::table('client_pos')
        ->where(["client_id" => $client_id]);

        if ($start_date && $end_date) {
            $query->whereBetween('po_date', [$start_date, $end_date]);
        }

        return $query->get();
    }

    function getnotes($rfq_id)
    {
        // Assuming the "client_rfqs" table has a "description" column
        $query = DB::table('client_rfqs')
            ->select('note')
            ->where('rfq_id', $rfq_id)
            ->first();

        return $query;
    }
        
    function getproducts()
    {
        return \DB::table('products')->orderBy('product_name')
        ->get();
    }
    
    function getcompanyproducts($company_id)
    {
        return \DB::table('products')->orderBy('product_name')->where('company_id', $company_id)
        ->get();
    }
    
    function freight_pricing($location, $weight){
        $charge = "";
        if($location == 'Europe'){
            if($weight > 0 && $weight <= 50){
                $charge = 7.5;
            }elseif($weight > 50 && $weight <= 100){
                $charge = 7.5;
            }elseif($weight > 100 && $weight <= 150){
                $charge = 7;
            }
        }elseif($location == 'UK'){
            if($weight > 0 && $weight <= 50){
                $charge = 7;
            }elseif($weight > 50 && $weight <= 100){
                $charge = 7;
            }elseif($weight > 100 && $weight <= 150){
                $charge = 6.5;
            }
        }elseif($location == 'US'){
            if($weight > 0 && $weight <= 50){
                $charge = 8.5;
            }elseif($weight > 50 && $weight <= 100){
                $charge = 8.5;
            }elseif($weight > 100 && $weight <= 150){
                $charge = 8;
            }
        }elseif($location == 'China'){
            if($weight > 0 && $weight <= 50){
                $charge = 12;
            }elseif($weight > 50 && $weight <= 100){
                $charge = 11;
            }elseif($weight > 100 && $weight <= 150){
                $charge = 10;
            }
        }elseif($location == 'Middle East'){
            if($weight > 0 && $weight <= 50){
                $charge = 11;
            }elseif($weight > 50 && $weight <= 100){
                $charge = 10;
            }elseif($weight > 100 && $weight <= 150){
                $charge = 9;
            }
        }elseif($location == 'Africa'){
            if($weight > 0 && $weight <= 50){
                $charge = 0;
            }elseif($weight > 50 && $weight <= 100){
                $charge = 0;
            }elseif($weight > 100 && $weight <= 150){
                $charge = 0;
            }
        }
        
        return $charge;
    }
    
    function getRecommendedSuppliers($product){
        return \DB::table('vendors')->orderBy('vendor_name')->whereJsonContains('products', $product)->get(['vendor_id', 'vendor_name']);
    }
    
    function getOtherSuppliers(){
        return \DB::table('vendors')->orderBy('vendor_name')->get(['vendor_id', 'vendor_name']);
    }
    
    function getCompanyVendor($company_id){
        return \DB::table('vendors')->orderBy('vendor_name')->where('company_id', $company_id)->get(['vendor_id', 'vendor_name']);
    }
    
    function getCountries(){
        return \DB::table('countries')->orderBy('name')->get(['id','name']);
    }
    
    function getCountryName($id){
        return \DB::table('countries')->where('id', $id)->value('name');
    }
    
    function getStateName($id){
        return \DB::table('states')->where('id', $id)->value('name');
    }
    
    function getStatesByCountry($id){
        return \DB::table('states')->where('country_id', $id)->orderBy('name')->get(['id','name']);
    }
    
    function getCitiesByState($id){
        return \DB::table('cities')->where('state_id', $id)->orderBy('name')->get(['id','name']);
    }
    
    function getVendorContacts($id){
        return \DB::table('vendor_contacts')->where('vendor_id', $id)->orderBy('first_name')->get(['contact_id','first_name', 'last_name']);
    }
?>
