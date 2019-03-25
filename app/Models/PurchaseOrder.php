<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'buyer',    //  to be removed later after implementing login
        'supplier',
        'total_cost',
        'breakdown',
        'purpose'
    ];
}
