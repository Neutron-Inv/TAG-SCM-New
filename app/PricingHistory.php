<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PricingHistory extends Pivot
{
    //
    protected $table = 'pricing_history';
    public $primaryKey = 'id';
    protected $guard_name = 'web';
    protected $fillable = [
        'rfq_id',
        'vendor_id',
        'contact_id',
        'line_items',
        'conformity',
        'total_quote',
        'accuracy',
        'pricing',
        'response_time',
        'negotiation',
        'rfq_code',
        'reference_number',
        'mail_id',
        'status',
        'rated_by',
        'issued_by',
        'misc_cost',
        'weight',
        'dimension',
        'hs_codes',
        'general_terms',
        'notes_to_pricing',
    ];

    // protected $casts = [
    //     'line_items' => 'array', // Automatically cast to and from JSON
    // ];

    public function vendor()
    {
        return $this->belongsTo('App\Vendors', 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'issued_by', 'user_id');
    }
    
    public function rater()
    {
        return $this->belongsTo('App\User', 'rated_by', 'user_id');
    }

    public function mail()
    {
        return $this->hasMany('App\MailTray', 'mail_id', 'mail_id');
    }
    
    public function finalRating()
    {
        return round(
            ($this->response_time * 0.20) +
            ($this->pricing * 0.25) +
            ($this->accuracy * 0.20) +
            ($this->conformity * 0.20) +
            ($this->negotiation * 0.15), 
            2 // Rounds to 2 decimal places
        );
    }

    public function jsonMiscCost()
    {
        return json_decode($this->misc_cost, true) ?? [];;
    }
}
