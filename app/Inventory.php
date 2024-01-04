<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Inventory extends Model
{
    use SoftDeletes;
    protected $table = 'inventories';
    protected $primaryKey = 'inventory_id';
    protected $fillable = [
        'material_number', 'short_description', 'complete_description', 'oem','oem_part_number', 'storage_location', 'quantity_location', 'material_condition',
        'preservations_required', 'recommended_changes', 'warehouse_id', 'approved_by', 'user_email'
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function getDeletedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }
}
