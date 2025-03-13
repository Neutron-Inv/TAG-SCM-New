<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePricingRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust if you need authorization logic
    }

    public function rules()
    {
        return [
            'response_time' => 'required|integer|min:1|max:5',
            'pricing' => 'required|integer|min:1|max:5',
            'description' => 'required|string',
            'conformity' => 'required|integer|min:1|max:5',
            'accuracy' => 'required|integer|min:1|max:5',
            'negotiation' => 'required|integer|min:1|max:5',
            'total_quote' => 'nullable|numeric|min:0',
            'reference_number' => 'required|string',
            'misc_cost_title' => 'nullable|array',
            'misc_cost_amount' => 'nullable|array',
            'weight' => 'nullable|string',
            'dimension' => 'nullable|string',
            'hs_codes' => 'nullable|string',
            'general_terms' => 'nullable|string',
            'notes_to_pricing' => 'nullable|string',
            'delivery_time' => 'nullable|string',
            'delivery_location' => 'nullable|string',
            'payment_term' => 'nullable|string',
            'lead_time' => 'nullable|string',
        ];
    }
}
