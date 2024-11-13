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
        'reliability',
        'pricing',
        'response_time',
        'communication',
        'mail_id',
        'status',
        'rated_by',
    ];

    protected $casts = [
        'line_items' => 'array', // Automatically cast to and from JSON
    ];

    public function vendor()
    {
        return $this->belongsTo('App\Vendors', 'vendor_id');
    }
}
