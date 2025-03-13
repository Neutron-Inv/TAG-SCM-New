<?php

namespace App\Services;

use App\PricingHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PricingService
{
    public function updatePricing($id, array $data)
    {
        try {
            // Find the existing record
            $pricing = PricingHistory::findOrFail($id);
            $user_id = Auth::user()->user_id;

            // Process Miscellaneous Costs
            $miscCostSupplierValues = $data['misc_cost_title'] ?? [];
            $miscAmountSupplierValues = $data['misc_cost_amount'] ?? [];
            $data_supplier = [];

            foreach ($miscCostSupplierValues as $key => $costValue) {
                if (isset($miscAmountSupplierValues[$key])) {
                    $data_supplier[] = [
                        'desc' => $costValue,
                        'amount' => $miscAmountSupplierValues[$key],
                    ];
                }
            }

            $json_supplier = json_encode($data_supplier);

            // Update record
            $pricing->update([
                'response_time' => $data['response_time'],
                'description' => $data['description'],
                'pricing' => $data['pricing'],
                'conformity' => $data['conformity'],
                'accuracy' => $data['accuracy'],
                'negotiation' => $data['negotiation'],
                'total_quote' => $data['total_quote'],
                'reference_number' => $data['reference_number'],
                'misc_cost' => $json_supplier,
                'weight' => $data['weight'] ?? null,
                'dimension' => $data['dimension'] ?? null,
                'hs_codes' => $data['hs_codes'] ?? null,
                'general_terms' => $data['general_terms'] ?? null,
                'notes_to_pricing' => $data['notes_to_pricing'] ?? null,
                'delivery_time' => $data['delivery_time'] ?? null,
                'delivery_location' => $data['delivery_location'] ?? null,
                'payment_term' => $data['payment_term'] ?? null,
                'lead_time' => $data['lead_time'] ?? null,
                'rated_by' => $user_id
            ]);

            return ['success' => true, 'message' => 'Supplier rating updated successfully.'];
        } catch (\Exception $e) {
            Log::error('Pricing Update Failed: ' . $e->getMessage());

            return ['success' => false, 'message' => 'Failed to update supplier rating. Error: ' . $e->getMessage()];
        }
    }
}
