<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class InventoryImage extends Model
{
    use SoftDeletes;
    protected $table = 'inventory_images';
    protected $primaryKey = 'image_id';
    protected $fillable = [
        'inventory_id', 'image'
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
