<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CompanyLogo extends Model
{
    use SoftDeletes;

    protected $table = 'company_logos';
    public $primaryKey = 'logo_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'company_id', 'company_logo', 'signature'
    ];

}
