<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Automation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'company_id', 'rfq_id', 'po_id', 'type', 'description', 'deleted_at'];

}
