<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfqSupplier extends Model
{
    protected $fillable = [
        'rfq_id',
        'reference_no',
        'vendor_id',
        'product',
        'description',
    ];

    // Define relationships if needed
    public function rfq()
    {
        return $this->belongsTo(ClientRfq::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendors::class);
    }
}
