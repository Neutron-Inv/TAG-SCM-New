<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    public $primaryKey = 'product_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'company_id',
        'product_name',
    ];

    public function getUnitNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setUnitNameAttribute($value)
    {
        return $this->attributes['product_name'] = $value;
    }

}
