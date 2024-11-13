<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MailTray extends Pivot
{
    //
    protected $table = 'mail_tray';
    public $primaryKey = 'id';
    protected $guard_name = 'web';
    protected $fillable = [
        'rfq_id',
        'vendor_id',
        'contact_id',
        'mail_id',
        'subject',
        'body',
        'recipient_email',
        'cc_email',
        'sent_by'
    ];

    protected $casts = [
        'cc_email' => 'array', // Automatically cast to and from JSON
    ];

    public function vendor()
    {
        return $this->belongsTo('App\Vendors', 'vendor_id');
    }

}
