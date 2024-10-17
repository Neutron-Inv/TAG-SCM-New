<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierDocument extends Model
{
    protected $table = 'supplier_documents';
    public $primaryKey = 'id';
    protected $guard_name = 'web';
    protected $fillable = [
        'rfq_id', 'vendor_id', 'file'
    ];
}
