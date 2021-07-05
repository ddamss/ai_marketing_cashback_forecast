<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashback extends Model
{
    protected $fillable = ['page', 'cashback', 'payment_delay', 'sale_date', 'sale_amount', 'cashback_rate', 'payment_status','first_item','row_id'];
    // protected $casts = [
    //     'sale_date' => 'datetime:d-m-Y H:i'
    // ];
    use HasFactory;
}
