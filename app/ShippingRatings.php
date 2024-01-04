<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ShippingRatings extends Model
{
    use SoftDeletes;

    protected $table = 'shipping_ratings';
    public $primaryKey = 'rating_id';
    protected $guard_name = 'web';
}
